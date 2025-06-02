<?php

namespace Modules\PkgSessionDeSuivi\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\PkgSessionDeSuivi\Domain\Entities\Question;

class QuestionSeeder extends Seeder
{
    public function run()
    {
        Question::factory()->count(100)->create();
    }
}
