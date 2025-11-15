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
    /**
     * Send a WhatsApp message using Fonnte API.
     * Optional $options map follows Fonnte docs: countryCode, delay, schedule, typing, template, url, etc.
     */
    public function send(string $phone, string $message, array $options = []): array
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
                    ...$this->filterAllowedOptions($options),
                ]);

            $ok = $response->successful();
            if (! $ok) {
                Log::warning('Fonnte send failed', [
                    'status' => $response->status(),
                    'body' => $this->safeJson($response),
                ]);
            }

            return [
                'success' => $ok,
                'status' => $response->status(),
                'body' => $this->safeJson($response),
                'error' => $ok ? null : ($this->safeJson($response)['detail'] ?? ('HTTP ' . $response->status())),
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
     * Send to multiple recipients. Fonnte supports comma-separated targets.
     * @param array<int,string> $phones
     */
    public function sendToMany(array $phones, string $message, array $options = []): array
    {
        if (! $this->enabled()) {
            return ['success' => false, 'status' => null, 'body' => null, 'error' => 'Fonnte disabled'];
        }

        $normalized = collect($phones)
            ->map(fn (string $p) => preg_replace('/[^0-9]/', '', $p) ?? '')
            ->filter()
            ->map(function (string $n) {
                return str_starts_with($n, '0') ? ('62' . substr($n, 1)) : $n;
            })
            ->implode(',');

        return $this->sendRaw($normalized, $message, $options);
    }

    /**
     * Lower-level sender when target string already normalized and comma-separated.
     */
    protected function sendRaw(string $targets, string $message, array $options = []): array
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => $this->token,
            ])
                ->timeout($this->timeout)
                ->asForm()
                ->post($this->baseUrl . '/send', [
                    'target' => $targets,
                    'message' => $message,
                    ...$this->filterAllowedOptions($options),
                ]);

            $ok = $response->successful();
            return [
                'success' => $ok,
                'status' => $response->status(),
                'body' => $this->safeJson($response),
                'error' => $ok ? null : ($this->safeJson($response)['detail'] ?? ('HTTP ' . $response->status())),
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
     * Allowlist of options supported by Fonnte text API (non-file):
     * countryCode, delay, schedule, typing, template, url, isGroup
     */
    protected function filterAllowedOptions(array $options): array
    {
        $allowed = [
            'countryCode', 'delay', 'schedule', 'typing', 'template', 'url', 'isGroup',
        ];

        return collect($options)
            ->only($allowed)
            ->filter(fn ($v) => $v !== null && $v !== '')
            ->all();
    }

    /**
     * Safely decode JSON; fall back to raw string on failure.
     */
    protected function safeJson(\Illuminate\Http\Client\Response $response): array
    {
        try {
            return $response->json() ?? [];
        } catch (\Throwable $e) {
            return ['raw' => $response->body()];
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
