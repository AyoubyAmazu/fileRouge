<?php

namespace Database\Factories;

use Modules\PkgSessionDeSuivi\Domain\Entities\CheckinForm;
use Modules\PkgSessionDeSuivi\Domain\Entities\Responsable;
use Illuminate\Database\Eloquent\Factories\Factory;

class CheckinFormFactory extends Factory
{
    protected $model = CheckinForm::class;

    public function definition()
    {
        return [
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(),
            'created_by' => Responsable::inRandomOrder()->first()->id,
            'is_active' => $this->faker->boolean(80),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
