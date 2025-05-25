<?php

namespace Modules\PkgEntretienIndividuel\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PreEntretienSeeder extends Seeder
{
    public function run()
    {
        DB::table('pre_entretiens')->insert([
            [
                'titre' => 'Évaluation des compétences techniques',
                'description' => 'Formulaire pour évaluer les compétences techniques des apprenants',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'titre' => 'Bilan de progression',
                'description' => 'Formulaire pour faire le point sur la progression de l\'apprenant',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
} 