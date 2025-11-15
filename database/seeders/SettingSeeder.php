<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $defaults = [
            // WhatsApp Fonnte Settings
            'fonnte_enabled' => 'false',
            'fonnte_token' => null,
            'fonnte_template_registered' => config('fonnte.templates.registered'),
            'fonnte_template_accepted' => config('fonnte.templates.accepted'),
            'fonnte_template_rejected' => config('fonnte.templates.rejected'),

            // School Information
            'school_name' => 'SMK Negeri 1',
            'school_address' => 'Jl. Pendidikan No. 123',
            'school_city' => 'Jakarta',
            'school_province' => 'DKI Jakarta',
            'school_postal_code' => '12345',
            'school_phone' => '(021) 1234-5678',
            'school_email' => 'ppdb@smk.sch.id',
            'school_website' => 'https://smk.sch.id',
            'school_description' => 'Sistem Penerimaan Peserta Didik Baru online yang memudahkan calon siswa untuk mendaftar ke SMK kami.',

            // Social Media (empty by default)
            'school_facebook' => '',
            'school_instagram' => '',
            'school_youtube' => '',
            'school_whatsapp' => '',

            // Chatbot (Gemini) defaults
            'gemini_enabled' => 'false',
            'gemini_api_key' => null,
            'gemini_model' => 'gemini-1.5-flash',
            'gemini_system_instruction' => \App\Http\Controllers\ChatbotController::defaultSystemInstruction(),
        ];

        foreach ($defaults as $key => $value) {
            if (! Setting::query()->where('key', $key)->exists()) {
                Setting::query()->create(['key' => $key, 'value' => $value]);
            }
        }
    }
}
