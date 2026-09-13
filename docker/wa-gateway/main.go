package main

import (
	"context"
	"database/sql"
	"encoding/base64"
	"encoding/json"
	"fmt"
	"log"
	"net/http"
	"os"
	"os/signal"
	"strings"
	"sync"
	"syscall"
	"time"

	"github.com/skip2/go-qrcode"
	"go.mau.fi/whatsmeow"
	waProto "go.mau.fi/whatsmeow/binary/proto"
	"go.mau.fi/whatsmeow/store/sqlstore"
	"go.mau.fi/whatsmeow/types"
	waLog "go.mau.fi/whatsmeow/util/log"
	"google.golang.org/protobuf/proto"
	_ "modernc.org/sqlite"
)

type Server struct {
	client    *whatsmeow.Client
	qrCode    string
	qrRaw     string
	qrLock    sync.RWMutex
	apiKey    string
	storePath string
}

func main() {
	port := getEnv("PORT", "3100")
	apiKey := getEnv("API_KEY", "sipedes_secret_wa_2026")
	storePath := getEnv("STORE_PATH", "./storages")

	if err := os.MkdirAll(storePath, 0755); err != nil {
		log.Fatalf("Gagal membuat direktori store: %v", err)
	}

	dbLog := waLog.Stdout("Database", "WARN", true)
	dbPath := fmt.Sprintf("file:%s/whatsapp.db?_pragma=busy_timeout(15000)&_pragma=journal_mode(WAL)&_pragma=foreign_keys(1)&_pragma=synchronous(NORMAL)", storePath)

	rawDB, err := sql.Open("sqlite", dbPath)
	if err != nil {
		log.Fatalf("Gagal membuka SQLite database: %v", err)
	}
	rawDB.SetMaxIdleConns(5)
	rawDB.SetMaxOpenConns(10)
	rawDB.SetConnMaxLifetime(10 * time.Minute)

	if _, err := rawDB.Exec("PRAGMA journal_mode = WAL; PRAGMA busy_timeout = 15000; PRAGMA foreign_keys = ON; PRAGMA synchronous = NORMAL;"); err != nil {
		log.Printf("Peringatan inisialisasi PRAGMA SQLite: %v", err)
	}

	container := sqlstore.NewWithDB(rawDB, "sqlite", dbLog)
	if err := container.Upgrade(context.Background()); err != nil {
		log.Fatalf("Gagal upgrade skema SQLite database: %v", err)
	}

	deviceStore, err := container.GetFirstDevice(context.Background())
	if err != nil {
		log.Fatalf("Gagal mengambil session device: %v", err)
	}

	clientLog := waLog.Stdout("Client", "INFO", true)
	client := whatsmeow.NewClient(deviceStore, clientLog)

	srv := &Server{
		client:    client,
		apiKey:    apiKey,
		storePath: storePath,
	}

	client.AddEventHandler(srv.handleEvents)

	// Mulai koneksi jika sudah pernah login
	if client.Store.ID != nil {
		go func() {
			if err := client.Connect(); err != nil {
				log.Printf("Gagal auto-connect: %v", err)
			} else {
				log.Printf("Berhasil terhubung kembali dengan nomor: %s", client.Store.ID.User)
			}
		}()
	}

	mux := http.NewServeMux()
	mux.HandleFunc("/health", srv.handleHealth)
	mux.HandleFunc("/app/status", srv.authMiddleware(srv.handleStatus))
	mux.HandleFunc("/app/qr", srv.authMiddleware(srv.handleQR))
	mux.HandleFunc("/app/pairing-code", srv.authMiddleware(srv.handlePairingCode))
	mux.HandleFunc("/app/logout", srv.authMiddleware(srv.handleLogout))
	mux.HandleFunc("/send/message", srv.authMiddleware(srv.handleSendMessage))

	server := &http.Server{
		Addr:    ":" + port,
		Handler: mux,
	}

	go func() {
		log.Printf("==================================================")
		log.Printf("🚀 Go-WA Gateway SIPEDES berjalan di port :%s", port)
		log.Printf("==================================================")
		if err := server.ListenAndServe(); err != nil && err != http.ErrServerClosed {
			log.Fatalf("Server error: %v", err)
		}
	}()

	stop := make(chan os.Signal, 1)
	signal.Notify(stop, os.Interrupt, syscall.SIGTERM)
	<-stop

	log.Println("Menghentikan Go-WA Gateway...")
	client.Disconnect()
	ctx, cancel := context.WithTimeout(context.Background(), 5*time.Second)
	defer cancel()
	server.Shutdown(ctx)
	log.Println("Go-WA Gateway berhenti dengan aman.")
}

