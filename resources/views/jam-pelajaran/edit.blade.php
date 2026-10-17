@extends('layouts.app')

@section('title', 'Edit Jam Pelajaran')

@section('content')
<div class="card" style="max-width: 600px; margin: 0 auto;">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-edit"></i> Edit Jam Pelajaran
        </h3>
        <a href="{{ route('jam-pelajaran.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div style="padding: 24px;">
        <form action="{{ route('jam-pelajaran.update', $jamPelajaran->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group" style="margin-bottom: 20px;">
                <label class="form-label">Nama Mata Pelajaran</label>
                <input type="text" name="nama" class="form-input" required value="{{ old('nama', $jamPelajaran->nama) }}" placeholder="Contoh: Fiqh, Tafsir, etc.">
            </div>

            <div class="form-group" style="margin-bottom: 20px;">
                <label class="form-label">Ustadz</label>
                <input type="text" name="ustadz" class="form-input" required value="{{ old('ustadz', $jamPelajaran->ustadz) }}" placeholder="Nama ustadz yang mengajar">
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 20px;">
                <div class="form-group" style="margin-bottom: 0;">
                    <label class="form-label">Jam Mulai</label>
                    <input type="time" name="jam_mulai" class="form-input" required value="{{ old('jam_mulai', $jamPelajaran->jam_mulai instanceof \Carbon\Carbon ? $jamPelajaran->jam_mulai->format('H:i') : \Carbon\Carbon::parse($jamPelajaran->jam_mulai)->format('H:i')) }}">
                </div>
                <div class="form-group" style="margin-bottom: 0;">
                    <label class="form-label">Jam Selesai</label>
                    <input type="time" name="jam_selesai" class="form-input" required value="{{ old('jam_selesai', $jamPelajaran->jam_selesai instanceof \Carbon\Carbon ? $jamPelajaran->jam_selesai->format('H:i') : \Carbon\Carbon::parse($jamPelajaran->jam_selesai)->format('H:i')) }}">
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 16px; margin-bottom: 20px;">
                <div class="form-group" style="margin-bottom: 0;">
                    <label class="form-label">Hari</label>
                    <select name="hari" class="form-select" required>
                        @foreach(['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'] as $h)
                            <option value="{{ $h }}" {{ (old('hari', $jamPelajaran->hari) == $h) ? 'selected' : '' }}>{{ $h }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group" style="margin-bottom: 0;">
                    <label class="form-label">Urutan</label>
                    <input type="number" name="urutan" class="form-input" required min="1" value="{{ old('urutan', $jamPelajaran->urutan) }}">
                </div>
                <div class="form-group" style="margin-bottom: 0;">
                    <label class="form-label">Kelas (Jenjang)</label>
                    <select name="kelas" class="form-select" required>
                        <option value="Safinatunnajah" {{ old('kelas', $jamPelajaran->kelas) == 'Safinatunnajah' ? 'selected' : '' }}>Safinatunnajah</option>
                        <option value="Muqodimah" {{ old('kelas', $jamPelajaran->kelas) == 'Muqodimah' ? 'selected' : '' }}>Muqodimah</option>
                    </select>
                </div>
            </div>

            <div class="form-group" style="margin-bottom: 24px;">
                <label class="form-label" style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                    <input type="checkbox" name="status" value="1" {{ old('status', $jamPelajaran->status) ? 'checked' : '' }} style="width: 18px; height: 18px;">
                    <span>Aktif</span>
                </label>
            </div>

            <div style="display: flex; gap: 12px; justify-content: flex-end;">
                <a href="{{ route('jam-pelajaran.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Update
                </button>
            </div>
        </form>
    </div>
</div>
@endsection