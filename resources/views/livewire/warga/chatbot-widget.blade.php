<div id="chat-widget-root" class="fixed bottom-6 right-6 z-50">
    <!-- Floating Chat Trigger Button -->
    <button wire:click="toggleChat" 
        class="w-14 h-14 rounded-full bg-gradient-to-tr from-emerald-600 to-teal-500 text-white flex items-center justify-center shadow-2xl hover:scale-105 active:scale-95 transition-all group">
        @if($isOpen)
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        @else
            <svg class="w-7 h-7 group-hover:rotate-6 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
            </svg>
        @endif
    </button>

    <!-- Chat Floating Box (WhatsApp Style) -->
    @if($isOpen)
        <div class="fixed bottom-24 right-4 sm:right-6 w-[92vw] sm:w-[380px] h-[520px] bg-slate-900 rounded-3xl shadow-2xl border border-slate-700/80 flex flex-col overflow-hidden z-50 animate-in fade-in slide-in-from-bottom-5 duration-200">
            
            <!-- Header -->
            <div class="p-4 bg-slate-800 border-b border-slate-700/80 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="relative">
                        <div class="w-9 h-9 rounded-full bg-emerald-500/20 text-emerald-400 border border-emerald-500/30 flex items-center justify-center text-lg font-bold">
                            🤖
                        </div>
                        <span class="w-2.5 h-2.5 rounded-full bg-emerald-400 absolute bottom-0 right-0 border-2 border-slate-800"></span>
                    </div>
                    <div>
                        <h4 class="font-bold text-white text-sm leading-none">Asisten AI Desa</h4>
                        <span class="text-[11px] text-emerald-400 font-medium">Dify RAG Active • 24/7</span>
                    </div>
                </div>

                <button wire:click="toggleChat" class="text-slate-400 hover:text-white transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <!-- Messages Stream Area -->
            <div id="chat-messages-box" class="flex-grow p-4 overflow-y-auto space-y-3.5 bg-slate-950/60 scrollbar-thin">
                @foreach($messages as $msg)
                    @if($msg['sender'] == 'bot')
                        <div class="flex items-start gap-2 max-w-[88%]">
                            <div class="w-6 h-6 rounded-full bg-emerald-600/30 text-emerald-400 text-xs flex items-center justify-center shrink-0 mt-1">
                                🤖
                            </div>
                            <div class="space-y-1">
                                <div class="p-3.5 rounded-2xl rounded-tl-xs bg-slate-800 text-slate-200 text-xs leading-relaxed border border-slate-700/60 shadow-xs whitespace-pre-line">
                                    {{ $msg['text'] }}
                                </div>

                                @if(!empty($msg['sources']))
                                    <div class="p-2 rounded-xl bg-slate-900/90 border border-slate-800 text-[10px] text-emerald-300/90 space-y-1">
                                        <span class="font-bold block text-slate-400">📚 Acuan Dokumen Resmi:</span>
                                        @foreach($msg['sources'] as $src)
                                            <div class="truncate">
                                                • {{ $src['document_name'] ?? 'SOP Pelayanan Desa' }}
                                            </div>
                                        @endforeach
                                    </div>
                                @endif

                                <span class="text-[9px] text-slate-500 block px-1">{{ $msg['time'] }}</span>
                            </div>
                        </div>
                    @else
                        <div class="flex items-end justify-end">
                            <div class="max-w-[85%] space-y-1">
                                <div class="p-3.5 rounded-2xl rounded-tr-xs bg-emerald-600 text-white text-xs leading-relaxed shadow-sm">
                                    {{ $msg['text'] }}
                                </div>
                                <span class="text-[9px] text-slate-500 block text-right px-1">{{ $msg['time'] }}</span>
                            </div>
                        </div>
                    @endif
                @endforeach

                @if($isLoading)
                    @if($streamedAnswer !== '')
                        <!-- Bubble jawaban streaming real-time -->
                        <div class="flex items-start gap-2 max-w-[88%]">
                            <div class="w-6 h-6 rounded-full bg-emerald-600/30 text-emerald-400 text-xs flex items-center justify-center shrink-0 mt-1">
                                🤖
                            </div>
                            <div class="p-3.5 rounded-2xl rounded-tl-xs bg-slate-800 text-slate-200 text-xs leading-relaxed border border-slate-700/60 shadow-xs whitespace-pre-line" wire:stream="answer">
                                {{ $streamedAnswer }}
                            </div>
                        </div>
                    @else
                        <div class="flex items-center gap-2 text-slate-400 text-xs p-2">
                            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-bounce"></span>
                            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-bounce [animation-delay:0.2s]"></span>
                            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-bounce [animation-delay:0.4s]"></span>
                            <span class="text-[11px] text-slate-500">Mencari di dokumen desa...</span>
                        </div>
                    @endif
                @endif
            </div>

            <!-- Input Box Area -->
            <form wire:submit.prevent="sendMessage" class="p-3 bg-slate-900 border-t border-slate-800 flex items-center gap-2">
                <input type="text" wire:model.live.debounce.500ms="query" placeholder="Ketik pertanyaan (misal: syarat SKU)..."
                    @disabled($isLoading)
                    class="flex-grow px-4 py-2.5 rounded-full bg-slate-800 text-white text-xs placeholder-slate-400 focus:outline-none focus:ring-1 focus:ring-emerald-500 border border-slate-700 disabled:opacity-60 disabled:cursor-not-allowed">
                
                <button type="submit" wire:loading.attr="disabled"
                    class="w-9 h-9 rounded-full bg-emerald-600 hover:bg-emerald-500 text-white flex items-center justify-center shrink-0 transition-colors shadow-md">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9-7-9-7-9 7 9 7zm0 0v-8"></path>
                    </svg>
                </button>
            </form>

        </div>
    @endif
</div>

@script
<script>
    document.addEventListener('livewire:init', () => {
        const scrollToBottom = (box) => {
            if (box) box.scrollTop = box.scrollHeight;
        };

        // Auto-scroll saat jawaban di-streaming (wire:stream)
        Livewire.hook('stream', ({ toEl }) => {
            scrollToBottom(document.getElementById('chat-messages-box'));
        });

        // Auto-scroll setelah DOM diperbarui (pesan baru, loading, dll.)
        Livewire.hook('morph.updated', () => {
            scrollToBottom(document.getElementById('chat-messages-box'));
        });

        // Auto-scroll saat widget dibuka (hanya amati container widget, bukan seluruh halaman)
        const widgetRoot = document.getElementById('chat-widget-root');
        if (widgetRoot) {
            const observer = new MutationObserver(() => {
                scrollToBottom(document.getElementById('chat-messages-box'));
            });
            observer.observe(widgetRoot, { childList: true, subtree: true });
        }
    });
</script>
@endscript
