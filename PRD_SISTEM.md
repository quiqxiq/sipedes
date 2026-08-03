# Product Requirements Document (PRD)
## Sistem Informasi Pelayanan Desa Rombiyah Barat + Chatbot AI (LLM + RAG)

| | |
|---|---|
| **Versi Dokumen** | 1.0 |
| **Tanggal** | Agustus 2026 |
| **Basis** | Bab I–III Skripsi "Sistem Informasi Pelayanan Desa Rombiyah Barat" |
| **Stack Utama** | Laravel 13 (PHP 8.3+), Filament v5 (panel internal), Livewire/Blade (portal warga), Dify (self-hosted RAG) |
| **Status** | Draft untuk implementasi |

---

## 1. Ringkasan Eksekutif

Sistem ini mendigitalkan pelayanan administrasi Desa Rombiyah Barat (pengajuan surat, verifikasi, penerbitan dokumen) sekaligus menyediakan chatbot AI berbasis **Retrieval-Augmented Generation (RAG)** agar warga bisa bertanya soal syarat/prosedur kapan saja tanpa datang ke kantor desa. Arsitektur tetap dua lapis sesuai skripsi: **Laravel** menangani seluruh logika bisnis (auth, surat-menyurat, dashboard tiga peran), sementara **Dify** (self-hosted, via Docker) menangani pipeline AI (embedding, vector store, orchestration LLM) dan diakses Laravel lewat REST API.

Perubahan/tambahan dari versi skripsi:
- Framework dinaikkan ke **Laravel 13** (rilis 17 Maret 2026, minimum PHP 8.3, tanpa breaking change dari Laravel 12).
- **Filament v5** dipakai untuk panel internal (Petugas & Admin) agar CRUD, tabel, filter, dan dashboard statistik bisa dibangun jauh lebih cepat daripada Blade admin custom — Filament v5 terkonfirmasi kompatibel dengan Laravel 13/PHP 8.3+.
- Portal warga (landing, pengajuan surat, riwayat, chatbot) **tetap custom Blade + Livewire**, karena Filament dioptimalkan untuk backoffice/admin, bukan portal publik dengan landing page dan wizard multi-langkah yang ramah non-teknis.

---

## 2. Latar Belakang Singkat

Warga Desa Rombiyah Barat masih mengurus surat secara manual (formulir kertas, antre, kembali lagi beberapa hari kemudian), yang paling memberatkan warga lansia atau yang tinggal jauh dari balai desa. Sistem yang sudah ada di penelitian sejenis (Laravel/PHP + form online) menyelesaikan sebagian masalah, tapi interaksinya satu arah — warga tidak bisa bertanya langsung soal syarat/prosedur. PRD ini menerjemahkan solusi skripsi (Laravel + Dify RAG) menjadi spesifikasi implementasi yang siap dikerjakan.

## 3. Tujuan Produk

1. Digitalkan seluruh alur pengajuan-verifikasi-penerbitan surat (domisili, tidak mampu, usaha, dll).
2. Sediakan chatbot 24/7 yang menjawab hanya berdasarkan dokumen resmi desa (SOP, Perdes, syarat surat), dengan risiko halusinasi ditekan lewat RAG + guardrail system prompt.
3. Berikan dashboard admin/petugas yang informatif (statistik, log aktivitas, manajemen basis pengetahuan) tanpa membangun UI CRUD dari nol.
4. Capai skor **System Usability Scale (SUS) ≥ 70** dan seluruh skenario Black Box Testing lulus sebelum rilis.

## 4. Ruang Lingkup

**Termasuk (in-scope):**
- Web app (browser), tidak ada aplikasi mobile native.
- Tiga peran: Warga, Petugas Desa, Administrator.
- Jenis surat: Domisili, Tidak Mampu, Usaha, Pengantar Nikah, Keterangan Kematian, Lainnya (dinamis via master data).
- Chatbot RAG dengan basis pengetahuan terbatas pada dokumen resmi desa (SOP, syarat surat, Perdes, profil desa).
- Black Box Testing + kuesioner SUS.

**Di luar cakupan (out-of-scope):**
- Aplikasi mobile native (iOS/Android).
- Pembayaran/retribusi online.
- Chatbot menjawab di luar domain layanan desa (general knowledge).
- Integrasi Dukcapil/NIK nasional secara real-time (data kependudukan tetap dikelola lokal oleh desa).

