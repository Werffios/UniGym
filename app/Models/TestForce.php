<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'upperLimbs',
        'lowerLimbs',
        'relationUpperLowerLimbs',
        'date',
        'client_id',
    ];

    // Relación uno a muchos con la tabla clients
    public function clients()
    {
        return $this->belongsTo(Client::class);
    }

}
