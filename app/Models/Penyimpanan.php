<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penyimpanan extends Model
{
    use HasFactory;

    protected $fillable = [
        'perusahaan_id',
        'lokasi',
        'jenis_penyimpanan',
        'kapasitas',
        'catatan',
    ];
}
