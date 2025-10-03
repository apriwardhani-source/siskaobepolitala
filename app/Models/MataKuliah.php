<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // tambahkan ini
use Illuminate\Database\Eloquent\Model;

class MataKuliah extends Model
{
    use HasFactory;

    protected $table = 'matakuliahs'; // sesuaikan dengan nama tabel
    protected $fillable = ['kode', 'nama', 'sks', 'dosen_id'];
}
