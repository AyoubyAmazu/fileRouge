<?php

namespace Modules\PkgEntretienIndividuel\Domain\Entities;

use Illuminate\Database\Eloquent\Model;

class ReponsePreEntretien extends Model
{
    protected $fillable = [
        'pre_entretien_id',
        'apprenant_id',
        'date_soumission'
    ];

    public function preEntretien()
    {
        return $this->belongsTo(PreEntretien::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    

    
    
}
