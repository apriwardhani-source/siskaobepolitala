<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cpmk extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_cpmk',
        'deskripsi',
        'mata_kuliah_id',
    ];

    // Relasi
    public function mataKuliah()
    {
        return $this->belongsTo(MataKuliah::class);
    }

    public function mappings()
    {
        return $this->hasMany(Mapping::class);
    }
}