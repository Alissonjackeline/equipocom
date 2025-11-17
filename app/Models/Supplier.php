<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Supplier extends Model
{
    use HasFactory;

    protected $table = 'suppliers';
    protected $primaryKey = 'idSupplier';

    protected $fillable = [
        'Company_name',
        'Ruc',
        'Phone',
        'Address',
        'Status'
    ];

    /**
     * Relación con Equipment
     */
    public function equipment()
    {
        return $this->hasMany(Equipment::class, 'Supplier_id', 'idSupplier');
    }
}