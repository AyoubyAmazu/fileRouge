<?php

namespace Modules\pkgEvenement\Models;

use Illuminate\Database\Eloquent\Model;

class Evenement extends Model
{
        protected $fillable = ['titre', 'description','time', 'date_debut', 'date_fin', 'lieu'];
        public function jours()
{
    return $this->hasMany(Jours::class);
}

}

