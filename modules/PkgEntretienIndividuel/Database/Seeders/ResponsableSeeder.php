<?php

namespace Modules\PkgEntretienIndividuel\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ResponsableSeeder extends Seeder
{
    public function run()
    {
        $responsable1Id = DB::table('users')->insertGetId([
            'name' => 'Jean Dupont',
            'email' => 'jean.dupont@example.com',
            'password' => Hash::make('password'),
            'role' => 'responsable',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $responsable2Id = DB::table('users')->insertGetId([
            'name' => 'Marie Martin',
            'email' => 'marie.martin@example.com',
            'password' => Hash::make('password'),
            'role' => 'responsable',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('responsables')->insert([
            ['user_id' => $responsable1Id, 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => $responsable2Id, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
