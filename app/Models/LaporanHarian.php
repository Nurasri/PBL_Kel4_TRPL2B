<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LaporanHarian extends Model
{
    protected $fillable = [
        'perusahaan_id',
        'tanggal',
        'jenis_limbah',
        'jumlah',
        'lokasi',
        'status'
    ];

    public function perusahaan()
    {
        return $this->belongsTo(Perusahaan::class);
    }
}