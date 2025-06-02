<?php

namespace Database\Factories;

use Modules\PkgSessionDeSuivi\Domain\Entities\StudentCheckin;
use App\Models\User;
use Modules\PkgSessionDeSuivi\Domain\Entities\Period;
use Modules\PkgSessionDeSuivi\Domain\Entities\CheckinForm;
use Illuminate\Database\Eloquent\Factories\Factory;

class StudentCheckinFactory extends Factory
{
    protected $model = StudentCheckin::class;

    public function definition()
    {
        $form = CheckinForm::inRandomOrder()->first();
        $period = Period::inRandomOrder()->first();
        $student = User::inRandomOrder()->first();

        $answers = [];
        $questions = $form->questions()->get();
        foreach ($questions as $question) {
            $answers[$question->id] = $question->type === 'rating'
                ? $this->faker->numberBetween(1, 5)
                : $this->faker->sentence();
        }

        return [
            'student_id' => $student->id,
            'period_id' => $period->id,
            'checkin_form_id' => $form->id,
            'answers' => json_encode($answers),
            'created_at' => $this->faker->dateTimeBetween('-2 months', 'now'),
            'updated_at' => now(),
        ];
    }
}
