<?php

namespace Modules\pkgEvenement\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\PkgApprenant\Models\Apprenant;

class Participant extends Model
{
   protected $fillable = ['apprenant_id'];

    public function utilisateur()
    {
        return $this->belongsTo(Apprenant::class);
    }
}
