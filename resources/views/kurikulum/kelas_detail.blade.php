<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Detail Kelas - {{ $kelas->nama_kelas ?? 'Tidak Ditemukan' }}</title>
    <link rel="stylesheet" href="{{ asset('css/kurikulum.css') }}">
</head>
<body>
@include('kurikulum.partials.topbar')

<div class="main-content container">
    @if(!$kelas)
        <div class="card"><p>Kelas tidak ditemukan.</p></div>
    @else
        @php
            $logoMap = [
                'PPLG' => 'LOGO RPL.jpeg',
                'RPL' => 'LOGO RPL.jpeg',
                'TJKT' => 'LogoTKJ.png',
                'TKJ' => 'LogoTKJ.png',
                'AKL' => 'LogoAKL.png',
                'DKV' => 'LogoDKVjpeg.png',
                'MPLB' => 'LogoMPLB.png',
                'PEMASARAN' => 'LogoPS.png',
                'TO' => 'LogoTO.png',
                'TM' => 'LogoTPM.png',
                'Teknik Logistik' => 'LogoTL.png',
                'KULINER' => 'LogoKULINER.png'
            ];
            $logoFile = $logoMap[$kelas->nama_jurusan] ?? 'Gambar_SMKN_1SUBANG.png';
        @endphp
        
        <div class="jurusan-header card">
            <img src="{{ asset('images/' . $logoFile) }}" alt="{{ $kelas->nama_jurusan }}">
            <h1>{{ $kelas->nama_kelas }} — {{ $kelas->nama_jurusan }}</h1>
            <p>Wali Kelas: {{ $kelas->wali_kelas ?: '-' }}</p>
            <p>Jumlah Siswa: {{ $kelas->jumlah_siswa }} (L: {{ $kelas->laki }} / P: {{ $kelas->perempuan }})</p>
        </div>

        <div class="card">
            <h3>Daftar Siswa</h3>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>NIS</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($siswa as $index => $r)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $r->nama_siswa }}</td>
                        <td>{{ $r->nis }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>

@include('kurikulum.partials.footer')
</body>
</html>
