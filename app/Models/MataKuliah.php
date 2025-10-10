<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MataKuliah extends Model
{
    use HasFactory;

    protected $table = 'mata_kuliahs';

    protected $fillable = [
        'kode_matkul',
        'nama_matkul',
        'sks',
    ];

    public function mappings()
    {
        return $this->belongsToMany(Mapping::class, 'mapping_mata_kuliahs', 'mata_kuliah_id', 'mapping_id')
                    ->withTimestamps();
    }

    // Relasi ke CPMK melalui pivot cpmk_mata_kuliah
    public function cpmks()
    {
        return $this->belongsToMany(Cpmk::class, 'cpmk_mata_kuliah', 'mata_kuliah_id', 'cpmk_id')
                    ->withTimestamps();
    }
}
