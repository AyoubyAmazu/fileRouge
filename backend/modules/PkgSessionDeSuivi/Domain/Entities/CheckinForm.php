<?php

namespace Modules\PkgSessionDeSuivi\Domain\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CheckinForm extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'title', 'description', 'created_by'
    ];
    
    public function questions()
    {
        return $this->hasMany(Question::class);
    }
    public function studentCheckins()
    {
        return $this->hasMany(StudentCheckin::class);
    }
    
    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory(): \Illuminate\Database\Eloquent\Factories\Factory
    {
        return \Database\Factories\CheckinFormFactory::new();
    }
}
