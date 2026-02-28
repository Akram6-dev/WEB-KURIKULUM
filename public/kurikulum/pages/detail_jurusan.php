<?php
session_start();
include '../config/db.php';
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$stmt = $conn->prepare('SELECT * FROM jurusan WHERE id_jurusan = ? LIMIT 1');
$stmt->bind_param('i',$id); $stmt->execute(); $prog = $stmt->get_result()->fetch_assoc();

$logoMap = [
  'PPLG' => 'LOGO RPL.jpeg',
          'RPL' => 'LOGO RPL.jpeg',
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
$logoFile = $prog ? ($logoMap[$prog['nama_jurusan']] ?? 'pplg.png') : 'pplg.png';
?>
<!doctype html><html lang="id"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Detail Jurusan</title><link rel="stylesheet" href="../assets/css/style.css"></head>
<body>
<?php include '../assets/templates/topbar_public.php'; ?>
<div class="main-content container">
  <?php if(!$prog): ?>
    <div class="card"><p>Jurusan tidak ditemukan.</p></div>
  <?php else: ?>
    <div class="jurusan-header card">
      <img src="../assets/images/<?php echo htmlspecialchars($logoFile); ?>" alt="<?php echo htmlspecialchars($prog['nama_jurusan']); ?>">
      <h1><?php echo htmlspecialchars($prog['nama_jurusan']); ?></h1>
      <p style="color:#64748b;"><?php echo htmlspecialchars($prog['deskripsi']); ?></p>
    </div>

    <div class="card">
      <h3>Pilih Tingkatan</h3>
      <div class="jurusan-buttons" style="display:flex;gap:12px;justify-content:center;margin:20px 0;">
        <a class="btn-outline" href="detail_jurusan.php?id=<?php echo $id; ?>&tingkat=10">Kelas 10</a>
        <a class="btn-outline" href="detail_jurusan.php?id=<?php echo $id; ?>&tingkat=11">Kelas 11</a>
        <a class="btn-outline" href="detail_jurusan.php?id=<?php echo $id; ?>&tingkat=12">Kelas 12</a>
      </div>
      <?php
      $tingkat = isset($_GET['tingkat']) ? $_GET['tingkat'] : null;
      if($tingkat){
        echo '<h4 style="margin-top:24px;">Rombongan Belajar Tingkat '.$tingkat.'</h4>';
        echo '<div class="kelas-list">';
        $kq = $conn->prepare('SELECT * FROM kelas WHERE id_jurusan=? AND tingkat=? ORDER BY nama_kelas');
        $kq->bind_param('is',$id,$tingkat);
        $kq->execute();
        $kr = $kq->get_result();
        while($kl = $kr->fetch_assoc()){
          $sq = $conn->prepare('SELECT COUNT(*) as total FROM siswa WHERE id_kelas=?');
          $sq->bind_param('i',$kl['id_kelas']);
          $sq->execute();
          $jml = $sq->get_result()->fetch_assoc()['total'];
          echo '<div class="kelas-card">';
          echo '<h4>'.htmlspecialchars($kl['nama_kelas']).'</h4>';
          echo '<p style="margin:8px 0;color:#64748b;"><strong>Wali Kelas:</strong><br>'.htmlspecialchars($kl['wali_kelas']?:'-').'</p>';
          echo '<p style="margin:8px 0;color:#64748b;"><strong>Jumlah Siswa:</strong> '.$jml.'</p>';
          echo '<a class="btn-outline" href="detail_kelas.php?id='.intval($kl['id_kelas']).'">Lihat Detail</a>';
          echo '</div>';
        }
        echo '</div>';
      }
      ?>
    </div>
  <?php endif; ?>
</div>
<?php include '../assets/templates/footer.php'; ?>
</body></html>