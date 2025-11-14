<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Setting;

class FonnteClient
{
    protected string $baseUrl;
    protected ?string $token;
    protected int $timeout;

    public function __construct()
    {
        $this->baseUrl = config('fonnte.base_url');
        $this->token = Setting::get('fonnte_token') ?: config('fonnte.token');
        $this->timeout = config('fonnte.timeout', 15);
    }

    public function enabled(): bool
    {
        $flagSetting = Setting::get('fonnte_enabled');
        $flag = $flagSetting !== null ? filter_var($flagSetting, FILTER_VALIDATE_BOOLEAN) : config('fonnte.enabled');
        return (bool) $flag && !empty($this->token);
    }

    /**
     * Send a WhatsApp message using Fonnte API.
     * @param string $phone E.164 or local format; we normalize digits only.
     * @param string $message Text content with placeholders already replaced.
     * @return array{success:bool, status:int|null, body:mixed, error:string|null}
     */
    public function send(string $phone, string $message): array
    {
        if (! $this->enabled()) {
            return ['success' => false, 'status' => null, 'body' => null, 'error' => 'Fonnte disabled'];
        }

        $normalized = preg_replace('/[^0-9]/', '', $phone);
        if (str_starts_with($normalized, '0')) {
            // Convert Indonesian local number starting with 0 to 62 format
            $normalized = '62' . substr($normalized, 1);
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => $this->token,
            ])
                ->timeout($this->timeout)
                ->asForm()
                ->post($this->baseUrl . '/send', [
                    'target' => $normalized,
                    'message' => $message,
                ]);

            $ok = $response->successful();
            if (! $ok) {
                Log::warning('Fonnte send failed', [
                    'status' => $response->status(),
                    'body' => $response->json(),
                ]);
            }

            return [
                'success' => $ok,
                'status' => $response->status(),
                'body' => $response->json(),
                'error' => $ok ? null : 'HTTP ' . $response->status(),
            ];
        } catch (\Throwable $e) {
            Log::error('Fonnte exception', ['msg' => $e->getMessage()]);
            return [
                'success' => false,
                'status' => null,
                'body' => null,
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Render a template string with placeholders.
     * Available placeholders: {name},{major},{reg}
     */
    public function renderTemplate(string $key, array $data): string
    {
        $custom = Setting::get("fonnte_template_{$key}");
        $base = $custom ?: (config("fonnte.templates.{$key}") ?? '');
        $replace = [
            '{name}' => $data['name'] ?? '',
            '{major}' => $data['major'] ?? '',
            '{reg}' => $data['reg'] ?? '',
        ];
        return strtr($base, $replace);
    }
}
