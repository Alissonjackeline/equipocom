<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignedTeam extends Model
{
    use HasFactory;

    protected $table = 'assigned_team';
    protected $primaryKey = 'idAssigned_Team';

    protected $fillable = [
        'Equipment_id',
        'Assignment_id',
        'Status'
    ];

    protected $casts = [
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
}