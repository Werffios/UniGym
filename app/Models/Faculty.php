<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Faculty extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    // Relación uno a muchos con la tabla type_faculties
    public function degree(): HasMany
    {
        return $this->hasMany(degree::class);
    }
}
