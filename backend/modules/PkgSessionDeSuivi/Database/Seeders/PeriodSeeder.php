<?php

namespace Modules\PkgSessionDeSuivi\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\PkgSessionDeSuivi\Domain\Entities\Period;

class PeriodSeeder extends Seeder
{
    public function run()
    {
        Period::factory()->count(10)->create();
    }
}
