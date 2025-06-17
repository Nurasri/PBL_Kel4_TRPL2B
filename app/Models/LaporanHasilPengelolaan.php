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
        'status_validasi',
        'validated_by',
        'validated_at',
        'catatan_validasi'
    ];

    protected $casts = [
        'tanggal_selesai' => 'date',
        'jumlah_berhasil_dikelola' => 'decimal:2',
        'jumlah_residu' => 'decimal:2',
        'biaya_aktual' => 'decimal:2',
        'efisiensi_pengelolaan' => 'decimal:2',
        'dokumentasi' => 'array',
        'validated_at' => 'datetime',
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

    public function validator()
    {
        return $this->belongsTo(User::class, 'validated_by');
    }

    // Accessors
    public function getStatusHasilNameAttribute()
    {
        return self::getStatusHasilOptions()[$this->status_hasil] ?? 'Unknown';
    }

    public function getStatusValidasiNameAttribute()
    {
        return self::getStatusValidasiOptions()[$this->status_validasi] ?? 'Unknown';
    }

    public function getStatusBadgeClassAttribute()
    {
        return [
            'berhasil' => 'green',
            'gagal' => 'red',
            'partial' => 'yellow'
        ][$this->status_hasil] ?? 'gray';
    }

    public function getValidasiBadgeClassAttribute()
    {
        return [
            'draft' => 'gray',
            'submitted' => 'blue',
            'approved' => 'green',
            'rejected' => 'red'
        ][$this->status_validasi] ?? 'gray';
    }

    // Methods
    public function isDraft()
    {
        return $this->status_validasi === 'draft';
    }

    public function canEdit()
    {
        return in_array($this->status_validasi, ['draft', 'rejected']);
    }

    public function canSubmit()
    {
        return $this->status_validasi === 'draft';
    }

    public function canApprove()
    {
        return $this->status_validasi === 'submitted';
    }

    public function submit()
    {
        $this->update([
            'status_validasi' => 'submitted'
        ]);
    }

    public function approve($validatorId, $catatan = null)
    {
        $this->update([
            'status_validasi' => 'approved',
            'validated_by' => $validatorId,
            'validated_at' => now(),
            'catatan_validasi' => $catatan
        ]);
    }

    public function reject($validatorId, $catatan)
    {
        $this->update([
            'status_validasi' => 'rejected',
            'validated_by' => $validatorId,
            'validated_at' => now(),
            'catatan_validasi' => $catatan
        ]);
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

    public static function getStatusValidasiOptions(): array
    {
        return [
            'draft' => 'Draft',
            'submitted' => 'Disubmit',
            'approved' => 'Disetujui',
            'rejected' => 'Ditolak'
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
            'dokumentasi.*.mimes' => 'File harus berformat PDF, JPG, JPEG, atau PNG.',
            'dokumentasi.*.max' => 'Ukuran file maksimal 5MB.'
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

    public function scopeByValidasi($query, $validasi)
    {
        return $query->where('status_validasi', $validasi);
    }

    public function scopeApproved($query)
    {
        return $query->where('status_validasi', 'approved');
    }

    public function scopePending($query)
    {
        return $query->where('status_validasi', 'submitted');
    }
}
