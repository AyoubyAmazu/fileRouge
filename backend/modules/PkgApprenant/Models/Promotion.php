<?php

namespace Modules\PkgApprenant\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\PkgApprenant\Models\Groupe;

class Promotion extends Model
{
    protected $fillable = [
        'year',
        'description',
    ];

    public function groupes()
    {
        return $this->hasMany(Groupe::class, 'promotion_id');
    }
}
