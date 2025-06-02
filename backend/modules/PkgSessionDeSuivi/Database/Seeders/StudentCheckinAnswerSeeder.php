<?php

namespace Modules\PkgSessionDeSuivi\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StudentCheckinAnswerSeeder extends Seeder
{
    public function run()
    {
        DB::table('student_checkin_answers')->insert([
            [
                'checkin_id' => 1,
                'question_id' => 1,
                'answer_text' => 'Feeling great',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'checkin_id' => 1,
                'question_id' => 2,
                'answer_text' => 'Completed all my tasks',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'checkin_id' => 1,
                'question_id' => 3,
                'answer_text' => '5',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'checkin_id' => 2,
                'question_id' => 1,
                'answer_text' => 'A bit tired',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'checkin_id' => 2,
                'question_id' => 2,
                'answer_text' => 'Finished most tasks',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'checkin_id' => 2,
                'question_id' => 3,
                'answer_text' => '4',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
