<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SawNilaiMahasiswa extends Model
{
    protected $table = 'saw_nilai_mahasiswa';
    
    protected $fillable = [
        'id_session',
        'nim',
        'nama_mahasiswa',
        'kode_mk',
        'nilai'
    ];

    protected $casts = [
        'nilai' => 'decimal:2'
    ];

    public function session()
    {
        return $this->belongsTo(SawSession::class, 'id_session', 'id_session');
    }

    public function mataKuliah()
    {
        return $this->belongsTo(MataKuliah::class, 'kode_mk', 'kode_mk');
    }
}
