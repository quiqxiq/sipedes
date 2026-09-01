@section('title', 'Form Pengajuan Surat Online — SIPEDES')

<div class="py-10 bg-slate-50 min-h-[85vh]">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
        
        <!-- Step Progress Bar -->
        <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-xs">
            <div class="flex items-center justify-between relative">
                <div class="absolute left-0 top-1/2 -translate-y-1/2 w-full h-1 bg-slate-100 z-0"></div>
                <div class="absolute left-0 top-1/2 -translate-y-1/2 h-1 bg-emerald-500 z-0 transition-all duration-300"
                    style="width: {{ $currentStep == 1 ? '0%' : ($currentStep == 2 ? '50%' : '100%') }}"></div>

                <!-- Step 1 Indicator -->
                <div class="relative z-10 flex flex-col items-center gap-1.5 cursor-pointer" wire:click="goToStep(1)">
                    <div class="w-10 h-10 rounded-full font-bold text-sm flex items-center justify-center transition-all shadow-sm
                        {{ $currentStep >= 1 ? 'bg-emerald-600 text-white shadow-emerald-600/30' : 'bg-slate-200 text-slate-500' }}">
                        1
                    </div>
                    <span class="text-[11px] font-bold text-slate-700">Pilih Surat</span>
                </div>

                <!-- Step 2 Indicator -->
                <div class="relative z-10 flex flex-col items-center gap-1.5 cursor-pointer" wire:click="goToStep(2)">
                    <div class="w-10 h-10 rounded-full font-bold text-sm flex items-center justify-center transition-all shadow-sm
                        {{ $currentStep >= 2 ? 'bg-emerald-600 text-white shadow-emerald-600/30' : 'bg-slate-200 text-slate-500' }}">
                        2
                    </div>
                    <span class="text-[11px] font-bold text-slate-700">Form & Berkas</span>
                </div>

                <!-- Step 3 Indicator -->
                <div class="relative z-10 flex flex-col items-center gap-1.5 cursor-pointer" wire:click="goToStep(3)">
                    <div class="w-10 h-10 rounded-full font-bold text-sm flex items-center justify-center transition-all shadow-sm
                        {{ $currentStep == 3 ? 'bg-emerald-600 text-white shadow-emerald-600/30' : 'bg-slate-200 text-slate-500' }}">
                        3
                    </div>
                    <span class="text-[11px] font-bold text-slate-700">Konfirmasi</span>
                </div>
            </div>
        </div>

        <!-- Step Content View -->
        <div class="bg-white p-6 sm:p-8 rounded-3xl border border-slate-200 shadow-sm">
            @if($currentStep == 1)
                @include('livewire.warga.pengajuan-surat.step-1')
            @elseif($currentStep == 2)
                @include('livewire.warga.pengajuan-surat.step-2')
            @elseif($currentStep == 3)
                @include('livewire.warga.pengajuan-surat.step-3')
            @endif
        </div>

    </div>
</div>