## 5. Definisi & Istilah

| Istilah | Keterangan |
|---|---|
| RAG | Retrieval-Augmented Generation — LLM menjawab berdasarkan konteks dokumen yang di-retrieve, bukan pengetahuan umum |
| Dify | Platform low-code untuk membangun aplikasi LLM (knowledge base, workflow, API chat) — dijalankan self-hosted via Docker |
| Filament | Admin panel builder berbasis Livewire untuk Laravel (Forms, Tables, Actions, Notifications) |
| Chunk | Potongan dokumen hasil pemecahan teks sebelum di-embed ke vector database |
| SUS | System Usability Scale, kuesioner 10 butir untuk mengukur kebergunaan sistem |

## 6. Pengguna & Peran

| Peran | Deskripsi | Akses Utama |
|---|---|---|
| **Warga** | Pengguna umum, mengajukan surat & bertanya ke chatbot | Portal publik (Blade/Livewire): daftar, ajukan surat, riwayat, chatbot, profil desa |
| **Petugas Desa** | Memverifikasi & menerbitkan surat | Panel Filament (subset resource): antrian permohonan, detail, aksi setujui/tolak/minta koreksi, cetak PDF |
| **Administrator** | Mengelola pengguna, basis pengetahuan chatbot, konfigurasi, laporan | Panel Filament penuh: semua resource + Manajemen Dokumen Pengetahuan, Manajemen Pengguna, Laporan, Log Aktivitas |

**Keputusan desain:** satu **Filament Panel** (`/admin`) dipakai bersama oleh Petugas & Admin, dengan visibilitas resource/aksi diatur lewat **Policy** + `spatie/laravel-permission` (role: `petugas`, `admin`), bukan dua panel terpisah. Ini lebih sederhana dipelihara untuk tim kecil/skripsi, dan Filament mendukung navigation grouping + `canAccess()` per resource dengan baik.

## 7. Keputusan Arsitektur & Stack Teknologi

### 7.1 Mengapa Laravel 13
Rilis 17 Maret 2026, minimum PHP 8.3, **tanpa breaking change** dari Laravel 12 — cocok dipakai sebagai basis baru karena upgrade jalur ke depan (bug fix s.d. Q3 2027, security s.d. Q1 2028) lebih panjang dibanding tetap di Laravel 11/12. Fitur baru yang relevan (opsional, tidak wajib dipakai): PHP Attributes sebagai alternatif non-breaking untuk properti kelas, `Cache::touch()`, dan **Laravel AI SDK** first-party (unified API text/agent/embeddings lintas provider OpenAI/Anthropic/Gemini). AI SDK ini **tidak dipakai** sebagai pengganti Dify pada versi pertama — arsitektur tetap mengikuti skripsi (Dify sebagai layanan RAG terpisah) karena sudah menjadi bagian dari kontribusi ilmiah yang dipertahankan. AI SDK bisa jadi jalur migrasi di masa depan jika ingin menyederhanakan arsitektur menjadi satu lapis (lihat §17 Risiko).

### 7.2 Mengapa (dan bagaimana) Filament dipakai
Filament **memungkinkan dan direkomendasikan** untuk proyek ini — versi stabil terbaru (v5.x) mendukung PHP `^8.2` sehingga otomatis kompatibel dengan Laravel 13/PHP 8.3+, dan Livewire/Filament sudah dikonfirmasi menjadi salah satu paket ekosistem yang jalan mulus di Laravel 13. Filament dipakai untuk:
- **Dashboard Admin & Petugas** (kartu statistik, grafik, tabel permohonan) — cocok karena semua kebutuhan di Gambar 3.14–3.15 skripsi (kartu ringkasan, tabel dengan filter/aksi, grafik) adalah kasus pakai inti Filament (`Widgets`, `Table Builder`, `Actions`).
- **Manajemen Dokumen Pengetahuan, Manajemen Pengguna, Log Aktivitas, Laporan** — seluruhnya CRUD/tabel dengan filter & export, yang bisa dibangun 70–80% lebih cepat lewat Filament Resource dibanding Blade admin custom.

Filament **tidak** dipakai untuk sisi warga (landing page, wizard pengajuan surat 3 langkah, widget chatbot ala WhatsApp) karena Filament didesain untuk backoffice, bukan portal publik dengan UX marketing/consumer-facing.

