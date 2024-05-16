<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TestAnthropometry extends Model
{
    use HasFactory;

    protected $fillable = [
        'height',
        'weight',
        'bicepFold',
        'tricepFold',
        'subscapular',
        'suprailiac',
        'client_id',
    ];

    // Relación uno a muchos con la tabla clients
    public function clients() : BelongsTo
    {
        return $this->belongsTo(Client::class);
    }
}
