<?php
session_start();
include '../config/db.php';
$res = $conn->query("SELECT * FROM jurusan ORDER BY id_jurusan DESC");
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Data Jurusan</title>
  <!-- Gunakan CSS yang sama seperti di Data Guru -->
  <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
  <!-- Include topbar dan sidebar biar tampilannya sama -->
  <?php include '../assets/templates/topbar_public.php'; ?>

  <div class="main-content container">
    <h1>Data Jurusan</h1>
    <div class="card">
      <table class="data-table">
        <thead>
          <tr>
            <th>No</th>
            <th>Nama Jurusan</th>
            <th>Deskripsi</th>
            <th>Logo</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $i = 1;
          while ($r = $res->fetch_assoc()):
          ?>
          <tr>
            <td><?php echo $i++; ?></td>
            <td><?php echo htmlspecialchars($r['nama_jurusan']); ?></td>
            <td><?php echo htmlspecialchars($r['deskripsi']); ?></td>
            <td>
              <img src="../assets/img/<?php echo htmlspecialchars($r['logo']); ?>" alt="Logo <?php echo htmlspecialchars($r['nama_jurusan']); ?>" width="60">
            </td>
          </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>
</body>
</html>
