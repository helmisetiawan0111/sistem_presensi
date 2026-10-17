@extends('layouts.app')

@section('title', 'Tambah Santri')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Tambah Data Santri</h3>
    </div>
    
    <form action="{{ route('santri.store') }}" method="POST">
        @csrf
        
        <div class="form-group">
            <label class="form-label">NIS *</label>
            <input type="text" name="nis" class="form-input" required value="{{ old('nis') }}">
            @error('nis')
            <p style="color: var(--danger); font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="form-group">
            <label class="form-label">Nama *</label>
            <input type="text" name="nama" class="form-input" required value="{{ old('nama') }}">
            @error('nama')
            <p style="color: var(--danger); font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="form-group">
            <label class="form-label">Alamat</label>
            <textarea name="alamat" class="form-input">{{ old('alamat') }}</textarea>
        </div>
        
        <div class="form-group">
            <label class="form-label">No. HP</label>
            <input type="text" name="no_hp" class="form-input" value="{{ old('no_hp') }}">
        </div>
        
        <div class="form-group">
            <label class="form-label">Tanggal Lahir</label>
            <input type="date" name="tanggal_lahir" class="form-input" value="{{ old('tanggal_lahir') }}">
        </div>
        
        <div class="form-group">
            <label class="form-label">Nama Orang Tua</label>
            <input type="text" name="nama_orang_tua" class="form-input" value="{{ old('nama_orang_tua') }}">
        </div>
        
        <div class="form-group">
            <label class="form-label">Khalaqoh *</label>
            <select name="jenjang" class="form-select" required>
                <option value="">Pilih Khalaqoh</option>
                <option value="Safinatunnajah" {{ old('jenjang') === 'Safinatunnajah' ? 'selected' : '' }}>Safinatunnajah</option>
                <option value="Muqodimah" {{ old('jenjang') === 'Muqodimah' ? 'selected' : '' }}>Muqodimah</option>
            </select>
            @error('jenjang')
            <p style="color: var(--danger); font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="form-group">
            <label class="form-label">Kelas</label>
            <select name="kelas" class="form-select">
                <option value="">Pilih Kelas</option>
                <option value="Kelas 1" {{ old('kelas') === 'Kelas 1' ? 'selected' : '' }}>Kelas 1</option>
                <option value="Kelas 2" {{ old('kelas') === 'Kelas 2' ? 'selected' : '' }}>Kelas 2</option>
            </select>
        </div>
        
        <div style="display: flex; gap: 1rem;">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('santri.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection