<?php

namespace Modules\pkgEvenement\Models;

use Illuminate\Database\Eloquent\Model;

class Evenement extends Model
{
        protected $fillable = ['titre', 'description', 'date_debut', 'date_fin', 'lieu'];

}
