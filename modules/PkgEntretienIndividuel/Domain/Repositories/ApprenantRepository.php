<?php

namespace Modules\PkgEntretienIndividuel\Domain\Repositories;

use Modules\PkgEntretienIndividuel\Domain\Interfaces\IApprenant;    
use Modules\PkgApprenant\Models\Apprenant;

    class ApprenantRepository implements IApprenant 
    {
   protected $model;

   public function __construct(Apprenant $model)
   {
       $this->model = $model;
   }

   public function getApprenantsWithGroup()
   {
       return $this->model->with('groupe')->get();
   }
   
}
