<?php

namespace Modules\pkgEvenement\Models;

use Illuminate\Database\Eloquent\Model;

class Encadrant extends Model
{
    protected $fillable = ['utilisateur_id'];

    public function utilisateur()
    {
        return $this->belongsTo(Formateur::class);
    }
}
