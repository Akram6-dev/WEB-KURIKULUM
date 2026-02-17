<?php
session_start();
include 'config/db.php';
$error='';
if($_SERVER['REQUEST_METHOD']==='POST'){
    $u = $_POST['username'] ?? '';
    $p = $_POST['password'] ?? '';
    $stmt = $conn->prepare("SELECT * FROM admin WHERE username=? LIMIT 1");
    $stmt->bind_param('s',$u); $stmt->execute(); $res = $stmt->get_result();
    if($res && $res->num_rows){
        $row = $res->fetch_assoc();
        if($p === $row['password']){
            $_SESSION['admin'] = $u;
            header('Location: pages/dashboard.php'); exit;
        } else { $error='Password salah'; }
    } else { $error='User tidak ditemukan'; }
}
?>
<!doctype html><html lang="id"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Login Admin</title><link rel="stylesheet" href="assets/css/style.css"></head>
<body>
<?php include 'assets/templates/topbar_public.php'; ?>
<div class="main-content container">
  <div class="card" style="max-width:480px;margin:40px auto">
    <h2>Admin Login</h2>
    <?php if($error) echo '<p style="color:red">'.htmlspecialchars($error).'</p>'; ?>
    <form method="post">
      <label>Username</label><br>
      <input name="username" required style="width:100%;margin:8px 0;padding:10px"><br>
      <label>Password</label><br>
      <input name="password" type="password" required style="width:100%;margin:8px 0;padding:10px"><br>
      <button class="btn" type="submit">Masuk</button>
    </form>
    <p style="margin-top:12px;color:#6b7280">Admin only untuk edit. user: admin password: NESAS_CEREN</p>
  </div>
</div>
<?php include 'assets/templates/footer.php'; ?>
</body></html>