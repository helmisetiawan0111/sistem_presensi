<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

class Absensi extends Model
{
    use HasFactory;

    protected $table = 'absensi';

    protected $fillable = [
        'santri_id',
        'jam_pelajaran_id',
        'user_id',
        'tanggal',
        'hari',
        'status',
        'denda',
        'keterangan',
        'status_pembayaran',
    ];

    protected function casts(): array
    {
        return [
            'tanggal' => 'date',
            'denda' => 'integer',
            'jam_pelajaran_id' => 'integer',
        ];
    }

    const STATUS_HADIR = 'hadir';
    const STATUS_IZIN = 'izin';
    const STATUS_SAKIT = 'sakit';
    const STATUS_ALPHA = 'alpha';

    const DENDA_HADIR = 0;
    const DENDA_IZIN = 2000;
    const DENDA_SAKIT = 2000;
    const DENDA_ALPHA = 5000;

    public static function getDendaForStatus(string $status): int
    {
        return match($status) {
            self::STATUS_HADIR => self::DENDA_HADIR,
            self::STATUS_IZIN => self::DENDA_IZIN,
            self::STATUS_SAKIT => self::DENDA_SAKIT,
            self::STATUS_ALPHA => self::DENDA_ALPHA,
            default => 0,
        };
    }

    public function santri(): BelongsTo
    {
        return $this->belongsTo(Santri::class);
    }

    public function jamPelajaran(): BelongsTo
    {
        return $this->belongsTo(JamPelajaran::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getNamaStatusAttribute(): string
    {
        return match($this->status) {
            self::STATUS_HADIR => 'Hadir',
            self::STATUS_IZIN => 'Izin',
            self::STATUS_SAKIT => 'Sakit',
            self::STATUS_ALPHA => 'Alpha',
            default => 'Unknown',
        };
    }

    protected static function booted()
    {
        static::creating(function ($absensi) {
            $absensi->denda = self::getDendaForStatus($absensi->status);
            $absensi->tanggal = $absensi->tanggal ?? Carbon::now()->toDateString();
            
            $hariMap = [
                'Sunday' => 'Minggu',
                'Monday' => 'Senin',
                'Tuesday' => 'Selasa',
                'Wednesday' => 'Rabu',
                'Thursday' => 'Kamis',
                'Friday' => 'Jumat',
                'Saturday' => 'Sabtu',
            ];
            $dayName = Carbon::now()->format('l');
            $absensi->hari = $hariMap[$dayName] ?? $dayName;
        });

        static::updating(function ($absensi) {
            $absensi->denda = self::getDendaForStatus($absensi->status);
        });
    }
}