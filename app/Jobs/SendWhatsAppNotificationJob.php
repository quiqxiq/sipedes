<?php

namespace App\Jobs;

use App\Services\WhatsAppService;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendWhatsAppNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;
    public int $backoff = 5;

    public string $templateKode;
    public string $phone;
    public array $variables;
    public ?string $namaPenerima;
    public ?int $refId;

    /**
     * Create a new job instance.
     */
    public function __construct(
        string $templateKode,
        string $phone,
        array $variables = [],
        ?string $namaPenerima = null,
        ?int $refId = null
    ) {
        $this->templateKode = $templateKode;
        $this->phone = $phone;
        $this->variables = $variables;
        $this->namaPenerima = $namaPenerima;
        $this->refId = $refId;
    }

    /**
     * Execute the job.
     */
    public function handle(WhatsAppService $waService): void
    {
        try {
            $waService->sendTemplate(
                $this->templateKode,
                $this->phone,
                $this->variables,
                $this->namaPenerima,
                $this->refId
            );
        } catch (Exception $e) {
            Log::error("SendWhatsAppNotificationJob Error: {$e->getMessage()}");
            throw $e;
        }
    }
}
