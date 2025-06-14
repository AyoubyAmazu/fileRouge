<?php


namespace Modules\pkgEvenement\Services;

use Modules\pkgEvenement\Models\CommunauteMembre;
use Modules\pkgEvenement\Repositories\Eloquent\CommunauteMembersRepository;
use Modules\pkgEvenement\Repositories\Interfaces\IRepositoryCommunauteMembers;
class CommunauteMemberService extends BaseService
{
    // This service class can be used to encapsulate business logic related to community members.
    // For example, you might have methods to create, update, delete, or retrieve community members.
    protected $repository;

    public function __construct(CommunauteMembersRepository $repository)
    {
        parent::__construct($repository);
        $this->repository = $repository;
    }

    public function totalMembers($year = null)
    {
        // Logic to count community members
        return $this->repository->totalMembers($year);
    }

 public function membersOfCommunaute(int $id)
    {
        // Logic to check if a user is a member of a community
        return $this->repository->memberOfCommunaute($id);
    }

    
}








?>