### 7.3 Dify (Self-Hosted RAG)
Dify di-deploy lewat Docker Compose, menyediakan: Knowledge Base (upload SOP/Perdes/syarat surat → auto chunking + embedding), pemilihan model LLM (Ollama lokal atau Cloud API — OpenAI/Anthropic/Gemini), dan REST API (`/chat-messages`, `/completion-messages`) yang dipanggil Laravel via Guzzle.

### 7.4 Ringkasan Stack

| Layer | Teknologi |
|---|---|
| Backend framework | Laravel 13 (PHP 8.3+) |
| Admin/Petugas UI | Filament v5 |
| Portal Warga UI | Blade + Livewire 3 + Alpine.js + Tailwind CSS |
| Database | MySQL 8.0 |
| Queue & cache | Redis + Laravel Horizon |
| Auth | Laravel Fortify (atau Breeze) + Sanctum (jika perlu API mobile nanti) |
| Otorisasi/role | `spatie/laravel-permission` + `bezhansalleh/filament-shield` |
| PDF surat | `barryvdh/laravel-dompdf` (atau `spatie/browsershot` jika perlu render HTML kompleks) |
| AI/RAG service | Dify (self-hosted, Docker Compose) — knowledge base + vector DB + LLM orchestration internal Dify |
| Klien HTTP ke Dify | Guzzle (`guzzlehttp/guzzle`, built-in Laravel) |
| Notifikasi | Laravel Notification (database + mail); WhatsApp opsional via Fonnte/Wablas API |
| Testing | Pest / PHPUnit |
| Aset build | Vite |
| Deployment | Nginx + PHP-FPM (atau Octane/FrankenPHP untuk performa tinggi), Supervisor untuk queue worker |

### 7.5 Diagram Arsitektur (tekstual)

```
[Browser: Warga / Petugas / Admin]
        |  HTTP(S)
        v
+-------------------------------------------------------+
|                 LARAVEL 13 APPLICATION                 |
|  ---------------------------------------------------  |
|  Portal Warga (Blade+Livewire)  |  Filament v5 Panel   |
|  - Landing / Profil Desa        |  - Resource Surat     |
|  - Auth warga                   |  - Resource Users     |
|  - Wizard Ajukan Surat          |  - Knowledge Docs     |
|  - Riwayat Permohonan           |  - Laporan/Statistik  |
|  - Widget Chatbot               |  - Log Aktivitas      |
|  ---------------------------------------------------  |
|  Modul Integrasi Chatbot (Service Class + Guzzle)      |
|  ---------------------------------------------------  |
|  Eloquent ORM  --->  MySQL 8 (users, permohonan_surat, |
|                       jenis_surat, dokumen_persyaratan, |
|                       chat_session, chat_history,       |
|                       knowledge_document, notifikasi,   |
|                       aktivitas_log, profil_desa)       |
|  Queue/Cache  --->  Redis + Horizon                    |
+-------------------------------------------------------+
        |  REST API (chat-messages, completion-messages)
        v
+-------------------------------------------------------+
|            DIFY (Self-Hosted, Docker Compose)          |
|  Knowledge Base -> Chunking -> Embedding -> Vector DB   |
|  Prompt Orchestration -> LLM Provider (Ollama / Cloud)  |
+-------------------------------------------------------+
```

---

## 8. Modul Fungsional

### 8.1 Autentikasi & Manajemen Pengguna
- Registrasi warga (Nama, NIK, Email, Password, Telepon, Alamat) via Blade/Livewire form, validasi unik NIK/email.
- Login berbasis role (Fortify), redirect: warga → portal publik; petugas/admin → Filament panel.
- Opsi "Ingat Saya"; lupa password via email reset link (Laravel bawaan).
- (Opsional, tidak wajib rilis 1) Login WhatsApp OTP / SSO Desa — disiapkan sebagai extension point, bukan target MVP.

### 8.2 Portal Warga
- Landing/Profil Desa: sejarah, visi-misi, kontak, jam operasional, statistik layanan (dibaca dari tabel `profil_desa`).
- Dashboard Warga: 3 kartu aksi (Ajukan Surat, Riwayat Surat, Tanya Chatbot) + status permohonan terakhir.

