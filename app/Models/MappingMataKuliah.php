<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MappingMataKuliah extends Model
{
    use HasFactory;

    protected $fillable = ['mapping_id', 'mata_kuliah_id'];

    public function mapping()
    {
        return $this->belongsTo(Mapping::class);
    }

    public function mataKuliah()
    {
        return $this->belongsTo(MataKuliah::class);
    }
}
