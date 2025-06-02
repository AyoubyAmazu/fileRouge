<?php

namespace Modules\PkgApprenant\Database\Seeders; 

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GroupeSeeder extends Seeder
{
    public function run()
    {
        // Get the promotion ID for year 2024
        $promotionId = DB::table('promotions')->where('year', 2024)->value('id');
        DB::table('groupes')->insert([
            [
                'nom' => 'Groupe A',
                'promotion_id' => $promotionId,
                'description' => 'Premier groupe de formation',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nom' => 'Groupe B',
                'promotion_id' => $promotionId,
                'description' => 'Deuxième groupe de formation',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
} 