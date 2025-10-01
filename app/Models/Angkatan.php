<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Angkatan extends Model
{
    use HasFactory;

    protected $fillable = ['tahun_angkatan', 'prodi_id'];

    public function prodi()
    {
        return $this->belongsTo(Prodi::class);
    }

    public function mahasiswas()
    {
        return $this->hasMany(Mahasiswa::class);
    }
}
