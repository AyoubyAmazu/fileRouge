<?php

namespace Modules\PkgEvenement\Services;

use Modules\pkgEvenement\Repositories\Interfaces\IRepositoryBase;

class EventBaseService
{
    // This service class can be used to encapsulate business logic related to events.
    // For example, you might have methods to create, update, delete, or retrieve events.
    protected $repository;
    public function __construct(IRepositoryBase $repository)
    {
        $this->repository = $repository;

    }

    public function getAll()
    {
        // Logic to retrieve all events
        return $this->repository->all();
    }
    public function create(array $data)
    {
        // Logic to create an event
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
