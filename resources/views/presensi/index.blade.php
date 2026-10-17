@extends('layouts.app')

@section('title', 'Presensi')

@section('content')
<div class="card" style="margin-bottom: 1rem;">
    <div class="card-body">
        <div class="mb-3">
            <h3 class="card-title">Presensi Harian - {{ $today }}</h3>
            <p><strong>Hari:</strong> {{ $hariIni }} | <strong>Petugas:</strong> {{ Auth::user()->name }}</p>
        </div>
        <div class="mb-3">
            <label for="tanggalPresensi" class="form-label">Pilih Tanggal</label>
            <input type="date" class="form-control" id="tanggalPresensi" name="tanggal" 
                   value="{{ request('tanggal') ?? now()->toDateString() }}"
                   max="{{ now()->toDateString() }}">
        </div>
    </div>
</div>

<div class="card">
    <form action="{{ request()->segment(1) == 'petugas' ? route('petugas.presensi.store', ['tanggal' => request('tanggal') ?? now()->toDateString()]) : route('presensi.store', ['tanggal' => request('tanggal') ?? now()->toDateString()]) }}" method="POST" id="presensiForm">
        @csrf
        <input type="hidden" name="jenjang" id="jenjangInput" value="{{ $jenjangFilter ?? 'safinatunnajah' }}">
        <input type="hidden" name="action" id="actionInput" value="save">
        
        <!-- Jenjang Selection - Compact -->
        <div class="jenjang-container">
            <div onclick="selectJenjang('safinatunnajah')" id="card-safinatunnajah" 
                 class="jenjang-card {{ ($jenjangFilter ?? 'safinatunnajah') == 'safinatunnajah' ? 'active-safinatunnajah' : '' }}">
                <div class="jenjang-label safinatunnajah">SAFINATUNNAJAH</div>
                <div class="jenjang-sub">Kelas 1</div>
            </div>
            
            <div onclick="selectJenjang('muqodimah')" id="card-muqodimah" 
                 class="jenjang-card {{ $jenjangFilter == 'muqodimah' ? 'active-muqodimah' : '' }}">
                <div class="jenjang-label muqodimah">MUQODIMAH</div>
                <div class="jenjang-sub">Kelas 2</div>
            </div>
        </div>
        
        <!-- Jam Pelajaran -->
        <div class="form-group" style="margin-top: 1rem;">
            <label class="form-label">Pilih Jam Pelajaran</label>
            <select name="jam_pelajaran_id" id="jamPelajaranSelect" class="form-select">
                <option value="">-- Pilih Jam --</option>
                @if($jenjangFilter == 'safinatunnajah')
                    @foreach($jamPelajaran['safinatunnajah'] as $jam)
                        <option value="{{ $jam['id'] }}" {{ (int)$selectedJamId === (int)$jam['id'] ? 'selected' : '' }}>
                            {{ $jam['nama'] }} ({{ $jam['jam_mulai'] }} - {{ $jam['jam_selesai'] }}) - {{ $jam['ustadz'] }}
                        </option>
                    @endforeach
                @endif
                @if($jenjangFilter == 'muqodimah')
                    @foreach($jamPelajaran['muqodimah'] as $jam)
                        <option value="{{ $jam['id'] }}" {{ (int)$selectedJamId === (int)$jam['id'] ? 'selected' : '' }}>
                            {{ $jam['nama'] }} ({{ $jam['jam_mulai'] }} - {{ $jam['jam_selesai'] }}) - {{ $jam['ustadz'] }}
                        </option>
                    @endforeach
                @endif
            </select>
        </div>
        
        <!-- Quick Actions -->
        <div class="quick-actions">
            <button type="button" class="btn btn-sm btn-success" onclick="setAllStatus('hadir')">Semua Hadir</button>
            <button type="button" class="btn btn-sm btn-danger" onclick="setAllStatus('alpha')">Semua Alpha</button>
        </div>
        
        <!-- Presensi Table - Compact -->
        <div class="table-wrapper">
            <table class="presensi-table">
                <thead>
                    <tr>
                        <th class="th-name">Nama Santri</th>
                        <th class="th-jenjang">Jenjang</th>
                        <th class="th-status">Status Presensi</th>
                        <th class="th-keterangan">Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($santri as $s)
                        <tr class="presensi-row">
                            <td class="td-name">{{ $s->nama }}</td>
                            <td class="td-jenjang">
                                <span class="badge {{ $s->jenjang == 'Safinatunnajah' ? 'badge-primary' : 'badge-success' }}">{{ $s->jenjang }}</span>
                            </td>
                            <td class="td-status">
                                <div class="status-options">
                                    @php
                                        $currentStatus = $existingAbsensi[$s->id] ?? null;
                                    @endphp
                                    <label class="status-option hadir {{ $currentStatus === 'hadir' ? 'selected' : '' }}"
                                           style="background: {{ $currentStatus === 'hadir' ? '#dcfce7' : 'white' }}; border-color: {{ $currentStatus === 'hadir' ? '#166534' : '#e5e7eb' }}; color: {{ $currentStatus === 'hadir' ? '#166534' : '#4b5563' }};">
                                        <input type="radio" name="presensi[{{ $s->id }}]" value="hadir" data-santri="{{ $s->id }}" class="presensi-radio" {{ $currentStatus === 'hadir' ? 'checked' : '' }}>
                                        <span>✓ Hadir</span>
                                    </label>
                                    <label class="status-option izin {{ $currentStatus === 'izin' ? 'selected' : '' }}"
                                           style="background: {{ $currentStatus === 'izin' ? '#fef3c7' : 'white' }}; border-color: {{ $currentStatus === 'izin' ? '#92400e' : '#e5e7eb' }}; color: {{ $currentStatus === 'izin' ? '#92400e' : '#4b5563' }};">
                                        <input type="radio" name="presensi[{{ $s->id }}]" value="izin" data-santri="{{ $s->id }}" class="presensi-radio" {{ $currentStatus === 'izin' ? 'checked' : '' }}>
                                        <span>⚠ Izin</span>
                                    </label>
                                    <label class="status-option sakit {{ $currentStatus === 'sakit' ? 'selected' : '' }}"
                                           style="background: {{ $currentStatus === 'sakit' ? '#f3e8ff' : 'white' }}; border-color: {{ $currentStatus === 'sakit' ? '#5b21b6' : '#e5e7eb' }}; color: {{ $currentStatus === 'sakit' ? '#5b21b6' : '#4b5563' }};">
                                        <input type="radio" name="presensi[{{ $s->id }}]" value="sakit" data-santri="{{ $s->id }}" class="presensi-radio" {{ $currentStatus === 'sakit' ? 'checked' : '' }}>
                                        <span>⚕ Sakit</span>
                                    </label>
                                    <label class="status-option alpha {{ $currentStatus === 'alpha' ? 'selected' : '' }}"
                                           style="background: {{ $currentStatus === 'alpha' ? '#fee2e2' : 'white' }}; border-color: {{ $currentStatus === 'alpha' ? '#991b1b' : '#e5e7eb' }}; color: {{ $currentStatus === 'alpha' ? '#991b1b' : '#4b5563' }};">
                                        <input type="radio" name="presensi[{{ $s->id }}]" value="alpha" data-santri="{{ $s->id }}" class="presensi-radio" {{ $currentStatus === 'alpha' ? 'checked' : '' }}>
                                        <span>✗ Alpha</span>
                                    </label>
                                </div>
                            </td>
                            <td class="td-keterangan">
                                <input type="text" class="form-input form-input-sm" name="keterangan[{{ $s->id }}]" placeholder="Opsional" value="{{ $existingAbsensiKeterangan[$s->id] ?? '' }}" maxlength="255">
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div id="saveStatus" class="save-status"></div>
    </form>
