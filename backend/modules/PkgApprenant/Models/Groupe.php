<?php

namespace Modules\PkgApprenant\Models;

use Modules\PkgApprenant\Models\Apprenant;
use Illuminate\Database\Eloquent\Model;

class Groupe extends Model
{
    protected $fillable = ['nom', 'annee_promotion', 'description'];

    public function apprenants()
    {
        return $this->hasMany(Apprenant::class);
    }
}
