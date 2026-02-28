<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>SMKN 1 Subang - Kurikulum</title>
    <link rel="stylesheet" href="{{ asset('kurikulum/assets/css/style.css') }}">
</head>
<body>
@include('kurikulum.partials.topbar')

<div class="main-content container">
    <div class="card" style="text-align:center;padding:40px;">
        <h1>SELAMAT DATANG DI KURIKULUM SMKN 1 SUBANG</h1>
        <p style="font-size:16px;color:#64748b;">Sistem Informasi Kurikulum SMKN 1 Subang</p>
    </div>
    
    <div class="card">
        <h2>Program Keahlian</h2>
        <div class="grid-program">
            @foreach($programs as $p)
                @php
                    $logoMap = [
                        'PPLG' => 'LogoRPL.png',
                        'RPL' => 'LogoRPL.png',
                        'TJKT' => 'LogoTKJ.png',
                        'TKJ' => 'LogoTKJ.png',
                        'AKL' => 'LogoAKL.png',
                        'DKV' => 'LogoDKVjpeg.png',
                        'MPLB' => 'LogoMPLB.png',
                        'PEMASARAN' => 'LogoPS.png',
                        'Pemasaran dan Bisnis Daring' => 'LogoPS.png',
                        'TO' => 'LogoTO.png',
                        'Teknik Otomotif' => 'LogoTO.png',
                        'TM' => 'LogoTPM.png',
                        'Teknik Mesin' => 'LogoTPM.png',
                        'TL' => 'LogoTL.png',
                        'Teknik Logistik' => 'LogoTL.png',
                        'KULINER' => 'LogoKULINER.png',
                        'Tata Boga dan Kuliner' => 'LogoKULINER.png',
                        'Pengembangan Perangkat Lunak dan Gim' => 'LogoRPL.png',
                        'Teknik Jaringan Komputer dan Telekomunikasi' => 'LogoTKJ.png',
                        'Akuntansi dan Keuangan Lembaga' => 'LogoAKL.png',
                        'Desain Komunikasi Visual' => 'LogoDKVjpeg.png',
                        'Manajemen Perkantoran dan Layanan Bisnis' => 'LogoMPLB.png'
                    ];
                    $logoFile = $logoMap[$p->nama_jurusan] ?? 'Gambar_SMKN_1SUBANG.png';
                @endphp
                
                <div class="prog-card" onclick="window.location.href='{{ route('kurikulum.jurusan.detail', $p->id_jurusan) }}'">
                    <img class="prog-logo" src="{{ asset('kurikulum/assets/images/' . $logoFile) }}" alt="{{ $p->nama_jurusan }}">
                    <h3>{{ $p->nama_jurusan }}</h3>
                    <p style="font-size:13px;color:#64748b;margin:8px 0;">{{ $p->deskripsi }}</p>
                </div>
            @endforeach
        </div>
    </div>
</div>

@include('kurikulum.partials.footer')
</body>
</html>
