<?php

namespace Modules\PkgEntretienIndividuel\Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Modules\PkgEntretienIndividuel\Domain\Entities\ReponsePreEntretien;
use Carbon\Carbon;

class ReponsePreEntretienSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $reponses = [
            [
                'pre_entretien_id' => 1,
                'apprenant_id' => 1,
                'date_soumission' => Carbon::now(),
            ],
            [
                'pre_entretien_id' => 1,
                'apprenant_id' => 2,
                'date_soumission' => Carbon::now()->subDays(2),
            ],
            [
                'pre_entretien_id' => 2,
                'apprenant_id' => 1,
                'date_soumission' => Carbon::now()->subDays(1),
            ],
        ];

        foreach ($reponses as $reponse) {
            ReponsePreEntretien::create($reponse);
        }
    }
}