### 8.3 Pengajuan Surat (Warga)
- Wizard 3 langkah: Pilih Surat → Isi Formulir + Upload Persyaratan → Konfirmasi.
- Validasi kelengkapan syarat & format/ukuran file sebelum simpan.
- Simpan `permohonan_surat` status `diajukan`, kirim notifikasi ke Petugas, tampilkan nomor permohonan + estimasi waktu.
- Tracking status via halaman "Riwayat Permohonan".

### 8.4 Verifikasi & Penerbitan Surat (Petugas — Filament Resource)
- `PermohonanSuratResource` dengan tab/filter status (`diajukan`, `diproses`, `disetujui`, `ditolak`).
- Halaman detail (Filament custom page/infolist): data pemohon, lampiran, panel aksi **Setujui & Proses / Tolak / Minta Koreksi** + catatan petugas — dipetakan langsung dari Filament `Actions`.
- Generate PDF surat dari template resmi (DomPDF) saat disetujui; update status `disetujui`, kirim notifikasi ke warga.

### 8.5 Chatbot AI (RAG via Dify)
- Widget chatbot di portal warga (Livewire component, tampilan ala WhatsApp sesuai mockup skripsi).
- Alur: buat/pakai `chat_session` → simpan pertanyaan ke `chat_history` → normalisasi teks → kirim ke Dify API (`conversation_id`, `query`, `user`) → terima jawaban + referensi sumber → simpan & tampilkan.
- Jika Dify tidak menemukan dokumen relevan atau API gagal, tampilkan pesan fallback ramah ("di luar cakupan info desa" / "coba lagi").

### 8.6 Manajemen Dokumen Pengetahuan (Admin — Filament Resource)
- Upload PDF/DOCX/TXT → validasi format/ukuran → simpan storage → panggil Dify Knowledge API untuk indexing → update `is_indexed`.
- Tampilkan status indexing (Terindeks/Proses/Gagal), jumlah chunks, kategori; aksi hapus (hapus di storage + panggil Dify untuk hapus vektor terkait).

### 8.7 Manajemen Pengguna (Admin — Filament Resource)
- CRUD user lintas role, filter role/status, kunci akun, konfirmasi/tolak akun pending.

### 8.8 Laporan & Statistik (Admin — Filament Widgets/Pages)
- KPI: Total Permohonan, Rata-rata Waktu Penyelesaian, Tingkat Penyelesaian, Interaksi Chatbot.
- Grafik: permohonan per jenis surat, distribusi status (donut), tren bulanan.
- Export PDF/CSV.

### 8.9 Log Aktivitas & Notifikasi
- Semua aksi penting (login, pengajuan, verifikasi, interaksi chatbot, upload dokumen) dicatat ke `aktivitas_log` (audit trail), ditampilkan via Filament Resource read-only dengan filter modul/aksi + export CSV.
- Notifikasi in-app (Laravel Notification `database` channel) + email untuk perubahan status penting.

---

## 9. Skema Basis Data (Ringkasan Entitas)

| Tabel | Field Kunci | Relasi |
|---|---|---|
| `users` | id, nama, nik, email, password, telepon, alamat, role | 1–n ke permohonan_surat (sbg warga & petugas), chat_session, knowledge_document, notifikasi, aktivitas_log |
| `jenis_surat` | id, nama, deskripsi, estimasi_waktu, syarat (json) | 1–n ke permohonan_surat |
| `permohonan_surat` | id, user_id, petugas_id, jenis_surat_id, status, catatan_petugas, file_pdf | n–1 ke users & jenis_surat; 1–n ke dokumen_persyaratan, notifikasi |
| `dokumen_persyaratan` | id, permohonan_id, nama_file, path | n–1 ke permohonan_surat |
| `notifikasi` | id, user_id, permohonan_id, pesan, dibaca_at | n–1 ke users & permohonan_surat |
| `chat_session` | id, user_id, dify_conversation_id, started_at | n–1 ke users; 1–n ke chat_history |
| `chat_history` | id, chat_session_id, pertanyaan, jawaban, sumber (json) | n–1 ke chat_session |
| `knowledge_document` | id, user_id (uploader), nama_file, kategori, jumlah_chunks, is_indexed, dify_document_id | n–1 ke users |
| `aktivitas_log` | id, user_id, modul, aksi, deskripsi, created_at | n–1 ke users |
| `profil_desa` | id, nama_desa, sejarah, visi_misi, kontak, jam_operasional, statistik (json) | entitas mandiri |

---

## 10. Integrasi Dify (Kontrak API)

