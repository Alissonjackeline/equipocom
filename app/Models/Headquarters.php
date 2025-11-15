<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Headquarters extends Model
{
    protected $table = 'headquarters';
    protected $primaryKey = 'idHeadquarters';

    protected $fillable = [
        'Name',
        'Address',
        'Phone',
        'Status',
        'Entity_id'
    ];

    // Relación con Entities
    public function entity()
    {
        return $this->belongsTo(Entities::class, 'Entity_id', 'idEntity');
    }
}