<?php

namespace Modules\pkgEvenement\Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CommunauteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('communautes')->insert([
            [
                'nom' => 'Tech Community',
                'description' => 'Passionnés de tech',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nom' => 'Artistes',
                'description' => 'Communauté des artistes',
                'created_at' => now(),
                'updated_at' => now()],
        ]);
    }
}
