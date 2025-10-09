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

    // Relasi ke Prodi
    public function prodi()
    {
        return $this->belongsTo(Prodi::class);
    }

    // Relasi ke CPMK (many-to-many)
    public function cpmks()
{
    return $this->hasMany(Cpmk::class, 'cpl_id');
}



    // Relasi ke Mapping jika ada
    public function mappings()
    {
        return $this->hasMany(Mapping::class);
    }
    
}
