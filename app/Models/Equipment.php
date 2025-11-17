<?php

namespace App\Models;

use Illuminate\Support\Facades\Storage; 
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Equipment extends Model
{
    use HasFactory;

    protected $table = 'equipment';
    protected $primaryKey = 'idEquipment';

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

    // Relación con EquipmentType
    public function equipmentType()
    {
        return $this->belongsTo(EquipmentType::class, 'EquipmentType_id', 'idEquipmentType');
    }

    // Relación con Supplier
    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'Supplier_id', 'idSupplier');
    }

    /**
     * Texto del estado
     */
    public function getStatusTextAttribute(): string
    {
        return match($this->status) {
            1 => 'Disponible',
            2 => 'Por preparar',
            3 => 'En uso',
            4 => 'Observación',
            5 => 'R Pendiente',
            6 => 'No devuelto',
            7 => 'Perdida-Robo',
            8 => 'De baja',
            default => 'Desconocido'
        };
    }

    /**
     * Clase del badge
     */
    public function getStatusClassAttribute(): string
    {
        return match($this->status) {
            1 => 'success',
            2 => 'info',
            3 => 'primary',
            4 => 'warning',
            5 => 'secondary',
            6 => 'danger',
            7 => 'dark',
            8 => 'light',
            default => 'secondary'
        };
    }

    /**
     * URL pública de la imagen
     */
    public function getImageUrlAttribute()
{
    if ($this->Imagen) {
        return asset('storage/' . $this->Imagen);
    }
    return asset('img/sin_imagen.png'); // opcional
}


    
    public function hasImage()
    {
        return $this->Imagen && Storage::disk('public')->exists($this->Imagen);
    }

    // Scopes
    public function scopeDisponible($query)
    {
        return $query->where('status', 1);
    }

    public function scopeEnUso($query)
    {
        return $query->where('status', 3);
    }

    public function scopeDeBaja($query)
    {
        return $query->where('status', 8);
    }
}