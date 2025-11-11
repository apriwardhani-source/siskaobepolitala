<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SawRanking extends Model
{
    protected $table = 'saw_rankings';
    protected $primaryKey = 'id_ranking';
    
    protected $fillable = [
        'id_session',
        'nim',
        'nama_mahasiswa',
        'total_skor',
        'ranking',
        'detail_perhitungan'
    ];

    protected $casts = [
        'total_skor' => 'decimal:6',
        'detail_perhitungan' => 'array'
    ];

    public function session()
    {
        return $this->belongsTo(SawSession::class, 'id_session', 'id_session');
    }
}
