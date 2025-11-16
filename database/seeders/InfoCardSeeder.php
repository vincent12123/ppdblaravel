<?php

namespace Database\Seeders;

use App\Models\InfoCard;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InfoCardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cards = [
            [
                'title' => 'Jadwal Pendaftaran',
                'description' => '1 Juni - 31 Juli ' . date('Y'),
                'icon' => 'fa-calendar-alt',
                'bg_color' => 'indigo',
                'icon_bg_color' => 'indigo',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'Gratis Biaya Pendaftaran',
                'description' => 'Tanpa dipungut biaya apapun',
                'icon' => 'fa-user-check',
                'bg_color' => 'green',
                'icon_bg_color' => 'green',
                'order' => 2,
                'is_active' => true,
            ],
            [
                'title' => '100% Online',
                'description' => 'Daftar kapan saja, di mana saja',
                'icon' => 'fa-laptop',
                'bg_color' => 'yellow',
                'icon_bg_color' => 'yellow',
                'order' => 3,
                'is_active' => true,
            ],
        ];

        foreach ($cards as $card) {
            InfoCard::updateOrCreate(
                ['title' => $card['title']],
                $card
            );
        }
    }
}
