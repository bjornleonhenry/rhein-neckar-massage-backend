<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Angebot;

class AngebotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Complete snapshot of all angebots (as of September 25, 2025)
        $angebots = [
            [
                'id' => 1,
                'title' => 'Entspannende Ganzkörpermassage',
                'description' => 'Eine wohltuende Ganzkörpermassage zur tiefen Entspannung und Stressreduktion.',
                'price' => '120.00',
                'duration_minutes' => 60,
                'category' => 'Massage',
                'image' => 'images/services/massage1.webp',
                'services' => ['Ganzkörpermassage', 'Aromatherapie', 'Entspannung'],
                'is_active' => 1,
                'created_at' => '2025-08-27 16:30:14',
                'updated_at' => '2025-08-27 16:30:14',
            ],
            [
                'id' => 2,
                'title' => 'Tantra Massage Erlebnis',
                'description' => 'Ein sinnliches Tantra-Erlebnis zur spirituellen und körperlichen Harmonie.',
                'price' => '180.00',
                'duration_minutes' => 90,
                'category' => 'Tantra',
                'image' => 'images/services/tantra1.webp',
                'services' => ['Tantra Massage', 'Energiearbeit', 'Meditation'],
                'is_active' => 1,
                'created_at' => '2025-08-27 16:30:14',
                'updated_at' => '2025-08-27 16:30:14',
            ],
            [
                'id' => 3,
                'title' => 'VIP Begleitung für Events',
                'description' => 'Exklusive Begleitung für besondere Anlässe und Events.',
                'price' => '300.00',
                'duration_minutes' => 180,
                'category' => 'Begleitung',
                'image' => 'images/services/vip1.webp',
                'services' => ['Eventbegleitung', 'Styling', 'Konversation'],
                'is_active' => 1,
                'created_at' => '2025-08-27 16:30:14',
                'updated_at' => '2025-08-27 16:30:14',
            ],
            [
                'id' => 4,
                'title' => 'Hot Stone Massage',
                'description' => 'Therapeutische Hot Stone Massage für tiefe Muskelentspannung.',
                'price' => '150.00',
                'duration_minutes' => 75,
                'category' => 'Massage',
                'image' => 'images/services/hotstone1.webp',
                'services' => ['Hot Stone Massage', 'Tiefenentspannung', 'Therapie'],
                'is_active' => 1,
                'created_at' => '2025-08-27 16:30:14',
                'updated_at' => '2025-08-27 16:30:14',
            ],
            [
                'id' => 5,
                'title' => 'Erotische Massage',
                'description' => 'Sinnliche erotische Massage mit besonderer Aufmerksamkeit für Ihre Wünsche.',
                'price' => '140.00',
                'duration_minutes' => 70,
                'category' => 'Massage',
                'image' => 'images/services/erotic1.webp',
                'services' => ['Erotische Massage', 'Sinnlichkeit', 'Entspannung'],
                'is_active' => 1,
                'created_at' => '2025-08-27 16:30:14',
                'updated_at' => '2025-08-27 16:30:14',
            ],
            [
                'id' => 6,
                'title' => 'Paar Massage',
                'description' => 'Romantische Paar-Massage für unvergessliche gemeinsame Momente.',
                'price' => '220.00',
                'duration_minutes' => 90,
                'category' => 'Massage',
                'image' => 'images/services/couple1.webp',
                'services' => ['Paar Massage', 'Romantik', 'Entspannung'],
                'is_active' => 1,
                'created_at' => '2025-08-27 16:30:14',
                'updated_at' => '2025-08-27 16:30:14',
            ],
            [
                'id' => 7,
                'title' => 'Thai Massage',
                'description' => 'Authentische Thai-Massage mit traditionellen Techniken und Stretching.',
                'price' => '130.00',
                'duration_minutes' => 80,
                'category' => 'Massage',
                'image' => 'images/services/thai1.webp',
                'services' => ['Thai Massage', 'Stretching', 'Traditionell'],
                'is_active' => 1,
                'created_at' => '2025-08-27 16:30:14',
                'updated_at' => '2025-08-27 16:30:14',
            ],
            [
                'id' => 8,
                'title' => 'Nuru Massage',
                'description' => 'Exotische Nuru-Massage mit speziellem Gleitgel für ultimative Entspannung.',
                'price' => '200.00',
                'duration_minutes' => 60,
                'category' => 'Massage',
                'image' => 'images/services/nuru1.webp',
                'services' => ['Nuru Massage', 'Gleitgel', 'Exotisch'],
                'is_active' => 1,
                'created_at' => '2025-08-27 16:30:14',
                'updated_at' => '2025-08-27 16:30:14',
            ],
            [
                'id' => 9,
                'title' => 'Business Begleitung',
                'description' => 'Professionelle Begleitung für Geschäftsessen und Business-Events.',
                'price' => '250.00',
                'duration_minutes' => 120,
                'category' => 'Begleitung',
                'image' => 'images/services/business1.webp',
                'services' => ['Business Begleitung', 'Konversation', 'Networking'],
                'is_active' => 1,
                'created_at' => '2025-08-27 16:30:14',
                'updated_at' => '2025-08-27 16:30:14',
            ],
        ];

        foreach ($angebots as $angebotData) {
            Angebot::updateOrCreate(
                ['id' => $angebotData['id']],
                $angebotData
            );
        }
    }
}
