<?php

namespace App\Models;

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

    /**
     * Casts para atributos
     */
    protected $casts = [
        'Price' => 'decimal:2',
        'status' => 'integer'
    ];

    /**
     * Relación con EquipmentType
     */
    // public function equipmentType()
    // {
    //     return $this->belongsTo(EquipmentType::class, 'EquipmentType_id', 'idEquipmentType');
    // }

    // /**
    //  * Relación con Supplier
    //  */
    // public function supplier()
    // {
    //     return $this->belongsTo(Supplier::class, 'Supplier_id', 'idSupplier');
    // }

    /**
     * Scope para equipos activos
     */
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    /**
     * Accessor para el estado
     */
    public function getStatusTextAttribute(): string
    {
        return $this->status == 1 ? 'Activo' : 'Inactivo';
    }

    /**
     * Accessor para la clase del badge
     */
    public function getStatusClassAttribute(): string
    {
        return $this->status == 1 ? 'success' : 'danger';
    }

    /**
     * Accessor para formatear el precio
     */
    public function getFormattedPriceAttribute(): string
    {
        return 'S/ ' . number_format($this->Price, 2);
    }

    /**
     * Accessor para la imagen (ruta completa)
     */
    public function getImageUrlAttribute(): ?string
    {
        if ($this->Imagen) {
            return asset('storage/' . $this->Imagen);
        }
        return null;
    }

    /**
     * Mutator para el código patrimonial (mayúsculas)
     */
    public function setCodigoPatriAttribute($value)
    {
        $this->attributes['CodigoPatri'] = strtoupper($value);
    }

    /**
     * Mutator para la serie (mayúsculas)
     */
    public function setSeriesAttribute($value)
    {
        $this->attributes['Series'] = strtoupper($value);
    }

    /**
     * Mutator para el modelo (mayúsculas)
     */
    public function setModelAttribute($value)
    {
        $this->attributes['Model'] = strtoupper($value);
    }

    /**
     * Mutator para la marca (mayúsculas)
     */
    public function setBrandAttribute($value)
    {
        $this->attributes['Brand'] = strtoupper($value);
    }

    /**
     * Verificar si el equipo tiene imagen
     */
    public function hasImage(): bool
    {
        return !empty($this->Imagen);
    }
}