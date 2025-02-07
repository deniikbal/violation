<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Classroom extends Model
{
    protected $fillable = ['name', 'teacher'];
    
    public function students():HasMany
    {
        return $this->hasMany(Student::class, 'classroom_id', 'id');
    }
}
