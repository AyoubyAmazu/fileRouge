<?php

namespace Modules\pkgEvenement\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\PkgApprenant\Models\Apprenant;

class Communaute extends Model
{
    protected $fillable = ['nom', 'description'];
    public function members()
    {
        return $this->belongsToMany(Apprenant::class, 'communaute_membres', 'communaute_id', 'apprenant_id');
    }



}
