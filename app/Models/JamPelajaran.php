<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JamPelajaran extends Model
{
    use HasFactory;

    protected $table = 'jam_pelajaran';

    protected $fillable = [
        'nama',
        'ustadz',
        'jam_mulai',
        'jam_selesai',
        'hari',
        'urutan',
        'status',
        'kelas',
    ];

    protected function casts(): array
    {
        return [
            'jam_mulai' => 'datetime',
            'jam_selesai' => 'datetime',
            'status' => 'boolean',
        ];
    }

    public function getJamMulaiFormattedAttribute(): string
    {
        return $this->jam_mulai instanceof \Carbon\Carbon 
            ? $this->jam_mulai->format('H:i') 
            : \Carbon\Carbon::parse($this->jam_mulai)->format('H:i');
    }

    public function getJamSelesaiFormattedAttribute(): string
    {
        return $this->jam_selesai instanceof \Carbon\Carbon 
            ? $this->jam_selesai->format('H:i') 
            : \Carbon\Carbon::parse($this->jam_selesai)->format('H:i');
    }

    public function absensi(): HasMany
    {
        return $this->hasMany(Absensi::class);
    }

    public function getNamaJamAttribute(): string
    {
        return $this->nama . ' (' . \Carbon\Carbon::parse($this->jam_mulai)->format('H:i') . ' - ' . \Carbon\Carbon::parse($this->jam_selesai)->format('H:i') . ')';
    }
}