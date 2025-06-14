<?php

namespace Modules\pkgEvenement\Controllers;

use Modules\pkgEvenement\Controllers\BaseController;
use Modules\PkgEvenement\Services\CommunauteMemberService;

class CommunauteMembersController extends BaseController
{
    protected $service;
    protected $relations = ["apprenants", "apprenants.user", "apprenants.group"];


    public function __construct(CommunauteMemberService $communauteMembersService)
    {

        $this->service = $communauteMembersService;
    }


    public function totalMembers()
    {

         $year = request()->query('year',  $year ?? now()->year);
        return $this->service->totalMembers($year);
    }

    public function memberOfCommunaute(int $id) 
    {
        
        return $this->service->membersOfCommunaute($id);
    }

}









?>
