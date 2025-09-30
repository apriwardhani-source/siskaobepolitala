<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prodi extends Model
{
    use HasFactory;

    // Tentukan kolom-kolom yang bisa diisi secara massal
    protected $fillable = [
        'kode_prodi',
        'nama_prodi',
        // Tambahkan kolom lain yang kamu miliki di tabel 'prodis' di sini, misalnya:
        // 'jenjang',
        // 'deskripsi',
    ];

    // Jika kamu ingin menentukan kolom yang *tidak* bisa diisi secara massal,
    // kamu bisa gunakan $guarded (kebalikan dari $fillable)
    // protected $guarded = ['id']; // Artinya semua kolom bisa diisi massal kecuali 'id'
    // Namun, $fillable lebih aman dan direkomendasikan.
}