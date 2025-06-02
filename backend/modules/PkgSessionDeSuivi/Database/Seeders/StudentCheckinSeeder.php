<?php

namespace Modules\PkgSessionDeSuivi\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\PkgSessionDeSuivi\Domain\Entities\StudentCheckin;

class StudentCheckinSeeder extends Seeder
{
    public function run()
    {
        StudentCheckin::factory()->count(50)->create();
    }
}
