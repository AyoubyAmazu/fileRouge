<?php

namespace Modules\pkgEvenement\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\PkgApprenant\Models\Apprenant;

class Inscription extends Model
{
    protected $fillable = ['participant_id', 'evenement_id', 'est_present'];

    public function apprenant()
    {
        return $this->belongsTo(Apprenant::class, 'participant_id');
    }

    public function evenement()
    {
        return $this->belongsTo(Evenement::class, 'evenement_id');
    }


}
