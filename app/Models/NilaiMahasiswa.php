<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NilaiMahasiswa extends Model
{
    use HasFactory;
    
    protected $table = 'nilai_mahasiswa';
    protected $primaryKey = 'id_nilai';
    public $incrementing = true;
    protected $fillable = [
        'nim',
        'kode_mk',
        'id_teknik',
        'id_cpl',
        'id_cpmk',
        'nilai',
        'id_tahun'
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'nim', 'nim');
    }

    public function mataKuliah()
    {
        return $this->belongsTo(MataKuliah::class, 'kode_mk', 'kode_mk');
    }

    public function teknikPenilaian()
    {
        return $this->belongsTo(TeknikPenilaian::class, 'id_teknik', 'id_teknik');
    }

    public function cpl()
    {
        return $this->belongsTo(CapaianProfilLulusan::class, 'id_cpl', 'id_cpl');
    }

    public function cpmk()
    {
        return $this->belongsTo(CapaianPembelajaranMataKuliah::class, 'id_cpmk', 'id_cpmk');
    }

    public function tahun()
    {
        return $this->belongsTo(Tahun::class, 'id_tahun', 'id_tahun');
    }
}