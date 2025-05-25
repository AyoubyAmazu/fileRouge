<?php

namespace Modules\PkgEntretienIndividuel\Database\Seeders; 

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuestionSeeder extends Seeder
{
    public function run()
    {
        // Get the first pre_entretien ID
        $preEntretienId = DB::table('pre_entretiens')->first()->id;

        DB::table('questions')->insert([
            [
                'pre_entretien_id' => $preEntretienId,
                'titre' => 'Comment évaluez-vous votre niveau en programmation ?',
                'description' => 'Évaluez votre niveau de compétence en programmation',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'pre_entretien_id' => $preEntretienId,
                'titre' => 'Quelles technologies maîtrisez-vous ?',
                'description' => 'Listez les technologies que vous connaissez',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'pre_entretien_id' => $preEntretienId,
                'titre' => 'Quels sont vos objectifs pour les prochains mois ?',
                'description' => 'Décrivez vos objectifs professionnels',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
} 