</div>

<script>
const jamPelajaranSelect = document.getElementById('jamPelajaranSelect');
const saveStatus = document.getElementById('saveStatus');
const jenjangInput = document.getElementById('jenjangInput');

function selectJenjang(jenjang) {
    const currentUrl = new URL(window.location);
    currentUrl.searchParams.set('jenjang', jenjang);
    currentUrl.searchParams.delete('jam');
    window.location.href = currentUrl.toString();
}

// Filter table when jam pelajaran changes
jamPelajaranSelect.addEventListener('change', function() {
    if (this.value) {
        const currentUrl = new URL(window.location);
        currentUrl.searchParams.set('jam', this.value);
        window.location.href = currentUrl.toString();
    }
});

// Redirect when date changes
document.getElementById('tanggalPresensi').addEventListener('change', function() {
    if (this.value) {
        const currentUrl = new URL(window.location);
        currentUrl.searchParams.set('tanggal', this.value);
        // Reset jam and jenjang filters? We'll keep jenjang as is, but reset jam to avoid confusion
        currentUrl.searchParams.delete('jam');
        window.location.href = currentUrl.toString();
    }
});

     function showSaveStatus(message, type) {
         // Empty - tidak menampilkan pesan
     }

function autoSave(santriId, status, isDeselect = false) {
    const jamId = jamPelajaranSelect.value;
    const token = '{{ csrf_token() }}';
    const jenjang = jenjangInput.value;
    const tanggal = document.getElementById('tanggalPresensi').value;
    const action = isDeselect ? 'deselect' : 'save';
    const statusToSend = isDeselect ? status : status;
    const keteranganInput = document.querySelector('input[name="keterangan[' + santriId + ']"]');
    const keterangan = keteranganInput ? keteranganInput.value : '';
    
    var autosaveUrl = "{{ request()->segment(1) == 'petugas' ? route('petugas.presensi.autosave') : route('presensi.autosave') }}";
    var xhttp = new XMLHttpRequest();
    xhttp.open("POST", autosaveUrl, true);
    xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhttp.setRequestHeader("X-CSRF-TOKEN", token);
    xhttp.send("jam_pelajaran_id=" + jamId + "&santri_id=" + santriId + "&status=" + statusToSend + "&keterangan=" + encodeURIComponent(keterangan) + "&jenjang=" + jenjang + "&tanggal=" + tanggal + "&action=" + action + "&_token=" + token);
    
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            try {
                var data = JSON.parse(this.responseText);
                if (data.success) {
                    if (isDeselect) {
                        showSaveStatus('Presensi dihapus', 'success');
                        setTimeout(function() { saveStatus.innerHTML = ''; }, 1500);
                    } else {
                        showSaveStatus('Tersimpan otomatis', 'success');
                    }
                } else {
                    showSaveStatus('Error: ' + (data.error || 'Unknown'), 'error');
                }
            } catch (e) {
                showSaveStatus('Parse Error: ' + e.message, 'error');
            }
        } else if (this.readyState == 4) {
            showSaveStatus('HTTP Error: ' + this.status, 'error');
        }
    };
}

