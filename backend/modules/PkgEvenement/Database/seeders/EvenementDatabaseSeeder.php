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
            EncadrantSeeder::class,
            ChefDeCommunauteSeeder::class,
            CommunauteMembreSeeder::class,
            ParticipantSeeder::class,
            PresenceEvenementSeeder::class,
            JoursSeeder::class,
        ]);
    }
}
