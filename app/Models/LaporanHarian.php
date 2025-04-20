<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LaporanHarian extends Model
{
    protected $fillable = ['tanggal', 'jenis_limbah', 'jumlah', 'lokasi', 'status'];

}
