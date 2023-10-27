<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class degree extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    // Relación uno a muchos con la tabla type_degrees
    public function typeDegree(): BelongsTo
    {
        return $this->belongsTo(type_degree::class);
    }

    // Relación uno a muchos con la tabla type_study
    public function typeStudy(): HasMany
    {
        return $this->hasMany(type_study::class);
    }
}
