<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mapping extends Model
{
    use HasFactory;

    protected $fillable = ['cpl_id', 'cpmk_id', 'bobot'];

    public function cpl() { return $this->belongsTo(Cpl::class); }
    public function cpmk() { return $this->belongsTo(Cpmk::class); }

    public function mataKuliahs()
    {
        return $this->belongsToMany(
            MataKuliah::class,
            'mapping_mata_kuliahs',
            'mapping_id',
            'mata_kuliah_id'
        )->withTimestamps();
    }
}
