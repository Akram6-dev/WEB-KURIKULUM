<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Jadwal</title>
    <link rel="stylesheet" href="{{ asset('kurikulum/assets/css/style.css') }}">
</head>
<body>
@include('kurikulum.partials.topbar')

<div class="main-content container">
    <h1>Jadwal Pelajaran</h1>
    
    @if($canEdit)
    <div class="card">
        <h3>{{ $editData ? 'Edit Jadwal' : 'Tambah Jadwal' }}</h3>
        <form method="POST" action="{{ $editData ? route('kurikulum.jadwal.update', $editData->id_jadwal) : route('kurikulum.jadwal.store') }}" style="max-width:500px;">
            @csrf
            @if($editData) @method('PUT') @endif
            
            <div style="position:relative;">
                <input type="text" id="kelasSearch" placeholder="Cari dan pilih kelas..." autocomplete="off" style="width:100%;padding:8px;margin:5px 0;border:1px solid #ddd;border-radius:4px;" value="{{ $editData->kelas_nama ?? '' }}">
                <input type="hidden" name="id_kelas" id="kelasValue" value="{{ $editData->id_kelas ?? '' }}" required>
                <div id="kelasDropdown" style="display:none;position:absolute;width:100%;max-height:200px;overflow-y:auto;background:#fff;border:1px solid #ddd;border-radius:4px;z-index:1000;margin-top:-5px;">
                    @foreach($kelas as $k)
                    <div class="kelas-item" data-id="{{ $k->id_kelas }}" data-name="{{ $k->nama_kelas }}" style="padding:8px;cursor:pointer;border-bottom:1px solid #f0f0f0;">{{ $k->nama_kelas }}</div>
                    @endforeach
                </div>
            </div>
            
            <select name="hari" required style="width:100%;padding:8px;margin:5px 0;">
                <option value="">Pilih Hari</option>
                @foreach(['Senin','Selasa','Rabu','Kamis','Jumat'] as $h)
                <option value="{{ $h }}" {{ ($editData && $editData->hari == $h) ? 'selected' : '' }}>{{ $h }}</option>
                @endforeach
            </select>
            
            <input type="time" name="jam_mulai" placeholder="Jam Mulai" value="{{ $editData->jam_mulai ?? '' }}" required style="width:100%;padding:8px;margin:5px 0;">
            <input type="time" name="jam_selesai" placeholder="Jam Selesai" value="{{ $editData->jam_selesai ?? '' }}" required style="width:100%;padding:8px;margin:5px 0;">
            <input type="text" name="mapel" placeholder="Mata Pelajaran" value="{{ $editData->mapel ?? '' }}" required style="width:100%;padding:8px;margin:5px 0;">
            <input type="text" name="guru" placeholder="Guru Pengajar" value="{{ $editData->guru_pengampu ?? '' }}" required style="width:100%;padding:8px;margin:5px 0;">
            
            <button type="submit" class="btn" style="margin-top:10px;">{{ $editData ? 'Update' : 'Tambah' }}</button>
            @if($editData)
            <a href="{{ route('kurikulum.jadwal.index') }}" class="btn-outline" style="margin-left:10px;">Batal</a>
            @endif
        </form>
    </div>
    @endif
    
    <div class="card">
        <div style="margin-bottom:15px;">
            <a href="/kurikulum/pages/jadwal_pdf.php" target="_blank" class="btn" style="background:#3b82f6;">📄 Export ke PDF</a>
        </div>
        <table class="data-table">
            <thead>
                <tr>
                    <th>Hari</th>
                    <th>Jam</th>
                    <th>Mapel</th>
                    <th>Guru</th>
                    <th>Kelas</th>
                    @if($canEdit)<th>Aksi</th>@endif
                </tr>
            </thead>
            <tbody>
                @foreach($jadwal as $r)
                <tr>
                    <td>{{ $r->hari }}</td>
                    <td>{{ $r->jam_mulai }} - {{ $r->jam_selesai }}</td>
                    <td>{{ $r->mapel }}</td>
                    <td>{{ $r->guru_pengampu }}</td>
                    <td>{{ $r->kelas }}</td>
                    @if($canEdit)
                    <td>
                        <a href="{{ route('kurikulum.jadwal.edit', $r->id_jadwal) }}" class="btn-outline" style="font-size:12px;padding:4px 8px;">Edit</a>
                        <form action="{{ route('kurikulum.jadwal.destroy', $r->id_jadwal) }}" method="POST" style="display:inline;" onsubmit="return confirm('Hapus data ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn" style="font-size:12px;padding:4px 8px;background:#e74c3c;border:none;cursor:pointer;">Hapus</button>
                        </form>
                    </td>
                    @endif
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
const kelasSearch = document.getElementById('kelasSearch');
const kelasValue = document.getElementById('kelasValue');
const kelasDropdown = document.getElementById('kelasDropdown');
const kelasItems = document.querySelectorAll('.kelas-item');

kelasSearch.addEventListener('focus', () => {
  kelasDropdown.style.display = 'block';
  filterKelas();
});

kelasSearch.addEventListener('input', filterKelas);

function filterKelas() {
  const search = kelasSearch.value.toLowerCase();
  kelasItems.forEach(item => {
    const name = item.dataset.name.toLowerCase();
    item.style.display = name.includes(search) ? 'block' : 'none';
  });
}

kelasItems.forEach(item => {
  item.addEventListener('click', () => {
    kelasSearch.value = item.dataset.name;
    kelasValue.value = item.dataset.id;
    kelasDropdown.style.display = 'none';
  });
  item.addEventListener('mouseenter', () => item.style.background = '#f0f0f0');
  item.addEventListener('mouseleave', () => item.style.background = '#fff');
});

document.addEventListener('click', (e) => {
  if (!e.target.closest('#kelasSearch') && !e.target.closest('#kelasDropdown')) {
    kelasDropdown.style.display = 'none';
  }
});
</script>
</body>
</html>
