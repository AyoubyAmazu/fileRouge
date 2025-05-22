<?php

namespace Modules\PkgEntretienIndividuel\Http\Controllers;

use Http\Controllers\Controller;
use Modules\PkgEntretienIndividuel\Services\UserService;

class UserController extends Controller
{
    private $userService;

    public function __construct(UserService $userService)                       
    {
        $this->userService = $userService;
    }

    public function getApprenantsWithGroup()
    {
        return $this->userService->getApprenantsWithGroup();
    }

}