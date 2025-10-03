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
        'prodi_id',
    ];

    public function prodi()
    {
        return $this->belongsTo(Prodi::class);
    }
}
