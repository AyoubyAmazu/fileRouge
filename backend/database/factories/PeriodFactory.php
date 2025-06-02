<?php

namespace Database\Factories;

use Modules\PkgSessionDeSuivi\Domain\Entities\Period;
use Illuminate\Database\Eloquent\Factories\Factory;

class PeriodFactory extends Factory
{
    protected $model = Period::class;

    public function definition()
    {
        $start = $this->faker->dateTimeBetween('-2 months', '+1 month');
        $end = (clone $start)->modify('+6 days');
        $today = now();
    
        return [
            'start_date' => $start->format('Y-m-d'),
            'end_date' => $end->format('Y-m-d'),
            'is_active' => $today->between($start, $end),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
    
}
