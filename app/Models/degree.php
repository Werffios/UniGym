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
        'type_degree_id',
    ];

    // Relación uno a muchos con la tabla type_degrees
    public function typeDegree(): BelongsTo
    {
        return $this->belongsTo(type_degree::class);
    }
    // Relación uno a muchos con la tabla clients
    public function client(): HasMany
    {
        return $this->hasMany(Client::class);
    }

    // Relación uno a muchos con la tabla faculties
    public function faculty(): BelongsTo
    {
        return $this->belongsTo(Faculty::class);
    }
}
