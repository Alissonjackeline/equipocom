<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EquipmentType extends Model
{
    use HasFactory;

    protected $table = 'equipment_types';
    protected $primaryKey = 'idEquipmentType';

    protected $fillable = [
        'Name',
        'Description',
        'Status'
    ];

    /**
     * Scope para tipos de equipo activos
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

    /**
     * Relación con Equipment (si la necesitas después)
     */
    public function equipment()
    {
        return $this->hasMany(Equipment::class, 'EquipmentType_id', 'idEquipmentType');
    }
}