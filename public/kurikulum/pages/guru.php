<?php
session_start();
include '../config/db.php';
$canEdit = !empty($_SESSION['admin']);

if($_SERVER['REQUEST_METHOD']==='POST' && $canEdit){
    if(isset($_POST['add'])){
        $nama=$_POST['nama']; $nip=$_POST['nip']; $mapel=$_POST['mapel'];
        $stmt=$conn->prepare('INSERT INTO guru (nama_guru,nip,mapel) VALUES (?,?,?)'); 
        $stmt->bind_param('sss',$nama,$nip,$mapel); 
        $stmt->execute(); 
        header('Location:guru.php'); exit;
    }
    if(isset($_POST['edit'])){
        $id=intval($_POST['id']); $nama=$_POST['nama']; $nip=$_POST['nip']; $mapel=$_POST['mapel'];
        $stmt=$conn->prepare('UPDATE guru SET nama_guru=?,nip=?,mapel=? WHERE id_guru=?');
        $stmt->bind_param('sssi',$nama,$nip,$mapel,$id);
        $stmt->execute();
        header('Location:guru.php'); exit;
    }
}
if(!empty($_GET['del']) && $canEdit){ 
    $id=intval($_GET['del']); 
    $conn->query('DELETE FROM guru WHERE id_guru='.$id); 
    header('Location:guru.php'); exit;
}

$editData = null;
if(!empty($_GET['edit'])){
    $id=intval($_GET['edit']);
    $editData = $conn->query('SELECT * FROM guru WHERE id_guru='.$id)->fetch_assoc();
}

$res=$conn->query('SELECT * FROM guru ORDER BY id_guru DESC');
?>
<!doctype html><html lang="id"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Data Guru</title><link rel="stylesheet" href="../assets/css/style.css"></head>
<body><?php include '../assets/templates/topbar_public.php'; ?>
<div class="main-content container">
<h1>Data Guru</h1>
<?php if($canEdit): ?>
<div class="card">
<h3><?php echo $editData ? 'Edit Guru' : 'Tambah Guru'; ?></h3>
<form method="POST" style="max-width:500px;">
<?php if($editData): ?><input type="hidden" name="id" value="<?php echo $editData['id_guru'];?>"><?php endif; ?>
<input type="text" name="nama" placeholder="Nama Guru" value="<?php echo $editData ? htmlspecialchars($editData['nama_guru']) : '';?>" required style="width:100%;padding:8px;margin:5px 0;">
<input type="text" name="nip" placeholder="NIP" value="<?php echo $editData ? htmlspecialchars($editData['nip']) : '';?>" required style="width:100%;padding:8px;margin:5px 0;">
<input type="text" name="mapel" placeholder="Mata Pelajaran" value="<?php echo $editData ? htmlspecialchars($editData['mapel']) : '';?>" required style="width:100%;padding:8px;margin:5px 0;">
<button type="submit" name="<?php echo $editData ? 'edit' : 'add';?>" class="btn" style="margin-top:10px;"><?php echo $editData ? 'Update' : 'Tambah';?></button>
<?php if($editData): ?><a href="guru.php" class="btn-outline" style="margin-left:10px;">Batal</a><?php endif; ?>
</form>
</div>
<?php endif; ?>
<div class="card">
<table class="data-table">
<thead><tr><th>No</th><th>Nama</th><th>NIP</th><th>Mapel</th><?php if($canEdit): ?><th>Aksi</th><?php endif; ?></tr></thead>
<tbody>
<?php $i=1; while($r=$res->fetch_assoc()): ?>
<tr>
<td><?php echo $i++;?></td>
<td><?php echo htmlspecialchars($r['nama_guru']);?></td>
<td><?php echo htmlspecialchars($r['nip']);?></td>
<td><?php echo htmlspecialchars($r['mapel']);?></td>
<?php if($canEdit): ?>
<td>
<a href="?edit=<?php echo $r['id_guru'];?>" class="btn-outline" style="font-size:12px;padding:4px 8px;">Edit</a>
<a href="?del=<?php echo $r['id_guru'];?>" onclick="return confirm('Hapus data ini?')" class="btn" style="font-size:12px;padding:4px 8px;background:#e74c3c;">Hapus</a>
</td>
<?php endif; ?>
</tr>
<?php endwhile; ?>
</tbody>
</table>
</div>
</div>
</body></html>