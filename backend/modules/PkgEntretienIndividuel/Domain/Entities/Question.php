<?php

namespace Modules\PkgEntretienIndividuel\Domain\Entities;
use Modules\PkgEntretienIndividuel\Domain\Entities\Formulaire;
use Modules\PkgEntretienIndividuel\Domain\Entities\PreEntretien;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $table = 'questions';
    protected $fillable = [
        'titre',
        'description',
        'pre_entretien_id',
    ];

    public function preEntretien()
    {
        return $this->belongsTo(PreEntretien::class, 'pre_entretien_id');
    }

    public function formulaire()
    {
        return $this->belongsTo(Formulaire::class, 'formulaire_id');
    }
}
