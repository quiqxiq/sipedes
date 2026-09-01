<footer class="bg-slate-900 text-slate-300 pt-12 pb-8 border-t border-slate-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 pb-8 border-b border-slate-800">
            <!-- Brand & Address -->
            <div class="space-y-3">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-lg bg-emerald-500 flex items-center justify-center text-white font-bold">
                        S
                    </div>
                    <span class="text-lg font-bold text-white tracking-wide">SIPEDES Rombiyah Barat</span>
                </div>
                <p class="text-xs text-slate-400 leading-relaxed">
                    Sistem Informasi Pelayanan Desa & Portal Administrasi Warga Berbasis Artificial Intelligence RAG (Dify AI).
                </p>
                <p class="text-xs text-slate-400">
                    Kantor Balai Desa Rombiyah Barat, Jl. Raya Ganding - Rombiyah Barat No. 01, Kec. Ganding, Kab. Sumenep, Jawa Timur 69462.
                </p>
            </div>

            <!-- Quick Links -->
            <div class="space-y-3">
                <h4 class="text-sm font-semibold text-white tracking-wide">Pelayanan Terpadu Desa</h4>
                <ul class="space-y-2 text-xs">
                    <li><a href="{{ route('warga.pengajuan.wizard') }}" class="hover:text-emerald-400 transition-colors">Pelayanan Surat Online</a></li>
                    <li><a href="{{ route('warga.pengaduan.create') }}" class="hover:text-emerald-400 transition-colors">Lapor Pengaduan & Aspirasi Warga</a></li>
                    <li><a href="{{ route('warga.informasi.bansos') }}" class="hover:text-emerald-400 transition-colors">Informasi Bansos (BLT-DD & Pangan)</a></li>
                    <li><a href="{{ route('warga.informasi.index') }}" class="hover:text-emerald-400 transition-colors">Struktur Pamong 5 Dusun & Warta Desa</a></li>
                </ul>
            </div>

            <!-- Operational Hours & Emergency -->
            <div class="space-y-3">
                <h4 class="text-sm font-semibold text-white tracking-wide">Jam Operasional Balai Desa</h4>
                <ul class="space-y-1.5 text-xs text-slate-400">
                    <li class="flex justify-between"><span>Senin - Kamis:</span> <span class="font-medium text-slate-200">08.00 - 15.00 WIB</span></li>
                    <li class="flex justify-between"><span>Jumat:</span> <span class="font-medium text-slate-200">08.00 - 11.30 WIB</span></li>
                    <li class="flex justify-between"><span>Sabtu - Minggu:</span> <span class="font-medium text-rose-400">Libur</span></li>
                </ul>
                <div class="pt-2">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-md bg-slate-800 text-xs text-emerald-400 font-medium border border-slate-700">
                        Hotline WA: 0812-3456-7890
                    </span>
                </div>
            </div>
        </div>

        <div class="pt-6 flex flex-col md:flex-row items-center justify-between text-xs text-slate-500">
            <p>&copy; {{ date('Y') }} Pemerintah Desa Rombiyah Barat. Hak Cipta Dilindungi Undang-Undang.</p>
            <p class="mt-2 md:mt-0">Powered by Laravel 13 & Dify AI RAG</p>
        </div>
    </div>
</footer>
