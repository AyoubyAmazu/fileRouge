<?php

namespace Modules\pkgEvenement\Controllers;

use Modules\pkgEvenement\Controllers\BaseController;
use Modules\PkgEvenement\Services\CommunauteMemberService;

class CommunauteMembersController extends BaseController
{
    protected $service;


    public function __construct(CommunauteMemberService $communauteMembersService)
    {

        $this->service = $communauteMembersService;
    }


    public function countMembers()
    {

         $year = request()->query('year',  $year ?? now()->year);
        return $this->service->countMembers($year);
    }

}









?>
