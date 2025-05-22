<?php

namespace Modules\PkgEntretienIndividuel\Database\Seeders;
use Modules\PkgApprenant\Database\Seeders\GroupeSeeder;
use Modules\PkgApprenant\Database\Seeders\ApprenantSeeder;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            GroupeSeeder::class,
            ApprenantSeeder::class,
            UserSeeder::class,
            PreEntretienSeeder::class,
            QuestionSeeder::class,
            OptionReponseSeeder::class,
            EntretienSeeder::class,
            EntretienApprenantSeeder::class,
            ReponseQuestionSeeder::class,
            ReponseOptionSeeder::class,
        ]);
    }
} 