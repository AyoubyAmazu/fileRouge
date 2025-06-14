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
            [
                'titre' => 'Atelier de Développement Web',
                'description' => 'Atelier pratique sur les frameworks modernes',
                'date_debut' => '2024-08-20',
                'date_fin' => '2024-08-20',
                'lieu' => 'Salle de Formation IT-Wave',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'titre' => 'Séminaire de Sécurité Informatique',
                'description' => 'Séminaire sur la cybersécurité et la protection des données',
                'date_debut' => '2024-09-10',
                'date_fin' => '2024-09-10',
                'lieu' => 'Centre de Conférences IT-Wave',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'titre' => 'Webinaire sur l\'Intelligence Artificielle',
                'description' => 'Webinaire interactif sur les applications de l\'IA',
                'date_debut' => '2024-10-05',
                'date_fin' => '2024-10-05',
                'lieu' => 'En ligne',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'titre' => 'Salon des Startups',
                'description' => 'Rencontre des startups innovantes',
                'date_debut' => '2024-11-15',
                'date_fin' => '2024-11-15',
                'lieu' => 'Parc des Expositions IT-Wave',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

    }
}
