<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Santri extends Model
{
    use HasFactory;

    protected $table = 'santri';

    protected $fillable = [
        'nis',
        'nama',
        'alamat',
        'no_hp',
        'tanggal_lahir',
        'nama_orang_tua',
        'jenjang',
        'kelas',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_lahir' => 'date',
            'status' => 'boolean',
        ];
    }

    public function absensi(): HasMany
    {
        return $this->hasMany(Absensi::class);
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }

    public function getTotalDendaAttribute(): int
    {
        return $this->absensi()->sum('denda');
    }

    public function getTotalHadirAttribute(): int
    {
        return $this->absensi()->where('status', 'hadir')->count();
    }

    public function getTotalIzinAttribute(): int
    {
        return $this->absensi()->where('status', 'izin')->count();
    }

    public function getTotalSakitAttribute(): int
    {
        return $this->absensi()->where('status', 'sakit')->count();
    }

    public function getTotalAlphaAttribute(): int
    {
        return $this->absensi()->where('status', 'alpha')->count();
    }

    public function getTotalPertemuanAttribute(): int
    {
        return $this->absensi()->count();
    }

    public function getPersentaseKehadiranAttribute(): float
    {
        $totalHadir = $this->total_hadir;
        $totalPertemuan = $this->total_pertemuan;

        if ($totalPertemuan === 0) {
            return 0;
        }

        return round(($totalHadir / $totalPertemuan) * 100, 2);
    }

    public function getKelasNameAttribute(): string
    {
        return $this->kelas ?? '-';
    }
}