**Konfigurasi (`.env`):**
```
DIFY_BASE_URL=http://dify-api:5001/v1
DIFY_API_KEY=app-xxxxxxxxxxxxxxxx
DIFY_KNOWLEDGE_API_KEY=dataset-xxxxxxxxxxxxxxxx
```

**Kirim pertanyaan chatbot** — `POST {DIFY_BASE_URL}/chat-messages`
```json
{
  "inputs": {},
  "query": "Apa syarat membuat surat keterangan tidak mampu?",
  "response_mode": "blocking",
  "conversation_id": "",
  "user": "warga-{{user_id}}"
}
```
Respons diproses: ambil `answer`, `conversation_id` (simpan ke `chat_session`), dan metadata `retriever_resources` (dijadikan referensi sumber di `chat_history.sumber`).

**Upload/index dokumen pengetahuan** — `POST {DIFY_BASE_URL}/datasets/{dataset_id}/document/create-by-file` (multipart file) → simpan `document_id` balikan ke `knowledge_document.dify_document_id`, poll status indexing via `GET .../documents/{document_id}/indexing-status`.

**Hapus dokumen** — `DELETE {DIFY_BASE_URL}/datasets/{dataset_id}/documents/{document_id}`.

Semua panggilan dibungkus dalam `App\Services\DifyService` (Guzzle client, timeout, retry 2x dengan backoff, logging kegagalan ke `aktivitas_log`/Laravel log channel `dify`).

---

## 11. Kebutuhan Non-Fungsional

| Aspek | Target |
|---|---|
| **Kegunaan** | Skor SUS ≥ 70 ("layak"), idealnya ≥ 85 |
| **Keamanan** | RBAC (spatie/permission + filament-shield), proteksi CSRF/XSS/SQL Injection bawaan Laravel, hash password (bcrypt/argon2), rate limiting form login & endpoint chatbot |
| **Privasi data** | NIK & data pribadi warga hanya bisa dilihat role berwenang (policy per-resource); NIK disamarkan pada tabel daftar (mis. `****1234`) |
| **Ketersediaan chatbot** | Timeout & fallback message jika Dify/LLM tidak merespons dalam batas waktu (mis. 15 detik) |
| **Performa** | Query builder terpaginasi untuk semua tabel besar (Filament Table default sudah paginate); index DB pada kolom filter umum (status, jenis_surat_id, created_at) |
| **Skalabilitas** | Queue (Horizon) untuk proses berat: generate PDF, kirim notifikasi, indexing dokumen ke Dify — tidak dilakukan sinkron di request cycle |
| **Aksesibilitas** | Kontras warna & ukuran font portal warga ramah pengguna lansia (mockup skripsi sudah mempertimbangkan ini) |

---

## 12. Rencana Pengujian

1. **Black Box Testing** — mencakup seluruh fitur utama: registrasi/login, pengajuan surat, verifikasi surat, generate PDF, chatbot RAG, manajemen dokumen pengetahuan. Teknik: Equivalence Partitioning, Boundary Value Analysis, Decision Table (skenario approve/reject/butuh-koreksi surat; skenario chatbot: pertanyaan dalam cakupan, di luar cakupan, API gagal).
2. **System Usability Scale (SUS)** — kuesioner 10 butir ke warga, petugas, admin setelah UAT; hasil dikategorikan sesuai skala standar (≥70 layak, ≥85 sangat baik).

---

## 13. Persiapan Lingkungan Pengembangan

### 13.1 Prasyarat
- PHP **8.3** atau lebih baru (wajib untuk Laravel 13) + ekstensi: `mbstring`, `openssl`, `pdo_mysql`, `bcmath`, `ctype`, `fileinfo`, `tokenizer`, `xml`, `gd`/`imagick` (untuk DomPDF/QR code Filament).
- Composer 2.x terbaru.
- Node.js 20+ dan NPM/PNPM (untuk Vite, Tailwind, Livewire assets).
- MySQL 8.0 (atau MariaDB 10.6+).
- Redis (queue + cache + Horizon).
- Docker & Docker Compose (untuk menjalankan Dify self-hosted).
- Git.

### 13.2 Instalasi Proyek Laravel 13
```bash
composer create-project laravel/laravel:^13.0 desa-rombiyah-barat
cd desa-rombiyah-barat
cp .env.example .env
php artisan key:generate
```

