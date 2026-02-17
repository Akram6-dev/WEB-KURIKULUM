<?php
session_start();
include '../config/db.php';
$canEdit = !empty($_SESSION['admin']);

if($_SERVER['REQUEST_METHOD']==='POST' && $canEdit){
    if(isset($_POST['add'])){
        $id_kelas=intval($_POST['id_kelas']); $tanggal=$_POST['tanggal']; $nama=$_POST['nama']; $status=$_POST['status'];
        $stmt=$conn->prepare('INSERT INTO absensi (id_kelas,tanggal,nama,status) VALUES (?,?,?,?)'); 
        $stmt->bind_param('isss',$id_kelas,$tanggal,$nama,$status); 
        $stmt->execute(); 
        header('Location:absen.php'); exit;
    }
    if(isset($_POST['edit'])){
        $id=intval($_POST['id']); $id_kelas=intval($_POST['id_kelas']); $tanggal=$_POST['tanggal']; $nama=$_POST['nama']; $status=$_POST['status'];
        $stmt=$conn->prepare('UPDATE absensi SET id_kelas=?,tanggal=?,nama=?,status=? WHERE id_absen=?');
        $stmt->bind_param('isssi',$id_kelas,$tanggal,$nama,$status,$id);
        $stmt->execute();
        header('Location:absen.php'); exit;
    }
}
if(!empty($_GET['del']) && $canEdit){ 
    $id=intval($_GET['del']); 
    $conn->query('DELETE FROM absensi WHERE id_absen='.$id); 
    header('Location:absen.php'); exit;
}

$editData = null;
if(!empty($_GET['edit'])){
    $id=intval($_GET['edit']);
    $editData = $conn->query('SELECT * FROM absensi WHERE id_absen='.$id)->fetch_assoc();
}

$kelasOpt = $conn->query('SELECT id_kelas,nama_kelas FROM kelas ORDER BY nama_kelas');
$filterKelas = isset($_GET['kelas']) ? intval($_GET['kelas']) : 0;
$filterTgl = isset($_GET['tgl']) ? $_GET['tgl'] : '';

$query = 'SELECT a.*,k.nama_kelas FROM absensi a LEFT JOIN kelas k ON a.id_kelas=k.id_kelas WHERE 1=1';
if($filterKelas) $query .= ' AND a.id_kelas='.$filterKelas;
if($filterTgl) $query .= ' AND a.tanggal="'.$conn->real_escape_string($filterTgl).'"';
$query .= ' ORDER BY a.tanggal DESC,a.nama';
$res=$conn->query($query);
?>
<!doctype html><html lang="id"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Absensi</title><link rel="stylesheet" href="../assets/css/style.css"></head>
<body><?php include '../assets/templates/topbar_public.php'; ?>
<div class="main-content container">
<h1>Absensi Siswa</h1>
<?php if($canEdit): ?>
<div class="card">
<h3><?php echo $editData ? 'Edit Absensi' : 'Tambah Absensi'; ?></h3>
<form method="POST" style="max-width:500px;">
<?php if($editData): ?><input type="hidden" name="id" value="<?php echo $editData['id_absen'];?>"><?php endif; ?>
<select name="id_kelas" required style="width:100%;padding:8px;margin:5px 0;">
<option value="">Pilih Kelas</option>
<?php $kelasOpt->data_seek(0); while($k=$kelasOpt->fetch_assoc()): ?>
<option value="<?php echo $k['id_kelas'];?>" <?php echo ($editData && $editData['id_kelas']==$k['id_kelas']) ? 'selected' : '';?>><?php echo htmlspecialchars($k['nama_kelas']);?></option>
<?php endwhile; ?>
</select>
<input type="date" name="tanggal" value="<?php echo $editData ? htmlspecialchars($editData['tanggal']) : date('Y-m-d');?>" required style="width:100%;padding:8px;margin:5px 0;">
<input type="text" name="nama" placeholder="Nama Siswa" value="<?php echo $editData ? htmlspecialchars($editData['nama']) : '';?>" required style="width:100%;padding:8px;margin:5px 0;">
<select name="status" required style="width:100%;padding:8px;margin:5px 0;">
<option value="">Pilih Status</option>
<option value="Hadir" <?php echo ($editData && $editData['status']=='Hadir') ? 'selected' : '';?>>Hadir</option>
<option value="Izin" <?php echo ($editData && $editData['status']=='Izin') ? 'selected' : '';?>>Izin</option>
<option value="Sakit" <?php echo ($editData && $editData['status']=='Sakit') ? 'selected' : '';?>>Sakit</option>
<option value="Alpa" <?php echo ($editData && $editData['status']=='Alpa') ? 'selected' : '';?>>Alpa</option>
</select>
<button type="submit" name="<?php echo $editData ? 'edit' : 'add';?>" class="btn" style="margin-top:10px;"><?php echo $editData ? 'Update' : 'Tambah';?></button>
<?php if($editData): ?><a href="absen.php" class="btn-outline" style="margin-left:10px;">Batal</a><?php endif; ?>
</form>
</div>
<?php endif; ?>
<div class="card">
<h3>Filter Absensi</h3>
<form method="GET" style="display:flex;gap:10px;margin-bottom:20px;">
<select name="kelas" style="padding:8px;">
<option value="">Semua Kelas</option>
<?php $kelasOpt->data_seek(0); while($k=$kelasOpt->fetch_assoc()): ?>
<option value="<?php echo $k['id_kelas'];?>" <?php echo ($filterKelas==$k['id_kelas']) ? 'selected' : '';?>><?php echo htmlspecialchars($k['nama_kelas']);?></option>
<?php endwhile; ?>
</select>
<input type="date" name="tgl" value="<?php echo htmlspecialchars($filterTgl);?>" style="padding:8px;">
<button type="submit" class="btn">Filter</button>
<a href="absen.php" class="btn-outline">Reset</a>
</form>
<table class="data-table">
<thead><tr><th>Tanggal</th><th>Nama</th><th>Kelas</th><th>Status</th><?php if($canEdit): ?><th>Aksi</th><?php endif; ?></tr></thead>
<tbody>
<?php while($r=$res->fetch_assoc()): 
$statusColor = ['Hadir'=>'#10b981','Izin'=>'#3b82f6','Sakit'=>'#f59e0b','Alpa'=>'#ef4444'];
?>
<tr>
<td><?php echo date('d M Y',strtotime($r['tanggal']));?></td>
<td><?php echo htmlspecialchars($r['nama']);?></td>
<td><?php echo htmlspecialchars($r['nama_kelas']);?></td>
<td><span style="background:<?php echo $statusColor[$r['status']]??'#6b7280';?>;color:white;padding:4px 8px;border-radius:4px;font-size:12px;"><?php echo htmlspecialchars($r['status']);?></span></td>
<?php if($canEdit): ?>
<td>
<a href="?edit=<?php echo $r['id_absen'];?>" class="btn-outline" style="font-size:12px;padding:4px 8px;">Edit</a>
<a href="?del=<?php echo $r['id_absen'];?>" onclick="return confirm('Hapus data ini?')" class="btn" style="font-size:12px;padding:4px 8px;background:#e74c3c;">Hapus</a>
</td>
<?php endif; ?>
</tr>
<?php endwhile; ?>
</tbody>
</table>
</div>
</div>
</body></html>