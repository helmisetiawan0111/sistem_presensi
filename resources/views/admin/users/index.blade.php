@extends('layouts.app')

@section('title', 'Kelola Pengguna')

@section('content')
<div class="section-card">
    <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1.25rem;">
        <i class="fas fa-users-cog" style="color: var(--primary); font-size: 1.1rem;"></i>
        <h5 style="margin: 0; font-weight: 600;">Kelola Pengguna</h5>
    </div>

    <div class="row g-3 mb-3 align-items-center">
        <div class="col-md-12">
            <form method="GET" action="{{ route('users.index') }}" class="d-flex gap-2">
                <input type="text" name="search" class="form-input" placeholder="Cari nama, NIS, username..." value="{{ request('search') }}" style="max-width: 320px; flex: 0 0 auto;">
                <input type="hidden" name="role" value="{{ request('role') }}">
                <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
            </form>
        </div>
        <div class="col-md-12">
            <select name="role" class="form-select" onchange="syncFilter(this.value)" style="max-width: 320px;">
                <option value="">Semua Role</option>
                <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="petugas" {{ request('role') == 'petugas' ? 'selected' : '' }}>Petugas</option>
                <option value="santri" {{ request('role') == 'santri' ? 'selected' : '' }}>Santri</option>
            </select>
        </div>
    </div>

    @push('scripts')
    <script>
    function syncFilter(role) {
        const params = new URLSearchParams(window.location.search);
        if (role) params.set('role', role); else params.delete('role');
        window.location.search = params.toString();
    }
    </script>
    @endpush

    @if(session('success'))
        <div class="alert alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger"><i class="fas fa-exclamation-circle"></i> {{ session('error') }}</div>
    @endif

    <div class="table-responsive">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Username / NIS</th>
                    <th>Role</th>
                    <th>Santri Terhubung</th>
                    <th style="width: 140px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                @php
                    $displayIdentifier = $user->nis ?? $user->username;
                    if (!$displayIdentifier || trim($displayIdentifier) === '') continue;
                @endphp
                <tr>
                    <td>
                        <div style="font-weight: 600;">{{ $user->name }}</div>
                        @if($user->email && $user->role === 'admin')
                        <small style="color: var(--gray);">{{ $user->email }}</small>
                        @endif
                    </td>
                    <td>{{ $displayIdentifier }}</td>
                    <td>
                        <span class="badge {{ $user->role === 'admin' ? 'badge-danger' : ($user->role === 'petugas' ? 'badge-warning' : 'badge-info') }}">
                            {{ ucfirst($user->role) }}
                        </span>
                    </td>
                    <td>
                        @if($user->santri)
                            <span style="color: #059669;"><i class="fas fa-check-circle"></i> {{ $user->santri->nama }}</span>
                        @else
                            <span style="color: var(--gray);">-</span>
                        @endif
                    </td>
                    <td>
                        @if($user->role !== 'admin')
                        <form action="{{ route('users.reset-password', $user->id) }}" method="POST" style="display:inline;" id="reset-password-form-{{ $user->id }}">
                            @csrf
                            <button type="submit" class="btn btn-warning btn-sm" onclick="event.preventDefault(); Swal.fire({ title: 'Reset password?', text: 'Reset password {{ $user->name }} ke {{ $displayIdentifier }}?', icon: 'warning', showCancelButton: true, confirmButtonColor: '#f59e0b', cancelButtonColor: '#6c757d', confirmButtonText: 'Ya, reset!', cancelButtonText: 'Batal' }).then((result) => { if (result.isConfirmed) { document.getElementById('reset-password-form-{{ $user->id }}').submit(); } });">
                                <i class="fas fa-key"></i> Reset
                            </button>
                        </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align: center; padding: 2rem; color: var(--gray);">
                        <i class="fas fa-users" style="font-size: 2rem; display: block; margin-bottom: 0.5rem; opacity: 0.5;"></i>
                        Tidak ada data pengguna.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($users->hasPages())
    <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px; margin-top: 20px;">
        <div style="color: var(--secondary); font-size: 13px;">
            Menampilkan {{ $users->firstItem() ?? 0 }} - {{ $users->lastItem() ?? 0 }} dari {{ $users->total() }} data
        </div>
        <div class="pagination" style="display: flex; gap: 4px; align-items: center; flex-wrap: wrap;">
            <button type="button" class="btn btn-sm btn-secondary" 
                    style="cursor: pointer; opacity: {{ $users->onFirstPage() ? '0.4' : '1' }}; pointer-events: {{ $users->onFirstPage() ? 'none' : 'auto' }};"
                    onclick="changeUserPage({{ $users->currentPage() - 1 }})">
                <i class="fas fa-chevron-left"></i> Sebelumnya
            </button>

            @for ($i = 1; $i <= $users->lastPage(); $i++)
                <a href="javascript:void(0)" 
                   onclick="changeUserPage({{ $i }})"
                   style="display: flex; align-items: center; justify-content: center; width: 36px; height: 36px; border-radius: 10px; font-size: 13px; font-weight: 600; text-decoration: none; border: 1px solid var(--border); color: var(--dark); background: var(--white); transition: all 0.2s; cursor: pointer; {{ $i === $users->currentPage() ? 'background: var(--primary); color: white; border-color: var(--primary);' : '' }} {{ $i !== $users->currentPage() ? 'cursor: pointer;' : '' }}"
                >{{ $i }}</a>
            @endfor

            <button type="button" class="btn btn-sm btn-secondary" 
                    style="cursor: pointer; opacity: {{ $users->hasMorePages() ? '1' : '0.4' }}; pointer-events: {{ $users->hasMorePages() ? 'auto' : 'none' }};"
                    onclick="changeUserPage({{ $users->currentPage() + 1 }})">
                Berikutnya <i class="fas fa-chevron-right"></i>
            </button>
        </div>
    </div>

    <form id="userPaginationForm" action="{{ route('users.index') }}" method="GET">
        <input type="hidden" name="page" id="userPageInput">
        <input type="hidden" name="search" value="{{ request('search') }}">
        <input type="hidden" name="role" value="{{ request('role') }}">
    </form>

    <script>
        function changeUserPage(page) {
            document.getElementById('userPageInput').value = page;
            document.getElementById('userPaginationForm').submit();
        }
    </script>
    @endif
</div>
@endsection