### 13.3 Instalasi Filament v5
```bash
composer require filament/filament:"^5.0" -W
php artisan filament:install --panels
php artisan make:filament-user   # buat akun admin pertama
```
Untuk role-based access di dalam satu panel:
```bash
composer require bezhansalleh/filament-shield
php artisan shield:install
php artisan shield:generate --all   # generate permission untuk tiap Resource
```

### 13.4 Autentikasi & Otorisasi
```bash
composer require laravel/fortify
php artisan fortify:install
composer require spatie/laravel-permission
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
php artisan migrate
```

### 13.5 Paket Pendukung Lain
```bash
composer require barryvdh/laravel-dompdf     # generate PDF surat
composer require guzzlehttp/guzzle           # klien REST API ke Dify (biasanya sudah ada)
composer require laravel/horizon             # dashboard queue Redis
php artisan horizon:install
composer require spatie/laravel-activitylog  # opsional, percepat audit trail aktivitas_log
```

### 13.6 Frontend (Portal Warga)
```bash
composer require livewire/livewire
npm install
npm install -D tailwindcss postcss autoprefixer
npx tailwindcss init -p
npm run build   # atau `npm run dev` saat development
```

### 13.7 Setup Dify (Self-Hosted via Docker)
```bash
git clone https://github.com/langgenius/dify.git
cd dify/docker
cp .env.example .env
# sesuaikan .env Dify: pilih vector store (mis. bawaan/pgvector/Weaviate), storage, secret key
docker compose up -d
```
Setelah Dify berjalan (default port 80/3000 tergantung konfigurasi), buat:
1. **Knowledge Base** baru → upload dokumen SOP/Perdes/syarat surat desa.
2. **Chat App** baru → pilih LLM provider (Ollama lokal atau API key OpenAI/Anthropic/Gemini) → hubungkan ke Knowledge Base yang dibuat → catat `API Key` app ini untuk dipakai Laravel.

### 13.8 Konfigurasi `.env` Laravel (ringkasan variabel penting)
```
APP_NAME="SI Pelayanan Desa Rombiyah Barat"
APP_URL=https://layanan.rombiyahbarat.desa.id

DB_CONNECTION=mysql
DB_DATABASE=desa_rombiyah_barat

QUEUE_CONNECTION=redis
CACHE_STORE=redis
REDIS_HOST=127.0.0.1

MAIL_MAILER=smtp

DIFY_BASE_URL=http://localhost/v1
DIFY_API_KEY=app-xxxxxxxxxxxxxxxx
DIFY_KNOWLEDGE_API_KEY=dataset-xxxxxxxxxxxxxxxx
DIFY_DATASET_ID=xxxxxxxx-xxxx-xxxx

# opsional, jika notifikasi WhatsApp dipakai
WA_GATEWAY_URL=
WA_GATEWAY_TOKEN=
```

### 13.9 Migrasi, Seeder, dan Storage
```bash
php artisan migrate --seed     # seeder: jenis_surat default, admin/petugas dummy, profil_desa
php artisan storage:link
```

### 13.10 Menjalankan Queue Worker & Scheduler
```bash
php artisan horizon          # jalankan via Supervisor di production
php artisan schedule:work    # untuk cron lokal (di production pakai crontab -> schedule:run)
```

---

## 14. Daftar Library/Package

### 14.1 Composer (Backend)
| Package | Fungsi |
|---|---|
| `laravel/framework:^13.0` | Framework inti |
| `filament/filament:^5.0` | Panel admin/petugas (Forms, Tables, Actions, Widgets) |
| `bezhansalleh/filament-shield` | RBAC berbasis permission di dalam Filament |
| `spatie/laravel-permission` | Role & permission (dipakai bersama filament-shield) |
| `laravel/fortify` | Backend autentikasi (register/login/reset password) |
| `barryvdh/laravel-dompdf` | Generate PDF surat resmi |
| `guzzlehttp/guzzle` | HTTP client untuk memanggil REST API Dify |
| `laravel/horizon` | Dashboard & manajemen queue Redis |
| `spatie/laravel-activitylog` | (opsional) mempercepat pencatatan `aktivitas_log` |
| `spatie/laravel-medialibrary` | (opsional) kelola upload dokumen persyaratan/knowledge lebih rapi |

