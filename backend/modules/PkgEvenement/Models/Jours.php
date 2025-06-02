<?php

namespace Modules\pkgEvenement\Models;
use Illuminate\Database\Eloquent\Model;

class Jours extends Model
{
    protected $fillable = [
        'evenement_id',
        'date',
        'heure_debut',
        'heure_fin',
        'apporter',
        'description',
        'pause_cafe',
        'pause_dejeuner'
    ];

    public function evenement()
    {
        return $this->belongsTo(Evenement::class);
    }
}


?>
