<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Wali Kelas - SMKN 1 Subang</title>
    <link rel="stylesheet" href="{{ asset('css/kurikulum.css') }}">
</head>
<body>
@include('kurikulum.partials.topbar')

<div class="main-content container">

    @if($canEdit)
    <div class="card" style="margin-bottom:24px">
        <h2>{{ $editData ? 'Edit Wali Kelas: ' . $editData->nama_kelas : 'Pilih Kelas untuk Diubah Wali Kelasnya' }}</h2>

        @if($editData)
        <form method="POST" action="{{ route('kurikulum.kelas.update', $editData->id_kelas) }}">
            @csrf
            @method('PUT')
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-top:16px">
                <div>
                    <label style="font-weight:600;display:block;margin-bottom:6px">Kelas</label>
                    <input type="text" value="{{ $editData->nama_kelas }}" disabled style="background:#f1f5f9">
                </div>
                <div>
                    <label style="font-weight:600;display:block;margin-bottom:6px">Pilih Wali Kelas</label>
                    <select name="wali_kelas" required>
                        <option value="">-- Pilih Guru --</option>
                        @foreach($guru as $g)
                        <option value="{{ $g->nama_guru }}" {{ $editData->wali_kelas == $g->nama_guru ? 'selected' : '' }}>
                            {{ $g->nama_guru }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div style="margin-top:16px;display:flex;gap:8px">
                <button class="btn" type="submit">Simpan</button>
                <a href="{{ route('kurikulum.kelas.index') }}" class="btn-outline">Batal</a>
            </div>
        </form>
        @endif
    </div>
    @endif

    <div class="card">
        <h2>Daftar Wali Kelas</h2>

        @if(session('error'))
        <div style="background:#fee2e2;color:#dc2626;padding:10px 14px;border-radius:6px;margin-bottom:16px">
            {{ session('error') }}
        </div>
        @endif

        {{-- Search & Tombol Acak/Reset --}}
        <div style="margin-bottom:16px;display:flex;gap:8px;flex-wrap:wrap;align-items:center;justify-content:space-between">
            <input type="text" id="searchInput" placeholder="Cari kelas atau wali kelas..." oninput="filterTable()"
                style="padding:8px 12px;border:1px solid #cbd5e1;border-radius:6px;min-width:240px;font-size:14px">

            @if($canEdit)
            <div style="display:flex;gap:8px">
                <form method="POST" action="{{ route('kurikulum.kelas.acak') }}" onsubmit="return confirm('Acak semua wali kelas?')">
                    @csrf
                    <button type="submit" class="btn" style="background:#f59e0b;border-color:#f59e0b">🔀 Acak Wali Kelas</button>
                </form>
                @if(session('wali_kelas_acak'))
                <form method="POST" action="{{ route('kurikulum.kelas.reset') }}" onsubmit="return confirm('Kembalikan wali kelas ke data semula?')">
                    @csrf
                    <button type="submit" class="btn" style="background:#6b7280;border-color:#6b7280">↩ Kembalikan Semula</button>
                </form>
                @endif
            </div>
            @endif
        </div>

        {{-- Filter by tingkat --}}
        <div style="margin-bottom:16px;display:flex;gap:8px;flex-wrap:wrap">
            <a href="{{ route('kurikulum.kelas.index') }}"
               class="{{ !request('tingkat') ? 'btn' : 'btn-outline' }}" style="padding:8px 16px">Semua</a>
            <a href="{{ route('kurikulum.kelas.index') }}?tingkat=10"
               class="{{ request('tingkat')=='10' ? 'btn' : 'btn-outline' }}" style="padding:8px 16px">Kelas X</a>
            <a href="{{ route('kurikulum.kelas.index') }}?tingkat=11"
               class="{{ request('tingkat')=='11' ? 'btn' : 'btn-outline' }}" style="padding:8px 16px">Kelas XI</a>
            <a href="{{ route('kurikulum.kelas.index') }}?tingkat=12"
               class="{{ request('tingkat')=='12' ? 'btn' : 'btn-outline' }}" style="padding:8px 16px">Kelas XII</a>
        </div>

        <table class="data-table" id="kelasTable">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Kelas</th>
                    <th>Jurusan</th>
                    <th>Tingkat</th>
                    <th>Wali Kelas</th>
                    @if($canEdit)<th>Aksi</th>@endif
                </tr>
            </thead>
            <tbody>
                @php $no = 1; @endphp
                @foreach($kelas as $k)
                @if(!request('tingkat') || request('tingkat') == $k->tingkat)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $k->nama_kelas }}</td>
                    <td>{{ $k->nama_jurusan ?? '-' }}</td>
                    <td>Kelas {{ $k->tingkat }}</td>
                    <td>
                        @if($k->wali_kelas)
                            <span style="color:#10b981;font-weight:600">{{ $k->wali_kelas }}</span>
                        @else
                            <span style="color:#ef4444">Belum ditentukan</span>
                        @endif
                    </td>
                    @if($canEdit)
                    <td>
                        <a href="{{ route('kurikulum.kelas.edit', $k->id_kelas) }}" class="btn" style="padding:6px 14px;font-size:12px">Edit</a>
                    </td>
                    @endif
                </tr>
                @endif
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
function filterTable() {
    const q = document.getElementById('searchInput').value.toLowerCase();
    document.querySelectorAll('#kelasTable tbody tr').forEach(row => {
        row.style.display = row.innerText.toLowerCase().includes(q) ? '' : 'none';
    });
}
</script>

@include('kurikulum.partials.footer')
</body>
</html>
