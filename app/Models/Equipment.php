<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    use HasFactory;

    protected $table = 'equipment';
    
    protected $primaryKey = 'idEquipment';

    public $timestamps = true;

    protected $fillable = [
        'EquipmentType_id',
        'CodigoPatri',
        'Series',
        'Model',
        'Brand',
        'Description',
        'Price',
        'status',
        'Supplier_id',
        'Imagen'
    ];

    protected $casts = [
        'Price' => 'decimal:2',
        'status' => 'integer'
    ];

    /**
     * Relación con el tipo de equipo
     */
    public function equipmentType()
    {
        return $this->belongsTo(EquipmentType::class, 'EquipmentType_id', 'idEquipmentType');
    }

    /**
     * Relación con el proveedor
     */
    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'Supplier_id', 'idSupplier');
    }

    /**
     * Relación con las asignaciones (a través de assigned_team)
     */
    public function assignedTeams()
    {
        return $this->hasMany(AssignedTeam::class, 'Equipment_id', 'idEquipment');
    }

    /**
     * Relación con las devoluciones
     */
    public function equipmentReturns()
    {
        return $this->hasMany(EquipmentReturn::class, 'Equipment_id', 'idEquipment');
    }

    /**
     * Scope para equipos activos
     */
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    /**
     * Scope para equipos disponibles (no asignados actualmente)
     */
    public function scopeAvailable($query)
    {
        return $query->where('status', 1)
            ->whereDoesntHave('equipmentReturns', function($q) {
                $q->where('Devolucion', 0)->where('Status', 1);
            });
    }

    /**
     * Scope para equipos asignados
     */
    public function scopeAssigned($query)
    {
        return $query->where('status', 1)
            ->whereHas('equipmentReturns', function($q) {
                $q->where('Devolucion', 0)->where('Status', 1);
            });
    }

    /**
     * Verificar si el equipo está disponible
     */
    public function getIsAvailableAttribute()
    {
        return $this->status == 1 && 
               !$this->equipmentReturns()
                   ->where('Devolucion', 0)
                   ->where('Status', 1)
                   ->exists();
    }

    /**
     * Verificar si el equipo está asignado actualmente
     */
    public function getIsAssignedAttribute()
    {
        return $this->equipmentReturns()
            ->where('Devolucion', 0)
            ->where('Status', 1)
            ->exists();
    }

    /**
     * Obtener la asignación actual del equipo
     */
    public function getCurrentAssignmentAttribute()
    {
        return $this->equipmentReturns()
            ->with('assignment')
            ->where('Devolucion', 0)
            ->where('Status', 1)
            ->first();
    }

    /**
     * Accesores para los estados - COLOR
     */
    public function getStatusClassAttribute()
    {
        $statusClasses = [
            1 => 'success',     // Disponible
            2 => 'info',        // Por preparar
            3 => 'primary',     // En uso
            4 => 'warning',     // Observación
            5 => 'secondary',   // R Pendiente
            6 => 'danger',      // No devuelto
            7 => 'dark',        // Perdida-Robo
            8 => 'secondary',   // De baja
        ];

        return $statusClasses[$this->status] ?? 'secondary';
    }

    /**
     * Accesores para los estados - TEXTO
     */
    public function getStatusTextAttribute()
    {
        $statusTexts = [
            1 => 'Disponible',
            2 => 'Por preparar',
            3 => 'En uso',
            4 => 'Observación',
            5 => 'R Pendiente',
            6 => 'No devuelto',
            7 => 'Perdida-Robo',
            8 => 'De baja',
        ];

        return $statusTexts[$this->status] ?? 'Desconocido';
    }

    /**
     * Accesores para los estados - ICONO
     */
    public function getStatusIconAttribute()
    {
        $statusIcons = [
            1 => 'fa-circle-check',
            2 => 'fa-hourglass-half',
            3 => 'fa-laptop',
            4 => 'fa-eye',
            5 => 'fa-tools',
            6 => 'fa-exclamation-triangle',
            7 => 'fa-shield-alt',
            8 => 'fa-ban',
        ];

        return $statusIcons[$this->status] ?? 'fa-circle';
    }

    /**
     * Accesor para la URL de la imagen
     */
    public function getImageUrlAttribute()
    {
        if ($this->Imagen) {
            return asset('storage/' . $this->Imagen);
        }
        return asset('images/default-equipment.png');
    }
}