<?php

namespace Modules\pkgEvenement\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Formateur extends Model
{
    protected $fillable = ['user_id', 'nom' , 'prenom' , 'email' , 'password' ,'specialite'];

    public function utilisateur()
    {
        return $this->belongsTo(User::class);
    }
   
}
