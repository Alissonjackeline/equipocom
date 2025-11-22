<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    protected $table = 'users';
    
    protected $primaryKey = 'idUser';

    public $timestamps = true;

    protected $fillable = [
        'Document',
        'Name',
        'Phone',
        'Email',
        'Status',
        'Password'
    ];

    protected $hidden = [
        'Password'
    ];

    /**
     * Relación con las asignaciones
     */
    public function assignments()
    {
        return $this->hasMany(Assignment::class, 'User_id', 'idUser');
    }

    /**
     * Relación con las devoluciones
     */
    public function equipmentReturns()
    {
        return $this->hasMany(EquipmentReturn::class, 'User_id', 'idUser');
    }

    /**
     * Scope para usuarios activos
     */
    public function scopeActive($query)
    {
        return $query->where('Status', 1);
    }

    /**
     * Obtener equipos actualmente asignados al usuario
     */
    public function getCurrentAssignedEquipmentAttribute()
    {
        return $this->equipmentReturns()
            ->with('equipment')
            ->where('Devolucion', 0)
            ->where('Status', 1)
            ->get()
            ->pluck('equipment');
    }
}