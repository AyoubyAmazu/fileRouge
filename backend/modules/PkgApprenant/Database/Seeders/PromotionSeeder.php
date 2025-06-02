<?php

namespace Modules\PkgApprenant\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PromotionSeeder extends Seeder
{
    public function run()
    {
        DB::table('promotions')->insert([
            [
                'year' => 2022,
                'description' => 'Promotion 2022-2023',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'year' => 2023,
                'description' => 'Promotion 2023-2024',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'year' => 2024,
                'description' => 'Promotion 2024-2025',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}