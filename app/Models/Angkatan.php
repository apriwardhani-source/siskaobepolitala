<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Angkatan extends Model
{
    use HasFactory;

    protected $fillable = ['tahun_kurikulum', 'matkul_id'];

    public function matkul()
    {
        return $this->belongsTo(MataKuliah::class, 'matkul_id');
    }

    public function mahasiswas()
    {
        return $this->hasMany(Mahasiswa::class);
    }
}
