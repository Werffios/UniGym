<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'document',
        'name',
        'surname',
        'birth_date',
        'height',
        'weight',
    ];


    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }
}
