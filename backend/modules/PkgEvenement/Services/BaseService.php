<?php

namespace Modules\PkgEvenement\Services;

use Illuminate\Database\Eloquent\Model;
use Modules\pkgEvenement\Repositories\Eloquent\BaseReporistory;
use Modules\pkgEvenement\Repositories\Interfaces\IRepositoryBase;

class BaseService
{
    // This service class can be used to encapsulate business logic related to events.
    // For example, you might have methods to create, update, delete, or retrieve events.
    protected $repository;
    public function __construct(BaseReporistory $baseReporistory)
    {
        $this->repository=$baseReporistory;

    }


    public function getAll(?int $year,)
    {
        // Logic to retrieve all events
        return response()->json($this->repository->all($year));
    }

    public function find(int $id)
    {
        // Logic to find an event by ID
        return response()->json($this->repository->find($id));
    }
    public function store(array $data)
    {
        // Logic to create a new event
        return response()->json([$this->repository->store($data)], 201);
    }
    public function destroy(int $id)
    {
        $this->repository->destroy($id);
        return response()->json(['message' => 'deleted successfully']);
    }

    public function update( $id,$data)
    {
        return $this->repository->update($id, $data);
    }
}
