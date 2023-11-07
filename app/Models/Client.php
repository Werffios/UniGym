<?php

namespace App\Models;

use App\Http\Controllers\TypeClientController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'document',
        'name',
        'surname',
        'height',
        'weight',
        'birth_date',
        'gender',
        'active',
        'type_client_id',
        'type_document_id',
        'degree_id',

    ];

    // Relación uno a muchos con la tabla attendances
    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }
    // Relación uno a muchos con la tabla type_clients
    public function typeClient(): BelongsTo
    {
        return $this->belongsTo(type_client::class);
    }
    // Relación uno a muchos con la tabla type_documents
    public function typeDocument(): BelongsTo
    {
        return $this->belongsTo(type_document::class);
    }
    public function pay(): HasMany
    {
        return $this->hasMany(Pay::class);
    }
    // Relación uno a muchos con la tabla degrees

    public function degree(): BelongsTo
    {
        return $this->belongsTo(degree::class);
    }

    public function typeClien(): BelongsTo
    {
        return $this->belongsTo(TypeClientController::class);
    }

    public function getActiveAttribute()
    {
        return $this->attributes['active'] == 1 ? 'Activo' : 'Inactivo';
    }
}
