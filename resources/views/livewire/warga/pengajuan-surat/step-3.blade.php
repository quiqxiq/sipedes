<div class="space-y-6">
    <div class="text-center max-w-xl mx-auto space-y-2">
        <h2 class="text-xl font-bold text-slate-900">Langkah 3: Konfirmasi Permohonan</h2>
        <p class="text-xs text-slate-500">Periksa kembali ringkasan data sebelum mengirimkan permohonan ke petugas desa.</p>
    </div>

    <div class="bg-white p-6 rounded-2xl border border-slate-200 space-y-4 text-xs">
        <div class="border-b border-slate-100 pb-3 flex items-center justify-between">
            <span class="text-slate-500 font-semibold">Jenis Surat:</span>
            <span class="font-bold text-emerald-700 text-sm">{{ $selectedJenisSurat->nama ?? '' }}</span>
        </div>

        <div class="border-b border-slate-100 pb-3 flex items-center justify-between">
            <span class="text-slate-500 font-semibold">Estimasi Waktu Proses:</span>
            <span class="font-semibold text-slate-800">{{ $selectedJenisSurat->estimasi_waktu ?? '-' }}</span>
        </div>

        <div class="border-b border-slate-100 pb-3 flex items-center justify-between">
            <span class="text-slate-500 font-semibold">Nama Pemohon:</span>
            <span class="font-bold text-slate-800">{{ Auth::user()->name }}</span>
        </div>

        <div class="border-b border-slate-100 pb-3 flex items-center justify-between">
            <span class="text-slate-500 font-semibold">NIK Pemohon:</span>
            <span class="font-mono text-slate-800">{{ Auth::user()->nik }}</span>
        </div>

        @php
            $persyaratan = $selectedJenisSurat->persyaratan_list ?? [];
            $uploadedCount = collect($dokumenFiles)->filter(fn ($f) => $f && is_object($f))->count();
        @endphp

        <div class="border-b border-slate-100 pb-3 flex items-center justify-between">
            <span class="text-slate-500 font-semibold">Jumlah Berkas Diunggah:</span>
            <span class="font-bold text-emerald-700">{{ $uploadedCount }} Berkas</span>
        </div>

        @if($uploadedCount > 0)
            <div class="border-b border-slate-100 pb-3 space-y-2">
                <span class="text-slate-500 font-semibold block">Rincian Dokumen Persyaratan:</span>
                <div class="space-y-1.5">
                    @foreach($dokumenFiles as $idx => $file)
                        @if($file && is_object($file))
                            <div class="flex items-center justify-between p-2.5 rounded-xl bg-slate-50 border border-slate-200">
                                <div class="flex items-center gap-2">
                                    <span class="px-2 py-0.5 rounded-md bg-emerald-100 text-emerald-800 font-bold text-[10px]">
                                        {{ $persyaratan[$idx]['nama'] ?? ('Berkas ' . ($idx + 1)) }}
                                    </span>
                                    <span class="font-medium text-slate-800 text-xs truncate max-w-xs">{{ $file->getClientOriginalName() }}</span>
                                </div>
                                <span class="text-slate-400 font-mono text-[11px]">{{ round($file->getSize() / 1024) }} KB</span>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        @endif

        @if($catatan_pemohon)
            <div class="pb-2">
                <span class="text-slate-500 font-semibold block mb-1">Catatan Pemohon:</span>
                <p class="p-3 rounded-xl bg-slate-50 text-slate-700 leading-relaxed">{{ $catatan_pemohon }}</p>
            </div>
        @endif
    </div>

    <div class="flex items-center justify-between pt-4">
        <button type="button" wire:click="goToStep(2)" class="px-5 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs transition-all">
            &larr; Ubah Berkas (Langkah 2)
        </button>

        <button type="button" wire:click="submit" class="px-6 py-3 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-xs shadow-lg shadow-emerald-600/25 transition-all">
            Kirim Permohonan Surat &rarr;
        </button>
    </div>
</div>
