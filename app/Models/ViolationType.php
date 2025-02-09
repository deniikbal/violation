<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ViolationType extends Model
{
    protected $fillable = ['name', 'points','category_id'];

    // Relasi ke tabel violations
    public function violations(): HasMany
    {
        return $this->hasMany(Violation::class, 'violation_type_id', 'id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
