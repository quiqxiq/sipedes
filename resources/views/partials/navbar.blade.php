<nav class="sticky top-0 z-40 bg-white/90 backdrop-blur-md border-b border-slate-200/80 shadow-xs">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            <!-- Brand Logo -->
            <div class="flex items-center gap-3">
                <a href="{{ route('warga.landing') }}" class="flex items-center gap-2.5 group">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-emerald-600 to-teal-500 flex items-center justify-center shadow-md shadow-emerald-500/20 group-hover:scale-105 transition-transform duration-200">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m0 0h5m-5 0v-4m0 4h5m-5 0v-4m0 0h-5m5 0V7"></path>
                        </svg>
                    </div>
                    <div class="flex flex-col">
                        <span class="font-bold text-lg text-slate-800 leading-snug group-hover:text-emerald-600 transition-colors">SIPEDES</span>
                        <span class="text-xs text-slate-500 font-medium">Rombiyah Barat</span>
                    </div>
                </a>
            </div>

            <!-- Navigation Links -->
            <div class="hidden lg:flex items-center space-x-5">
                <a href="{{ route('warga.landing') }}" class="text-xs font-semibold text-slate-600 hover:text-emerald-600 transition-colors">
                    Beranda
                </a>
                <a href="{{ route('warga.landing') }}#layanan" class="text-xs font-semibold text-slate-600 hover:text-emerald-600 transition-colors">
                    Layanan Surat
                </a>
                <a href="{{ route('warga.pengaduan.create') }}" class="text-xs font-semibold text-slate-600 hover:text-emerald-600 transition-colors">
                    Lapor Pengaduan
                </a>
                <a href="{{ route('warga.informasi.bansos') }}" class="text-xs font-semibold text-slate-600 hover:text-emerald-600 transition-colors">
                    Bansos & Program
                </a>
                <a href="{{ route('warga.informasi.index') }}" class="text-xs font-semibold text-slate-600 hover:text-emerald-600 transition-colors">
                    Warta & Pamong
                </a>
                @auth
                    <a href="{{ route('warga.dashboard') }}" class="text-xs font-semibold text-emerald-700 bg-emerald-50 px-3 py-1.5 rounded-lg hover:bg-emerald-100 transition-colors">
                        Dashboard Warga
                    </a>
                @endauth
            </div>

            <!-- User Auth Action Buttons -->
            <div class="flex items-center gap-3">
                @auth
                    <div class="relative flex items-center gap-3">
                        <a href="{{ route('warga.pengajuan.wizard') }}" class="hidden sm:inline-flex items-center gap-1.5 px-4 py-2 text-xs font-semibold text-white bg-gradient-to-r from-emerald-600 to-teal-600 rounded-lg hover:from-emerald-500 hover:to-teal-500 shadow-sm transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Ajukan Surat
                        </a>
                        
                        <div class="flex items-center gap-2 pl-2 border-l border-slate-200">
                            <div class="w-8 h-8 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold text-sm">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                            <span class="hidden lg:inline text-xs font-semibold text-slate-700">{{ Auth::user()->name }}</span>
                            
                            <form method="POST" action="{{ route('warga.logout') }}" class="inline">
                                @csrf
                                <button type="submit" title="Keluar" class="p-1.5 text-slate-400 hover:text-rose-600 transition-colors rounded-lg hover:bg-rose-50">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1m0-10V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2h4a2 2 0 002-2v-1"></path>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('warga.login') }}" class="px-4 py-2 text-xs font-semibold text-slate-700 hover:text-emerald-600 hover:bg-slate-50 rounded-lg transition-all">
                        Masuk
                    </a>
                    <a href="{{ route('warga.register') }}" class="px-4 py-2 text-xs font-semibold text-white bg-emerald-600 hover:bg-emerald-500 rounded-lg shadow-sm transition-all">
                        Daftar Warga
                    </a>
                @endauth
            </div>
        </div>
    </div>
</nav>
