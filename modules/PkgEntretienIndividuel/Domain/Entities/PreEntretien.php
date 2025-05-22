<?php

namespace Modules\PkgEntretienIndividuel\Domain\Entities;

use Illuminate\Database\Eloquent\Model;

class PreEntretien extends Model
{
    protected $table = 'pre_entretiens';
    protected $fillable = [
       'titre',
       'description',
       'deadline'
    ];

    public function questions()
    {
        return $this->hasMany(Question::class);
    }
}
