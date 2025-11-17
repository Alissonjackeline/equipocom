<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Boss extends Model
{
    use HasFactory;

    protected $table = 'bosses';
    protected $primaryKey = 'idBoss';

    protected $fillable = [
        'Document',
        'Name',
        'Cargo',
        'Area_id',
        'Phone',
        'Status'
    ];

    public function area()
    {
        return $this->belongsTo(Area::class, 'Area_id', 'idArea');
    }

    public function scopeActive($query)
    {
        return $query->where('Status', 1);
    }

    public function getStatusTextAttribute(): string
    {
        return $this->Status == 1 ? 'Activo' : 'Inactivo';
    }

    public function getStatusClassAttribute(): string
    {
        return $this->Status == 1 ? 'success' : 'danger';
    }

    public function setDocumentAttribute($value)
    {
        $this->attributes['Document'] = preg_replace('/[^0-9]/', '', $value);
    }

    public function setNameAttribute($value)
    {
        $this->attributes['Name'] = ucwords(strtolower($value));
    }

    public function setCargoAttribute($value)
    {
        $this->attributes['Cargo'] = ucwords(strtolower($value));
    }
}