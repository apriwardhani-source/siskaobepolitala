<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProfilLulusan extends Model
{
    use HasFactory;
    protected $table = 'profil_lulusans';
    protected $primaryKey = 'id_pl';
    public $incrementing = true;
    protected $fillable = [
        'kode_pl',
        'kode_prodi',
        'id_tahun',
        'deskripsi_pl',
        'profesi_pl',
        'unsur_pl',
        'keterangan_pl',
        'sumber_pl',
    ];

    public function prodi() {
        return $this->belongsTo(Prodi::class, 'kode_prodi', 'kode_prodi');
    }
    public function capaianProfilLulusans()
    {
        return $this->belongsToMany(CapaianProfilLulusan::class, 'cpl_pl', 'id_pl', 'id_cpl');
    }

    public function tahun()
    {
        return $this->belongsTo(Tahun::class, 'id_tahun', 'id_tahun');
    }
}
