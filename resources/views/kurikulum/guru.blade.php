<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Data Guru</title>
    <link rel="stylesheet" href="{{ asset('css/kurikulum.css') }}">
</head>
<body>
@include('kurikulum.partials.topbar')

<div class="main-content container">
    <h1>Data Guru</h1>
    
    @if($canEdit)
    <div class="card">
        <h3>{{ $editData ? 'Edit Guru' : 'Tambah Guru' }}</h3>
        <form method="POST" action="{{ $editData ? route('kurikulum.guru.update', $editData->id_guru) : route('kurikulum.guru.store') }}" style="max-width:500px;">
            @csrf
            @if($editData) @method('PUT') @endif
            
            <input type="text" name="nama" placeholder="Nama Guru" value="{{ $editData->nama_guru ?? '' }}" required style="width:100%;padding:8px;margin:5px 0;">
            <input type="text" name="nip" placeholder="NIP" value="{{ $editData->nip ?? '' }}" required style="width:100%;padding:8px;margin:5px 0;">
            
            <div style="position:relative;">
                <input type="text" id="mapelSearch" placeholder="Cari dan pilih mata pelajaran..." autocomplete="off" style="width:100%;padding:8px;margin:5px 0;border:1px solid #ddd;border-radius:4px;" value="{{ $editData->mapel ?? '' }}">
                <input type="hidden" name="mapel" id="mapelValue" value="{{ $editData->mapel ?? '' }}" required>
                <div id="mapelDropdown" style="display:none;position:absolute;width:100%;max-height:200px;overflow-y:auto;background:#fff;border:1px solid #ddd;border-radius:4px;z-index:1000;margin-top:-5px;">
                    @foreach($mapel as $m)
                    <div class="mapel-item" data-name="{{ $m->nama_mapel }}" style="padding:8px;cursor:pointer;border-bottom:1px solid #f0f0f0;">
                        <span style="font-size:11px;background:{{ $m->kategori == 'Produktif' ? '#dbeafe' : '#dcfce7' }};color:{{ $m->kategori == 'Produktif' ? '#1d4ed8' : '#15803d' }};padding:2px 6px;border-radius:4px;margin-right:6px;">{{ $m->kategori }}</span>
                        {{ $m->nama_mapel }}
                    </div>
                    @endforeach
                </div>
            </div>
            
            <button type="submit" class="btn" style="margin-top:10px;">{{ $editData ? 'Update' : 'Tambah' }}</button>
            @if($editData)
            <a href="{{ route('kurikulum.guru.index') }}" class="btn-outline" style="margin-left:10px;">Batal</a>
            @endif
        </form>
    </div>
    @endif
    
    <div class="card">
        <table class="data-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>NIP</th>
                    <th>Mapel</th>
                    @if($canEdit)<th>Aksi</th>@endif
                </tr>
            </thead>
            <tbody>
                @foreach($guru as $i => $r)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $r->nama_guru }}</td>
                    <td>{{ $r->nip }}</td>
                    <td>{{ $r->mapel }}</td>
                    @if($canEdit)
                    <td>
                        <a href="{{ route('kurikulum.guru.edit', $r->id_guru) }}" class="btn-outline" style="font-size:12px;padding:4px 8px;">Edit</a>
                        <form action="{{ route('kurikulum.guru.destroy', $r->id_guru) }}" method="POST" style="display:inline;" onsubmit="return confirm('Hapus data ini?')">
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
const mapelSearch = document.getElementById('mapelSearch');
const mapelValue = document.getElementById('mapelValue');
const mapelDropdown = document.getElementById('mapelDropdown');
const mapelItems = document.querySelectorAll('.mapel-item');

mapelSearch.addEventListener('focus', () => { mapelDropdown.style.display = 'block'; filterMapel(); });
mapelSearch.addEventListener('input', filterMapel);

function filterMapel() {
    const search = mapelSearch.value.toLowerCase();
    mapelItems.forEach(item => {
        item.style.display = item.dataset.name.toLowerCase().includes(search) ? 'block' : 'none';
    });
}

mapelItems.forEach(item => {
    item.addEventListener('click', () => {
        mapelSearch.value = item.dataset.name;
        mapelValue.value = item.dataset.name;
        mapelDropdown.style.display = 'none';
    });
    item.addEventListener('mouseenter', () => item.style.background = '#f0f0f0');
    item.addEventListener('mouseleave', () => item.style.background = '#fff');
});

document.addEventListener('click', (e) => {
    if (!e.target.closest('#mapelSearch') && !e.target.closest('#mapelDropdown')) {
        mapelDropdown.style.display = 'none';
    }
});
</script>
</body>
</html>
