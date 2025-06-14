<?php

namespace Modules\pkgEvenement\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CommunauteMembreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('communaute_membres')->insert([
            [
                'communaute_id' => 1,
                'apprenant_id' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'communaute_id' => 1,
                'apprenant_id' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'communaute_id' => 2,
                'apprenant_id' => 2,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'communaute_id' => 2,
                'apprenant_id' => 2,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'communaute_id' => 1,
                'apprenant_id' => 3,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'communaute_id' => 2,
                'apprenant_id' => 3,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
