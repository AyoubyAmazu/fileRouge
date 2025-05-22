<?php

namespace Modules\PkgEntretienIndividuel\Domain\Entities;
use Modules\PkgEntretienIndividuel\Domain\Entities\Question;

use Illuminate\Database\Eloquent\Model;

class OptionReponse extends Model
{
    protected $table = 'option_reponses';
    protected $fillable = [
        'question_id',
        'texte',
    ];
    public function question()
    {
        return $this->belongsTo(Question::class, 'question_id');
    }
}
