<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class type_degree extends Model
{
    use HasFactory;

    protected $fillable = [
        'IdDegree',
        'IdClient',
    ];

    // Relación uno a muchos con la tabla type_degrees
    public function degree(): HasMany
    {
        return $this->hasMany(degree::class);
    }



}
