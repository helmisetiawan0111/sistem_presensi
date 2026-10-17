<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\JamPelajaran;

class JamPelajaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define schedule for both classes (All same time: 08:00, 09:00, 10:00)
        $schedule = [
            'Senin' => [
                'Safinatunnajah' => [
                    ['nama' => 'Fiqh', 'jam_mulai' => '08:00', 'jam_selesai' => '09:00', 'ustadz' => 'Ustadz Ahmad'],
                    ['nama' => 'Tafsir', 'jam_mulai' => '09:00', 'jam_selesai' => '10:00', 'ustadz' => 'Ustadz Buhari'],
                    ['nama' => 'Hadits', 'jam_mulai' => '10:00', 'jam_selesai' => '11:00', 'ustadz' => 'Ustadz Hasan'],
                ],
                'Muqodimah' => [
                    ['nama' => 'Fiqh Asas', 'jam_mulai' => '08:00', 'jam_selesai' => '09:00', 'ustadz' => 'Ustadzah Fatimah'],
                    ['nama' => 'Tafsir', 'jam_mulai' => '09:00', 'jam_selesai' => '10:00', 'ustadz' => 'Ustadzah Aisyah'],
                    ['nama' => 'Hadits', 'jam_mulai' => '10:00', 'jam_selesai' => '11:00', 'ustadz' => 'Ustadzah Khadijah'],
                ],
            ],
            'Selasa' => [
                'Safinatunnajah' => [
                    ['nama' => 'Fiqh', 'jam_mulai' => '08:00', 'jam_selesai' => '09:00', 'ustadz' => 'Ustadz Ahmad'],
                    ['nama' => 'Tajwid', 'jam_mulai' => '09:00', 'jam_selesai' => '10:00', 'ustadz' => 'Ustadz Buhari'],
                    ['nama' => 'Siyam', 'jam_mulai' => '10:00', 'jam_selesai' => '11:00', 'ustadz' => 'Ustadz Hasan'],
                ],
                'Muqodimah' => [
                    ['nama' => 'Fiqh', 'jam_mulai' => '08:00', 'jam_selesai' => '09:00', 'ustadz' => 'Ustadzah Fatimah'],
                    ['nama' => 'Tajwid', 'jam_mulai' => '09:00', 'jam_selesai' => '10:00', 'ustadz' => 'Ustadzah Aisyah'],
                    ['nama' => 'Siyam', 'jam_mulai' => '10:00', 'jam_selesai' => '11:00', 'ustadz' => 'Ustadzah Khadijah'],
                ],
            ],
            'Rabu' => [
                'Safinatunnajah' => [
                    ['nama' => 'Fiqh', 'jam_mulai' => '08:00', 'jam_selesai' => '09:00', 'ustadz' => 'Ustadz Ahmad'],
                    ['nama' => 'Nahwu', 'jam_mulai' => '09:00', 'jam_selesai' => '10:00', 'ustadz' => 'Ustadz Buhari'],
                    ['nama' => 'Shorof', 'jam_mulai' => '10:00', 'jam_selesai' => '11:00', 'ustadz' => 'Ustadz Hasan'],
                ],
                'Muqodimah' => [
                    ['nama' => 'Fiqh', 'jam_mulai' => '08:00', 'jam_selesai' => '09:00', 'ustadz' => 'Ustadzah Fatimah'],
                    ['nama' => 'Nahwu', 'jam_mulai' => '09:00', 'jam_selesai' => '10:00', 'ustadz' => 'Ustadzah Aisyah'],
                    ['nama' => 'Shorof', 'jam_mulai' => '10:00', 'jam_selesai' => '11:00', 'ustadz' => 'Ustadzah Khadijah'],
                ],
            ],
            'Kamis' => [
                'Safinatunnajah' => [
                    ['nama' => 'Fiqh', 'jam_mulai' => '08:00', 'jam_selesai' => '09:00', 'ustadz' => 'Ustadz Ahmad'],
                    ['nama' => 'Tafasir', 'jam_mulai' => '09:00', 'jam_selesai' => '10:00', 'ustadz' => 'Ustadz Buhari'],
                    ['nama' => 'Sirah', 'jam_mulai' => '10:00', 'jam_selesai' => '11:00', 'ustadz' => 'Ustadz Hasan'],
                ],
                'Muqodimah' => [
                    ['nama' => 'Fiqh', 'jam_mulai' => '08:00', 'jam_selesai' => '09:00', 'ustadz' => 'Ustadzah Fatimah'],
                    ['nama' => 'Tafasir', 'jam_mulai' => '09:00', 'jam_selesai' => '10:00', 'ustadz' => 'Ustadzah Aisyah'],
                    ['nama' => 'Sirah', 'jam_mulai' => '10:00', 'jam_selesai' => '11:00', 'ustadz' => 'Ustadzah Khadijah'],
                ],
            ],
            'Jumat' => [
                'Safinatunnajah' => [
                    ['nama' => 'Tafsir Jumat', 'jam_mulai' => '08:00', 'jam_selesai' => '09:00', 'ustadz' => 'Ustadz Ahmad'],
                ],
                'Muqodimah' => [
                    ['nama' => 'Tafsir Jumat', 'jam_mulai' => '08:00', 'jam_selesai' => '09:00', 'ustadz' => 'Ustadzah Fatimah'],
                ],
            ],
            'Sabtu' => [
                'Safinatunnajah' => [
                    ['nama' => 'Fiqh', 'jam_mulai' => '08:00', 'jam_selesai' => '09:00', 'ustadz' => 'Ustadz Ahmad'],
                    ['nama' => 'Tajwid', 'jam_mulai' => '09:00', 'jam_selesai' => '10:00', 'ustadz' => 'Ustadz Buhari'],
                    ['nama' => 'Hadits', 'jam_mulai' => '10:00', 'jam_selesai' => '11:00', 'ustadz' => 'Ustadz Hasan'],
                ],
                'Muqodimah' => [
                    ['nama' => 'Fiqh', 'jam_mulai' => '08:00', 'jam_selesai' => '09:00', 'ustadz' => 'Ustadzah Fatimah'],
                    ['nama' => 'Tajwid', 'jam_mulai' => '09:00', 'jam_selesai' => '10:00', 'ustadz' => 'Ustadzah Aisyah'],
                    ['nama' => 'Hadits', 'jam_mulai' => '10:00', 'jam_selesai' => '11:00', 'ustadz' => 'Ustadzah Khadijah'],
                ],
            ],
            'Minggu' => [
                'Safinatunnajah' => [
                    ['nama' => 'Tajwid', 'jam_mulai' => '08:00', 'jam_selesai' => '09:00', 'ustadz' => 'Ustadz Buhari'],
                    ['nama' => 'Hadits', 'jam_mulai' => '09:00', 'jam_selesai' => '10:00', 'ustadz' => 'Ustadz Hasan'],
                    ['nama' => 'Fiqh', 'jam_mulai' => '10:00', 'jam_selesai' => '11:00', 'ustadz' => 'Ustadz Ahmad'],
                ],
                'Muqodimah' => [
                    ['nama' => 'Tajwid', 'jam_mulai' => '08:00', 'jam_selesai' => '09:00', 'ustadz' => 'Ustadzah Aisyah'],
                    ['nama' => 'Hadits', 'jam_mulai' => '09:00', 'jam_selesai' => '10:00', 'ustadz' => 'Ustadzah Khadijah'],
                    ['nama' => 'Fiqh', 'jam_mulai' => '10:00', 'jam_selesai' => '11:00', 'ustadz' => 'Ustadzah Fatimah'],
                ],
            ],
        ];

        foreach ($schedule as $hari => $kelasData) {
            foreach ($kelasData as $kelas => $jams) {
                $urutan = 1;
                foreach ($jams as $jam) {
                    JamPelajaran::updateOrCreate(
                        [
                            'hari' => $hari,
                            'kelas' => $kelas,
                            'urutan' => $urutan,
                        ],
                        [
                            'nama' => $jam['nama'],
                            'jam_mulai' => $jam['jam_mulai'],
                            'jam_selesai' => $jam['jam_selesai'],
                            'ustadz' => $jam['ustadz'],
                            'status' => true,
                        ]
                    );
                    $urutan++;
                }
            }
        }
    }
}
