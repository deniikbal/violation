<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Student extends Model
{
    protected $fillable = [
        'name',
        'nis',
        'classroom_id',
        'email',
    ]; 

    public function violations(): HasMany
    {
        return $this->hasMany(Violation::class, 'student_id', 'id');
    }

     // Menghitung total poin pelanggaran
     public function getTotalPointsAttribute()
     {
         return $this->violations()->with('violationType')->get()->sum(function ($violation) {
             return $violation->violationType->points ?? 0;
         });
     }

    public function classroom(): BelongsTo
    {
        return $this->belongsTo(Classroom::class, 'classroom_id', 'id');
    }
}
