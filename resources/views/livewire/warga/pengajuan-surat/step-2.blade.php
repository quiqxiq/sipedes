<div class="space-y-6">
    <div class="text-center max-w-xl mx-auto space-y-2">
        <h2 class="text-xl font-bold text-slate-900">Langkah 2: Kelengkapan Berkas & Keterangan</h2>
        <p class="text-xs text-slate-500">
            Surat Terpilih: <strong class="text-emerald-700">{{ $selectedJenisSurat->nama ?? '' }}</strong>
        </p>
    </div>

    @php
        $persyaratan = $selectedJenisSurat->persyaratan_list ?? [];
    @endphp

    <!-- Syarat Berkas Info & Form Input File Terpisah -->
    <div class="space-y-4 bg-white p-6 rounded-2xl border border-slate-200 shadow-xs">
        <div class="border-b border-slate-100 pb-3 flex flex-col sm:flex-row sm:items-center justify-between gap-2">
            <div>
                <h3 class="text-sm font-bold text-slate-900">Form Berkas Persyaratan Yang Perlu Diunggah</h3>
                <p class="text-xs text-slate-500">Silakan unggah dokumen persyaratan di bawah ini (Format: PDF, JPG, JPEG, PNG — Maksimal 3MB per berkas).</p>
            </div>
        </div>

        @if(!empty($persyaratan))
            <div class="space-y-4 pt-1">
                @foreach($persyaratan as $index => $syarat)
                    <div class="p-4 rounded-2xl border transition-all {{ (isset($errors) && $errors->has('dokumenFiles.' . $index)) ? 'border-rose-300 bg-rose-50/40' : 'border-slate-200 bg-slate-50/60' }} space-y-2.5">
                        <div class="flex items-center justify-between gap-2">
                            <label class="text-xs font-bold text-slate-800 flex items-center gap-1.5">
                                <span class="w-5 h-5 rounded-full bg-emerald-600 text-white text-[11px] font-bold flex items-center justify-center shrink-0">
                                    {{ $index + 1 }}
                                </span>
                                <span>{{ $syarat['nama'] }}</span>
                                @if(!empty($syarat['wajib']))
                                    <span class="text-rose-600 font-bold">* (Wajib)</span>
                                @else
                                    <span class="text-slate-400 font-normal">(Opsional)</span>
                                @endif
                            </label>

                            @if(isset($dokumenFiles[$index]) && is_object($dokumenFiles[$index]))
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800 flex items-center gap-1 border border-emerald-200">
                                    <svg class="w-3.5 h-3.5 text-emerald-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    Terpilih
                                </span>
                            @endif
                        </div>

                        @if(!empty($syarat['keterangan']))
                            <p class="text-[11px] text-slate-500 pl-6 italic">📌 Catatan: {{ $syarat['keterangan'] }}</p>
                        @endif

                        <div class="pl-6">
                            <label for="dokumen_file_{{ $index }}" class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 p-3 bg-white rounded-xl border {{ (isset($errors) && $errors->has('dokumenFiles.' . $index)) ? 'border-rose-400 ring-1 ring-rose-300' : 'border-slate-300 hover:border-emerald-500' }} hover:bg-emerald-50/20 transition-all cursor-pointer group shadow-2xs">
                                <input type="file" 
                                       id="dokumen_file_{{ $index }}"
                                       wire:model="dokumenFiles.{{ $index }}" 
                                       accept=".pdf,.jpg,.jpeg,.png"
                                       class="sr-only">

                                <span class="inline-flex items-center justify-center gap-2 px-3.5 py-2 rounded-lg bg-emerald-600 group-hover:bg-emerald-700 text-white font-semibold text-xs transition-colors shrink-0 shadow-xs">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                                    </svg>
                                    <span>Pilih Berkas</span>
                                </span>

                                <div class="flex-1 min-w-0 text-xs">
                                    @if(isset($dokumenFiles[$index]) && is_object($dokumenFiles[$index]))
                                        <div class="flex items-center justify-between gap-2">
                                            <span class="font-medium text-emerald-800 truncate flex items-center gap-1.5">
                                                <span>📄</span>
                                                <span class="truncate">{{ $dokumenFiles[$index]->getClientOriginalName() }}</span>
                                            </span>
                                            <span class="text-slate-400 font-mono text-[11px] shrink-0 ml-1">
                                                {{ round($dokumenFiles[$index]->getSize() / 1024) }} KB
                                            </span>
                                        </div>
                                    @else
                                        <span class="text-slate-400 font-normal">Belum ada berkas dipilih (Format: PDF, JPG, PNG - Maks 3MB)</span>
                                    @endif
                                </div>
                            </label>

                            <div wire:loading wire:target="dokumenFiles.{{ $index }}" class="text-xs text-emerald-600 font-semibold mt-1.5 flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5 animate-spin" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                                </svg>
                                <span>Sedang mengunggah berkas... Mohon tunggu.</span>
                            </div>

                            @error('dokumenFiles.' . $index)
                                <p class="mt-1.5 text-xs text-rose-600 font-medium">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 text-xs text-slate-500 italic">
                Jenis surat ini tidak memerlukan dokumen persyaratan berkas tambahan.
            </div>
        @endif

        <div class="pt-4 border-t border-slate-100">
            <label for="catatan_pemohon" class="block text-xs font-bold text-slate-700 mb-1">Catatan Tambahan / Alasan Keperluan (Opsional)</label>
            <textarea id="catatan_pemohon" wire:model="catatan_pemohon" rows="3" placeholder="Tuliskan keperluan pengajuan surat ini (misal: untuk persyaratan beasiswa, perizinan usaha, dll)" 
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
