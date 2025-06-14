<?php
namespace Modules\pkgEvenement\Repositories\Interfaces;

interface Icrud{
    public function all(?int $year );
    public function find(int $id);
    public function store(array $data);
    public function update(int $id, array $data);
    public function destroy(int $id);

}
?>
