<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class type_study extends Model
{
    use HasFactory;

    protected $fillable = [
        'IdTypeDegree',
        'IdClient',
    ];

    // Relación muchos a muchos con la tabla degrees
    public function degrees() : BelongsToMany
    {
        return $this->belongsToMany(degree::class);
    }
}
