<?php

namespace Modules\PkgSessionDeSuivi\Domain\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\PkgSessionDeSuivi\Domain\Entities\ApprenantCheckin;

class Period extends Model
{
    use HasFactory;
  
    protected $table = 'periods';
    protected $appends = ['period'];

    protected $fillable = [
        'week_number',
        'start_date',
        'end_date',
        'is_active',
    ];
    public function apprenantCheckins()
    {
        return $this->hasMany(ApprenantCheckin::class);
    }
    public function getPeriodAttribute()
    {
        return \Carbon\Carbon::parse($this->start_date)->format('d M') . ' - ' .
               \Carbon\Carbon::parse($this->end_date)->format('d M');
    }

    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory(): \Illuminate\Database\Eloquent\Factories\Factory
    {
        return \Database\Factories\PeriodFactory::new();
    }
}
