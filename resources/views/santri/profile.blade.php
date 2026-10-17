@extends('layouts.app')

@section('title', 'Profil Saya')

@push('styles')
<style>
.profile-header {
    display: flex;
    align-items: center;
    gap: 1.5rem;
    padding: 1.5rem 0;
    border-bottom: 1px solid #e2e8f0;
    margin-bottom: 1.5rem;
}

.profile-avatar {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, #0d9488, #0f766e);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 2rem;
    font-weight: 700;
    flex-shrink: 0;
}

.form-input {
    width: 100%;
    padding: 0.75rem 1rem;
    border: 1px solid #e2e8f0;
    border-radius: 10px;
    font-size: 0.95rem;
    transition: all 0.2s;
}

.form-input:focus {
    outline: none;
    border-color: #0d9488;
    box-shadow: 0 0 0 3px rgba(13, 148, 136, 0.1);
}

.form-group {
    margin-bottom: 1rem;
}

.form-label {
    display: block;
    font-size: 0.85rem;
    font-weight: 500;
    color: #334155;
    margin-bottom: 0.5rem;
}

.profile-info h4 {
    font-size: 1.25rem;
    font-weight: 700;
    color: #1e293b;
    margin: 0 0 0.25rem 0;
}

.profile-info .profile-nis {
    font-size: 0.9rem;
    color: #64748b;
    margin: 0;
}

.profile-section {
    margin-bottom: 1.5rem;
}

.profile-section h5 {
    font-size: 0.9rem;
    font-weight: 600;
    color: #334155;
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.profile-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1rem;
}

.profile-item {
    padding: 0.75rem 0;
    border-bottom: 1px solid #f1f5f9;
}

.profile-item:last-child {
    border-bottom: none;
}

.profile-item .label {
    font-size: 0.75rem;
    color: #64748b;
    margin-bottom: 0.25rem;
}

.profile-item .value {
    font-size: 0.95rem;
    font-weight: 500;
    color: #1e293b;
}

.badge-status {
    display: inline-flex;
    align-items: center;
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 500;
}

.badge-status.aktif { background: #d1fae5; color: #065f46; }
.badge-status.nonaktif { background: #fee2e2; color: #991b1b; }
</style>
@endpush

@section('content')
    <div class="section-card">
        <!-- Profile Header -->
        <div class="profile-header">
            <div class="profile-avatar">
                {{ substr(auth()->user()->name, 0, 1) }}
            </div>
            <div class="profile-info">
                <h4>{{ auth()->user()->name }}</h4>
                <p class="profile-nis">
                    <i class="fas fa-id-badge"></i> NIS: {{ auth()->user()->santri->nis ?? '-' }}
                </p>
            </div>
        </div>

        <!-- Informasi Pribadi -->
        <div class="profile-section">
            <h5><i class="fas fa-user"></i> Informasi Pribadi</h5>
            <div class="profile-grid">
                <div>
                    <div class="profile-item">
                        <div class="label">Nama Lengkap</div>
                        <div class="value">{{ auth()->user()->name }}</div>
                    </div>
                </div>
                <div>
                    <div class="profile-item">
                        <div class="label">NIS</div>
                        <div class="value">{{ auth()->user()->santri->nis ?? '-' }}</div>
                    </div>
                </div>
                <div>
                    <div class="profile-item">
                        <div class="label">Kelas</div>
                        <div class="value">{{ auth()->user()->santri->kelas ?? '-' }}</div>
                    </div>
                </div>
                <div>
                    <div class="profile-item">
                        <div class="label">Jenjang/Khalaqoh</div>
                        <div class="value">{{ auth()->user()->santri->jenjang ?? '-' }}</div>
                    </div>
                </div>
                <div>
                    <div class="profile-item">
                        <div class="label">Status</div>
                        <div class="value">
                            @if(auth()->user()->santri && auth()->user()->santri->status)
                                <span class="badge-status aktif"><i class="fas fa-check-circle"></i> Aktif</span>
                            @else
                                <span class="badge-status nonaktif"><i class="fas fa-times-circle"></i> Nonaktif</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kontak -->
        @if(auth()->user()->santri && auth()->user()->santri->no_hp)
        <div class="profile-section">
            <h5><i class="fas fa-phone"></i> Kontak</h5>
            <div class="profile-grid">
                <div>
                    <div class="profile-item">
                        <div class="label">No. HP</div>
                        <div class="value">{{ auth()->user()->santri->no_hp ?? '-' }}</div>
                    </div>
                </div>
                <div>
                    <div class="profile-item">
                        <div class="label">Alamat</div>
                        <div class="value">{{ auth()->user()->santri->alamat ?? '-' }}</div>
                    </div>
                </div>
                <div>
                    <div class="profile-item">
                        <div class="label">Nama Orang Tua</div>
                        <div class="value">{{ auth()->user()->santri->nama_orang_tua ?? '-' }}</div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Change Password Card -->
    <div class="section-card" style="margin-top: 1.5rem;">
        <h5><i class="fas fa-lock"></i> Ganti Password</h5>
        
        @if(session('status'))
            <div class="alert alert-success" style="margin-bottom: 1rem;">
                <i class="fas fa-check-circle"></i> {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('santri.password.update') }}">
            @csrf
            @method('PATCH')

            <div class="row g-3">
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="form-label" for="current_password">Password Saat Ini</label>
                        <input type="password" name="current_password" id="current_password" class="form-input" required placeholder="Masukkan password saat ini">
                        @error('current_password')
                            <div style="font-size:0.8rem; color:#ef4444; margin-top:0.25rem;">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="form-label" for="password">Password Baru</label>
                        <input type="password" name="password" id="password" class="form-input" required placeholder="Masukkan password baru">
                        @error('password')
                            <div style="font-size:0.8rem; color:#ef4444; margin-top:0.25rem;">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="form-label" for="password_confirmation">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-input" required placeholder="Ulangi password baru">
                    </div>
                </div>
            </div>

            <div class="d-flex gap-2 justify-content-end" style="margin-top: 1rem;">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan Password
                </button>
            </div>
        </form>
    </div>
@endsection