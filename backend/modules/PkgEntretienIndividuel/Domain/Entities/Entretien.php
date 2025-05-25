<?php

namespace Modules\PkgEntretienIndividuel\Domain\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\PkgApprenant\Models\Groupe;

class Entretien extends Model
{
    protected $fillable = [
        'titre',
        'description',
        'date_heure',
        'duree_minutes',
        'responsable_id',
        'groupe_id',
        'pre_entretien_id',
        'statut'
    ];

    public function preEntretien()
    {
        return $this->belongsTo(PreEntretien::class, 'pre_entretien_id');
    }

    public function groupe()
    {
        return $this->belongsTo(Groupe::class, 'groupe_id');
    }
} 