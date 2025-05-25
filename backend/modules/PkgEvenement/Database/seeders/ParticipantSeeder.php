<?php

namespace Modules\pkgEvenement\Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ParticipantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('participants')->insert([
            ['apprenant_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['apprenant_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['apprenant_id' => 3, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
