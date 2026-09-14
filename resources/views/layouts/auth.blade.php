<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Autentikasi Warga — SIPEDES Desa Rombiya Barat')</title>
    <link rel="icon" type="image/jpeg" href="{{ asset('images/logo.png') }}">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS (via Vite) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Outfit', sans-serif;
        }
    </style>
</head>
<body class="min-h-screen flex flex-col justify-between bg-gradient-to-br from-slate-50 via-emerald-50/20 to-slate-100 text-slate-800 antialiased selection:bg-emerald-500 selection:text-white">
    
    <!-- Minimalist Navigation Bar (Tanpa Header Landing Page) -->
    <header class="w-full py-4 px-4 sm:px-8 flex items-center justify-between">
        <a href="{{ route('warga.landing') }}" class="inline-flex items-center gap-2 text-xs font-semibold text-slate-600 hover:text-emerald-600 bg-white/80 hover:bg-white px-3.5 py-2 rounded-xl border border-slate-200/80 shadow-xs backdrop-blur-sm transition-all group">
            <svg class="w-4 h-4 transition-transform group-hover:-translate-x-0.5 text-slate-500 group-hover:text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            <span>Kembali ke Beranda</span>
        </a>
    </header>

    <!-- Flash Notifications -->
    <div class="max-w-md mx-auto w-full px-4 sm:px-6">
        @if(session('success'))
            <div class="mb-4 p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs sm:text-sm flex items-start gap-3 shadow-xs">
                <svg class="w-5 h-5 text-emerald-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div class="flex-1 leading-relaxed">{{ session('success') }}</div>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-4 p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-xs sm:text-sm flex items-start gap-3 shadow-xs">
                <svg class="w-5 h-5 text-rose-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div class="flex-1 leading-relaxed">{{ session('error') }}</div>
            </div>
        @endif

        @if(session('info'))
            <div class="mb-4 p-4 rounded-2xl bg-sky-50 border border-sky-200 text-sky-800 text-xs sm:text-sm flex items-start gap-3 shadow-xs">
                <svg class="w-5 h-5 text-sky-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div class="flex-1 leading-relaxed">{{ session('info') }}</div>
            </div>
        @endif
    </div>

    <!-- Main Auth Card Container -->
    <main class="flex-1 flex items-center justify-center py-6 sm:py-10 px-4 sm:px-6">
        @yield('content')
    </main>

    <!-- Minimalist Clean Footer (Tanpa Footer Landing Page) -->
    <footer class="w-full py-4 text-center text-xs text-slate-400">
        <p>&copy; {{ date('Y') }} Pemerintah Desa Rombiya Barat &middot; SIPEDES Digital</p>
    </footer>

    @livewireScripts
    @stack('scripts')
</body>
</html>
