<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Detail Jurusan - {{ $jurusan->nama_jurusan ?? 'Tidak Ditemukan' }}</title>
    <link rel="stylesheet" href="{{ asset('kurikulum/assets/css/style.css') }}">
</head>
<body>
@include('kurikulum.partials.topbar')

<div class="main-content container">
    @if(!$jurusan)
        <div class="card"><p>Jurusan tidak ditemukan.</p></div>
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
            $logoFile = $logoMap[$jurusan->nama_jurusan] ?? 'Gambar_SMKN_1SUBANG.png';
        @endphp
        
        <div class="jurusan-header card">
            <img src="{{ asset('kurikulum/assets/images/' . $logoFile) }}" alt="{{ $jurusan->nama_jurusan }}">
            <h1>{{ $jurusan->nama_jurusan }}</h1>
            <p style="color:#64748b;">{{ $jurusan->deskripsi }}</p>
        </div>

        <div class="card">
            <h3>Pilih Tingkatan</h3>
            <div class="jurusan-buttons" style="display:flex;gap:12px;justify-content:center;margin:20px 0;">
                <a class="btn-outline" href="{{ route('kurikulum.jurusan.detail', ['id' => $jurusan->id_jurusan, 'tingkat' => 10]) }}">Kelas 10</a>
                <a class="btn-outline" href="{{ route('kurikulum.jurusan.detail', ['id' => $jurusan->id_jurusan, 'tingkat' => 11]) }}">Kelas 11</a>
                <a class="btn-outline" href="{{ route('kurikulum.jurusan.detail', ['id' => $jurusan->id_jurusan, 'tingkat' => 12]) }}">Kelas 12</a>
            </div>
            
            @if($tingkat)
                <h4 style="margin-top:24px;">Rombongan Belajar Tingkat {{ $tingkat }}</h4>
                <div class="kelas-list">
                    @foreach($kelasList as $kl)
                        <div class="kelas-card">
                            <h4>{{ $kl->nama_kelas }}</h4>
                            <p style="margin:8px 0;color:#64748b;"><strong>Wali Kelas:</strong><br>{{ $kl->wali_kelas ?: '-' }}</p>
                            <p style="margin:8px 0;color:#64748b;"><strong>Jumlah Siswa:</strong> {{ $kl->jumlah_siswa }}</p>
                            <a class="btn-outline" href="{{ route('kurikulum.kelas.detail', $kl->id_kelas) }}">Lihat Detail</a>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    @endif
</div>

@include('kurikulum.partials.footer')
</body>
</html>
