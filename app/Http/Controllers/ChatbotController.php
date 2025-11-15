<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ChatbotController extends Controller
{
    public function handleChat(Request $request)
    {
        $validated = $request->validate([
            'message' => ['required', 'string', 'max:500'],
        ]);

        // Check settings
        $enabled = Setting::get('gemini_enabled', 'false') === 'true';
        $apiKey = Setting::get('gemini_api_key');
        $model = Setting::get('gemini_model', 'gemini-1.5-flash');
        $system = Setting::get('gemini_system_instruction', self::defaultSystemInstruction());

        if (! $enabled || blank($apiKey)) {
            return response()->json([
                'reply' => 'Maaf, asisten AI belum diaktifkan oleh admin.',
            ], 503);
        }

        $endpoint = sprintf(
            'https://generativelanguage.googleapis.com/v1beta/models/%s:generateContent?key=%s',
            $model,
            $apiKey,
        );

        // Build request payload for Gemini v1beta REST API
        $payload = [
            'system_instruction' => [
                'role' => 'system',
                'parts' => [ ['text' => $system] ],
            ],
            'contents' => [
                [
                    'role' => 'user',
                    'parts' => [ ['text' => (string) $validated['message']] ],
                ],
            ],
            'generation_config' => [
                'temperature' => 0.4,
                'topK' => 32,
                'topP' => 1,
                'maxOutputTokens' => 512,
            ],
        ];

        try {
            $response = Http::timeout(15)
                ->acceptJson()
                ->asJson()
                ->post($endpoint, $payload);

            if (! $response->successful()) {
                return response()->json([
                    'reply' => 'Maaf, asisten AI sedang sibuk. Coba lagi sebentar.',
                ], 500);
            }

            $data = $response->json();
            $text = data_get($data, 'candidates.0.content.parts.0.text')
                ?? data_get($data, 'candidates.0.content.parts.0')
                ?? 'Maaf, saya tidak mendapatkan jawaban.';

            return response()->json([
                'reply' => $this->markdownToSimpleHtml((string) $text),
            ]);
        } catch (\Throwable $e) {
            report($e);
            return response()->json([
                'reply' => 'Maaf, terjadi gangguan koneksi ke layanan AI.',
            ], 500);
        }
    }

    public static function defaultSystemInstruction(): string
    {
        return "Anda adalah asisten virtual untuk PPDB (Penerimaan Peserta Didik Baru) sebuah sekolah. " .
            "Jawab HANYA pertanyaan seputar PPDB: jadwal pendaftaran, persyaratan dokumen, biaya (jika ada), jurusan yang tersedia, dan cara mendaftar. " .
            "Jika pertanyaan di luar topik PPDB, tolak dengan sopan dan arahkan kembali ke topik PPDB. " .
            "Contoh: 'Maaf, saya hanya bisa membantu pertanyaan seputar PPDB sekolah ini.' " .
            "Gunakan bahasa Indonesia yang ramah, singkat, dan jelas.";
    }

    private function markdownToSimpleHtml(string $text): string
    {
        // Escape HTML
        $text = e($text);
        // **bold** => <strong>
        $text = preg_replace('/\*\*(.*?)\*\*/s', '<strong>$1</strong>', $text);
        // *italic* => <em>
        $text = preg_replace('/\*(.*?)\*/s', '<em>$1</em>', $text);
        // new lines to <br>
        return nl2br($text);
    }
}
