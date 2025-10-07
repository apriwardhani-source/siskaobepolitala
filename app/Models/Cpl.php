<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cpl extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_cpl',
        'deskripsi',
        'threshold',
    ];

    protected $casts = [
        'threshold' => 'decimal:2',
    ];

    // Relasi
    public function prodi()
    {
        return $this->belongsTo(Prodi::class);
    }

    public function mappings()
    {
        return $this->hasMany(Mapping::class);
    }
}