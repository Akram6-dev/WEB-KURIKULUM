<?php
session_start();
include '../config/db.php';
$canEdit = !empty($_SESSION['admin']);

if($_SERVER['REQUEST_METHOD']==='POST' && $canEdit){
    if(isset($_POST['add'])){
        $id_kelas=intval($_POST['id_kelas']); $hari=$_POST['hari']; $jam_mulai=$_POST['jam_mulai']; $jam_selesai=$_POST['jam_selesai']; $mapel=$_POST['mapel']; $guru=$_POST['guru'];
        $kelasNama = $conn->query('SELECT nama_kelas FROM kelas WHERE id_kelas='.$id_kelas)->fetch_assoc()['nama_kelas'];
        $stmt=$conn->prepare('INSERT INTO jadwal (id_kelas,hari,jam_mulai,jam_selesai,mapel,guru_pengampu,kelas) VALUES (?,?,?,?,?,?,?)'); 
        $stmt->bind_param('issssss',$id_kelas,$hari,$jam_mulai,$jam_selesai,$mapel,$guru,$kelasNama); 
        $stmt->execute(); 
        header('Location:jadwal.php'); exit;
    }
    if(isset($_POST['edit'])){
        $id=intval($_POST['id']); $id_kelas=intval($_POST['id_kelas']); $hari=$_POST['hari']; $jam_mulai=$_POST['jam_mulai']; $jam_selesai=$_POST['jam_selesai']; $mapel=$_POST['mapel']; $guru=$_POST['guru'];
        $kelasNama = $conn->query('SELECT nama_kelas FROM kelas WHERE id_kelas='.$id_kelas)->fetch_assoc()['nama_kelas'];
        $stmt=$conn->prepare('UPDATE jadwal SET id_kelas=?,hari=?,jam_mulai=?,jam_selesai=?,mapel=?,guru_pengampu=?,kelas=? WHERE id_jadwal=?');
        $stmt->bind_param('issssssi',$id_kelas,$hari,$jam_mulai,$jam_selesai,$mapel,$guru,$kelasNama,$id);
        $stmt->execute();
        header('Location:jadwal.php'); exit;
    }
}
if(!empty($_GET['del']) && $canEdit){ 
    $id=intval($_GET['del']); 
    $conn->query('DELETE FROM jadwal WHERE id_jadwal='.$id); 
    header('Location:jadwal.php'); exit;
}

$editData = null;
if(!empty($_GET['edit'])){
    $id=intval($_GET['edit']);
    $editData = $conn->query('SELECT * FROM jadwal WHERE id_jadwal='.$id)->fetch_assoc();
}

$kelasOpt = $conn->query('SELECT id_kelas,nama_kelas FROM kelas ORDER BY nama_kelas');
$res=$conn->query('SELECT * FROM jadwal ORDER BY FIELD(hari,"Senin","Selasa","Rabu","Kamis","Jumat","Sabtu"),jam_mulai');
?>
<!doctype html><html lang="id"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Jadwal</title><link rel="stylesheet" href="../assets/css/style.css"></head>
<body><?php include '../assets/templates/topbar_public.php'; ?>
<div class="main-content container">
<h1>Jadwal Pelajaran</h1>
<?php if($canEdit): ?>
<div class="card">
<h3><?php echo $editData ? 'Edit Jadwal' : 'Tambah Jadwal'; ?></h3>
<form method="POST" style="max-width:500px;">
<?php if($editData): ?><input type="hidden" name="id" value="<?php echo $editData['id_jadwal'];?>"><?php endif; ?>
<div style="position:relative;">
<input type="text" id="kelasSearch" placeholder="Cari dan pilih kelas..." autocomplete="off" style="width:100%;padding:8px;margin:5px 0;border:1px solid #ddd;border-radius:4px;" value="<?php if($editData && $editData['id_kelas']){ $kelasEdit = $conn->query('SELECT nama_kelas FROM kelas WHERE id_kelas='.$editData['id_kelas'])->fetch_assoc(); echo htmlspecialchars($kelasEdit['nama_kelas'] ?? ''); } ?>">
<input type="hidden" name="id_kelas" id="kelasValue" value="<?php echo $editData ? $editData['id_kelas'] : '';?>" required>
<div id="kelasDropdown" style="display:none;position:absolute;width:100%;max-height:200px;overflow-y:auto;background:#fff;border:1px solid #ddd;border-radius:4px;z-index:1000;margin-top:-5px;">
<?php $kelasOpt->data_seek(0); while($k=$kelasOpt->fetch_assoc()): ?>
<div class="kelas-item" data-id="<?php echo $k['id_kelas'];?>" data-name="<?php echo htmlspecialchars($k['nama_kelas']);?>" style="padding:8px;cursor:pointer;border-bottom:1px solid #f0f0f0;"><?php echo htmlspecialchars($k['nama_kelas']);?></div>
<?php endwhile; ?>
</div>
</div>
<script>
const kelasSearch = document.getElementById('kelasSearch');
const kelasValue = document.getElementById('kelasValue');
const kelasDropdown = document.getElementById('kelasDropdown');
const kelasItems = document.querySelectorAll('.kelas-item');

