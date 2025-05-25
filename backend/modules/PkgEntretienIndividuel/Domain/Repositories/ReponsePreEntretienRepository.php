<?php

namespace Modules\PkgEntretienIndividuel\Domain\Repositories;

use Modules\PkgEntretienIndividuel\Domain\Interfaces\IReponsePreEntretien;
use Modules\PkgEntretienIndividuel\Domain\Entities\ReponsePreEntretien;

class ReponsePreEntretienRepository implements IReponsePreEntretien
{
   private $model;

   public function __construct(ReponsePreEntretien $model)
   {
      $this->model = $model;
   }

   public function getAll()
   {
      return $this->model->all();
   }

   public function getById($id)
   {
      return $this->model->find($id);
   }

   public function create($data)
   {
      return $this->model->create($data);
   }

   public function update($id, $data)
   {
      return $this->model->find($id)->update($data);
   }

   public function delete($id)
   {
      return $this->model->find($id)->delete();
   }
}

   
   
   