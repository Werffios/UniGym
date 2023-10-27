<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class type_client extends Model
{
    use HasFactory;


    // Relación uno a muchos con la tabla clients
    public function clients() : HasMany
    {
        return $this->hasMany(Client::class);
    }
}
