<div class="space-y-6">
    <div class="text-center max-w-xl mx-auto space-y-2">
        <h2 class="text-xl font-bold text-slate-900">Langkah 2: Kelengkapan Berkas & Keterangan</h2>
        <p class="text-xs text-slate-500">
            Surat Terpilih: <strong class="text-emerald-700">{{ $selectedJenisSurat->nama ?? '' }}</strong>
        </p>
    </div>

    <!-- Syarat Berkas Info -->
    <div class="p-4 rounded-2xl bg-amber-50 border border-amber-200 text-amber-900 text-xs space-y-2">
        <span class="font-bold block">📌 Syarat Berkas Persyaratan Yang Wajib Diunggah:</span>
        <ul class="list-disc list-inside space-y-1 text-amber-800">
            @foreach((array) ($selectedJenisSurat->syarat ?? []) as $syarat)
                <li>{{ $syarat }}</li>
            @endforeach
        </ul>
    </div>

    <!-- Upload Form -->
    <div class="space-y-4 bg-white p-6 rounded-2xl border border-slate-200">
        <div>
            <label class="block text-xs font-semibold text-slate-700 mb-1">Upload Berkas Persyaratan (PDF, JPG, PNG — Max 3MB per file)</label>
            <input type="file" wire:model="files" multiple class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-emerald-500 outline-none">
            
            <div wire:loading wire:target="files" class="text-xs text-emerald-600 font-semibold mt-1">
                ⏳ Mengunggah file... Mohon tunggu.
            </div>

            @error('files.*')
                <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
            @enderror
        </div>

        @if(!empty($files))
            <div class="space-y-2">
                <span class="text-xs font-bold text-slate-700">Daftar File Terunggah:</span>
                <div class="space-y-1.5">
                    @foreach($files as $index => $file)
                        <div class="flex items-center justify-between p-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs">
                            <span class="font-medium text-slate-800 truncate max-w-xs">{{ $file->getClientOriginalName() }}</span>
                            <span class="text-slate-400 font-mono">{{ round($file->getSize() / 1024) }} KB</span>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <div>
            <label for="catatan_pemohon" class="block text-xs font-semibold text-slate-700 mb-1">Catatan Tambahan / Alasan Keperluan (Opsional)</label>
            <textarea id="catatan_pemohon" wire:model="catatan_pemohon" rows="3" placeholder="Tuliskan keperluan pengajuan surat ini (misal: untuk persyaratan pendaftaran beasiswa kampus, dll)" 
                class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-emerald-500 outline-none"></textarea>
        </div>
    </div>

    <div class="flex items-center justify-between pt-4">
        <button type="button" wire:click="goToStep(1)" class="px-5 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs transition-all">
            &larr; Kembali ke Langkah 1
        </button>

        <button type="button" wire:click="goToStep(3)" class="px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-xs shadow-md transition-all">
            Lanjut ke Konfirmasi &rarr;
        </button>
    </div>
</div>
