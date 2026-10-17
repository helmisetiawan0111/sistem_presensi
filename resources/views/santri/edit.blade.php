@extends('layouts.app')

@section('title', 'Edit Santri')

@section('content')
@php
    $user = $santri->user;
@endphp

<!-- Tab Navigation -->
<div style="display: flex; gap: 0.5rem; margin-bottom: 1.5rem; border-bottom: 1px solid #e2e8f0; padding-bottom: 0.5rem; align-items: center; flex-wrap: wrap;">
    <span class="btn btn-primary" style="border-radius: 8px 8px 0 0; pointer-events: none;">
        <i class="fas fa-user-graduate"></i> Data Santri
    </span>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Edit Data Santri</h3>
    </div>
    
    <form action="{{ route('santri.update', $santri->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label class="form-label">NIS *</label>
            <input type="text" name="nis" class="form-input" required value="{{ $santri->nis }}">
            @error('nis')
            <p style="color: var(--danger); font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="form-group">
            <label class="form-label">Nama *</label>
            <input type="text" name="nama" class="form-input" required value="{{ $santri->nama }}">
            @error('nama')
            <p style="color: var(--danger); font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="form-group">
            <label class="form-label">Alamat</label>
            <textarea name="alamat" class="form-input">{{ $santri->alamat }}</textarea>
        </div>
        
        <div class="form-group">
            <label class="form-label">No. HP</label>
            <input type="text" name="no_hp" class="form-input" value="{{ $santri->no_hp }}">
        </div>
        
        <div class="form-group">
            <label class="form-label">Tanggal Lahir</label>
            <input type="date" name="tanggal_lahir" class="form-input" value="{{ $santri->tanggal_lahir ? \Carbon\Carbon::parse($santri->tanggal_lahir)->format('Y-m-d') : '' }}">
        </div>
        
        <div class="form-group">
            <label class="form-label">Nama Orang Tua</label>
            <input type="text" name="nama_orang_tua" class="form-input" value="{{ $santri->nama_orang_tua }}">
        </div>
        
        <div class="form-group">
            <label class="form-label">Khalaqoh *</label>
            <select name="jenjang" class="form-select" required>
                <option value="Safinatunnajah" {{ $santri->jenjang === 'Safinatunnajah' ? 'selected' : '' }}>Safinatunnajah</option>
                <option value="Muqodimah" {{ $santri->jenjang === 'Muqodimah' ? 'selected' : '' }}>Muqodimah</option>
            </select>
        </div>
        
        <div class="form-group">
            <label class="form-label">Kelas</label>
            <select name="kelas" class="form-select">
                <option value="">Pilih Kelas</option>
                <option value="Kelas 1" {{ $santri->kelas === 'Kelas 1' ? 'selected' : '' }}>Kelas 1</option>
                <option value="Kelas 2" {{ $santri->kelas === 'Kelas 2' ? 'selected' : '' }}>Kelas 2</option>
            </select>
        </div>
        
        <div class="form-group">
            <label class="form-label">Status</label>
            <select name="status" class="form-select">
                <option value="1" {{ $santri->status ? 'selected' : '' }}>Aktif</option>
                <option value="0" {{ !$santri->status ? 'selected' : '' }}>Nonaktif</option>
            </select>
        </div>
        
        <div style="display: flex; gap: 1rem;">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('santri.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>

@endsection