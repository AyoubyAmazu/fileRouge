<?php

namespace Modules\PkgSessionDeSuivi\Domain\Entities;

use Illuminate\Database\Eloquent\Model;

class StudentCheckinAnswer extends Model
{
    protected $fillable = [
        'checkin_id',
        'question_id',
        'answer_text',
    ];
}
