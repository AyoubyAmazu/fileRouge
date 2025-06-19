<?php

namespace Modules\pkgEvenement\Models;

use Illuminate\Database\Eloquent\Model;

class CommunauteMembre extends Model
{
   protected $fillable = ['communaute_id', 'apprenant_id' , 'role'];


}
