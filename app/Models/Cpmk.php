<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cpmk extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_cpmk',
        'deskripsi',
        'cpl_id',
    ];

    public function cpl()
    {
        return $this->belongsTo(Cpl::class, 'cpl_id');
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

}
