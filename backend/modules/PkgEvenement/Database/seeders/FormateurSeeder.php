<?php

namespace Modules\pkgEvenement\Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FormateurSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
            DB::table('formateurs')->insert([
            ['user_id' => 1, 'specialite' => 'PHP & Laravel', 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 2, 'specialite' => 'Javascript & Vue.js', 'created_at' => now(), 'updated_at' => now()],
        ]);

    }
}