func (s *Server) authMiddleware(next http.HandlerFunc) http.HandlerFunc {
	return func(w http.ResponseWriter, r *http.Request) {
		w.Header().Set("Content-Type", "application/json")
		key := r.Header.Get("X-Api-Key")
		if key == "" {
			key = r.URL.Query().Get("api_key")
		}

		if s.apiKey != "" && key != s.apiKey {
			http.Error(w, `{"error":"Unauthorized: Invalid API Key"}`, http.StatusUnauthorized)
			return
		}
		next(w, r)
	}
}

func (s *Server) handleEvents(evt interface{}) {
	// Handler event internal jika dibutuhkan
}

func (s *Server) handleHealth(w http.ResponseWriter, r *http.Request) {
	json.NewEncoder(w).Encode(map[string]interface{}{
		"status":  "ok",
		"service": "SIPEDES Go-WA Gateway",
		"time":    time.Now().Format(time.RFC3339),
	})
}

func (s *Server) handleStatus(w http.ResponseWriter, r *http.Request) {
	connected := s.client.IsConnected()
	loggedIn := s.client.IsLoggedIn()
	phone := ""

	if s.client.Store.ID != nil {
		phone = s.client.Store.ID.User
	}

	json.NewEncoder(w).Encode(map[string]interface{}{
		"connected":   connected,
		"logged_in":   loggedIn,
		"phone":       phone,
		"device_name": "Balai Desa Rombiya Barat (SIPEDES)",
	})
}

func (s *Server) handleQR(w http.ResponseWriter, r *http.Request) {
	if s.client.IsLoggedIn() {
		json.NewEncoder(w).Encode(map[string]interface{}{
			"connected": true,
			"logged_in": true,
			"qr_code":   nil,
			"message":   "Perangkat WhatsApp sudah terhubung.",
		})
		return
	}

	// Hubungkan dan dapatkan QR Channel
	if !s.client.IsConnected() {
		qrChan, err := s.client.GetQRChannel(context.Background())
		if err != nil {
			http.Error(w, fmt.Sprintf(`{"error":"Gagal inisialisasi QR: %v"}`, err), http.StatusInternalServerError)
			return
		}

		if err := s.client.Connect(); err != nil {
			http.Error(w, fmt.Sprintf(`{"error":"Gagal connect: %v"}`, err), http.StatusInternalServerError)
			return
		}

		go func() {
			for evt := range qrChan {
				if evt.Event == "code" {
					png, err := qrcode.Encode(evt.Code, qrcode.Medium, 280)
					if err == nil {
						b64 := "data:image/png;base64," + base64.StdEncoding.EncodeToString(png)
						s.qrLock.Lock()
						s.qrCode = b64
						s.qrRaw = evt.Code
						s.qrLock.Unlock()
					}
				} else {
					s.qrLock.Lock()
					s.qrCode = ""
					s.qrRaw = ""
					s.qrLock.Unlock()
				}
			}
		}()

		// Tunggu sejenak hingga QR pertama tersedia
		time.Sleep(1 * time.Second)
	}

	s.qrLock.RLock()
	currentQR := s.qrCode
	raw := s.qrRaw
	s.qrLock.RUnlock()

	json.NewEncoder(w).Encode(map[string]interface{}{
		"connected": s.client.IsConnected(),
		"logged_in": s.client.IsLoggedIn(),
		"qr_code":   currentQR,
		"raw":       raw,
	})
}

