<?php
include '../config/db.php';
$res=$conn->query('SELECT * FROM jadwal ORDER BY FIELD(hari,"Senin","Selasa","Rabu","Kamis","Jumat"),jam_mulai');
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Print Jadwal</title>
<style>
body{font-family:Arial,sans-serif;margin:20px;}
h1{text-align:center;color:#333;margin-bottom:5px;}
h3{text-align:center;color:#666;margin-top:0;margin-bottom:20px;}
table{width:100%;border-collapse:collapse;margin-top:20px;}
th,td{border:1px solid #ddd;padding:8px;text-align:left;font-size:12px;}
th{background-color:#4CAF50;color:white;}
tr:nth-child(even){background-color:#f2f2f2;}
.print-btn{background:#3b82f6;color:white;padding:10px 20px;border:none;cursor:pointer;margin-bottom:20px;border-radius:5px;}
@media print{.print-btn{display:none;}@page{margin:0.5cm;}}
</style>
</head>
<body>
<button class="print-btn" onclick="window.print()">🖨️ Print / Save as PDF</button>
<h1>JADWAL PELAJARAN</h1>
<h3>SMKN 1 SUBANG</h3>
<table>
<thead>
<tr>
<th>No</th>
<th>Hari</th>
<th>Jam</th>
<th>Mata Pelajaran</th>
<th>Guru Pengajar</th>
<th>Kelas</th>
</tr>
</thead>
<tbody>
<?php 
$no=1;
while($r=$res->fetch_assoc()): 
?>
<tr>
<td><?php echo $no++;?></td>
<td><?php echo htmlspecialchars($r['hari']);?></td>
<td><?php echo htmlspecialchars($r['jam_mulai']).' - '.htmlspecialchars($r['jam_selesai']);?></td>
<td><?php echo htmlspecialchars($r['mapel']);?></td>
<td><?php echo htmlspecialchars($r['guru_pengampu']);?></td>
<td><?php echo htmlspecialchars($r['kelas']);?></td>
</tr>
<?php endwhile; ?>
</tbody>
</table>
<p style="margin-top:20px;font-size:10px;color:#666;">Dicetak pada: <?php echo date('d F Y H:i');?></p>
</body>
</html>
