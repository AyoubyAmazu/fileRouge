<?php

namespace Modules\PkgApprenant\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ApprenantSeeder extends Seeder
{
    public function run()
    {
        // Get group IDs
        $groupA = DB::table('groupes')->where('nom', 'Groupe A')->first()->id;
        $groupB = DB::table('groupes')->where('nom', 'Groupe B')->first()->id;
        $groupC = DB::table('groupes')->where('nom', 'Groupe A')->first()->id;

        $apprenant1Id = DB::table('users')->insertGetId([
            'name' => 'Pierre Durand',
            'email' => 'pierre.durand@example.com',
            'password' => Hash::make('password'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $apprenant2Id = DB::table('users')->insertGetId([
            'name' => 'Sophie Bernard',
            'email' => 'sophie.bernard@example.com',
            'password' => Hash::make('password'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $apprenant3Id = DB::table('users')->insertGetId([
            'name' => 'Mathieu Martin',
            'email' => 'mathieu.martin@example.com',
            'password' => Hash::make('password'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);


        DB::table('apprenants')->insert([
            ['user_id' => $apprenant1Id, 'groupe_id' => $groupA, 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => $apprenant2Id, 'groupe_id' => $groupB, 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => $apprenant3Id, 'groupe_id' => $groupA, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
