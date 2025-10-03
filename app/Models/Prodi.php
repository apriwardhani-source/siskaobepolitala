<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prodi extends Model
{
    use HasFactory;

    protected $table = 'prodis';

    protected $fillable = ['kode_prodi', 'nama_prodi', 'jenjang'];

    public function mataKuliahs()
    {
        return $this->hasMany(MataKuliah::class, 'prodi_id');
    }
}
