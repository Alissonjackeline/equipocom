<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Area extends Model
{
    protected $table = 'areas';
    protected $primaryKey = 'idArea';

    protected $fillable = [
        'Name',
        'Status',
        'Headquarters_id'
    ];

    /**
     * Relación con Headquarters
     */
    public function headquarters(): BelongsTo
    {
        return $this->belongsTo(Headquarters::class, 'Headquarters_id', 'idHeadquarters');
    }

    /**
     * Scope para áreas activas
     */
    public function scopeActive($query)
    {
        return $query->where('Status', 1);
    }

    /**
     * Accessor para el estado
     */
    public function getStatusTextAttribute(): string
    {
        return $this->Status == 1 ? 'Activo' : 'Inactivo';
    }

    /**
     * Accessor para la clase del badge
     */
    public function getStatusClassAttribute(): string
    {
        return $this->Status == 1 ? 'success' : 'danger';
    }
}