<?php

namespace Modules\pkgEvenement\Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EncadrantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        DB::table('encadrants')->insert([
            ['Formateur_id' => 1, 'created_at' => now(), 'updated_at' => now()],
        ]);

    }
}
