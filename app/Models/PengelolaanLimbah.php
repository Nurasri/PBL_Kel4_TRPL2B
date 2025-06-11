<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengelolaanLimbah extends Model
{
    use HasFactory;

    protected $fillable = [
        'perusahaan_id',
        'laporan_harian_id',
        'penyimpanan_id',
        'vendor_id',
        'jumlah_dikelola',
        'satuan',
        'jenis_pengelolaan',
        'status',
        'tanggal_mulai',
        'tanggal_selesai',
        'biaya',
        'nomor_manifest',
        'catatan'
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
        'jumlah_dikelola' => 'decimal:2',
        'biaya' => 'decimal:2',
    ];

    // Relationships
    public function perusahaan()
    {
        return $this->belongsTo(Perusahaan::class);
    }

    public function laporanHarian()
    {
        return $this->belongsTo(LaporanHarian::class);
    }

    public function penyimpanan()
    {
        return $this->belongsTo(Penyimpanan::class);
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    // Accessors
    public function getStatusNameAttribute()
    {
        return self::getStatusOptions()[$this->status] ?? 'Unknown';
    }

    public function getStatusBadgeClassAttribute()
    {
        return [
            'diproses' => 'yellow',
            'dalam_pengangkutan' => 'blue',
            'selesai' => 'green',
            'dibatalkan' => 'red'
        ][$this->status] ?? 'gray';
    }

    public function getJenisPengelolaanNameAttribute()
    {
        return self::getJenisPengelolaanOptions()[$this->jenis_pengelolaan] ?? 'Unknown';
    }

    // Methods
    public function canEdit()
    {
        return in_array($this->status, ['diproses']);
    }

    public function canCancel()
    {
        return in_array($this->status, ['diproses', 'dalam_pengangkutan']);
    }

    public function markAsCompleted()
    {
        $this->update([
            'status' => 'selesai',
            'tanggal_selesai' => now()
        ]);
    }

    // Static methods
    public static function getJenisPengelolaanOptions(): array
    {
        return [
            'internal' => 'Pengelolaan Internal',
            'vendor_eksternal' => 'Vendor Eksternal',
            'disposal' => 'Disposal/Pemusnahan',
            'recycling' => 'Daur Ulang'
        ];
    }

    public static function getStatusOptions(): array
    {
        return [
            'diproses' => 'Sedang Diproses',
            'dalam_pengangkutan' => 'Dalam Pengangkutan',
            'selesai' => 'Selesai',
            'dibatalkan' => 'Dibatalkan'
        ];
    }

    public static function validationRules($id = null): array
    {
        return [
            'laporan_harian_id' => 'required|exists:laporan_harians,id',
            'penyimpanan_id' => 'required|exists:penyimpanans,id',
            'vendor_id' => 'nullable|exists:vendors,id',
            'jumlah_dikelola' => 'required|numeric|min:0.01',
            'jenis_pengelolaan' => 'required|in:' . implode(',', array_keys(self::getJenisPengelolaanOptions())),
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'biaya' => 'nullable|numeric|min:0',
            'nomor_manifest' => 'nullable|string|max:100',
            'catatan' => 'nullable|string|max:1000'
        ];
    }

    public static function validationMessages(): array
    {
        return [
            'laporan_harian_id.required' => 'Laporan harian wajib dipilih.',
            'penyimpanan_id.required' => 'Penyimpanan wajib dipilih.',
            'jumlah_dikelola.required' => 'Jumlah yang dikelola wajib diisi.',
            'jumlah_dikelola.min' => 'Jumlah minimal 0.01.',
            'jenis_pengelolaan.required' => 'Jenis pengelolaan wajib dipilih.',
            'tanggal_mulai.required' => 'Tanggal mulai wajib diisi.',
            'tanggal_selesai.after_or_equal' => 'Tanggal selesai harus setelah atau sama dengan tanggal mulai.'
        ];
    }
}
