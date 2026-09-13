<?php

return [
    /*
    |--------------------------------------------------------------------------
    | WhatsApp Gateway URL (Go-WA Microservice)
    |--------------------------------------------------------------------------
    | URL endpoint kontainer Go-WA yang berjalan di Docker lokal atau server.
    */
    'gateway_url' => env('WHATSAPP_GATEWAY_URL', 'http://127.0.0.1:3100'),

    /*
    | API Key rahasia untuk autentikasi komunikasi internal REST API
    */
    'api_key' => env('WHATSAPP_API_KEY', 'sipedes_secret_wa_2026'),

    /*
    | Nomor telepon WhatsApp Pamong / Balai Desa default penerima alert internal
    */
    'petugas_phone' => env('WHATSAPP_PETUGAS_PHONE', '082334567890'),

    /*
    | Sakelar master aktif/nonaktifkan pengiriman WhatsApp otomatis
    */
    'enabled' => env('WHATSAPP_NOTIFICATION_ENABLED', true),

    /*
    | Timeout request HTTP ke gateway (dalam detik)
    */
    'timeout' => env('WHATSAPP_HTTP_TIMEOUT', 8),
];
