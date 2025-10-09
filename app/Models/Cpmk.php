<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cpmk extends Model
{
    use HasFactory;

    protected $fillable = [
        'cpl_id',
        'kode_cpmk',
        'deskripsi',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function cpl()
    {
        return $this->belongsTo(Cpl::class);
    }

    public function mataKuliahs()
    {
        return $this->belongsToMany(MataKuliah::class, 'cpmk_mata_kuliah')
            ->withTimestamps();
    }

    public function mappings()
    {
        return $this->hasMany(Mapping::class, 'cpmk_id');
    }

    public function subCpmks()
    {
        return $this->hasMany(SubCpmk::class);
    }
}
