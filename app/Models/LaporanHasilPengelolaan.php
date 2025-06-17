<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LaporanHasilPengelolaan extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'perusahaan_id',
        'pengelolaan_limbah_id',
        'tanggal_selesai',
        'status_hasil',
        'jumlah_berhasil_dikelola',
        'jumlah_residu',
        'satuan',
        'metode_disposal_akhir',
        'biaya_aktual',
        'efisiensi_pengelolaan',
        'dokumentasi',
        'nomor_sertifikat',
        'catatan_hasil',
       
    ];

    protected $casts = [
        'tanggal_selesai' => 'date',
        'jumlah_berhasil_dikelola' => 'decimal:2',
        'jumlah_residu' => 'decimal:2',
        'biaya_aktual' => 'decimal:2',
        'efisiensi_pengelolaan' => 'decimal:2',
        'dokumentasi' => 'array',
        
    ];

    // Relationships
    public function perusahaan()
    {
        return $this->belongsTo(Perusahaan::class);
    }

    public function pengelolaanLimbah()
    {
        return $this->belongsTo(PengelolaanLimbah::class);
    }

    

    // Accessors
    public function getStatusHasilNameAttribute()
    {
        return self::getStatusHasilOptions()[$this->status_hasil] ?? 'Unknown';
    }

    

    public function getStatusBadgeClassAttribute()
    {
        return [
            'berhasil' => 'green',
            'gagal' => 'red',
            'partial' => 'yellow'
        ][$this->status_hasil] ?? 'gray';
    }

    

    // Methods
    public function isDraft()
    {
        return $this->status_validasi === 'draft';
    }

    public function canEdit()
    {
        return true; // Perusahaan selalu bisa edit
    }

    public function canSubmit()
    {
        return $this->status_validasi === 'draft';
    }



    public function calculateEfficiency()
    {
        if ($this->pengelolaanLimbah && $this->pengelolaanLimbah->jumlah_dikelola > 0) {
            return ($this->jumlah_berhasil_dikelola / $this->pengelolaanLimbah->jumlah_dikelola) * 100;
        }
        return 0;
    }

    // Static methods
    public static function getStatusHasilOptions(): array
    {
        return [
            'berhasil' => 'Berhasil Sepenuhnya',
            'partial' => 'Berhasil Sebagian',
            'gagal' => 'Gagal'
        ];
    }

   

    public static function getMetodeDisposalOptions(): array
    {
        return [
            'landfill' => 'Landfill',
            'incineration' => 'Insinerasi',
            'recycling' => 'Daur Ulang',
            'composting' => 'Pengomposan',
            'treatment' => 'Pengolahan',
            'recovery' => 'Recovery',
            'neutralization' => 'Netralisasi',
            'stabilization' => 'Stabilisasi'
        ];
    }

    public static function validationRules($id = null): array
    {
        return [
            'pengelolaan_limbah_id' => 'required|exists:pengelolaan_limbahs,id',
            'tanggal_selesai' => 'required|date|before_or_equal:today',
            'status_hasil' => 'required|in:berhasil,gagal,partial',
            'jumlah_berhasil_dikelola' => 'required|numeric|min:0',
            'jumlah_residu' => 'nullable|numeric|min:0',
            'metode_disposal_akhir' => 'nullable|string|max:255',
            'biaya_aktual' => 'nullable|numeric|min:0',
            'nomor_sertifikat' => 'nullable|string|max:255',
            'catatan_hasil' => 'nullable|string|max:2000',
            'dokumentasi.*' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120' // 5MB
        ];
    }

    public static function validationMessages(): array
    {
        return [
            'pengelolaan_limbah_id.required' => 'Pengelolaan limbah wajib dipilih.',
            'tanggal_selesai.required' => 'Tanggal selesai wajib diisi.',
            'tanggal_selesai.before_or_equal' => 'Tanggal selesai tidak boleh lebih dari hari ini.',
            'status_hasil.required' => 'Status hasil wajib dipilih.',
            'jumlah_berhasil_dikelola.required' => 'Jumlah berhasil dikelola wajib diisi.',
            'jumlah_berhasil_dikelola.min' => 'Jumlah tidak boleh kurang dari 0.',
            'biaya_aktual.numeric' => 'Biaya aktual harus berupa angka.',
            'biaya_aktual.min' => 'Biaya aktual tidak boleh kurang dari 0.',
            'dokumentasi.*.file' => 'Dokumentasi harus berupa file.',
            'dokumentasi.*.mimes' => 'Dokumentasi harus berformat PDF, JPG, JPEG, atau PNG.',
            'dokumentasi.*.max' => 'Ukuran file dokumentasi maksimal 5MB.',
            'nomor_sertifikat.max' => 'Nomor sertifikat maksimal 100 karakter.',
            'catatan_hasil.max' => 'Catatan hasil maksimal 2000 karakter.'
        ];
    }

    // Scopes
    public function scopeByPerusahaan($query, $perusahaanId)
    {
        return $query->where('perusahaan_id', $perusahaanId);
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status_hasil', $status);
    }
    // public function scopeByValidasi($query, $status)
    // {
    //     return $query->where('status_validasi', $status);
    // }

    // Boot method untuk auto-calculate efficiency
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            // Auto-calculate efficiency if not set
            if (is_null($model->efisiensi_pengelolaan)) {
                $model->efisiensi_pengelolaan = $model->calculateEfficiency();
            }
        });
    }
    
}
