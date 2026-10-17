@extends('layouts.app')

@section('title', 'Tambah Jam Pelajaran')

@section('content')
<div class="card" style="max-width: 600px; margin: 0 auto;">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-plus-circle"></i> Tambah Jam Pelajaran
        </h3>
        <a href="{{ route('jam-pelajaran.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div style="padding: 24px;">
        <form action="{{ route('jam-pelajaran.store') }}" method="POST">
            @csrf

            <div class="form-group" style="margin-bottom: 20px;">
                <label class="form-label">Nama Mata Pelajaran</label>
                <input type="text" name="nama" class="form-input" required placeholder="Contoh: Fiqh, Tafsir, etc.">
            </div>

            <div class="form-group" style="margin-bottom: 20px;">
                <label class="form-label">Ustadz</label>
                <input type="text" name="ustadz" class="form-input" required placeholder="Nama ustadz yang mengajar">
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 20px;">
                <div class="form-group" style="margin-bottom: 0;">
                    <label class="form-label">Jam Mulai</label>
                    <input type="time" name="jam_mulai" class="form-input" required>
                </div>
                <div class="form-group" style="margin-bottom: 0;">
                    <label class="form-label">Jam Selesai</label>
                    <input type="time" name="jam_selesai" class="form-input" required>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 16px; margin-bottom: 20px;">
                <div class="form-group" style="margin-bottom: 0;">
                    <label class="form-label">Hari</label>
                    <select name="hari" class="form-select" required>
                        <option value="Senin">Senin</option>
                        <option value="Selasa">Selasa</option>
                        <option value="Rabu">Rabu</option>
                        <option value="Kamis">Kamis</option>
                        <option value="Jumat">Jumat</option>
                        <option value="Sabtu">Sabtu</option>
                        <option value="Minggu">Minggu</option>
                    </select>
                </div>
                <div class="form-group" style="margin-bottom: 0;">
                    <label class="form-label">Urutan</label>
                    <input type="number" name="urutan" class="form-input" required min="1" placeholder="1,2,3...">
                </div>
                <div class="form-group" style="margin-bottom: 0;">
                    <label class="form-label">Kelas (Jenjang)</label>
                    <select name="kelas" class="form-select" required>
                        <option value="Safinatunnajah">Safinatunnajah (Kelas 1)</option>
                        <option value="Muqodimah">Muqodimah (Kelas 2)</option>
                    </select>
                </div>
            </div>

            <div class="form-group" style="margin-bottom: 24px;">
                <label class="form-label" style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                    <input type="checkbox" name="status" value="1" checked style="width: 18px; height: 18px;">
                    <span>Aktif</span>
                </label>
            </div>

            <div style="display: flex; gap: 12px; justify-content: flex-end;">
                <a href="{{ route('jam-pelajaran.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection