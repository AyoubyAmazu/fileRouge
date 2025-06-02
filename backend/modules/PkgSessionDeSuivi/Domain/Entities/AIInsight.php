<?php

namespace Modules\PkgSessionDeSuivi\Domain\Entities;

use Illuminate\Database\Eloquent\Model;

class AIInsight extends Model
{
    protected $fillable = [
        'student_checkin_id',
        'insight',
    ];
    
    public function studentCheckin()
    {
        return $this->belongsTo(StudentCheckin::class);
    }
}
