@extends('layouts.app')

@section('title', 'Ranking Kehadiran')

@section('content')
<div class="card" style="margin-bottom: 1.5rem;">
    <form action="{{ route('rekap.ranking') }}" method="GET" style="display: flex; gap: 1rem; align-items: flex-end;">
        <div class="form-group" style="margin-bottom: 0;">
            <label class="form-label">Bulan</label>
            <select name="bulan" class="form-select">
                @foreach($bulanList as $key => $name)
                <option value="{{ $key }}" {{ $bulan == $key ? 'selected' : '' }}>{{ $name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group" style="margin-bottom: 0;">
            <label class="form-label">Tahun</label>
            <select name="tahun" class="form-select">
                @foreach($tahunList as $t)
                <option value="{{ $t }}" {{ $tahun == $t ? 'selected' : '' }}>{{ $t }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Filter</button>
    </form>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Ranking Kehadiran Santri</h3>
    </div>
    
    @if(count($data) > 0)
    <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th>Rank</th>
                    <th>Nama</th>
                    <th>Hadir</th>
                    <th>Izin</th>
                    <th>Sakit</th>
                    <th>Alpha</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $d)
                <tr>
                    <td>
                        @if($d['rank'] == 1)
                        <span class="badge" style="background: gold; color: black;">🥇 1</span>
                        @elseif($d['rank'] == 2)
                        <span class="badge" style="background: silver; color: black;">🥈 2</span>
                        @elseif($d['rank'] == 3)
                        <span class="badge" style="background: #cd7f32; color: white;">🥉 3</span>
                        @else
                        {{ $d['rank'] }}
                        @endif
                    </td>
                    <td>{{ $d['santri']->nama }}</td>
                    <td><span class="badge badge-success">{{ $d['hadir'] }}</span></td>
                    <td><span class="badge badge-warning">{{ $d['izin'] }}</span></td>
                    <td><span class="badge badge-info">{{ $d['sakit'] }}</span></td>
                    <td><span class="badge badge-danger">{{ $d['alpha'] }}</span></td>
                    <td>{{ $d['total'] }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <div class="empty-state">
        <p>Tidak ada data absensi</p>
    </div>
    @endif
</div>
@endsection