<?php

namespace Modules\PkgEntretienIndividuel\Services;

use Modules\PkgEntretienIndividuel\Domain\Interfaces\IUser; 

class UserService
{
    private $userRepository;

    public function __construct(IUser $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getApprenantsWithGroup()
    {
        return $this->userRepository->getApprenantsWithGroup();
    }
}