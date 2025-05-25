<?php

namespace Modules\pkgEvenement\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\PkgApprenant\Models\Apprenant;

class CommunauteMembre extends Model
{
   protected $fillable = ['communaute_id', 'utilisateur_id'];

    public function communaute()
    {
        return $this->belongsTo(Communaute::class);
    }

    public function apprenant()
    {
        return $this->belongsTo(Apprenant::class);
    }
}
