<?php

namespace App\Jobs;

use App\Services\FonnteClient;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendWhatsAppMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public string $phone;
    public string $templateKey;
    public array $data;

    public function __construct(string $phone, string $templateKey, array $data)
    {
        $this->phone = $phone;
        $this->templateKey = $templateKey;
        $this->data = $data;
    }

    public function handle(): void
    {
        $client = new FonnteClient();
        if (! $client->enabled()) {
            return; // silently skip
        }
        $message = $client->renderTemplate($this->templateKey, $this->data);
        $client->send($this->phone, $message);
    }
}
