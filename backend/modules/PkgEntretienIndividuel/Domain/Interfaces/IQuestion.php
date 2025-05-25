<?php

namespace Modules\PkgEntretienIndividuel\Domain\Interfaces;

interface IQuestion
{
    public function all();
    public function find($id);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
}