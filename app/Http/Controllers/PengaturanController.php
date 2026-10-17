<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PengaturanController extends Controller
{
    /**
     * Display the settings page.
     */
    public function index()
    {
        return view('pengaturan.index');
    }

    /**
     * Reset semua data absensi (dengan konfirmasi).
     */
    public function resetPresensi(Request $request)
    {
        $request->validate([
            'confirmation' => 'required|in:YA',
        ]);

        try {
            DB::beginTransaction();

            // Hapus semua data absensi
            DB::table('absensi')->delete();

            DB::commit();

            return redirect()->back()->with('success', 'Semua data absensi berhasil direset.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal reset data: ' . $e->getMessage());
        }
    }

    /**
     * Clear all data Santri (dangerous operation).
     */
    public function resetSantri(Request $request)
    {
        $request->validate([
            'confirmation' => 'required|in:YA',
        ]);

        try {
            DB::beginTransaction();

            // Hapus semua data santri
            DB::table('santri')->delete();

            DB::commit();

            return redirect()->back()->with('success', 'Semua data santri berhasil direset.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal reset data santri: ' . $e->getMessage());
        }
    }
}
