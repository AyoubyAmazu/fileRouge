<?php

namespace Modules\PkgSessionDeSuivi\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\PkgSessionDeSuivi\Domain\Entities\CheckinForm;
use Modules\PkgSessionDeSuivi\Domain\Entities\Question;

class CheckinFormSeeder extends Seeder
{
    public function run()
    {
        CheckinForm::factory()->count(10)->create()->each(function ($form) {
            Question::factory()->count(rand(3, 5))->create([
                'checkin_form_id' => $form->id,
            ]);
        });
    }
}
