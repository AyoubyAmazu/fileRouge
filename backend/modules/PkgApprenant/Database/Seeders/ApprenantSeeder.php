<?php

namespace Modules\PkgApprenant\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;
use Illuminate\Support\Str;

class ApprenantSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('fr_FR');
        $groups = DB::table('groupes')->get();
        foreach ($groups as $group) {
            for ($i = 1; $i <= 10; $i++) {
                $name = $faker->firstName() . ' ' . $faker->lastName();
                $email = strtolower(Str::slug($name, '.')) . $i . '@example.com';
                $userId = DB::table('users')->insertGetId([
                    'name' => $name,
                    'email' => $email,
                    'password' => Hash::make('password'),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                DB::table('apprenants')->insert([
                    'user_id' => $userId,
                    'groupe_id' => $group->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
