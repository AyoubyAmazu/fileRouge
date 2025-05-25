<?php

namespace Modules\pkgEvenement\Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PresenceEvenementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         DB::table('presence_evenements')->insert([
            ['evenement_id' => 1, 'participant_id' => 1, 'statut' => 'present', 'created_at' => now(), 'updated_at' => now()],
            ['evenement_id' => 2, 'participant_id' => 1, 'statut' => 'absent', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
