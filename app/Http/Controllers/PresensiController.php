<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\JamPelajaran;
use App\Models\Santri;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;

class PresensiController extends Controller
{
    public function index(Request $request): View
    {
        // Use selected date from request, or today as default
        $selectedDate = $request->query('tanggal', Carbon::now()->toDateString());
        $selectedDateName = Carbon::parse($selectedDate)->format('l');

        $hariMap = [
            'Sunday' => 'Minggu',
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu',
        ];
        $hariIni = $hariMap[$selectedDateName] ?? $selectedDateName;

        $jadwalFull = $this->getJadwalForHari($hariIni);

        // Pisahkan jadwal per jenjang
        $jamPelajaran = [
            'safinatunnajah' => collect($jadwalFull['safinatunnajah']),
            'muqodimah' => collect($jadwalFull['muqodimah']),
        ];

        $selectedJamId = (int) ($request->query('jam') ?? $request->jam_pelajaran_id ?? 1);

        // Filter santri by jenjang (default: safinatunnajah)
        $jenjang = $request->get('jenjang', 'safinatunnajah');
        $santri = Santri::select('id', 'nama', 'jenjang', 'status')->where('status', true)
            ->where('jenjang', 'LIKE', $jenjang)
            ->orderBy('nama')
            ->get();
        
        // Debug: Log jumlah santri
        \Illuminate\Support\Facades\Log::info("Jenjang: $jenjang, Jumlah santri: " . $santri->count());
        
        // Debug: Dump untuk test
        if ($santri->count() === 0) {
            \Illuminate\Support\Facades\Log::info("TIDAK ADA SANTRI UNTUK JENJANG: $jenjang");
        }

        // Clear any session data that might interfere
        session()->forget(['presensi_data', 'last_jam_id']);
        
        // Get existing attendance for this specific jam_pelajaran_id and selected date
        $existingAbsensi = Absensi::where('tanggal', $selectedDate)
            ->where('jam_pelajaran_id', (int) $selectedJamId)
            ->get(['santri_id', 'status', 'keterangan'])
            ->toArray();

        $existingAbsensiStatus = [];
        $existingAbsensiKeterangan = [];
        foreach ($existingAbsensi as $row) {
            $existingAbsensiStatus[$row['santri_id']] = $row['status'];
            $existingAbsensiKeterangan[$row['santri_id']] = $row['keterangan'];
        }

        return view('presensi.index', [
            'santri' => $santri,
            'jamPelajaran' => $jamPelajaran,
            'selectedJamId' => $selectedJamId,
            'today' => $selectedDate,
            'hariIni' => $hariIni,
            'existingAbsensi' => $existingAbsensiStatus,
            'existingAbsensiKeterangan' => $existingAbsensiKeterangan,
            'jenjangFilter' => $jenjang ?? null
        ]);
    }

    

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'jenjang' => 'required|in:safinatunnajah,muqodimah',
            'jam_pelajaran_id' => 'required|integer|min:1|exists:jam_pelajaran,id',
            'presensi' => 'required|array',
            'presensi.*' => 'required|in:hadir,izin,sakit,alpha',
            'keterangan' => 'nullable|array',
            'keterangan.*' => 'nullable|string|max:255',
            'tanggal' => ['required', 'date', 'before_or_equal:today'],
        ]);

        $user = Auth::user();
        $tanggal = $validated['tanggal'];
        $tanggalName = Carbon::parse($tanggal)->format('l');

        $hariMap = [
            'Sunday' => 'Minggu',
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu',
        ];
        $hariIni = $hariMap[$tanggalName] ?? $tanggalName;

        $jamPelajaranId = (int) $validated['jam_pelajaran_id'];
        $keterangan = $validated['keterangan'] ?? [];

        $savedCount = 0;
        $updatedCount = 0;

        $santriIds = array_keys($validated['presensi']);
        $santriList = Santri::whereIn('id', $santriIds)->get()->keyBy('id');

        foreach ($validated['presensi'] as $santriId => $status) {
            $denda = Absensi::getDendaForStatus($status);
            $keteranganText = $keterangan[$santriId] ?? null;
            if ($keteranganText === '') {
                $keteranganText = null;
            }

            $santri = $santriList->get($santriId);
            if (!$santri || strtolower($santri->jenjang) !== strtolower($validated['jenjang'])) {
                continue;
            }

            $existing = Absensi::where('santri_id', $santriId)
                ->where('jam_pelajaran_id', $jamPelajaranId)
                ->where('tanggal', $tanggal)
                ->first();

            $deselecting = ($request->input('action') === 'deselect');

            if ($deselecting) {
                if ($existing) {
                    $existing->delete();
                    $updatedCount++;
                }
            } elseif ($existing) {
                $existing->update([
                    'status' => $status,
                    'denda' => $denda,
                    'keterangan' => $keteranganText,
                    'user_id' => $user->id,
                ]);
                $updatedCount++;
            } else {
                Absensi::create([
                    'santri_id' => $santriId,
                    'jam_pelajaran_id' => $jamPelajaranId,
                    'user_id' => $user->id,
                    'tanggal' => $tanggal,
                    'hari' => $hariIni,
                    'status' => $status,
                    'denda' => $denda,
                    'keterangan' => $keteranganText,
                ]);
                $savedCount++;
            }
        }

        $message = "Presensi berhasil disimpan!";
        if ($savedCount > 0) $message .= " ($savedCount baru)";
        if ($updatedCount > 0) $message .= " ($updatedCount diperbarui)";

        $redirectParams = [];
        if ($request->has('jenjang')) {
            $redirectParams['jenjang'] = $request->jenjang;
        }
        $redirectParams['jam'] = $jamPelajaranId;
        $redirectParams['tanggal'] = $tanggal;
        return redirect()->route('presensi.index', $redirectParams)->with('success', $message);
    }

    public function autoSave(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $validated = $request->validate([
                'jam_pelajaran_id' => 'required|integer|min:1|exists:jam_pelajaran,id',
                'santri_id' => 'required|integer',
                'status' => 'required|in:hadir,izin,sakit,alpha',
                'keterangan' => 'nullable|string|max:255',
                'jenjang' => 'required|in:safinatunnajah,muqodimah',
                'tanggal' => 'required|date',
                'action' => 'nullable|in:save,deselect',
            ]);

            $user = Auth::user();
            $tanggal = $validated['tanggal'];
            $tanggalName = Carbon::parse($tanggal)->format('l');

            $hariMap = [
                'Sunday' => 'Minggu',
                'Monday' => 'Senin',
                'Tuesday' => 'Selasa',
                'Wednesday' => 'Rabu',
                'Thursday' => 'Kamis',
                'Friday' => 'Jumat',
                'Saturday' => 'Sabtu',
            ];
            $hariIni = $hariMap[$tanggalName] ?? $tanggalName;

            $jamPelajaranId = (int) $validated['jam_pelajaran_id'];
            $santriId = (int) $validated['santri_id'];
            $status = $validated['status'];
            $keteranganText = $validated['keterangan'] ?? null;
            if ($keteranganText === '') {
                $keteranganText = null;
            }
            $jenjang = $validated['jenjang'] ?? 'safinatunnajah';
            $denda = Absensi::getDendaForStatus($status);

            // Verify that the santri belongs to the selected jenjang
            $santri = Santri::find($santriId);
            if (!$santri || strtolower($santri->jenjang) !== strtolower($jenjang)) {
                return response()->json(['success' => false, 'error' => 'Santri does not belong to selected jenjang']);
            }

            $existing = Absensi::where('santri_id', $santriId)
                ->where('jam_pelajaran_id', $jamPelajaranId)
                ->where('tanggal', $tanggal)
                ->first();

            $deselecting = ($request->input('action') === 'deselect');

            if ($deselecting) {
                if ($existing) {
                    $existing->delete();
                }
            } elseif ($existing) {
                $existing->update([
                    'status' => $status,
                    'denda' => $denda,
                    'keterangan' => $keteranganText,
                    'user_id' => $user->id,
                ]);
            } else {
                Absensi::create([
                    'santri_id' => $santriId,
                    'jam_pelajaran_id' => $jamPelajaranId,
                    'user_id' => $user->id,
                    'tanggal' => $tanggal,
                    'hari' => $hariIni,
                    'status' => $status,
                    'denda' => $denda,
                    'keterangan' => $keteranganText,
                ]);
            }

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }
    }

    public function edit(Request $request): View
    {
        $tanggal = $request->query('tanggal', Carbon::now()->toDateString());
        $dayOfWeek = Carbon::parse($tanggal)->format('l');

        $hariMap = [
            'Sunday' => 'Minggu',
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu',
        ];
        $hari = $hariMap[$dayOfWeek] ?? $dayOfWeek;

        $jadwalFull = $this->getJadwalForHari($hari);
        $jamPelajaran = collect($jadwalFull);

        $santri = Santri::select('id', 'nama', 'jenjang', 'status')->where('status', true)->orderBy('nama')->get();

        $existingAbsensi = Absensi::where('tanggal', $tanggal)
            ->pluck('status', 'santri_id')
            ->toArray();

        // Default jenjang filter
        $jenjangFilter = 'safinatunnajah';

        return view('presensi.edit', compact('santri', 'tanggal', 'hari', 'jamPelajaran', 'existingAbsensi', 'jenjangFilter'));
    }

    /**
     * Dashboard untuk petugas absen
     */
    public function dashboard(Request $request): View
    {
        $today = Carbon::now()->toDateString();
        $todayName = Carbon::now()->format('l');
        
        $hariMap = [
            'Sunday' => 'Minggu',
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu',
        ];
        $hariIni = $hariMap[$todayName] ?? $todayName;

        // Total santri aktif hari ini (berdasarkan jenjang Safinatunnajah dan Muqodimah)
        $totalSantriSafina = Santri::where('status', true)
            ->where('jenjang', 'Safinatunnajah')
            ->count();
        $totalSantriMuqo = Santri::where('status', true)
            ->where('jenjang', 'Muqodimah')
            ->count();
        $totalSantri = $totalSantriSafina + $totalSantriMuqo;

        // Hitung presensi hari ini (santri yang sudah presensi minimal 1x)
        $santriSudahPresensi = Absensi::where('tanggal', $today)
            ->distinct('santri_id')
            ->pluck('santri_id')
            ->toArray();
        $totalHadir = count($santriSudahPresensi);
        $totalBelum = $totalSantri - $totalHadir;
        $persentase = $totalSantri > 0 ? round(($totalHadir / $totalSantri) * 100) : 0;

        // Statistik per jenjang
        $statistikJenjang = [
            'Safinatunnajah' => [
                'total' => $totalSantriSafina,
                'hadir' => 0,
                'belum' => $totalSantriSafina,
                'persentase' => 0,
            ],
            'Muqodimah' => [
                'total' => $totalSantriMuqo,
                'hadir' => 0,
                'belum' => $totalSantriMuqo,
                'persentase' => 0,
            ],
        ];

        // Hitung hadir per jenjang - SATU query saja buat kedua jenjang
        $hadirPerJenjang = Absensi::where('tanggal', $today)
            ->whereIn('santri_id', function($q) {
                $q->select('id')->from('santri')->where('status', true);
            })
            ->selectRaw('s.jenjang, COUNT(DISTINCT absensi.santri_id) as hadir_count')
            ->join('santri as s', 'absensi.santri_id', '=', 's.id')
            ->groupBy('s.jenjang')
            ->pluck('hadir_count', 's.jenjang');

        foreach (['Safinatunnajah', 'Muqodimah'] as $jenjang) {
            $hadirCount = $hadirPerJenjang[$jenjang] ?? 0;
            
            $statistikJenjang[$jenjang]['hadir'] = $hadirCount;
            $statistikJenjang[$jenjang]['belum'] = $statistikJenjang[$jenjang]['total'] - $hadirCount;
            $statistikJenjang[$jenjang]['persentase'] = $statistikJenjang[$jenjang]['total'] > 0 
                ? round(($hadirCount / $statistikJenjang[$jenjang]['total']) * 100) 
                : 0;
        }

        // Jadwal hari ini
        $jadwalHariIni = $this->getJadwalForHari($hariIni);

        // Santri yang belum presensi hari ini (ambil 10 teratas)
        $totalBelumPresensi = Santri::where('status', true)
            ->whereNotIn('id', $santriSudahPresensi)
            ->count();

        $santriBelumPresensi = Santri::where('status', true)
            ->whereNotIn('id', $santriSudahPresensi)
            ->orderBy('nama')
            ->limit(10)
            ->get();

        // Update terakhir presensi hari ini
        $lastUpdate = Absensi::where('tanggal', $today)
            ->orderBy('updated_at', 'desc')
            ->first();
        $lastUpdateTime = $lastUpdate ? $lastUpdate->updated_at->format('H:i:s') : null;

        return view('petugas.dashboard', [
            'today' => $today,
            'hariIni' => $hariIni,
            'totalSantri' => $totalSantri,
            'totalHadir' => $totalHadir,
            'totalBelum' => $totalBelum,
            'persentase' => $persentase,
            'statistikJenjang' => $statistikJenjang,
            'jadwalHariIni' => $jadwalHariIni,
            'santriBelumPresensi' => $santriBelumPresensi,
            'totalBelumPresensi' => $totalBelumPresensi,
            'lastUpdate' => $lastUpdateTime,
        ]);
    }

    private function getJadwalForHari(string $hari): array
    {
        // Ambil jadwal dari database berdasarkan hari
        $jadwalSafinatunnajah = JamPelajaran::where('hari', $hari)
            ->where('kelas', 'Safinatunnajah')
            ->where('status', true)
            ->orderBy('urutan')
            ->get()
            ->map(function ($jam) {
                return [
                    'id' => $jam->id,
                    'nama' => $jam->nama,
                    'jam_mulai' => $jam->jam_mulai instanceof \Carbon\Carbon 
                        ? $jam->jam_mulai->format('H:i') 
                        : \Carbon\Carbon::parse($jam->jam_mulai)->format('H:i'),
                    'jam_selesai' => $jam->jam_selesai instanceof \Carbon\Carbon 
                        ? $jam->jam_selesai->format('H:i') 
                        : \Carbon\Carbon::parse($jam->jam_selesai)->format('H:i'),
                    'ustadz' => $jam->ustadz,
                ];
            })->toArray();

        $jadwalMuqodimah = JamPelajaran::where('hari', $hari)
            ->where('kelas', 'Muqodimah')
            ->where('status', true)
            ->orderBy('urutan')
            ->get()
            ->map(function ($jam) {
                return [
                    'id' => $jam->id,
                    'nama' => $jam->nama,
                    'jam_mulai' => $jam->jam_mulai instanceof \Carbon\Carbon 
                        ? $jam->jam_mulai->format('H:i') 
                        : \Carbon\Carbon::parse($jam->jam_mulai)->format('H:i'),
                    'jam_selesai' => $jam->jam_selesai instanceof \Carbon\Carbon 
                        ? $jam->jam_selesai->format('H:i') 
                        : \Carbon\Carbon::parse($jam->jam_selesai)->format('H:i'),
                    'ustadz' => $jam->ustadz,
                ];
            })->toArray();

        return [
            'safinatunnajah' => $jadwalSafinatunnajah,
            'muqodimah' => $jadwalMuqodimah,
        ];
    }
}