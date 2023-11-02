<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pay extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'start_date',
        'end_date',
        'amount',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
