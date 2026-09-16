<footer class="bg-slate-900 text-slate-300 pt-12 pb-8 border-t border-slate-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 pb-8 border-b border-slate-800">
            <!-- Brand & Address -->
            <div class="space-y-3">
                <div class="flex items-center gap-2.5">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo Desa {{ $profil->nama_desa ?? 'Rombiya Barat' }}" class="w-9 h-9 object-contain rounded-lg">
                    <span class="text-lg font-bold text-white tracking-wide">SIPEDES {{ $profil->nama_desa ?? 'Rombiya Barat' }}</span>
                </div>
                <p class="text-xs text-slate-400 leading-relaxed">
                    Sistem Pelayanan Desa (SIPEDES) & Portal Administrasi Warga Berbasis Artificial Intelligence RAG (Dify AI).
                </p>
                <p class="text-xs text-slate-400">
                    {{ $profil->kontak['alamat_kantor'] ?? 'Kantor Balai Desa Rombiya Barat, Jl. Raya Ganding - Rombiya Barat No. 01, Kec. Ganding, Kab. Sumenep, Jawa Timur 69462.' }}
                </p>
            </div>

            <!-- Quick Links -->
            <div class="space-y-3">
                <h4 class="text-sm font-semibold text-white tracking-wide">Pelayanan Terpadu Desa</h4>
                <ul class="space-y-2 text-xs">
                    <li><a href="{{ route('warga.pengajuan.wizard') }}" class="hover:text-emerald-400 transition-colors">Pelayanan Surat Online</a></li>
                    <li><a href="{{ route('warga.pengaduan.create') }}" class="hover:text-emerald-400 transition-colors">Lapor Pengaduan & Aspirasi Warga</a></li>
                    <li><a href="{{ route('warga.informasi.bansos') }}" class="hover:text-emerald-400 transition-colors">Cek Penerima Bansos (PKH, BLT-DD, Beras CBP)</a></li>
                    <li><a href="{{ route('warga.informasi.index') }}" class="hover:text-emerald-400 transition-colors">Struktur Pamong & Warta Desa</a></li>
                    <li><a href="{{ route('warga.landing') }}#profil-desa" class="hover:text-emerald-400 transition-colors">Profil, Visi Misi & Potensi Desa</a></li>
                </ul>
            </div>

            <!-- Operational Hours & Emergency -->
            <div class="space-y-3">
                <h4 class="text-sm font-semibold text-white tracking-wide">Jam Operasional Balai Desa</h4>
                <ul class="space-y-1.5 text-xs text-slate-400">
                    @if(!empty($profil->jam_operasional))
                        @foreach($profil->jam_operasional as $hari => $jam)
                            <li class="flex justify-between">
                                <span>{{ $hari }}:</span>
                                <span class="font-medium {{ str_contains(strtolower($jam), 'libur') ? 'text-rose-400' : 'text-slate-200' }}">{{ $jam }}</span>
                            </li>
                        @endforeach
                    @else
                        <li class="flex justify-between"><span>Senin - Kamis:</span> <span class="font-medium text-slate-200">08.00 - 15.00 WIB</span></li>
                        <li class="flex justify-between"><span>Jumat:</span> <span class="font-medium text-slate-200">08.00 - 11.30 WIB</span></li>
                        <li class="flex justify-between"><span>Sabtu - Minggu:</span> <span class="font-medium text-rose-400">Libur (Online 24 Jam)</span></li>
                    @endif
                </ul>
                <div class="pt-2">
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $profil->kontak['whatsapp'] ?? $profil->kontak['telepon'] ?? '082334567890') }}" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-md bg-slate-800 hover:bg-slate-700 text-xs text-emerald-400 font-medium border border-slate-700 transition-colors">
                        Hotline WA: {{ $profil->kontak['whatsapp'] ?? $profil->kontak['telepon'] ?? '082334567890' }}
                    </a>
                </div>
            </div>
        </div>

        <div class="pt-6 flex flex-col md:flex-row items-center justify-between text-xs text-slate-500">
            <p>&copy; {{ date('Y') }} DESA {{ strtoupper($profil->nama_desa ?? 'Rombiya Barat') }}. Hak Cipta Dilindungi Undang-Undang.</p>
            <p class="mt-2 md:mt-0">Powered by Laravel 13 & Dify AI RAG</p>
        </div>
    </div>
</footer>
