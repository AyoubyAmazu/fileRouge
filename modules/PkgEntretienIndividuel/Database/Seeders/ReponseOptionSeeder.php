<?php

namespace Modules\PkgEntretienIndividuel\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReponseOptionSeeder extends Seeder
{
    public function run()
    {
        // Get all reponse_questions
        $reponseQuestions = DB::table('reponse_questions')
            ->join('questions', 'reponse_questions.question_id', '=', 'questions.id')
            ->select('reponse_questions.*')
            ->get();

        foreach ($reponseQuestions as $reponseQuestion) {
            // Get options for this question
            $options = DB::table('option_reponses')
                ->where('question_id', $reponseQuestion->question_id)
                ->get();

            // For each question, select one or more options
            $selectedOptions = $options->take($options->count() > 1 ? 2 : 1);

            foreach ($selectedOptions as $option) {
                DB::table('reponse_options')->insert([
                    [
                        'reponse_question_id' => $reponseQuestion->id,
                        'option_reponse_id' => $option->id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                ]);
            }
        }
    }
} 