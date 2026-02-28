<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Data Guru</title>
    <link rel="stylesheet" href="{{ asset('kurikulum/assets/css/style.css') }}">
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
            <input type="text" name="mapel" placeholder="Mata Pelajaran" value="{{ $editData->mapel ?? '' }}" required style="width:100%;padding:8px;margin:5px 0;">
            
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
</body>
</html>
