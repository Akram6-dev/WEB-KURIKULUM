<?php
session_start();
include '../config/db.php';
$canEdit = !empty($_SESSION['admin']);

if($_SERVER['REQUEST_METHOD']==='POST' && $canEdit){
    if(isset($_POST['add'])){
        $id_kelas=intval($_POST['id_kelas']); $judul=$_POST['judul']; $deskripsi=$_POST['deskripsi']; $tanggal=date('Y-m-d');
        $stmt=$conn->prepare('INSERT INTO materi (id_kelas,judul,deskripsi,tanggal_upload) VALUES (?,?,?,?)'); 
        $stmt->bind_param('isss',$id_kelas,$judul,$deskripsi,$tanggal); 
        $stmt->execute(); 
        header('Location:materi.php'); exit;
    }
    if(isset($_POST['edit'])){
        $id=intval($_POST['id']); $id_kelas=intval($_POST['id_kelas']); $judul=$_POST['judul']; $deskripsi=$_POST['deskripsi'];
        $stmt=$conn->prepare('UPDATE materi SET id_kelas=?,judul=?,deskripsi=? WHERE id_materi=?');
        $stmt->bind_param('issi',$id_kelas,$judul,$deskripsi,$id);
        $stmt->execute();
        header('Location:materi.php'); exit;
    }
}
if(!empty($_GET['del']) && $canEdit){ 
    $id=intval($_GET['del']); 
    $conn->query('DELETE FROM materi WHERE id_materi='.$id); 
    header('Location:materi.php'); exit;
}

$editData = null;
if(!empty($_GET['edit'])){
    $id=intval($_GET['edit']);
    $editData = $conn->query('SELECT * FROM materi WHERE id_materi='.$id)->fetch_assoc();
}

$kelasOpt = $conn->query('SELECT id_kelas,nama_kelas FROM kelas ORDER BY nama_kelas');
$res=$conn->query('SELECT m.*,k.nama_kelas FROM materi m LEFT JOIN kelas k ON m.id_kelas=k.id_kelas ORDER BY m.tanggal_upload DESC');
?>
<!doctype html><html lang="id"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Materi</title><link rel="stylesheet" href="../assets/css/style.css"></head>
<body><?php include '../assets/templates/topbar_public.php'; ?>
<div class="main-content container">
<h1>Ruang Materi</h1>
<?php if($canEdit): ?>
<div class="card">
<h3><?php echo $editData ? 'Edit Materi' : 'Tambah Materi'; ?></h3>
<form method="POST" style="max-width:600px;">
<?php if($editData): ?><input type="hidden" name="id" value="<?php echo $editData['id_materi'];?>"><?php endif; ?>
<select name="id_kelas" required style="width:100%;padding:8px;margin:5px 0;">
<option value="">Pilih Kelas</option>
<?php $kelasOpt->data_seek(0); while($k=$kelasOpt->fetch_assoc()): ?>
<option value="<?php echo $k['id_kelas'];?>" <?php echo ($editData && $editData['id_kelas']==$k['id_kelas']) ? 'selected' : '';?>><?php echo htmlspecialchars($k['nama_kelas']);?></option>
<?php endwhile; ?>
</select>
<input type="text" name="judul" placeholder="Judul Materi" value="<?php echo $editData ? htmlspecialchars($editData['judul']) : '';?>" required style="width:100%;padding:8px;margin:5px 0;">
<textarea name="deskripsi" placeholder="Deskripsi Materi" required style="width:100%;padding:8px;margin:5px 0;min-height:100px;"><?php echo $editData ? htmlspecialchars($editData['deskripsi']) : '';?></textarea>
<button type="submit" name="<?php echo $editData ? 'edit' : 'add';?>" class="btn" style="margin-top:10px;"><?php echo $editData ? 'Update' : 'Tambah';?></button>
<?php if($editData): ?><a href="materi.php" class="btn-outline" style="margin-left:10px;">Batal</a><?php endif; ?>
</form>
</div>
<?php endif; ?>
<div class="card">
<?php while($r=$res->fetch_assoc()): ?>
<div style="border:1px solid #e5e7eb;padding:15px;margin:10px 0;border-radius:8px;">
<h3 style="margin:0 0 8px 0;color:#1f2937;"><?php echo htmlspecialchars($r['judul']);?></h3>
<p style="color:#6b7280;font-size:14px;margin:5px 0;"><strong>Kelas:</strong> <?php echo htmlspecialchars($r['nama_kelas']);?> | <strong>Tanggal:</strong> <?php echo date('d M Y',strtotime($r['tanggal_upload']));?></p>
<p style="margin:10px 0;color:#374151;"><?php echo nl2br(htmlspecialchars($r['deskripsi']));?></p>
<?php if($canEdit): ?>
<div style="margin-top:10px;">
<a href="?edit=<?php echo $r['id_materi'];?>" class="btn-outline" style="font-size:12px;padding:4px 8px;">Edit</a>
<a href="?del=<?php echo $r['id_materi'];?>" onclick="return confirm('Hapus materi ini?')" class="btn" style="font-size:12px;padding:4px 8px;background:#e74c3c;">Hapus</a>
</div>
<?php endif; ?>
</div>
<?php endwhile; ?>
</div>
</div>
</body></html>