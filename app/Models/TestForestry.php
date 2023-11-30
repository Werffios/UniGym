<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TestForestry extends Model
{
    use HasFactory;

    protected $fillable = [
        'bicepCircumference',
        'tricepCircumference',
        'carpusPerimeter',
        'subscapular',
        'suprailiac',
        'fatPercentage',
        'IMC',
        'IMCEvaluation',
        'healthyWeight',
        'date',
        'client_id',
    ];

    // Relación uno a muchos con la tabla clients
    public function clients() : BelongsTo
    {
        return $this->belongsTo(Client::class);
    }
}
