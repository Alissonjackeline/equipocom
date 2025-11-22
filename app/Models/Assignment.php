<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    use HasFactory;

    protected $table = 'assignments';
    protected $primaryKey = 'idAssignment';

    protected $fillable = [
        'User_id',
        'Boss_id',
        'Date',
        'Document',
        'Image',
        'Comment',
        'Status'
    ];

    protected $casts = [
        'Date' => 'datetime',
        'Status' => 'integer'
    ];

    // Relaciones
    public function user()
    {
        return $this->belongsTo(User::class, 'User_id', 'idUser');
    }

    public function boss()
    {
        return $this->belongsTo(Boss::class, 'Boss_id', 'idBoss');
    }

    public function assignedTeams()
    {
        return $this->hasMany(AssignedTeam::class, 'Assignment_id', 'idAssignment');
    }

    public function equipmentReturns()
    {
        return $this->hasMany(EquipmentReturn::class, 'Assignment_id', 'idAssignment');
    }
}