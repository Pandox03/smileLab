<?php

namespace Database\Seeders;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(RoleSeeder::class);
        $this->call(PrestationSeeder::class);
        $this->call(StockSeeder::class);

        if (! User::where('email', 'demo@smilelab.demo')->exists()) {
            $manager = User::factory()->create([
                'name' => 'Démo Smile Lab',
                'email' => 'demo@smilelab.demo',
                'password' => Hash::make('SmileLab2026'),
            ]);
            $manager->assignRole('manager');
        }

        Setting::setMany([
            'lab_name' => 'Smile Lab',
            'lab_adresse' => "8 rue des Prothésistes\nQuartier Racine\nCasablanca",
            'lab_phone' => '05 22 48 90 10',
            'lab_email' => 'contact@smilelab.demo',
            'lab_siege_social' => '8 rue des Prothésistes, Quartier Racine, Casablanca',
            'facture_prefix' => 'FAC',
            'facture_devise' => 'DHS',
            'facture_prochain_numero' => '1',
            'facture_tva_rate' => '20',
        ]);
    }
}
