<?php

namespace Database\Seeders;

use App\Models\WebsiteSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WebsiteSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            [
                'key' => 'hero_youtube_url',
                'value' => 'https://www.youtube.com/embed/i4alQJYhKtw?si=jqo-1bsz6RHNOyDP',
                'type' => 'url',
                'description' => 'YouTube URL for hero section video'
            ],
            [
                'key' => 'hero_youtube_title',
                'value' => 'DESA JERUKSAWIT KAB. KARANGANYAR',
                'type' => 'text',
                'description' => 'Title for hero section YouTube video'
            ]
        ];

        foreach ($settings as $setting) {
            WebsiteSetting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}
