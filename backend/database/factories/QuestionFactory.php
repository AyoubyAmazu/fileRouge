<?php

namespace Database\Factories;

use Modules\PkgSessionDeSuivi\Domain\Entities\Question;
use Modules\PkgSessionDeSuivi\Domain\Entities\CheckinForm;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuestionFactory extends Factory
{
    protected $model = Question::class;

    public function definition()
    {
        return [
            'checkin_form_id' => CheckinForm::factory(),
            'question_text' => $this->faker->sentence(),
            'question_type' => $this->faker->randomElement(['text', 'rating']),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
