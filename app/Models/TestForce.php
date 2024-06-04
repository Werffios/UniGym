<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TestForce extends Model
{
    use HasFactory;

    protected $fillable = [
        'benchPress',
        'benchPressReps',
        'pulleyOpenHigh',
        'pulleyOpenHighReps',
        'barbellBicepsCurl',
        'barbellBicepsCurlReps',
        'legFlexion',
        'legFlexionReps',
        'legExtension',
        'legExtensionReps',
        'legFlexExt',
        'legFlexExtReps',
        'client_id',
        'weight',
    ];

    // Relación uno a muchos con la tabla clients

    public function clients() : BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

}
