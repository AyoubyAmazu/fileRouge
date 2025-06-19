<?php

namespace Modules\pkgEvenement\Controllers;

use Modules\pkgEvenement\Controllers\BaseController;
use Modules\PkgEvenement\Services\CommunauteMemberService;

class CommunauteMembersController extends BaseController
{
    protected $service;
    protected $relations = ["apprenants", "apprenants.user", "apprenants.group",'communaute'];


    public function __construct(CommunauteMemberService $communauteMembersService)
    {

        $this->service = $communauteMembersService;
    }


    public function totalMembers()
    {

         $year = request()->query('year',  $year ?? now()->year);
        return $this->service->totalMembers($year);
    }

    public function countMemberOfCommunaute(int $id)
    {

        return $this->service->countMemberOfCommunaute($id);
    }

    public function getMembersByCommunaute(int $communauteId)
    {
        return $this->service->getMembersByCommunaute($communauteId);
    }

    public function getCommunitysByMember($id)
    {
        return $this->service->getCommunitysByMember($id);
    }
}









?>
