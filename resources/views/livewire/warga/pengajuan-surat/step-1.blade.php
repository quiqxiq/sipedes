<div class="space-y-6">
    <div class="text-center max-w-xl mx-auto space-y-2">
        <h2 class="text-xl font-bold text-slate-900">Langkah 1: Pilih Jenis Surat</h2>
        <p class="text-xs text-slate-500">Pilih jenis surat administrasi desa yang ingin Anda ajukan hari ini.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        @foreach($jenisSuratList as $surat)
            <div wire:click="selectJenisSurat({{ $surat->id }})" 
                class="p-5 rounded-2xl border cursor-pointer transition-all flex flex-col justify-between group 
                {{ $jenis_surat_id == $surat->id ? 'bg-emerald-50/80 border-emerald-500 ring-2 ring-emerald-500/20' : 'bg-white border-slate-200 hover:border-emerald-300 hover:bg-slate-50' }}">
                
                <div>
                    <div class="flex items-center justify-between mb-3">
                        <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-emerald-100 text-emerald-800">
                            {{ $surat->kode }}
                        </span>
                        <span class="text-[11px] text-slate-500 font-medium flex items-center gap-1">
                            <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            {{ $surat->estimasi_waktu }}
                        </span>
                    </div>

                    <h3 class="font-bold text-slate-900 text-base group-hover:text-emerald-700 transition-colors mb-1">
                        {{ $surat->nama }}
                    </h3>
                    
                    <p class="text-xs text-slate-600 leading-relaxed mb-4">
                        {{ $surat->deskripsi }}
                    </p>
                </div>

                <div class="pt-3 border-t border-slate-100 flex items-center justify-between">
                    <span class="text-xs font-semibold text-emerald-700">Pilih Layanan Ini</span>
                    <span class="w-6 h-6 rounded-full bg-emerald-600 text-white flex items-center justify-center text-xs font-bold">&rarr;</span>
                </div>
            </div>
        @endforeach
    </div>
</div>
