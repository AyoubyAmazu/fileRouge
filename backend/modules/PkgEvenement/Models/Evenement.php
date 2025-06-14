<?php

namespace Modules\pkgEvenement\Models;

use Illuminate\Database\Eloquent\Model;

class Evenement extends Model
{
        protected $fillable = ['titre', 'description','time', 'date_debut', 'date_fin', 'lieu'];
        public function Evenement_jours()
        {
            return $this->hasMany(EvenementJours::class);
        }
        public function formateur()
        {
            return $this->belongsTo(Formateur::class, 'formateur_id');
        }


}

