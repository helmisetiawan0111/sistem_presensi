@extends('layouts.app')

@section('title', 'Pengaturan')

@section('content')
@if (session('status') === 'profile-updated')
    <div class="alert alert-success" style="margin-bottom: 20px;">
        <i class="fas fa-check-circle"></i> Profil berhasil diperbarui.
    </div>
@endif

@if (session('status') === 'password-updated')
    <div class="alert alert-success" style="margin-bottom: 20px;">
        <i class="fas fa-check-circle"></i> Kata sandi berhasil diubah.
    </div>
@endif

@if($user->isSantri() && $user->must_change_password)
<div class="alert alert-danger" style="margin-bottom: 20px;">
    <i class="fas fa-exclamation-triangle"></i>
    Anda disarankan mengganti kata sandi sebelum melanjutkan.
    <a href="{{ $user->isAdmin() ? route('password.update') : route('santri.password.update') }}" style="font-weight: 600;">Ganti sekarang</a>.
</div>
@endif

<!-- ==================== INFORMASI AKUN ==================== -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Informasi Akun</h3>
    </div>

    <!-- Username & NIS (read-only) -->
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 24px;">
        <div>
            <label class="form-label">Username</label>
            <div class="form-input" style="background: var(--light); color: var(--secondary);">{{ $user->username ?? '-' }}</div>
        </div>
        @if($user->nis)
        <div>
            <label class="form-label">NIS</label>
            <div class="form-input" style="background: var(--light); color: var(--secondary);">{{ $user->nis }}</div>
        </div>
        @endif
    </div>

    <!-- Form Nama -->
    <form method="post" action="{{ route('profile.update') }}">
        @csrf
        @method('patch')

        <div class="form-group">
            <label class="form-label" for="name">Nama Lengkap</label>
            <input type="text" id="name" name="name" class="form-input" value="{{ old('name', $user->name) }}" required autofocus>
            @error('name')
                <div class="alert alert-danger" style="margin-top:8px; padding:10px;">{{ $message }}</div>
            @enderror
        </div>

        @if($user->isAdmin())
        <div class="form-group">
            <label class="form-label" for="email">Email (untuk pemulihan akun)</label>
            <input type="email" id="email" name="email" class="form-input" value="{{ old('email', $user->email) }}" placeholder="email@domain.com">
            @error('email')
                <div class="alert alert-danger" style="margin-top:8px; padding:10px;">{{ $message }}</div>
            @enderror
            <small style="color: var(--gray); font-size: 12px;">Email ini akan digunakan jika Anda lupa kata sandi.</small>
        </div>
        @endif

            <div style="margin-top: 24px; display: flex; gap: 12px;">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i>
                    Simpan Perubahan
                </button>

                @auth
                    @if (auth()->user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
                    @elseif (auth()->user()->role === 'petugas')
                        <a href="{{ route('petugas.presensi.index') }}" class="btn btn-secondary">
                    @elseif (auth()->user()->role === 'santri')
                        <a href="{{ route('santri.dashboard') }}" class="btn btn-secondary">
                    @endif
                        <i class="fas fa-times"></i>
                        Batal
                    </a>
                @endauth
            </div>
    </form>
</div>

<!-- ==================== DATA SANTRI ==================== -->
@if($user->isSantri() && $user->santo)
<div class="card" style="margin-top: 24px;">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-user-graduate" style="color: var(--primary); margin-right: 8px;"></i>Data Santri
        </h3>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
        <div>
            <label class="form-label">Kelas</label>
            <div class="form-input" style="background: var(--light);">{{ $user->santo->kelas_name ?? '-' }}</div>
        </div>
        <div>
            <label class="form-label">Jenjang</label>
            <div class="form-input" style="background: var(--light);">{{ ucfirst($user->santo->jenjang) }}</div>
        </div>
        <div>
            <label class="form-label">Nama Orang Tua</label>
            <div class="form-input" style="background: var(--light);">{{ $user->santo->nama_orang_tua }}</div>
        </div>
        <div>
            <label class="form-label">Nomor HP</label>
            <div class="form-input" style="background: var(--light);">{{ $user->santo->no_hp ?? '-' }}</div>
        </div>
        <div>
            <label class="form-label">Alamat</label>
            <div class="form-input" style="background: var(--light);">{{ $user->santo->alamat ?? '-' }}</div>
        </div>
        <div>
            <label class="form-label">Tanggal Lahir</label>
            <div class="form-input" style="background: var(--light);">{{ $user->santo->tanggal_lahir?->format('d M Y') ?? '-' }}</div>
        </div>
        <div>
            <label class="form-label">Status</label>
            <div class="form-input" style="background: var(--light);">
                @if($user->santo->status)
                    <span class="badge badge-success">Aktif</span>
                @else
                    <span class="badge badge-danger">Tidak Aktif</span>
                @endif
            </div>
        </div>
        <div>
            <label class="form-label">Persentase Kehadiran</label>
            <div class="form-input" style="background: var(--light); font-weight: 600; color: var(--primary);">{{ $user->santo->persentase_kehadiran ?? 0 }}%</div>
        </div>
    </div>

    <div style="margin-top: 16px; display: flex; gap: 12px; flex-wrap: wrap;">
        <div class="stat-card" style="padding: 12px 20px; background: #d1fae5; border-radius: 10px;">
            <span style="font-size: 13px; color: #065f46; font-weight: 600;">Hadir: {{ $user->santo->total_hadir }}x</span>
        </div>
        <div class="stat-card" style="padding: 12px 20px; background: #fef3c7; border-radius: 10px;">
            <span style="font-size: 13px; color: #92400e; font-weight: 600;">Izin: {{ $user->santo->total_izin }}x</span>
        </div>
        <div class="stat-card" style="padding: 12px 20px; background: #dbeafe; border-radius: 10px;">
            <span style="font-size: 13px; color: #1e40af; font-weight: 600;">Sakit: {{ $user->santo->total_sakit }}x</span>
        </div>
        <div class="stat-card" style="padding: 12px 20px; background: #fee2e2; border-radius: 10px;">
            <span style="font-size: 13px; color: #991b1b; font-weight: 600;">Alpha: {{ $user->santo->total_alpha }}x</span>
        </div>
        <div class="stat-card" style="padding: 12px 20px; background: var(--light); border-radius: 10px; border: 1px solid var(--border);">
            <span style="font-size: 13px; color: var(--dark); font-weight: 600;">Total: {{ $user->santo->total_pertemuan }}x</span>
        </div>
    </div>
</div>
@endif

<!-- ==================== UBAH KATA SANDI ==================== -->
@auth
<div class="card" style="margin-top: 24px;">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-lock" style="color: var(--warning); margin-right: 8px;"></i>Ubah Kata Sandi
        </h3>
    </div>

    @if($user->must_change_password && $user->isAdmin())
    <p style="margin-bottom:12px; font-size:12px; color:var(--warning);">
        <i class="fas fa-info-circle"></i> Harap isi password baru setelah melakukan reset.
    </p>
    @endif

    <form method="post" action="{{ route('password.update') }}">
        @csrf
        @method('put')

        @if(!($user->must_change_password && $user->isAdmin()))
        <div class="form-group">
            <label class="form-label" for="current_password">Kata Sandi Saat Ini</label>
            <input type="password" id="current_password" name="current_password" class="form-input" required autocomplete="current-password">
            @error('current_password', 'updatePassword')
                <div class="alert alert-danger" style="margin-top:8px; padding:10px;">{{ $message }}</div>
            @enderror
        </div>
        @endif

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
            <div class="form-group">
                <label class="form-label" for="password">Kata Sandi Baru</label>
                <input type="password" id="password" name="password" class="form-input" required autocomplete="new-password">
            </div>
            <div class="form-group">
                <label class="form-label" for="password_confirmation">Konfirmasi Kata Sandi</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="form-input" required autocomplete="new-password">
            </div>
        </div>

            <button type="submit" class="btn btn-primary" style="margin-top: 8px;">
                <i class="fas fa-lock"></i>
                Simpan Kata Sandi
            </button>
    </form>
</div>
@endauth

@endsection
