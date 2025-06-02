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


    public function getAll()
    {
        // Logic to retrieve all events
        return response()->json($this->repository->all());
    }

    public function find(int $id)
    {
        // Logic to find an event by ID
        return response()->json($this->repository->find($id));
    }
    public function store(array $data)
    {
        // Logic to create a new event
        return response()->json($this->repository->store($data));
    }

    public function update(int $id, array $data)
    {
        // Logic to update an event
    }



    public function delete(int $id)
    {
        // Logic to delete an event
    }

    public function get(int $id)
    {
        // Logic to retrieve an event by ID
    }
}
