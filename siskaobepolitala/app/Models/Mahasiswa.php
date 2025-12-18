<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory;
    
    protected $table = 'mahasiswas';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $fillable = [
        'nim',
        'nama_mahasiswa',
        'kode_prodi',
        'id_tahun_kurikulum',
        'status'
    ];

    public function prodi()
    {
        return $this->belongsTo(Prodi::class, 'kode_prodi', 'kode_prodi');
    }

    public function tahunKurikulum()
    {
        return $this->belongsTo(Tahun::class, 'id_tahun_kurikulum', 'id_tahun');
    }

    public function nilai()
    {
        return $this->hasMany(NilaiMahasiswa::class, 'nim', 'nim');
    }

    public function skorCPL()
    {
        return $this->hasMany(SkorCplMahasiswa::class, 'nim', 'nim');
    }
}