<?php

namespace Modules\pkgEvenement\Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InscriptionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('inscriptions')->insert([
        ['participant_id' => 1, 'evenement_id' => 1, 'est_present' => true ,'created_at' => now(), 'updated_at' => now()],
        ['participant_id' => 2, 'evenement_id' => 1, 'est_present' => false ,'created_at' => now(), 'updated_at' => now()],
        ['participant_id' => 3, 'evenement_id' => 1, 'est_present' => true ,'created_at' => now(), 'updated_at' => now()],
        ['participant_id' => 1, 'evenement_id' => 2, 'est_present' => false ,'created_at' => now(), 'updated_at' => now()],
        ['participant_id' => 2, 'evenement_id' => 2, 'est_present' => true ,'created_at' => now(), 'updated_at' => now()],
        ['participant_id' => 3, 'evenement_id' => 2, 'est_present' => false ,'created_at' => now(), 'updated_at' => now()],
        ['participant_id' => 1, 'evenement_id' => 3, 'est_present' => true ,'created_at' => now(), 'updated_at' => now()],
        ['participant_id' => 2, 'evenement_id' => 3, 'est_present' => false ,'created_at' => now(), 'updated_at' => now()],
        ['participant_id' => 3, 'evenement_id' => 3, 'est_present' => true ,'created_at' => now(), 'updated_at' => now()],
        ['participant_id' => 1, 'evenement_id' => 4, 'est_present' => false ,'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