function setAllStatus(status) {
    const radios = document.querySelectorAll('input[name^="presensi["][value="' + status + '"]');
    radios.forEach(radio => {
        radio.checked = true;
        radio.classList.add('was-selected');
        var santriId = radio.getAttribute('data-santri');
        autoSave(santriId, status, false);
    });
    showSaveStatus('Tersimpan otomatis', 'success');
    setTimeout(function() {
        saveStatus.innerHTML = '';
    }, 2000);
}

document.querySelectorAll('.presensi-radio').forEach(radio => {
    radio.addEventListener('change', function() {
        if (this.checked) {
            var santriId = this.getAttribute('data-santri');
            var status = this.value;
            autoSave(santriId, status, false);
        }
    });
    
    radio.addEventListener('click', function() {
        var santriId = this.getAttribute('data-santri');
        var status = this.value;
        if (this.classList.contains('was-selected') && this.checked) {
            this.checked = false;
            this.classList.remove('was-selected');
            autoSave(santriId, status, true);
        } else {
            document.querySelectorAll('.presensi-radio[data-santri="' + santriId + '"]').forEach(function(r) {
                r.classList.remove('was-selected');
            });
            this.classList.add('was-selected');
        }
    });
});

document.querySelectorAll('input[name^="keterangan["]').forEach(input => {
    input.addEventListener('change', function() {
        var santriId = this.getAttribute('name').match(/\[(\d+)\]/)[1];
        var status = document.querySelector('input[name="presensi[' + santriId + ']"]:checked');
        if (status) {
            autoSave(santriId, status.value, false);
        }
    });
});
</script>

