<?php

namespace Modules\PkgEntretienIndividuel\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReponseQuestionSeeder extends Seeder
{
    public function run()
    {
        // Get the first entretien_apprenant
        $entretienApprenant = DB::table('entretien_apprenant')->first();

        // Get the entretien
        $entretien = DB::table('entretiens')
            ->where('id', $entretienApprenant->entretien_id)
            ->first();

        // Get all questions for this pre_entretien
        $questions = DB::table('questions')
            ->where('pre_entretien_id', $entretien->pre_entretien_id)
            ->get();

        foreach ($questions as $question) {
            DB::table('reponse_questions')->insert([
                [
                    'entretien_apprenant_id' => $entretienApprenant->id,
                    'question_id' => $question->id,
                    'reponse_texte' => 'Je souhaite améliorer mes compétences en développement web.',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            ]);
        }
    }
} 