### 14.2 NPM (Frontend Portal Warga)
| Package | Fungsi |
|---|---|
| `livewire/livewire` (composer) + Alpine.js (bundled Livewire) | Interaktivitas tanpa full SPA |
| `tailwindcss` | Styling utility-first |
| `vite` | Build tool asset (bawaan Laravel 13) |

### 14.3 Layanan Eksternal
| Layanan | Fungsi |
|---|---|
| Dify (self-hosted, Docker) | Knowledge base, embedding, vector store, orchestration LLM, REST API chatbot |
| Ollama (opsional) | Menjalankan LLM open-source secara lokal untuk Dify |
| OpenAI / Anthropic / Google Gemini (opsional) | LLM cloud alternatif yang dikonfigurasi di dalam Dify |
| Fonnte / Wablas (opsional) | Gateway notifikasi WhatsApp |

---

## 15. Deployment & Operasional

- **Web server:** Nginx + PHP-FPM 8.3, atau Laravel Octane + FrankenPHP bila trafik tinggi.
- **Queue:** Horizon dijalankan via Supervisor (auto-restart bila crash) — wajib untuk proses generate PDF, kirim notifikasi, dan pemanggilan indexing Dify agar tidak memblokir request warga.
- **Dify:** butuh resource server terpisah/mencukupi (minimal beberapa GB RAM tergantung model & vector store yang dipilih); disarankan di server/VM sendiri agar tidak bersaing resource dengan Laravel.
- **Backup:** backup terjadwal untuk MySQL (data transaksi desa) **dan** volume Docker Dify (knowledge base + vector index), karena keduanya sama-sama sumber kebenaran yang tidak boleh hilang.
- **HTTPS:** wajib (Let's Encrypt) karena sistem menangani data pribadi (NIK, KK, alamat).
- **Monitoring:** Laravel Pulse/Telescope (dev) untuk observability aplikasi; log channel khusus (`dify`) untuk memantau kegagalan panggilan API AI.

---

## 16. Risiko & Mitigasi

| Risiko | Mitigasi |
|---|---|
| Dify/LLM tidak merespons atau lambat | Timeout + fallback message ramah, queue retry, tampilkan status "chatbot sedang gangguan" tanpa menghentikan fitur lain |
| Halusinasi jawaban chatbot | System prompt yang membatasi ke konteks dokumen (sudah dirancang di Bab III), tahap "cek cakupan" menolak menjawab bila di luar dokumen |
| Data desa sensitif (NIK, KK) bocor | RBAC ketat via filament-shield, penyamaran NIK di tampilan daftar, HTTPS wajib |
| Kompleksitas menjalankan 2 sistem (Laravel + Dify) | Docker Compose terdokumentasi jelas, service class terpisah (`DifyService`) agar mudah di-mock saat testing |
| Filament kurang cocok untuk kebutuhan UI sangat custom (mis. widget chatbot WhatsApp-style) | Sudah diantisipasi: bagian tersebut dibangun di luar Filament (Blade/Livewire), Filament hanya untuk backoffice |
| Ke depan ingin menyederhanakan arsitektur (hilangkan Dify) | Laravel 13 punya AI SDK first-party (unified provider) — bisa jadi jalur migrasi jangka panjang, tapi **bukan** untuk rilis pertama karena mengubah kontribusi ilmiah skripsi |

---

## 17. Fase Pengembangan (selaras Waterfall skripsi)

1. **Analisis Kebutuhan** — sudah selesai (Bab I–III skripsi: wawancara Kepala Desa, Petugas, Warga).
2. **Perancangan** — sudah selesai (Flowchart, DFD, ERD, wireframe); PRD ini menerjemahkannya ke keputusan teknis.
3. **Implementasi** — setup proyek (§13) → modul Auth → modul Surat (Warga+Petugas) → integrasi Dify+Chatbot → modul Admin (dokumen pengetahuan, pengguna, laporan, log).
4. **Pengujian** — Black Box Testing per modul + kuesioner SUS ke tiga kelompok pengguna.
5. **Evaluasi & Penyempurnaan** — perbaikan berdasarkan temuan pengujian, dokumentasikan hasil sebagai bagian laporan penelitian.

---

*Dokumen ini disusun berdasarkan isi Bab I–III skripsi dan diperbarui untuk menggunakan Laravel 13 serta Filament v5 sebagai keputusan implementasi tambahan (belum ada di draf skripsi asli) — sebaiknya dicantumkan sebagai catatan implementasi/lampiran teknis saat penulisan Bab IV.*