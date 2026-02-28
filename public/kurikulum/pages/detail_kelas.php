<?php
session_start();
include '../config/db.php';
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$stmt = $conn->prepare('SELECT k.*, j.nama_jurusan FROM kelas k LEFT JOIN jurusan j ON k.id_jurusan=j.id_jurusan WHERE id_kelas=? LIMIT 1');
$stmt->bind_param('i',$id); $stmt->execute(); $kelas = $stmt->get_result()->fetch_assoc();

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
$logoFile = $kelas ? ($logoMap[$kelas['nama_jurusan']] ?? 'pplg.png') : 'pplg.png';

$siswa_res = $conn->prepare('SELECT * FROM siswa WHERE id_kelas = ?');
$siswa_res->bind_param('i',$id); $siswa_res->execute(); $siswa = $siswa_res->get_result();
?>
<!doctype html><html lang="id"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Detail Kelas</title><link rel="stylesheet" href="../assets/css/style.css"></head>
<body>
<?php include '../assets/templates/topbar_public.php'; ?>
<div class="main-content container">
  <?php if(!$kelas): ?>
    <div class="card"><p>Kelas tidak ditemukan.</p></div>
  <?php else: ?>
    <div class="jurusan-header card">
      <img src="../assets/images/<?php echo htmlspecialchars($logoFile); ?>" alt="<?php echo htmlspecialchars($kelas['nama_jurusan']); ?>">
      <h1><?php echo htmlspecialchars($kelas['nama_kelas']); ?> — <?php echo htmlspecialchars($kelas['nama_jurusan']); ?></h1>
      <p>Wali Kelas: <?php echo htmlspecialchars($kelas['wali_kelas']?:'-'); ?></p>
      <p>Jumlah Siswa: <?php echo intval($kelas['jumlah_siswa']); ?> (L: <?php echo intval($kelas['laki']); ?> / P: <?php echo intval($kelas['perempuan']); ?>)</p>
    </div>

    <div class="card">
      <h3>Daftar Siswa</h3>
      <table class="data-table"><thead><tr><th>No</th><th>Nama</th><th>NIS</th></tr></thead><tbody>
      <?php $i=1; while($r=$siswa->fetch_assoc()): ?>
        <tr><td><?php echo $i++;?></td><td><?php echo htmlspecialchars($r['nama_siswa']);?></td><td><?php echo htmlspecialchars($r['nis']);?></td></tr>
      <?php endwhile; ?>
      </tbody></table>
    </div>
  <?php endif; ?>
</div>
<?php include '../assets/templates/footer.php'; ?>
</body></html>