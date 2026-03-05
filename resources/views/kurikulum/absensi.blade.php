<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Absensi Siswa</title>
    <link rel="stylesheet" href="{{ asset('kurikulum/assets/css/style.css') }}">
</head>
<body>
@include('kurikulum.partials.topbar')

<div class="main-content container">
    <h1>Absensi Siswa</h1>
    
    @if($canEdit)
    <div class="card">
        <h3>{{ $editData ? 'Edit Absensi' : 'Tambah Absensi' }}</h3>
        <form method="POST" action="{{ $editData ? route('kurikulum.absensi.update', $editData->id_absen) : route('kurikulum.absensi.store') }}" style="max-width:500px;">
            @csrf
            @if($editData) @method('PUT') @endif
            
            <select name="id_kelas" required style="width:100%;padding:8px;margin:5px 0;">
                <option value="">Pilih Kelas</option>
                @foreach($kelas as $k)
                    <option value="{{ $k->id_kelas }}" {{ $editData && $editData->id_kelas == $k->id_kelas ? 'selected' : '' }}>
                        {{ $k->nama_kelas }}
                    </option>
                @endforeach
            </select>
            
            <input type="date" name="tanggal" value="{{ $editData ? $editData->tanggal : date('Y-m-d') }}" required style="width:100%;padding:8px;margin:5px 0;">
            
            <input type="text" name="nama" placeholder="Nama Siswa" value="{{ $editData ? $editData->nama : '' }}" required style="width:100%;padding:8px;margin:5px 0;">
            
            <select name="status" required style="width:100%;padding:8px;margin:5px 0;">
                <option value="">Pilih Status</option>
                <option value="Hadir" {{ $editData && $editData->status == 'Hadir' ? 'selected' : '' }}>Hadir</option>
                <option value="Izin" {{ $editData && $editData->status == 'Izin' ? 'selected' : '' }}>Izin</option>
                <option value="Sakit" {{ $editData && $editData->status == 'Sakit' ? 'selected' : '' }}>Sakit</option>
                <option value="Alpa" {{ $editData && $editData->status == 'Alpa' ? 'selected' : '' }}>Alpa</option>
            </select>
            
            <button type="submit" class="btn" style="margin-top:10px;">{{ $editData ? 'Update' : 'Tambah' }}</button>
            @if($editData)
                <a href="{{ route('kurikulum.absensi.index') }}" class="btn-outline" style="margin-left:10px;">Batal</a>
            @endif
        </form>
    </div>
    @endif
    
    <div class="card">
        <h3>Filter Absensi</h3>
        <form method="GET" action="{{ route('kurikulum.absensi.index') }}" style="display:flex;gap:10px;margin-bottom:20px;">
            <select name="kelas" style="padding:8px;">
                <option value="">Semua Kelas</option>
                @foreach($kelas as $k)
                    <option value="{{ $k->id_kelas }}" {{ request('kelas') == $k->id_kelas ? 'selected' : '' }}>
                        {{ $k->nama_kelas }}
                    </option>
                @endforeach
            </select>
            
            <input type="date" name="tgl" value="{{ request('tgl') }}" style="padding:8px;">
            
            <button type="submit" class="btn">Filter</button>
            <a href="{{ route('kurikulum.absensi.index') }}" class="btn-outline">Reset</a>
        </form>
        
        <table class="data-table">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Nama</th>
                    <th>Kelas</th>
                    <th>Status</th>
                    @if($canEdit)<th>Aksi</th>@endif
                </tr>
            </thead>
            <tbody>
                @php
                    $statusColor = [
                        'Hadir' => '#10b981',
                        'Izin' => '#3b82f6',
                        'Sakit' => '#f59e0b',
                        'Alpa' => '#ef4444'
                    ];
                @endphp
                @foreach($absensi as $r)
                <tr>
                    <td>{{ date('d M Y', strtotime($r->tanggal)) }}</td>
                    <td>{{ $r->nama }}</td>
                    <td>{{ $r->nama_kelas }}</td>
                    <td>
                        <span style="background:{{ $statusColor[$r->status] ?? '#6b7280' }};color:white;padding:4px 8px;border-radius:4px;font-size:12px;">
                            {{ $r->status }}
                        </span>
                    </td>
                    @if($canEdit)
                    <td>
                        <a href="{{ route('kurikulum.absensi.edit', $r->id_absen) }}" class="btn-outline" style="font-size:12px;padding:4px 8px;">Edit</a>
                        <form method="POST" action="{{ route('kurikulum.absensi.destroy', $r->id_absen) }}" style="display:inline;" onsubmit="return confirm('Hapus data ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn" style="font-size:12px;padding:4px 8px;background:#e74c3c;">Hapus</button>
                        </form>
                    </td>
                    @endif
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@include('kurikulum.partials.footer')
</body>
</html>
