<?php
session_start();
include 'config/db.php';
$programs = $conn->query("SELECT * FROM jurusan ORDER BY id_jurusan");
?>
<!doctype html><html lang="id"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>SMKN 1 Subang - Kurikulum</title><link rel="stylesheet" href="assets/css/style.css"></head>
<body>
<?php include 'assets/templates/topbar_public.php'; ?>
<div class="main-content container">
  <div class="card" style="text-align:center;padding:40px;">
    <h1>SELAMAT DATANG DI KURIKULUM SMKN 1 SUBANG</h1>
    <p style="font-size:16px;color:#64748b;">Sistem Informasi Kurikulum SMKN 1 Subang</p>
  </div>
  <div class="card">
    <h2>Program Keahlian</h2>
    <div class="grid-program">
      <?php while($p=$programs->fetch_assoc()): 
        $logoMap = [
          'RPL' => 'LOGO RPL.jpeg',
          'PPLG' => 'pplg.png',
          'TKJ' => 'LOGO TKJ.jpeg',
          'TJKT' => 'tjkt.png',
          'AKL' => 'LOGO AKL.jpeg',
          'DKV' => 'LOGO DKV.jpeg',
          'MPLB' => 'LOGO MPLB.jpeg',
          'PEMASARAN' => 'LOGO PEMASARAN.jpeg',
          'TO' => 'LOGO TEKNIK OTOMATIF.jpeg',
          'TM' => 'LOGO TEKNIK PEMESINAN.jpeg',
          'Teknik Logistik' => 'LOGO TEKNIK LOGISTIK.jpeg',
          'KULINER' => 'LOGO TATA BOGA.jpeg'
        ];
        $logoFile = $logoMap[$p['nama_jurusan']] ?? 'pplg.png';
      ?>
        <div class="prog-card" onclick="window.location.href='pages/detail_jurusan.php?id=<?php echo $p['id_jurusan']; ?>'">
          <img class="prog-logo" src="assets/images/<?php echo htmlspecialchars($logoFile); ?>" alt="<?php echo htmlspecialchars($p['nama_jurusan']); ?>">
          <h3><?php echo htmlspecialchars($p['nama_jurusan']); ?></h3>
          <p style="font-size:13px;color:#64748b;margin:8px 0;"><?php echo htmlspecialchars($p['deskripsi']); ?></p>
        </div>
      <?php endwhile; ?>
    </div>
  </div>
</div>
<?php include 'assets/templates/footer.php'; ?>
</body></html>