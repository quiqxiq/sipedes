<x-filament-panels::page>
    <style>
        /* Scoped WhatsApp Gateway Dashboard Styles */
        .wa-wrapper {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
            font-family: inherit;
        }

        .wa-grid-3 {
            display: grid;
            grid-template-columns: repeat(1, minmax(0, 1fr));
            gap: 1rem;
        }
        @media (min-width: 768px) {
            .wa-grid-3 {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }
        }

        .wa-card {
            background-color: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 1rem;
            padding: 1.25rem 1.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            display: flex;
            align-items: center;
            justify-content: space-between;
            transition: all 0.2s ease;
        }
        .dark .wa-card {
            background-color: #111827;
            border-color: #1f2937;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
        }
        .wa-card:hover {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.08);
        }

        .wa-label {
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: #6b7280;
            margin-bottom: 0.35rem;
        }
        .dark .wa-label { color: #9ca3af; }

        .wa-title {
            font-size: 1.15rem;
            font-weight: 800;
            color: #111827;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .dark .wa-title { color: #f9fafb; }

        .wa-subtext {
            font-size: 0.75rem;
            color: #6b7280;
            margin-top: 0.35rem;
        }
        .dark .wa-subtext { color: #9ca3af; }

        .wa-icon-box {
            width: 3.25rem;
            height: 3.25rem;
            border-radius: 0.875rem;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .wa-icon-box.emerald {
            background-color: #ecfdf5;
            color: #059669;
        }
        .dark .wa-icon-box.emerald {
            background-color: rgba(6, 78, 59, 0.35);
            color: #34d399;
        }
        .wa-icon-box.sky {
            background-color: #f0f9ff;
            color: #0284c7;
        }
        .dark .wa-icon-box.sky {
            background-color: rgba(12, 74, 110, 0.35);
            color: #38bdf8;
        }
        .wa-icon-box.purple {
            background-color: #faf5ff;
            color: #9333ea;
        }
        .dark .wa-icon-box.purple {
            background-color: rgba(88, 28, 135, 0.35);
            color: #c084fc;
        }

        .wa-dot {
            width: 0.65rem;
            height: 0.65rem;
            border-radius: 9999px;
            display: inline-block;
            position: relative;
        }
        .wa-dot.online {
            background-color: #10b981;
            box-shadow: 0 0 8px #10b981;
        }
        .wa-dot.offline {
            background-color: #ef4444;
            box-shadow: 0 0 6px #ef4444;
        }
        .wa-dot.waiting {
            background-color: #f59e0b;
            box-shadow: 0 0 6px #f59e0b;
        }

        /* Banner Success */
        .wa-connected-banner {
            background: linear-gradient(135deg, #ecfdf5 0%, #ffffff 50%, #f0fdf4 100%);
            border: 1px solid #a7f3d0;
            border-radius: 1.25rem;
            padding: 1.5rem 2rem;
            display: flex;
            flex-direction: column;
            gap: 1rem;
            box-shadow: 0 4px 6px -1px rgba(16, 185, 129, 0.08);
        }
        .dark .wa-connected-banner {
            background: linear-gradient(135deg, rgba(6, 78, 59, 0.25) 0%, #111827 50%, rgba(6, 78, 59, 0.15) 100%);
            border-color: #065f46;
        }
        @media (min-width: 768px) {
            .wa-connected-banner {
                flex-direction: row;
                align-items: center;
                justify-content: space-between;
            }
        }

        /* Tabs Card */
        .wa-tab-card {
            background-color: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 1.25rem;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }
        .dark .wa-tab-card {
            background-color: #111827;
            border-color: #1f2937;
        }

        .wa-tab-header {
            padding: 1.25rem 1.75rem;
            background-color: #f9fafb;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }
        .dark .wa-tab-header {
            background-color: rgba(17, 24, 39, 0.7);
            border-color: #1f2937;
        }
        @media (min-width: 768px) {
            .wa-tab-header {
                flex-direction: row;
                align-items: center;
                justify-content: space-between;
            }
        }

        .wa-tab-nav {
            display: inline-flex;
            padding: 0.3rem;
            background-color: #e5e7eb;
            border-radius: 0.75rem;
            gap: 0.25rem;
        }
        .dark .wa-tab-nav { background-color: #1f2937; }

        .wa-tab-btn {
            padding: 0.5rem 1.25rem;
            font-size: 0.8rem;
            font-weight: 700;
            border-radius: 0.55rem;
            border: none;
            background: transparent;
            color: #4b5563;
            cursor: pointer;
            transition: all 0.15s ease;
        }
        .dark .wa-tab-btn { color: #9ca3af; }
        .wa-tab-btn.active {
            background-color: #ffffff;
            color: #059669;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }
        .dark .wa-tab-btn.active {
            background-color: #374151;
            color: #34d399;
        }

        .wa-tab-body {
            padding: 1.75rem;
        }
        @media (min-width: 768px) {
            .wa-tab-body { padding: 2.25rem; }
        }

        /* 2-Column Layout for QR and Pairing */
        .wa-split-layout {
            display: grid;
            grid-template-columns: 1fr;
            gap: 2rem;
            align-items: center;
        }
        @media (min-width: 900px) {
            .wa-split-layout {
                grid-template-columns: 320px 1fr;
            }
        }

        .wa-qr-box {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 1.75rem;
            background-color: #f9fafb;
            border: 2px dashed #d1d5db;
            border-radius: 1.25rem;
            text-align: center;
            min-height: 330px;
        }
        .dark .wa-qr-box {
            background-color: #1f2937;
            border-color: #374151;
        }

        .wa-qr-frame {
            padding: 0.75rem;
            background: #ffffff;
            border-radius: 1rem;
            border: 2px solid #10b981;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        .wa-qr-img {
            width: 230px;
            height: 230px;
            display: block;
            border-radius: 0.5rem;
            object-fit: contain;
        }

        .wa-pairing-box {
            padding: 1.75rem;
            background-color: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 1.25rem;
        }
        .dark .wa-pairing-box {
            background-color: #1f2937;
            border-color: #374151;
        }

        .wa-code-display {
            font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;
            font-size: 2.25rem;
            font-weight: 900;
            letter-spacing: 0.25em;
            text-align: center;
            padding: 1rem 1.5rem;
            background: #ecfdf5;
            color: #065f46;
            border: 2px dashed #34d399;
            border-radius: 0.875rem;
            margin-top: 1rem;
            user-select: all;
        }
        .dark .wa-code-display {
            background: rgba(6, 78, 59, 0.4);
            color: #6ee7b7;
            border-color: #059669;
        }

        /* Step List */
        .wa-steps {
            display: flex;
            flex-direction: column;
            gap: 0.85rem;
        }
        .wa-step-row {
            display: flex;
            align-items: flex-start;
            gap: 0.85rem;
            font-size: 0.875rem;
            color: #374151;
            line-height: 1.5;
        }
        .dark .wa-step-row { color: #d1d5db; }
        .wa-num-badge {
            flex-shrink: 0;
            width: 1.75rem;
            height: 1.75rem;
            border-radius: 0.5rem;
            background-color: #ecfdf5;
            color: #059669;
            font-weight: 800;
            font-size: 0.8rem;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid #a7f3d0;
        }
        .dark .wa-num-badge {
            background-color: rgba(6, 78, 59, 0.4);
            color: #34d399;
            border-color: #065f46;
        }

        /* Buttons & Inputs */
        .wa-btn-primary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 0.65rem 1.25rem;
            font-size: 0.85rem;
            font-weight: 700;
            color: #ffffff;
            background-color: #059669;
            border: none;
            border-radius: 0.65rem;
            cursor: pointer;
            transition: background 0.15s ease;
        }
        .wa-btn-primary:hover { background-color: #047857; }

        .wa-btn-danger {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 0.65rem 1.25rem;
            font-size: 0.85rem;
            font-weight: 700;
            color: #ffffff;
            background-color: #dc2626;
            border: none;
            border-radius: 0.65rem;
            cursor: pointer;
            transition: background 0.15s ease;
        }
        .wa-btn-danger:hover { background-color: #b91c1c; }

        .wa-btn-outline {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            font-size: 0.8rem;
            font-weight: 600;
            color: #374151;
            background-color: #ffffff;
            border: 1px solid #d1d5db;
            border-radius: 0.55rem;
            cursor: pointer;
            transition: all 0.15s ease;
        }
        .dark .wa-btn-outline {
            background-color: #1f2937;
            color: #e5e7eb;
            border-color: #374151;
        }
        .wa-btn-outline:hover {
            background-color: #f3f4f6;
        }
        .dark .wa-btn-outline:hover {
            background-color: #374151;
        }

        .wa-input {
            width: 100%;
            padding: 0.65rem 1rem;
            font-size: 0.875rem;
            border: 1px solid #d1d5db;
            border-radius: 0.65rem;
            background-color: #ffffff;
            color: #111827;
            outline: none;
            transition: border 0.15s ease;
        }
        .dark .wa-input {
            background-color: #111827;
            border-color: #374151;
            color: #f9fafb;
        }
        .wa-input:focus {
            border-color: #059669;
            box-shadow: 0 0 0 2px rgba(5, 150, 105, 0.2);
        }

        /* Form Uji Coba */
        .wa-test-box {
            background-color: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 1.25rem;
            padding: 1.75rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }
        .dark .wa-test-box {
            background-color: #111827;
            border-color: #1f2937;
        }

        .wa-alert-success {
            padding: 0.85rem 1.25rem;
            border-radius: 0.75rem;
            background-color: #ecfdf5;
            border: 1px solid #a7f3d0;
            color: #065f46;
            font-size: 0.85rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.65rem;
            margin-bottom: 1.25rem;
        }
        .dark .wa-alert-success {
            background-color: rgba(6, 78, 59, 0.35);
            border-color: #065f46;
            color: #6ee7b7;
        }

        .wa-alert-danger {
            padding: 0.85rem 1.25rem;
            border-radius: 0.75rem;
            background-color: #fef2f2;
            border: 1px solid #fecaca;
            color: #991b1b;
            font-size: 0.85rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.65rem;
            margin-bottom: 1.25rem;
        }
        .wa-form-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 1rem;
        }
        @media (min-width: 768px) {
            .wa-form-grid {
                grid-template-columns: 240px 1fr;
            }
        }
    </style>

    <div wire:poll.4s="pollStatus" class="wa-wrapper">

        {{-- 1. TIGA KARTU STATUS METRIK UTAMA --}}
        <div class="wa-grid-3">
            {{-- Kartu 1: Gateway Engine --}}
            <div class="wa-card">
                <div>
                    <div class="wa-label">Layanan Go-WA Docker</div>
                    <div class="wa-title">
                        @if($isOnline)
                            <span class="wa-dot online"></span>
                            <span style="color: #059669;">Online (:3100)</span>
                        @else
                            <span class="wa-dot offline"></span>
                            <span style="color: #dc2626;">Offline</span>
                        @endif
                    </div>
                    <div class="wa-subtext">Engine whatsmeow multi-device</div>
                </div>
                <div class="wa-icon-box emerald">
                    <x-heroicon-o-cpu-chip style="width: 1.75rem; height: 1.75rem;" />
                </div>
            </div>

            {{-- Kartu 2: Status Akun WhatsApp --}}
            <div class="wa-card">
                <div>
                    <div class="wa-label">Sesi Akun Desa</div>
                    <div class="wa-title">
                        @if($isLoggedIn)
                            <span class="wa-dot online"></span>
                            <span style="color: #059669;">Terhubung</span>
                        @elseif($isOnline)
                            <span class="wa-dot waiting"></span>
                            <span style="color: #d97706;">Menunggu Pairing</span>
                        @else
                            <span class="wa-dot offline"></span>
                            <span style="color: #dc2626;">Belum Aktif</span>
                        @endif
                    </div>
                    <div class="wa-subtext">
                        {{ $phone ? 'Nomor: +' . $phone : 'Belum ada nomor tertaut' }}
                    </div>
                </div>
                <div class="wa-icon-box sky">
                    <x-heroicon-o-device-phone-mobile style="width: 1.75rem; height: 1.75rem;" />
                </div>
            </div>

            {{-- Kartu 3: Kontrol Real-Time --}}
            <div class="wa-card">
                <div>
                    <div class="wa-label">Sinkronisasi Realtime</div>
                    <div style="margin-top: 0.4rem; display: flex; gap: 0.5rem; align-items: center;">
                        <button type="button" wire:click="refreshStatus" class="wa-btn-outline">
                            <x-heroicon-m-arrow-path style="width: 1rem; height: 1rem;" />
                            Segarkan
                        </button>
                        @if($isLoggedIn)
                            <button type="button" wire:click="disconnect" wire:confirm="Konfirmasi: Putuskan tautan akun WhatsApp balai desa?" class="wa-btn-outline" style="color: #dc2626; border-color: #fca5a5;">
                                <x-heroicon-m-power style="width: 1rem; height: 1rem;" />
                                Logout
                            </button>
                        @endif
                    </div>
                    <div class="wa-subtext">Auto-update setiap 4 detik</div>
                </div>
                <div class="wa-icon-box purple">
                    <x-heroicon-o-signal style="width: 1.75rem; height: 1.75rem;" />
                </div>
            </div>
        </div>

        {{-- 2. TAMPILAN KETIKA SUDAH LOGIN --}}
        @if($isLoggedIn)
            <div class="wa-connected-banner">
                <div style="display: flex; align-items: center; gap: 1.25rem;">
                    <div style="width: 3.5rem; height: 3.5rem; border-radius: 1rem; background-color: #059669; color: #ffffff; display: flex; align-items: center; justify-content: center; flex-shrink: 0; box-shadow: 0 4px 8px rgba(5, 150, 105, 0.25);">
                        <x-heroicon-o-check-badge style="width: 2rem; height: 2rem;" />
                    </div>
                    <div>
                        <div style="font-size: 1.2rem; font-weight: 800; color: #111827;" class="dark:text-white">
                            WhatsApp Balai Desa Aktif & Siap Melayani
                        </div>
                        <div style="font-size: 0.85rem; color: #4b5563; margin-top: 0.25rem;" class="dark:text-gray-300">
                            Perangkat nomor <strong>+{{ $phone }}</strong> siap mengirimkan konfirmasi surat dan notifikasi pengaduan secara otomatis ke warga.
                        </div>
                    </div>
                </div>
                <button type="button" wire:click="disconnect" wire:confirm="Konfirmasi: Anda akan memutuskan tautan WhatsApp ini dari SIPEDES." class="wa-btn-danger">
                    <x-heroicon-m-arrow-right-on-rectangle style="width: 1.1rem; height: 1.1rem;" />
                    Putuskan Perangkat
                </button>
            </div>
        @else
            {{-- 3. TAMPILAN PENAUTAN (SCAN QR & PAIRING CODE) --}}
            <div class="wa-tab-card">
                <div class="wa-tab-header">
                    <div>
                        <div style="font-size: 1.05rem; font-weight: 800; color: #111827;" class="dark:text-white">
                            Tautkan Akun WhatsApp Balai Desa
                        </div>
                        <div style="font-size: 0.8rem; color: #6b7280; margin-top: 0.2rem;">
                            Pilih metode penautan di bawah ini untuk menghubungkan nomor WhatsApp resmi desa.
                        </div>
                    </div>
                    <div class="wa-tab-nav">
                        <button type="button" wire:click="$set('activeTab', 'qr')" class="wa-tab-btn {{ $activeTab === 'qr' ? 'active' : '' }}">
                            📷 Scan QR-Code
                        </button>
                        <button type="button" wire:click="$set('activeTab', 'pairing')" class="wa-tab-btn {{ $activeTab === 'pairing' ? 'active' : '' }}">
                            🔢 Pairing Code (8-Karakter)
                        </button>
                    </div>
                </div>

                <div class="wa-tab-body">
                    {{-- TAB 1: SCAN QR CODE --}}
                    @if($activeTab === 'qr')
                        <div class="wa-split-layout">
                            {{-- Sisi Kiri: Tampilan QR --}}
                            <div class="wa-qr-box">
                                @if(!$isOnline)
                                    <div style="color: #dc2626; margin-bottom: 0.75rem;">
                                        <x-heroicon-o-exclamation-triangle style="width: 3rem; height: 3rem; margin: 0 auto;" />
                                    </div>
                                    <div style="font-weight: 800; font-size: 0.95rem; color: #111827;" class="dark:text-white">
                                        Gateway Sedang Dimulai
                                    </div>
                                    <div style="font-size: 0.75rem; color: #6b7280; margin: 0.5rem 0 1rem 0; line-height: 1.4;">
                                        Kontainer Docker Go-WA sedang melakukan inisialisasi pada port 3100.
                                    </div>
                                    <button type="button" wire:click="refreshStatus" class="wa-btn-primary" style="font-size: 0.8rem; padding: 0.5rem 1rem;">
                                        Cek Status Lagi
                                    </button>
                                @elseif($qrCode)
                                    <div class="wa-qr-frame">
                                        <img src="{{ $qrCode }}" alt="WhatsApp QR Code" class="wa-qr-img" />
                                    </div>
                                    <div style="margin-top: 1rem;">
                                        <button type="button" wire:click="fetchQr" class="wa-btn-outline">
                                            <x-heroicon-m-arrow-path style="width: 1rem; height: 1rem; {{ $loadingQr ? 'animation: spin 1s linear infinite;' : '' }}" />
                                            Segarkan QR Code
                                        </button>
                                    </div>
                                @else
                                    <div style="color: #059669; margin-bottom: 0.75rem;">
                                        <x-heroicon-m-arrow-path style="width: 2.5rem; height: 2.5rem; margin: 0 auto; animation: spin 1.5s linear infinite;" />
                                    </div>
                                    <div style="font-weight: 700; font-size: 0.9rem; color: #111827;" class="dark:text-white">
                                        Menghubungkan ke WhatsApp...
                                    </div>
                                    <div style="font-size: 0.75rem; color: #6b7280; margin: 0.4rem 0 1rem 0;">
                                        Mengambil kode QR multi-device terbaru.
                                    </div>
                                    <button type="button" wire:click="fetchQr" class="wa-btn-primary" style="font-size: 0.8rem; padding: 0.5rem 1rem;">
                                        Ambil QR Sekarang
                                    </button>
                                @endif
                            </div>

                            {{-- Sisi Kanan: Panduan Langkah --}}
                            <div>
                                <div style="font-size: 1.1rem; font-weight: 800; color: #111827; margin-bottom: 1.25rem;" class="dark:text-white">
                                    Panduan Memindai Kode QR dari HP
                                </div>
                                <div class="wa-steps">
                                    <div class="wa-step-row">
                                        <div class="wa-num-badge">1</div>
                                        <div>Buka aplikasi <strong>WhatsApp</strong> pada smartphone resmi Balai Desa Rombiya Barat.</div>
                                    </div>
                                    <div class="wa-step-row">
                                        <div class="wa-num-badge">2</div>
                                        <div>Ketuk menu <strong>titik tiga ⋮</strong> di pojok kanan atas (Android) atau menu <strong>Pengaturan ⚙️</strong> di pojok kanan bawah (iPhone).</div>
                                    </div>
                                    <div class="wa-step-row">
                                        <div class="wa-num-badge">3</div>
                                        <div>Pilih menu <strong>Perangkat Tertaut</strong>, lalu ketuk tombol <strong>Tautkan Perangkat</strong>.</div>
                                    </div>
                                    <div class="wa-step-row">
                                        <div class="wa-num-badge">4</div>
                                        <div>Arahkan kamera HP ke kode QR di sebelah kiri. Sistem akan langsung otomatis terhubung secara real-time!</div>
                                    </div>
                                </div>
                                <div style="margin-top: 1.5rem; padding: 0.85rem 1.25rem; background-color: #fffbeb; border: 1px solid #fde68a; border-radius: 0.75rem; font-size: 0.8rem; color: #92400e; display: flex; align-items: flex-start; gap: 0.6rem;">
                                    <x-heroicon-m-information-circle style="width: 1.25rem; height: 1.25rem; flex-shrink: 0; color: #d97706;" />
                                    <div>
                                        <strong>Tips:</strong> Jika kamera HP buram atau sulit memindai, gunakan tab <strong>Pairing Code (8-Karakter)</strong> di atas untuk menautkan tanpa kamera.
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- TAB 2: PAIRING CODE (8 KARAKTER) --}}
                    @if($activeTab === 'pairing')
                        <div class="wa-split-layout">
                            {{-- Sisi Kiri: Form & Display Kode --}}
                            <div class="wa-pairing-box">
                                <div class="wa-label">Nomor WhatsApp Balai Desa</div>
                                <div style="font-size: 0.8rem; color: #4b5563; margin-bottom: 0.75rem;" class="dark:text-gray-300">
                                    Masukkan nomor HP yang terpasang aplikasi WhatsApp:
                                </div>
                                <div style="display: flex; gap: 0.5rem;">
                                    <input 
                                        type="text" 
                                        wire:model="pairingPhone" 
                                        placeholder="Contoh: 082334567890" 
                                        class="wa-input" />
                                    <button 
                                        type="button" 
                                        wire:click="requestPairingCode" 
                                        class="wa-btn-primary" 
                                        style="white-space: nowrap;">
                                        <x-heroicon-m-key style="width: 1rem; height: 1rem; {{ $loadingPairing ? 'animation: spin 1s linear infinite;' : '' }}" />
                                        <span>{{ $loadingPairing ? 'Membuat...' : 'Buat Kode' }}</span>
                                    </button>
                                </div>
                                @error('pairingPhone')
                                    <div style="font-size: 0.75rem; color: #dc2626; margin-top: 0.35rem;">{{ $message }}</div>
                                @enderror

                                @if($pairingCode)
                                    <div style="margin-top: 1.25rem; text-align: center;">
                                        <div style="font-size: 0.7rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: #059669;">
                                            Kode Pairing Anda
                                        </div>
                                        <div class="wa-code-display">
                                            {{ $pairingCode }}
                                        </div>
                                        <div style="font-size: 0.75rem; color: #059669; margin-top: 0.5rem;">
                                            Masa aktif kode ~{{ $pairingExpiresIn }} detik. Masukkan pada WhatsApp HP Anda sekarang.
                                        </div>
                                    </div>
                                @endif
                            </div>

                            {{-- Sisi Kanan: Panduan Langkah Pairing Code --}}
                            <div>
                                <div style="font-size: 1.1rem; font-weight: 800; color: #111827; margin-bottom: 1.25rem;" class="dark:text-white">
                                    Cara Memasukkan Kode di WhatsApp HP
                                </div>
                                <div class="wa-steps">
                                    <div class="wa-step-row">
                                        <div class="wa-num-badge">1</div>
                                        <div>Buka aplikasi WhatsApp di HP Balai Desa, lalu masuk ke menu <strong>Perangkat Tertaut</strong>.</div>
                                    </div>
                                    <div class="wa-step-row">
                                        <div class="wa-num-badge">2</div>
                                        <div>Ketuk tombol hijau <strong>Tautkan Perangkat</strong>.</div>
                                    </div>
                                    <div class="wa-step-row">
                                        <div class="wa-num-badge">3</div>
                                        <div>
                                            Saat kamera terbuka, perhatikan teks di bagian bawah dan ketuk: <br />
                                            <strong style="color: #059669; text-decoration: underline;">"Tautkan dengan nomor telepon saja"</strong>
                                        </div>
                                    </div>
                                    <div class="wa-step-row">
                                        <div class="wa-num-badge">4</div>
                                        <div>Masukkan 8 karakter kode pairing yang tertera di kotak sebelah kiri. Perangkat akan langsung tertaut!</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @endif

        {{-- 4. FORMULIR UJI COBA KIRIM PESAN --}}
        <div class="wa-test-box">
            <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1.25rem;">
                <div class="wa-icon-box purple" style="width: 2.5rem; height: 2.5rem; border-radius: 0.65rem;">
                    <x-heroicon-o-paper-airplane style="width: 1.35rem; height: 1.35rem;" />
                </div>
                <div>
                    <div style="font-size: 1.05rem; font-weight: 800; color: #111827;" class="dark:text-white">
                        Uji Coba Pengiriman Pesan (Test Send)
                    </div>
                    <div style="font-size: 0.8rem; color: #6b7280;">
                        Kirim pesan uji coba untuk memverifikasi apakah pesan WhatsApp berhasil terkirim ke nomor target.
                    </div>
                </div>
            </div>

            @if($feedbackMessage)
                <div class="{{ $feedbackType === 'success' ? 'wa-alert-success' : 'wa-alert-danger' }}">
                    <x-heroicon-m-check-circle style="width: 1.25rem; height: 1.25rem; flex-shrink: 0;" />
                    <span>{{ $feedbackMessage }}</span>
                </div>
            @endif

            <div class="wa-form-grid">
                <div>
                    <label style="display: block; font-size: 0.75rem; font-weight: 700; color: #374151; margin-bottom: 0.35rem;" class="dark:text-gray-300">
                        Nomor WhatsApp Target
                    </label>
                    <input 
                        type="text" 
                        wire:model="testPhone" 
                        placeholder="Contoh: 081234567890" 
                        class="wa-input" />
                    @error('testPhone')
                        <div style="font-size: 0.75rem; color: #dc2626; margin-top: 0.25rem;">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <label style="display: block; font-size: 0.75rem; font-weight: 700; color: #374151; margin-bottom: 0.35rem;" class="dark:text-gray-300">
                        Isi Pesan Uji Coba
                    </label>
                    <div style="display: flex; gap: 0.5rem;">
                        <input 
                            type="text" 
                            wire:model="testMessage" 
                            class="wa-input" />
                        <button 
                            type="button" 
                            wire:click="sendTestMessage" 
                            class="wa-btn-primary" 
                            style="background-color: #9333ea; white-space: nowrap;">
                            <x-heroicon-m-paper-airplane style="width: 1rem; height: 1rem; {{ $sendingTest ? 'animation: pulse 1s infinite;' : '' }}" />
                            <span>{{ $sendingTest ? 'Mengirim...' : 'Kirim Tes' }}</span>
                        </button>
                    </div>
                    @error('testMessage')
                        <div style="font-size: 0.75rem; color: #dc2626; margin-top: 0.25rem;">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

    </div>
</x-filament-panels::page>
