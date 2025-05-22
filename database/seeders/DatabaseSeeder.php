<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents; 
use Illuminate\Database\Seeder;
use Modules\PkgEntretienIndividuel\Database\Seeders\DatabaseSeeder as EntretienDatabaseSeeder;
use Modules\PkgEntretienIndividuel\Database\Seeders\ReponsePreEntretienSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $this->call([
            EntretienDatabaseSeeder::class,
            ReponsePreEntretienSeeder::class,
        ]);
    }
} 