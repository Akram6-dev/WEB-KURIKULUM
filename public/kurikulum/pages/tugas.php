<?php
include '../config/db.php';
$res=$conn->query('SELECT * FROM tugas ORDER BY tanggal_upload DESC');
?>
<!doctype html><html lang="id"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Tugas</title><link rel="stylesheet" href="../assets/css/style.css"></head>
<body><?php include '../assets/templates/topbar_public.php'; ?>
<div class="main-content container"><h1>Ruang Tugas</h1><div class="card"><table class="data-table"><thead><tr><th>Judul</th><th>Kelas</th><th>Tanggal</th></tr></thead><tbody><?php while($r=$res->fetch_assoc()): ?><tr><td><?php echo htmlspecialchars($r['judul']);?></td><td><?php echo htmlspecialchars($r['id_kelas']);?></td><td><?php echo htmlspecialchars($r['tanggal_upload']);?></td></tr><?php endwhile; ?></tbody></table></div></div></body></html>