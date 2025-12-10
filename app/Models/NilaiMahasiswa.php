<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class NilaiMahasiswa extends Model
{
    use HasFactory, LogsActivity;
    
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
        'nilai_akhir',
        'id_tahun',
        'user_id'
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

    public function dosen()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Activity Log Configuration
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['nim', 'kode_mk', 'nilai', 'nilai_akhir', 'user_id'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(fn(string $eventName) => "Nilai {$eventName} for NIM {$this->nim}");
    }
}