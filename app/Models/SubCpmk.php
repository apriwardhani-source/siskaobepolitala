<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCpmk extends Model
{
    use HasFactory;

    protected $fillable = ['cpmk_id', 'uraian'];

    public function cpmk()
    {
        return $this->belongsTo(Cpmk::class);
    }
}

