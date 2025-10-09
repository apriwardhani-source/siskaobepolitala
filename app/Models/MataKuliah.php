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
}