func (s *Server) handlePairingCode(w http.ResponseWriter, r *http.Request) {
	if r.Method != http.MethodPost {
		http.Error(w, `{"error":"Method not allowed"}`, http.StatusMethodNotAllowed)
		return
	}

	var req struct {
		Phone string `json:"phone"`
	}
	if err := json.NewDecoder(r.Body).Decode(&req); err != nil || req.Phone == "" {
		http.Error(w, `{"error":"Parameter 'phone' wajib diisi"}`, http.StatusBadRequest)
		return
	}

	// Pastikan terkoneksi
	if !s.client.IsConnected() {
		if err := s.client.Connect(); err != nil {
			http.Error(w, fmt.Sprintf(`{"error":"Gagal connect ke server WhatsApp: %v"}`, err), http.StatusInternalServerError)
			return
		}
	}

	phone := cleanPhone(req.Phone)
	code, err := s.client.PairPhone(r.Context(), phone, true, whatsmeow.PairClientChrome, "Chrome (Linux)")
	if err != nil {
		http.Error(w, fmt.Sprintf(`{"error":"Gagal membuat pairing code: %v"}`, err), http.StatusInternalServerError)
		return
	}

	json.NewEncoder(w).Encode(map[string]interface{}{
		"success":      true,
		"pairing_code": code,
		"expires_in":   160,
		"message":      "Kode pairing berhasil dibuat. Masukkan kode ini pada WhatsApp HP Anda.",
	})
}

func (s *Server) handleLogout(w http.ResponseWriter, r *http.Request) {
	if r.Method != http.MethodPost {
		http.Error(w, `{"error":"Method not allowed"}`, http.StatusMethodNotAllowed)
		return
	}

	if s.client.IsLoggedIn() {
		s.client.Logout(r.Context())
	}
	s.client.Disconnect()

	s.qrLock.Lock()
	s.qrCode = ""
	s.qrRaw = ""
	s.qrLock.Unlock()

	json.NewEncoder(w).Encode(map[string]interface{}{
		"success": true,
		"message": "Sesi WhatsApp berhasil diputuskan.",
	})
}

func (s *Server) handleSendMessage(w http.ResponseWriter, r *http.Request) {
	if r.Method != http.MethodPost {
		http.Error(w, `{"error":"Method not allowed"}`, http.StatusMethodNotAllowed)
		return
	}

	var req struct {
		Phone   string `json:"phone"`
		Message string `json:"message"`
	}
	if err := json.NewDecoder(r.Body).Decode(&req); err != nil || req.Phone == "" || req.Message == "" {
		http.Error(w, `{"error":"Parameter 'phone' dan 'message' wajib diisi"}`, http.StatusBadRequest)
		return
	}

	if !s.client.IsLoggedIn() {
		http.Error(w, `{"error":"Perangkat WhatsApp belum tertaut/login. Silakan lakukan scan QR atau pairing code terlebih dahulu."}`, http.StatusServiceUnavailable)
		return
	}

	if !s.client.IsConnected() {
		if err := s.client.Connect(); err != nil {
			http.Error(w, fmt.Sprintf(`{"error":"Koneksi WhatsApp sedang terputus dan gagal reconnect: %v"}`, err), http.StatusServiceUnavailable)
			return
		}
	}

	recipientJID := types.NewJID(cleanPhone(req.Phone), types.DefaultUserServer)
	msg := &waProto.Message{
		Conversation: proto.String(req.Message),
	}

	resp, err := s.client.SendMessage(r.Context(), recipientJID, msg)
	if err != nil {
		http.Error(w, fmt.Sprintf(`{"error":"Gagal mengirim pesan: %v"}`, err), http.StatusInternalServerError)
		return
	}

	json.NewEncoder(w).Encode(map[string]interface{}{
		"success":    true,
		"message_id": resp.ID,
		"timestamp":  resp.Timestamp.Format(time.RFC3339),
	})
}

func cleanPhone(phone string) string {
	cleaned := strings.Map(func(r rune) rune {
		if r >= '0' && r <= '9' {
			return r
		}
		return -1
	}, phone)

	if strings.HasPrefix(cleaned, "0") {
		cleaned = "62" + cleaned[1:]
	}
	return cleaned
}

func getEnv(key, def string) string {
	if val := os.Getenv(key); val != "" {
		return val
	}
	return def
}
