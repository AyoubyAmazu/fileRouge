<?php

namespace Modules\PkgSessionDeSuivi\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ResponsableSeeder extends Seeder
{
    public function run()
    {
        DB::table('responsables')->insert([
            [
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
