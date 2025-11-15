<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Entities extends Model
{
    // Nombre de la tabla
    protected $table = 'entities';

    // Primary key personalizada
    protected $primaryKey = 'idEntity';

    public $incrementing = true;

    // Tipo de clave primaria
    protected $keyType = 'int';

    // Campos asignables
    protected $fillable = [
        'Razon',
        'Ruc',
        'Representative',
        'Address',
        'Phone',
        'Correo',
        'Image',
        'Status'
    ];

    // Relación: una entidad tiene muchas sedes
    public function headquarters()
    {
        return $this->hasMany(Headquarters::class, 'Entity_id', 'idEntity');
    }
}