<style>
/* Jenjang Selection - Compact */
.jenjang-container {
    display: flex;
    gap: 0.5rem;
    margin-bottom: 1rem;
}

.jenjang-card {
    flex: 1;
    padding: 0.5rem 1rem;
    border-radius: 6px;
    border: 2px solid #e5e7eb;
    cursor: pointer;
    transition: all 0.3s;
    text-align: center;
    background: white;
    min-width: 140px;
}

.jenjang-card:hover {
    background: #f9fafb;
}

.active-safinatunnajah {
    background: #eff6ff;
    border-color: #3b82f6;
    box-shadow: 0 4px 6px -1px rgba(59, 130, 246, 0.3);
}

.active-muqodimah {
    background: #ecfdf5;
    border-color: #10b981;
    box-shadow: 0 4px 6px -1px rgba(16, 185, 129, 0.3);
}

.jenjang-label {
    font-size: 14px;
    font-weight: 600;
    margin-bottom: 4px;
}

.jenjang-label.safinatunnajah {
    color: #1e40af;
}

.jenjang-label.muqodimah {
    color: #047857;
}

.jenjang-sub {
    font-size: 11px;
    color: #6b7280;
}

/* Quick Actions */
.quick-actions {
    display: flex;
    gap: 0.5rem;
    margin-bottom: 1rem;
}

/* Table - Compact */
.table-wrapper {
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    border-radius: 8px;
    overflow: hidden;
}

.presensi-table {
    margin: 0;
    border-spacing: 0;
    border-collapse: collapse;
    width: 100%;
}

.presensi-table thead tr {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.presensi-table th {
    padding: 10px 12px;
    text-align: left;
    font-size: 13px;
    color: white;
    font-weight: 600;
}

.presensi-row {
    border-bottom: 1px solid #f1f5f9;
    transition: background 0.2s;
}

.presensi-row:hover {
    background: #f8fafc;
}

.td-name {
    padding: 8px 12px;
    font-weight: 500;
    color: #1f2937;
    font-size: 13px;
}

.td-jenjang {
    padding: 8px 12px;
}

.td-status {
    padding: 8px 12px;
}

.td-keterangan {
    padding: 8px 12px;
    min-width: 160px;
}

.form-input-sm {
    padding: 4px 8px !important;
    font-size: 12px !important;
    border-radius: 4px !important;
    border: 1px solid #e5e7eb !important;
    width: 100% !important;
}

.th-keterangan {
    width: 160px;
}

/* Status Options - Compact */
.status-options {
    display: flex;
    gap: 6px;
    align-items: center;
    flex-wrap: wrap;
}

.status-option {
    display: flex;
    align-items: center;
    gap: 4px;
    cursor: pointer;
    padding: 4px 8px;
    border-radius: 4px;
    border: 1px solid #e5e7eb;
    transition: all 0.2s;
    font-size: 12px;
    font-weight: 500;
    justify-content: center;
    min-width: 70px;
}

.status-option:hover {
    background: #f9fafb;
}

.save-status {
    margin-top: 0.75rem;
    font-size: 13px;
}
</style>
@endsection