<?php

namespace Modules\PkgEntretienIndividuel\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OptionReponseSeeder extends Seeder
{
    public function run()
    {
        // Get the first two questions
        $questions = DB::table('questions')
            ->orderBy('id')
            ->take(2)
            ->get();

        // Options for first question
        DB::table('option_reponses')->insert([
            [
                'question_id' => $questions[0]->id,
                'texte' => 'Débutant',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'question_id' => $questions[0]->id,
                'texte' => 'Intermédiaire',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'question_id' => $questions[0]->id,
                'texte' => 'Avancé',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);

        // Options for second question
        DB::table('option_reponses')->insert([
            [
                'question_id' => $questions[1]->id,
                'texte' => 'PHP',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'question_id' => $questions[1]->id,
                'texte' => 'JavaScript',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'question_id' => $questions[1]->id,
                'texte' => 'Python',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
} 