<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory;

    protected $fillable = [
    'nim',
    'nama',           // atau 'nama_mahasiswa' -> sesuaikan dengan migration
    'tahun_kurikulum',
    'prodi_id',
];


    // relasi ke Angkatan
    public function angkatan()
    {
        return $this->belongsTo(Angkatan::class);
    }

    // relasi ke Prodi
    public function prodi()
    {
        return $this->belongsTo(Prodi::class);
    }
}
