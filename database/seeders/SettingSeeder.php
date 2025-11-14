<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $defaults = [
            'fonnte_enabled' => 'false',
            'fonnte_token' => null,
            'fonnte_template_registered' => config('fonnte.templates.registered'),
            'fonnte_template_accepted' => config('fonnte.templates.accepted'),
            'fonnte_template_rejected' => config('fonnte.templates.rejected'),
        ];

        foreach ($defaults as $key => $value) {
            if (! Setting::query()->where('key', $key)->exists()) {
                Setting::query()->create(['key' => $key, 'value' => $value]);
            }
        }
    }
}
