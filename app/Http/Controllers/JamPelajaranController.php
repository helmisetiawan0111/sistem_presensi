<?php

namespace App\Http\Controllers;

use App\Models\JamPelajaran;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class JamPelajaranController extends Controller
{
    public function index(): View
    {
        $jamPelajaran = JamPelajaran::orderBy('hari')->orderBy('urutan')->get();
        
        return view('jam-pelajaran.index', compact('jamPelajaran'));
    }

    public function create(): View
    {
        return view('jam-pelajaran.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'ustadz' => 'required|string|max:255',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
            'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
            'urutan' => [
                'required',
                'integer',
                'min:1',
                Rule::unique('jam_pelajaran')->where(function ($query) use ($request) {
                    return $query->where('hari', $request->hari)
                                 ->where('kelas', $request->kelas);
                })
            ],
            'kelas' => 'required|in:Safinatunnajah,Muqodimah',
        ], [
            'nama.required' => 'Nama jam pelajaran wajib diisi',
            'ustadz.required' => 'Nama ustadz wajib diisi',
            'jam_mulai.required' => 'Jam mulai wajib diisi',
            'jam_selesai.required' => 'Jam selesai wajib diisi',
            'jam_selesai.after' => 'Jam selesai harus setelah jam mulai',
            'hari.required' => 'Hari wajib dipilih',
            'urutan.required' => 'Urutan wajib diisi',
            'urutan.unique' => 'Urutan untuk hari dan kelas ini sudah digunakan',
            'kelas.required' => 'Kelas (Jenjang) wajib dipilih',
            'kelas.in' => 'Kelas tidak valid',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        JamPelajaran::create($request->all());

        return redirect()->route('jam-pelajaran.index')->with('success', 'Jadwal berhasil ditambahkan');
    }

    public function edit(JamPelajaran $jamPelajaran): View
    {
        return view('jam-pelajaran.edit', compact('jamPelajaran'));
    }

    public function update(Request $request, JamPelajaran $jamPelajaran): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'ustadz' => 'required|string|max:255',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
            'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
            'urutan' => [
                'required',
                'integer',
                'min:1',
                Rule::unique('jam_pelajaran')->where(function ($query) use ($request) {
                    return $query->where('hari', $request->hari)
                                 ->where('kelas', $request->kelas);
                })->ignore($jamPelajaran->id)
            ],
            'kelas' => 'required|in:Safinatunnajah,Muqodimah',
        ], [
            'nama.required' => 'Nama jam pelajaran wajib diisi',
            'ustadz.required' => 'Nama ustadz wajib diisi',
            'jam_mulai.required' => 'Jam mulai wajib diisi',
            'jam_selesai.required' => 'Jam selesai wajib diisi',
            'jam_selesai.after' => 'Jam selesai harus setelah jam mulai',
            'hari.required' => 'Hari wajib dipilih',
            'urutan.required' => 'Urutan wajib diisi',
            'urutan.unique' => 'Urutan untuk hari dan kelas ini sudah digunakan',
            'kelas.required' => 'Kelas (Jenjang) wajib dipilih',
            'kelas.in' => 'Kelas tidak valid',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $jamPelajaran->update($request->all());

        return redirect()->route('jam-pelajaran.index')->with('success', 'Jadwal berhasil diperbarui');
    }

    public function destroy(JamPelajaran $jamPelajaran): RedirectResponse
    {
        $jamPelajaran->delete();

        return redirect()->route('jam-pelajaran.index')->with('success', 'Jam pelajaran berhasil dihapus');
    }
}