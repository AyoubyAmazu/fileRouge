<?php

namespace Modules\pkgEvenement\Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EvenementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('evenements')->insert([
            [
                'titre' => 'Hackathon IT-Wave',
                'description' => 'Création de solutions digitales',
                'date_debut' => '2025-06-01',
                'date_fin' => '2025-06-01',
                'lieu' => 'Salle Polyvalente Solicode',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'titre' => 'Conférence Tech',
                'description' => 'Conférence sur les dernières technologies',
                'date_debut' => '2025-07-15',
                'date_fin' => '2025-07-15',
                'lieu' => 'Auditorium Central',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

    }
}
