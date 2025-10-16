<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeknikPenilaian extends Model
{
    use HasFactory;
    
    protected $table = 'teknik_penilaian';
    protected $primaryKey = 'id_teknik';
    public $incrementing = true;
    protected $fillable = [
        'nama_teknik',
        'kode_mk',
        'id_cpl',
        'id_cpmk',
        'bobot',
        'id_tahun'
    ];

    public function mataKuliah()
    {
        return $this->belongsTo(MataKuliah::class, 'kode_mk', 'kode_mk');
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

    public function nilaiMahasiswa()
    {
        return $this->hasMany(NilaiMahasiswa::class, 'id_teknik', 'id_teknik');
    }
}