<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EquipmentReturn extends Model
{
    use HasFactory;

    protected $table = 'equipment_return';
    protected $primaryKey = 'id';

    protected $fillable = [
        'Assignment_id',
        'Equipment_id',
        'User_id',
        'Date',
        'Devolucion',
        'Document',
        'Image',
        'Comment',
        'Status'
    ];

    protected $casts = [
        'Date' => 'datetime',
        'Devolucion' => 'boolean',
        'Status' => 'integer'
    ];

    // Relaciones
    public function assignment()
    {
        return $this->belongsTo(Assignment::class, 'Assignment_id', 'idAssignment');
    }

    public function equipment()
    {
        return $this->belongsTo(Equipment::class, 'Equipment_id', 'idEquipment');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'User_id', 'idUser');
    }
}