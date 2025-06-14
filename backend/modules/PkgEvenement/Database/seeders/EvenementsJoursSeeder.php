<?php


namespace Modules\pkgEvenement\Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EvenementsJoursSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('Evenement_jours')->insert([
            [
                'evenement_id' => 1,
                'date' => '2025-06-01',
                'heure_debut' => '09:00:00',
                'heure_fin' => '17:00:00',
                'apporter' => 'Ordinateur portable, chargeur',
                'description' => 'Journée de formation sur les nouvelles technologies',
                'pause_cafe' => true,
                'pause_dejeuner' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'evenement_id' => 2,
                'date' => '2025-06-02',
                'heure_debut' => '10:00:00',
                'heure_fin' => '16:00:00',
                'apporter' => null,
                'description' => 'Conférence sur l\'innovation en entreprise',
                'pause_cafe' => true,
                'pause_dejeuner' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'evenement_id' => 2,
                'date' => '2025-06-03',
                'heure_debut' => '08:30:00',
                'heure_fin' => '15:30:00',
                'apporter' => 'Bloc-notes, stylo',
                'description' => 'Atelier pratique sur le développement web',
                'pause_cafe' => true,
                'pause_dejeuner' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'evenement_id' => 4,
                'date' => '2024-06-04',
                'heure_debut' => '09:00:00',
                'heure_fin' => '17:00:00',
                'apporter' => null,
                'description' => 'Séminaire sur la sécurité informatique',
                'pause_cafe' => true,
                'pause_dejeuner' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'evenement_id' => 5,
                'date' => '2024-06-05',
                'heure_debut' => '11:00:00',
                'heure_fin' => '14:00:00',
                'apporter' => null,
                'description' => 'Webinaire sur l\'intelligence artificielle',
                'pause_cafe' => false,
                'pause_dejeuner' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
