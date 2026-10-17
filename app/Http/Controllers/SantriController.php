<?php

namespace App\Http\Controllers;

use App\Models\Santri;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class SantriController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->search;
        $jenjang = $request->jenjang;

        $query = Santri::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('nis', 'like', "%{$search}%");
            });
        }

        if ($jenjang) {
            $query->where('jenjang', $jenjang);
        }

        $santri = $query->orderBy('nama')->paginate(15)->withQueryString();

        return view('santri.index', compact('santri', 'search', 'jenjang'));
    }

    public function create(): View
    {
        return view('santri.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'nis' => 'required|unique:santri,nis|unique:users,nis',
            'nama' => 'required|string|max:255',
            'alamat' => 'nullable|string|max:255',
            'no_hp' => 'nullable|string|max:20',
            'tanggal_lahir' => 'nullable|date',
            'nama_orang_tua' => 'nullable|string|max:255',
            'jenjang' => 'required|in:Safinatunnajah,Muqodimah',
            'kelas' => 'nullable|string|max:50',
        ], [
            'nis.required' => 'NIS wajib diisi',
            'nis.unique' => 'NIS sudah terdaftar',
            'nama.required' => 'Nama wajib diisi',
            'jenjang.required' => 'Jenjang wajib dipilih',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $santri = Santri::create($request->all());

        // Create associated user for santri with default password = nis and must change password on first login
        User::create([
            'name' => $santri->nama,
            'email' => null, // nullable, we login with nis
            'password' => Hash::make($santri->nis),
            'role' => 'santri',
            'santri_id' => $santri->id,
            'nis' => $santri->nis,
            'must_change_password' => true,
        ]);

        return redirect()->route('santri.index')->with('success', 'Data Santri berhasil ditambahkan');
    }

    public function show(Santri $santri): View
    {
        $absensi = $santri->absensi()->with('jamPelajaran')->orderByDesc('tanggal')->paginate(30);
         
        return view('santri.show', compact('santri', 'absensi'));
    }

    public function edit(Santri $santri): View
    {
        return view('santri.edit', compact('santri'));
    }

    public function update(Request $request, Santri $santri): RedirectResponse
    {
        $userRule = 'required|unique:santri,nis,' . $santri->id;
        if ($santri->user) {
            $userRule .= '|unique:users,nis,' . $santri->user->id;
        }
        
        $validator = Validator::make($request->all(), [
            'nis' => $userRule,
            'nama' => 'required|string|max:255',
            'alamat' => 'nullable|string|max:255',
            'no_hp' => 'nullable|string|max:20',
            'tanggal_lahir' => 'nullable|date',
            'nama_orang_tua' => 'nullable|string|max:255',
            'jenjang' => 'required|in:Safinatunnajah,Muqodimah',
            'kelas' => 'nullable|string|max:50',
        ], [
            'nis.required' => 'NIS wajib diisi',
            'nis.unique' => 'NIS sudah terdaftar',
            'nama.required' => 'Nama wajib diisi',
            'jenjang.required' => 'Jenjang wajib dipilih',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $santri->update($request->all());

        // Update or create associated user if nis or name changed
        $user = $santri->user;
        if ($user) {
            // Update existing user
            $user->name = $santri->nama;
            $user->nis = $santri->nis;
            // Note: we do not update password here because if they changed it, we don't want to reset
            // If they haven't changed password and nis changed, then password should be updated to new nis hash?
            // But for simplicity, we leave password as is. If they want to sync, they can change password.
            $user->save();
        } else {
            // Create user if it doesn't exist (should not happen in normal flow, but handle just in case)
            User::create([
                'name' => $santri->nama,
                'email' => null, // nullable, we login with nis
                'password' => Hash::make($santri->nis),
                'role' => 'santri',
                'santri_id' => $santri->id,
                'nis' => $santri->nis,
                'must_change_password' => true,
            ]);
        }

        return redirect()->route('santri.index')->with('success', 'Data Santri berhasil diperbarui');
    }

    public function destroy(Santri $santri): RedirectResponse
    {
        if ($santri->user) {
            $santri->user->delete();
        }
        $santri->delete();

        return redirect()->route('santri.index')->with('success', 'Data Santri berhasil dihapus');
    }

    public function resetPassword(Santri $santri): RedirectResponse
    {
        $user = $santri->user;

        if (!$user) {
            return back()->with('error', 'Akun santri tidak ditemukan.');
        }

        $user->password = Hash::make($santri->nis);
        $user->save();

        return back()->with('success', 'Password berhasil direset ke NIS.');
    }
}