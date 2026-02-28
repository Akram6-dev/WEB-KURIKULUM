<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Materi</title>
    <link rel="stylesheet" href="{{ asset('kurikulum/assets/css/style.css') }}">
</head>
<body>
@include('kurikulum.partials.topbar')

<div class="main-content container">
    <h1>Ruang Materi</h1>
    
    @if($canEdit)
    <div class="card">
        <h3>{{ $editData ? 'Edit Materi' : 'Tambah Materi' }}</h3>
        <form method="POST" action="{{ $editData ? route('kurikulum.materi.update', $editData->id_materi) : route('kurikulum.materi.store') }}" style="max-width:600px;">
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
            
            <input type="text" name="judul" placeholder="Judul Materi" value="{{ $editData->judul ?? '' }}" required style="width:100%;padding:8px;margin:5px 0;">
            <textarea name="deskripsi" placeholder="Deskripsi Materi" required style="width:100%;padding:8px;margin:5px 0;min-height:100px;">{{ $editData->deskripsi ?? '' }}</textarea>
            
            <button type="submit" class="btn" style="margin-top:10px;">{{ $editData ? 'Update' : 'Tambah' }}</button>
            @if($editData)
            <a href="{{ route('kurikulum.materi.index') }}" class="btn-outline" style="margin-left:10px;">Batal</a>
            @endif
        </form>
    </div>
    @endif
    
    <div class="card">
        @foreach($materi as $r)
        <div style="border:1px solid #e5e7eb;padding:15px;margin:10px 0;border-radius:8px;">
            <h3 style="margin:0 0 8px 0;color:#1f2937;">{{ $r->judul }}</h3>
            <p style="color:#6b7280;font-size:14px;margin:5px 0;">
                <strong>Kelas:</strong> {{ $r->nama_kelas }} | 
                <strong>Tanggal:</strong> {{ date('d M Y', strtotime($r->tanggal_upload)) }}
            </p>
            <p style="margin:10px 0;color:#374151;">{{ $r->deskripsi }}</p>
            @if($canEdit)
            <div style="margin-top:10px;">
                <a href="{{ route('kurikulum.materi.edit', $r->id_materi) }}" class="btn-outline" style="font-size:12px;padding:4px 8px;">Edit</a>
                <form action="{{ route('kurikulum.materi.destroy', $r->id_materi) }}" method="POST" style="display:inline;" onsubmit="return confirm('Hapus materi ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn" style="font-size:12px;padding:4px 8px;background:#e74c3c;border:none;cursor:pointer;">Hapus</button>
                </form>
            </div>
            @endif
        </div>
        @endforeach
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
