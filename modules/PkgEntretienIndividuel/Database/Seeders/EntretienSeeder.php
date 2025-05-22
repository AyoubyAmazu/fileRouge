<?php

namespace Modules\PkgEntretienIndividuel\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EntretienSeeder extends Seeder
{
    public function run()
    {
        // Get IDs
        // Get first responsable record ID
        $responsableId = DB::table('responsables')->value('id');

        $groupeId = DB::table('groupes')
            ->first()
            ->id;

        $preEntretienId = DB::table('pre_entretiens')
            ->first()
            ->id;

        DB::table('entretiens')->insert([
            [
                'titre' => 'Premier entretien de suivi',
                'description' => 'Entretien pour faire le point sur la progression',
                'date_heure' => now()->addDays(2),
                'duree_minutes' => 60,
                'responsable_id' => $responsableId,
                'groupe_id' => $groupeId,
                'pre_entretien_id' => $preEntretienId,
                'statut' => 'planifié',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'titre' => 'Bilan intermédiaire',
                'description' => 'Évaluation des compétences acquises',
                'date_heure' => now()->addDays(7),
                'duree_minutes' => 45,
                'responsable_id' => $responsableId,
                'groupe_id' => $groupeId,
                'pre_entretien_id' => null,
                'statut' => 'planifié',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
} 