<?php

namespace Modules\PkgEntretienIndividuel\Services;

use Modules\PkgEntretienIndividuel\Domain\Interfaces\IApprenant;

class ApprenantService
{
    private $apprenantRepository;

    public function __construct(IApprenant $apprenantRepository)
    {
        $this->apprenantRepository = $apprenantRepository;
    }

    public function getApprenantsWithGroup()
    {
        return $this->apprenantRepository->getApprenantsWithGroup();
    }
}