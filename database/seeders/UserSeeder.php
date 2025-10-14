<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Snapshot of current users data as of September 25, 2025
        $users = [
            [
                'id' => 1,
                'name' => 'admin',
                'email' => 'admin@rhein-neckar-massage.de',
                'email_verified_at' => null,
                'password' => '$2y$12$2H.Ua5zODcgshSaBRdMW4uv4IAsJx7kvLwb5VqglsXjlHaeV/KIG.',
                'two_factor_secret' => null,
                'two_factor_recovery_codes' => null,
                'two_factor_confirmed_at' => null,
                'remember_token' => null,
                'created_at' => '2025-08-27 12:38:32',
                'updated_at' => '2025-09-24 22:19:13',
            ],
            [
                'id' => 2,
                'name' => 'admin',
                'email' => 'admin@rhein-neckar-massage.team',
                'email_verified_at' => null,
                'password' => '$2y$12$KcSQrtzk7Y17Hb161NZ/0utUzS3Xrax30qiV7K7EAd2k3uKFzaOcy',
                'two_factor_secret' => null,
                'two_factor_recovery_codes' => null,
                'two_factor_confirmed_at' => null,
                'remember_token' => null,
                'created_at' => '2025-08-27 14:39:49',
                'updated_at' => '2025-09-24 22:20:19',
            ],
            [
                'id' => 3,
                'name' => 'admin',
                'email' => 'admin@escortsmassage.com',
                'email_verified_at' => '2025-08-28 00:27:10',
                'password' => '$2y$12$dVtYY68W6TlPybfjMcPWC.yQyJK6ue1K2X3c5hf2U/1nV.wXNePZS',
                'two_factor_secret' => null,
                'two_factor_recovery_codes' => null,
                'two_factor_confirmed_at' => null,
                'remember_token' => 'eOs2lzLU7J8VwcZ0j4N766WcDiDhcl7SXt0F0QoJtv5KSj4FmFG2thgk3M3J',
                'created_at' => '2025-08-27 18:20:55',
                'updated_at' => '2025-08-28 00:27:10',
            ],
            [
                'id' => 16,
                'name' => 'Test User',
                'email' => 'test@example.com',
                'email_verified_at' => '2025-09-25 00:25:47',
                'password' => '$2y$12$DSWs2siV111sh0MvqjOlt.jSWuFr5/Henqj8Tkg10tQvcyjFUnVbe',
                'two_factor_secret' => null,
                'two_factor_recovery_codes' => null,
                'two_factor_confirmed_at' => null,
                'remember_token' => 'crHnRLCrF3',
                'created_at' => '2025-09-25 00:25:47',
                'updated_at' => '2025-09-25 00:25:47',
            ],
        ];
        
        foreach ($users as $userData) {
            User::updateOrCreate(
                ['email' => $userData['email']],
                $userData
            );
        }
    }
}
