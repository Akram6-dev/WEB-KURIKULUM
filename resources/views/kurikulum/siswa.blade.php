<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Data Siswa</title>
    <link rel="stylesheet" href="{{ asset('kurikulum/assets/css/style.css') }}">
</head>
<body>
@include('kurikulum.partials.topbar')

<div class="main-content container">
    <h1>Data Siswa</h1>
    
    @if($canEdit)
    <div class="card">
        <h3>{{ $editData ? 'Edit Siswa' : 'Tambah Siswa' }}</h3>
        <form method="POST" action="{{ $editData ? route('kurikulum.siswa.update', $editData->id_siswa) : route('kurikulum.siswa.store') }}" style="max-width:500px;">
            @csrf
            @if($editData) @method('PUT') @endif
            
            <input type="text" name="nama" placeholder="Nama Siswa" value="{{ $editData->nama_siswa ?? '' }}" required style="width:100%;padding:8px;margin:5px 0;">
            <input type="text" name="nis" placeholder="NIS" value="{{ $editData->nis ?? '' }}" required style="width:100%;padding:8px;margin:5px 0;">
            
            <div style="position:relative;">
                <input type="text" id="kelasSearch" placeholder="Cari dan pilih kelas..." autocomplete="off" style="width:100%;padding:8px;margin:5px 0;border:1px solid #ddd;border-radius:4px;" value="{{ $editData->kelas_nama ?? '' }}">
                <input type="hidden" name="id_kelas" id="kelasValue" value="{{ $editData->id_kelas ?? '' }}" required>
                <div id="kelasDropdown" style="display:none;position:absolute;width:100%;max-height:200px;overflow-y:auto;background:#fff;border:1px solid #ddd;border-radius:4px;z-index:1000;margin-top:-5px;">
                    @foreach($kelas as $k)
                    <div class="kelas-item" data-id="{{ $k->id_kelas }}" data-name="{{ $k->nama_kelas }}" style="padding:8px;cursor:pointer;border-bottom:1px solid #f0f0f0;">{{ $k->nama_kelas }}</div>
                    @endforeach
                </div>
            </div>
            
            <select name="jk" required style="width:100%;padding:8px;margin:5px 0;">
                <option value="">Jenis Kelamin</option>
                <option value="L" {{ ($editData && $editData->jk == 'L') ? 'selected' : '' }}>Laki-laki</option>
                <option value="P" {{ ($editData && $editData->jk == 'P') ? 'selected' : '' }}>Perempuan</option>
            </select>
            
            <button type="submit" class="btn" style="margin-top:10px;">{{ $editData ? 'Update' : 'Tambah' }}</button>
            @if($editData)
            <a href="{{ route('kurikulum.siswa.index') }}" class="btn-outline" style="margin-left:10px;">Batal</a>
            @endif
        </form>
    </div>
    @endif
    
    <div class="card">
        <div style="margin-bottom:15px;">
            <input type="text" id="searchFilterKelas" placeholder="Cari Kelas..." style="padding:8px;border:1px solid #ddd;border-radius:4px;width:200px;">
        </div>
        <table class="data-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Siswa</th>
                    <th>NIS</th>
                    <th>Kelas</th>
                    <th>JK</th>
                    @if($canEdit)<th>Aksi</th>@endif
                </tr>
            </thead>
            <tbody>
                @foreach($siswa as $i => $r)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $r->nama_siswa }}</td>
                    <td>{{ $r->nis }}</td>
                    <td>{{ $r->nama_kelas ?? '' }}</td>
                    <td>{{ $r->jk ?? '' }}</td>
                    @if($canEdit)
                    <td>
                        <a href="{{ route('kurikulum.siswa.edit', $r->id_siswa) }}" class="btn-outline" style="font-size:12px;padding:4px 8px;">Edit</a>
                        <form action="{{ route('kurikulum.siswa.destroy', $r->id_siswa) }}" method="POST" style="display:inline;" onsubmit="return confirm('Hapus data ini?')">
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

const searchFilter = document.getElementById('searchFilterKelas');
const tableRows = document.querySelectorAll('.data-table tbody tr');
searchFilter.addEventListener('input', function() {
    const search = this.value.toLowerCase();
    tableRows.forEach(row => {
        const kelasCell = row.cells[3].textContent.toLowerCase();
        row.style.display = kelasCell.includes(search) ? '' : 'none';
    });
});
</script>
</body>
</html>
