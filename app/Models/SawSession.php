<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SawSession extends Model
{
    protected $table = 'saw_sessions';
    protected $primaryKey = 'id_session';
    
    protected $fillable = [
        'kode_prodi',
        'id_tahun',
        'judul',
        'uploaded_by',
        'total_mahasiswa',
        'status'
    ];

    public function prodi()
    {
        return $this->belongsTo(Prodi::class, 'kode_prodi', 'kode_prodi');
    }

    public function tahun()
    {
        return $this->belongsTo(Tahun::class, 'id_tahun', 'id_tahun');
    }

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function nilaiMahasiswa()
    {
        return $this->hasMany(SawNilaiMahasiswa::class, 'id_session', 'id_session');
    }

    public function rankings()
    {
        return $this->hasMany(SawRanking::class, 'id_session', 'id_session');
    }
}
