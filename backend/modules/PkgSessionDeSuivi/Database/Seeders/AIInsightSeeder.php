<?php

namespace Modules\PkgSessionDeSuivi\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AIInsightSeeder extends Seeder
{
    public function run()
    {
        DB::table('ai_insights')->insert([
            [
                'student_checkin_id' => 1,
                'insight_text' => 'Student shows excellent engagement.',
                'type' => 'engagement',
            ],
            [
                'student_checkin_id' => 2,
                'insight_text' => 'Student needs to improve time management.',
                'type' => 'recommendation',
            ],
        ]);
    }
}
