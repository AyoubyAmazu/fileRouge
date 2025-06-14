<?php

namespace Modules\PkgApprenant\Models;

use Modules\PkgApprenant\Models\Groupe;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Modules\pkgEvenement\Models\CommunauteMembre;

class Apprenant extends Model
{
    protected $fillable = [
        'user_id',
        'groupe_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function groupe()
    {
        return $this->belongsTo(Groupe::class);
    }

    public function communauteMembres()
    {
        return $this->hasMany(CommunauteMembre::class);
    }


}
