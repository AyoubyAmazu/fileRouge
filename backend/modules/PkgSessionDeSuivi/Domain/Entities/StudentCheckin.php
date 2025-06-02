<?php

namespace Modules\PkgSessionDeSuivi\Domain\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\PkgSessionDeSuivi\Domain\Entities\Period;
use Modules\PkgSessionDeSuivi\Domain\Entities\CheckinForm;

class StudentCheckin  extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'student_id',
        'period_id',
        'checkin_form_id',
        'answers',
    ];
    protected $table = 'student_checkins';
    public function student()
    {
        return $this->belongsTo(User::class);
    }
    public function period()
    {
        return $this->belongsTo(Period::class);
    }
    public function checkinForm()
    {
        return $this->belongsTo(CheckinForm::class);
    }
    
    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory(): \Illuminate\Database\Eloquent\Factories\Factory
    {
        return \Database\Factories\StudentCheckinFactory::new();
    }
}
