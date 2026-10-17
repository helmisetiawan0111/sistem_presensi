@extends('layouts.app')

@section('title', 'Data Santri')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Data Santri</h3>
        <a href="{{ route('santri.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i>
            Tambah Santri
        </a>
    </div>
    
    <form action="{{ route('santri.index') }}" method="GET" style="display: flex; gap: 12px; margin-bottom: 20px; flex-wrap: wrap;">
        <input type="text" name="search" placeholder="Cari nama atau NIS..." class="form-input" style="max-width: 280px;" value="{{ $search ?? '' }}">
        
        <select name="jenjang" class="form-select" style="max-width: 180px;">
            <option value="">Semua Khalaqoh</option>
            <option value="Safinatunnajah" {{ ($jenjang ?? '') === 'Safinatunnajah' ? 'selected' : '' }}>Safinatunnajah</option>
            <option value="Muqodimah" {{ ($jenjang ?? '') === 'Muqodimah' ? 'selected' : '' }}>Muqodimah</option>
        </select>
        
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-search"></i>
            Cari
        </button>
        
        @if($search || $jenjang)
        <a href="{{ route('santri.index') }}" class="btn btn-secondary">
            <i class="fas fa-times"></i>
            Reset
        </a>
        @endif
    </form>
    
    @if($santri->count() > 0)
    <div class="table-container">
        <table class="data-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>NIS</th>
                    <th>Nama</th>
                    <th>Jenjang</th>
                    <th>Kelas</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($santri as $index => $s)
                <tr>
                    <td>{{ $santri->firstItem() + $index }}</td>
                    <td><span class="badge badge-primary">{{ $s->nis }}</span></td>
                    <td><strong>{{ $s->nama }}</strong></td>
                    <td><span class="badge badge-info">{{ $s->jenjang }}</span></td>
                    <td>{{ $s->kelas ?? '-' }}</td>
                    <td>
                        @if($s->status)
                        <span class="badge badge-success">Aktif</span>
                        @else
                        <span class="badge badge-danger">Nonaktif</span>
                        @endif
                    </td>
                    <td>
                        <div style="display: flex; gap: 8px;">
                            <a href="{{ route('santri.show', $s->id) }}" class="btn btn-sm btn-secondary" title="Lihat">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('santri.edit', $s->id) }}" class="btn btn-sm btn-secondary" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('santri.destroy', $s->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" title="Hapus" onclick="event.preventDefault(); Swal.fire({ title: 'Hapus data?', text: 'Yakin hapus data ini?', icon: 'warning', showCancelButton: true, confirmButtonColor: '#ef4444', cancelButtonColor: '#6c757d', confirmButtonText: 'Ya, hapus!', cancelButtonText: 'Batal' }).then((result) => { if (result.isConfirmed) { this.closest('form').submit(); } });">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px;">
        <div style="color: var(--secondary); font-size: 13px;">
            Menampilkan {{ $santri->firstItem() ?? 0 }} - {{ $santri->lastItem() ?? 0 }} dari {{ $santri->total() }} data
        </div>
        <div class="pagination" style="display: flex; gap: 4px; align-items: center; flex-wrap: wrap;">
            <button type="button" class="btn btn-sm btn-secondary" 
                    style="cursor: pointer; opacity: {{ $santri->onFirstPage() ? '0.4' : '1' }}; pointer-events: {{ $santri->onFirstPage() ? 'none' : 'auto' }};"
                    onclick="changePage({{ $santri->currentPage() - 1 }})">
                <i class="fas fa-chevron-left"></i> Sebelumnya
            </button>

            @for ($i = 1; $i <= $santri->lastPage(); $i++)
                <a href="javascript:void(0)" 
                   onclick="changePage({{ $i }})"
                   style="display: flex; align-items: center; justify-content: center; width: 36px; height: 36px; border-radius: 10px; font-size: 13px; font-weight: 600; text-decoration: none; border: 1px solid var(--border); color: var(--dark); background: var(--white); transition: all 0.2s; cursor: pointer; {{ $i === $santri->currentPage() ? 'background: var(--primary); color: white; border-color: var(--primary);' : '' }} {{ $i !== $santri->currentPage() ? 'cursor: pointer;' : '' }}"
                >{{ $i }}</a>
            @endfor

            <button type="button" class="btn btn-sm btn-secondary" 
                    style="cursor: pointer; opacity: {{ $santri->hasMorePages() ? '1' : '0.4' }}; pointer-events: {{ $santri->hasMorePages() ? 'auto' : 'none' }};"
                    onclick="changePage({{ $santri->currentPage() + 1 }})">
                Berikutnya <i class="fas fa-chevron-right"></i>
            </button>
        </div>
    </div>

    <form id="paginationForm" action="{{ route('santri.index') }}" method="GET">
        <input type="hidden" name="page" id="pageInput">
        <input type="hidden" name="search" value="{{ $search ?? '' }}">
        <input type="hidden" name="jenjang" value="{{ $jenjang ?? '' }}">
    </form>

    <script>
        function changePage(page) {
            document.getElementById('pageInput').value = page;
            document.getElementById('paginationForm').submit();
        }
    </script>
    @else
    <div class="empty-state">
        <i class="fas fa-users"></i>
        <h3>Belum Ada Data Santri</h3>
        <p>Silakan tambah data santri terlebih dahulu</p>
        <a href="{{ route('santri.create') }}" class="btn btn-primary" style="margin-top: 16px;">
            <i class="fas fa-plus"></i>
            Tambah Santri
        </a>
    </div>
    @endif
</div>
@endsection