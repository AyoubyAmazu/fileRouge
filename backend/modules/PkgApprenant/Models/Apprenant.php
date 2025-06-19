<?php

namespace Modules\PkgApprenant\Models;

use Modules\PkgApprenant\Models\Groupe;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Modules\pkgEvenement\Models\Communaute;

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

    public function communautes()
    {
        return $this->belongsToMany(Communaute::class, 'communaute_membres', 'apprenant_id', 'communaute_id');
    }


}
