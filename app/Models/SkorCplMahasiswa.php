<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SkorCplMahasiswa extends Model
{
    use HasFactory;
    
    protected $table = 'skor_cpl_mahasiswa';
    protected $primaryKey = 'id_skor';
    public $incrementing = true;
    protected $fillable = [
        'nim',
        'id_cpl',
        'id_tahun',
        'skor'
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'nim', 'nim');
    }

    public function cpl()
    {
        return $this->belongsTo(CapaianProfilLulusan::class, 'id_cpl', 'id_cpl');
    }

    public function tahun()
    {
        return $this->belongsTo(Tahun::class, 'id_tahun', 'id_tahun');
    }
}