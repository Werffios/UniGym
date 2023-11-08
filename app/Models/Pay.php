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

    public static function boot()
    {
        parent::boot();

        static::created(function ($pay) {
            $client = $pay->client;
            $typeClient = $client->typeClient;

            $monthsToAdd = $typeClient->months;
            $startDate = now();

            if ($monthsToAdd == 2) {
                $endDate = now()->addMonths($monthsToAdd)->startOfMonth()->subDay();
            } else {
                $endDate = now()->addMonths($typeClient->months);
            }

            $pay->update([
                'start_date' => $startDate,
                'amount' => $typeClient->fee,
                'end_date' => $endDate
            ]);
        });
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
