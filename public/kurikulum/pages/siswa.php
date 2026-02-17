<?php
session_start();
include '../config/db.php';
$canEdit = !empty($_SESSION['admin']);

if($_SERVER['REQUEST_METHOD']==='POST' && $canEdit){
    if(isset($_POST['add'])){
        $nama=$_POST['nama']; $nis=$_POST['nis']; $id_kelas=intval($_POST['id_kelas']); $jk=$_POST['jk'];
        $stmt=$conn->prepare('INSERT INTO siswa (nama_siswa,nis,id_kelas,jk) VALUES (?,?,?,?)'); 
        $stmt->bind_param('ssis',$nama,$nis,$id_kelas,$jk); 
        $stmt->execute(); 
        header('Location:siswa.php'); exit;
    }
    if(isset($_POST['edit'])){
        $id=intval($_POST['id']); $nama=$_POST['nama']; $nis=$_POST['nis']; $id_kelas=intval($_POST['id_kelas']); $jk=$_POST['jk'];
        $stmt=$conn->prepare('UPDATE siswa SET nama_siswa=?,nis=?,id_kelas=?,jk=? WHERE id_siswa=?');
        $stmt->bind_param('ssisi',$nama,$nis,$id_kelas,$jk,$id);
        $stmt->execute();
        header('Location:siswa.php'); exit;
    }
}
if(!empty($_GET['del']) && $canEdit){ 
    $id=intval($_GET['del']); 
    $conn->query('DELETE FROM siswa WHERE id_siswa='.$id); 
    header('Location:siswa.php'); exit;
}

$editData = null;
if(!empty($_GET['edit'])){
    $id=intval($_GET['edit']);
    $editData = $conn->query('SELECT * FROM siswa WHERE id_siswa='.$id)->fetch_assoc();
}

$kelas = $conn->query('SELECT id_kelas,nama_kelas FROM kelas ORDER BY nama_kelas');
$res = $conn->query("SELECT s.*,k.nama_kelas FROM siswa s LEFT JOIN kelas k ON s.id_kelas=k.id_kelas ORDER BY s.id_siswa DESC");
?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Data Siswa</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <?php include '../assets/templates/topbar_public.php'; ?>
    <div class="main-content container">
        <h1>Data Siswa</h1>
        <?php if($canEdit): ?>
        <div class="card">
        <h3><?php echo $editData ? 'Edit Siswa' : 'Tambah Siswa'; ?></h3>
        <form method="POST" style="max-width:500px;">
        <?php if($editData): ?><input type="hidden" name="id" value="<?php echo $editData['id_siswa'];?>"><?php endif; ?>
        <input type="text" name="nama" placeholder="Nama Siswa" value="<?php echo $editData ? htmlspecialchars($editData['nama_siswa']) : '';?>" required style="width:100%;padding:8px;margin:5px 0;">
        <input type="text" name="nis" placeholder="NIS" value="<?php echo $editData ? htmlspecialchars($editData['nis']) : '';?>" required style="width:100%;padding:8px;margin:5px 0;">
        <select name="id_kelas" required style="width:100%;padding:8px;margin:5px 0;">
        <option value="">Pilih Kelas</option>
        <?php $kelas->data_seek(0); while($k=$kelas->fetch_assoc()): ?>
        <option value="<?php echo $k['id_kelas'];?>" <?php echo ($editData && $editData['id_kelas']==$k['id_kelas']) ? 'selected' : '';?>><?php echo htmlspecialchars($k['nama_kelas']);?></option>
        <?php endwhile; ?>
        </select>
        <select name="jk" required style="width:100%;padding:8px;margin:5px 0;">
        <option value="">Jenis Kelamin</option>
        <option value="L" <?php echo ($editData && $editData['jk']=='L') ? 'selected' : '';?>>Laki-laki</option>
        <option value="P" <?php echo ($editData && $editData['jk']=='P') ? 'selected' : '';?>>Perempuan</option>
        </select>
        <button type="submit" name="<?php echo $editData ? 'edit' : 'add';?>" class="btn" style="margin-top:10px;"><?php echo $editData ? 'Update' : 'Tambah';?></button>
        <?php if($editData): ?><a href="siswa.php" class="btn-outline" style="margin-left:10px;">Batal</a><?php endif; ?>
        </form>
        </div>
        <?php endif; ?>
        <div class="card">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Siswa</th>
                        <th>NIS</th>
                        <th>Kelas</th>
                        <th>JK</th>
                        <?php if($canEdit): ?><th>Aksi</th><?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    while ($r = $res->fetch_assoc()):
                    ?>
                    <tr>
                        <td><?php echo $i++; ?></td>
                        <td><?php echo htmlspecialchars($r['nama_siswa']); ?></td>
                        <td><?php echo htmlspecialchars($r['nis']); ?></td>
                        <td><?php echo htmlspecialchars($r['nama_kelas'] ?? ''); ?></td>
                        <td><?php echo htmlspecialchars($r['jk'] ?? ''); ?></td>
                        <?php if($canEdit): ?>
                        <td>
                        <a href="?edit=<?php echo $r['id_siswa'];?>" class="btn-outline" style="font-size:12px;padding:4px 8px;">Edit</a>
                        <a href="?del=<?php echo $r['id_siswa'];?>" onclick="return confirm('Hapus data ini?')" class="btn" style="font-size:12px;padding:4px 8px;background:#e74c3c;">Hapus</a>
                        </td>
                        <?php endif; ?>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>