<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Detail Jurusan - SMKN 1 Subang</title>
    <link rel="stylesheet" href="{{ asset('kurikulum/assets/css/style.css') }}">
</head>
<body>
@include('kurikulum.partials.topbar')
<div class="main-content container">
    <div class="card">
        <h2>{{ $jurusan->nama_jurusan }}</h2>
        <p>{{ $jurusan->keterangan }}</p>
        <p>{{ $jurusan->deskripsi }}</p>
        <a href="{{ route('kurikulum.index') }}">← Kembali</a>
    </div>
</div>
@include('kurikulum.partials.footer')
</body>
</html>
