<?php

namespace Modules\pkgEvenement\Database\Seeders;
use Illuminate\Database\Seeder;


class EvenementDatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            FormateurSeeder::class,
            EvenementSeeder::class,
            CommunauteSeeder::class,
            CommunauteMembreSeeder::class,
            InscriptionsSeeder::class,
            EvenementsJoursSeeder::class,
        ]);
    }
}
