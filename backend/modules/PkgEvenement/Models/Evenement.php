<?php

namespace Modules\pkgEvenement\Models;

use Illuminate\Database\Eloquent\Model;

class Evenement extends Model
{
        protected $fillable = ['titre', 'description','places','time', 'date_debut', 'date_fin', 'lieu'];
        public function Evenement_jours()
        {
            return $this->hasMany(EvenementJours::class);
        }
        public function formateur()
        {
            return $this->belongsTo(Formateur::class, 'formateur_id');
        }

         public function inscription()
        {
            return $this->hasMany(Inscription::class, 'evenment_id');
        }

}