kelasSearch.addEventListener('focus', () => {
  kelasDropdown.style.display = 'block';
  filterKelas();
});

kelasSearch.addEventListener('input', filterKelas);

function filterKelas() {
  const search = kelasSearch.value.toLowerCase();
  kelasItems.forEach(item => {
    const name = item.dataset.name.toLowerCase();
    item.style.display = name.includes(search) ? 'block' : 'none';
  });
}

kelasItems.forEach(item => {
  item.addEventListener('click', () => {
    kelasSearch.value = item.dataset.name;
    kelasValue.value = item.dataset.id;
    kelasDropdown.style.display = 'none';
  });
  item.addEventListener('mouseenter', () => item.style.background = '#f0f0f0');
  item.addEventListener('mouseleave', () => item.style.background = '#fff');
});

document.addEventListener('click', (e) => {
  if (!e.target.closest('#kelasSearch') && !e.target.closest('#kelasDropdown')) {
    kelasDropdown.style.display = 'none';
  }
});
</script>
<select name="hari" required style="width:100%;padding:8px;margin:5px 0;">
<option value="">Pilih Hari</option>
<?php foreach(['Senin','Selasa','Rabu','Kamis','Jumat'] as $h): ?>
<option value="<?php echo $h;?>" <?php echo ($editData && $editData['hari']==$h) ? 'selected' : '';?>><?php echo $h;?></option>
<?php endforeach; ?>
</select>
<input type="time" name="jam_mulai" placeholder="Jam Mulai" value="<?php echo $editData ? htmlspecialchars($editData['jam_mulai']) : '';?>" required style="width:100%;padding:8px;margin:5px 0;">
<input type="time" name="jam_selesai" placeholder="Jam Selesai" value="<?php echo $editData ? htmlspecialchars($editData['jam_selesai']) : '';?>" required style="width:100%;padding:8px;margin:5px 0;">
<input type="text" name="mapel" placeholder="Mata Pelajaran" value="<?php echo $editData ? htmlspecialchars($editData['mapel']) : '';?>" required style="width:100%;padding:8px;margin:5px 0;">
<input type="text" name="guru" placeholder="Guru Pengajar" value="<?php echo $editData ? htmlspecialchars($editData['guru_pengampu']) : '';?>" required style="width:100%;padding:8px;margin:5px 0;">
<button type="submit" name="<?php echo $editData ? 'edit' : 'add';?>" class="btn" style="margin-top:10px;"><?php echo $editData ? 'Update' : 'Tambah';?></button>
<?php if($editData): ?><a href="jadwal.php" class="btn-outline" style="margin-left:10px;">Batal</a><?php endif; ?>
</form>
</div>
<?php endif; ?>
<div class="card">
<div style="margin-bottom:15px;">
<a href="jadwal_pdf.php" target="_blank" class="btn" style="background:#3b82f6;">📄 Export ke PDF</a>
</div>
<table class="data-table">
<thead><tr><th>Hari</th><th>Jam</th><th>Mapel</th><th>Guru</th><th>Kelas</th><?php if($canEdit): ?><th>Aksi</th><?php endif; ?></tr></thead>
<tbody>
<?php while($r=$res->fetch_assoc()): ?>
<tr>
<td><?php echo htmlspecialchars($r['hari']);?></td>
<td><?php echo htmlspecialchars($r['jam_mulai']).' - '.htmlspecialchars($r['jam_selesai']);?></td>
<td><?php echo htmlspecialchars($r['mapel']);?></td>
<td><?php echo htmlspecialchars($r['guru_pengampu']);?></td>
<td><?php echo htmlspecialchars($r['kelas']);?></td>
<?php if($canEdit): ?>
<td>
<a href="?edit=<?php echo $r['id_jadwal'];?>" class="btn-outline" style="font-size:12px;padding:4px 8px;">Edit</a>
<a href="?del=<?php echo $r['id_jadwal'];?>" onclick="return confirm('Hapus data ini?')" class="btn" style="font-size:12px;padding:4px 8px;background:#e74c3c;">Hapus</a>
</td>
<?php endif; ?>
</tr>
<?php endwhile; ?>
</tbody>
</table>
</div>
</div>
</body></html>