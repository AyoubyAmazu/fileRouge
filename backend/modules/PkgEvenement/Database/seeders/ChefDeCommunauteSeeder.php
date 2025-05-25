<?php

namespace Modules\pkgEvenement\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ChefDeCommunauteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        DB::table('chef_de_communautes')->insert([
            ['Apprenant_id' => 1, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
