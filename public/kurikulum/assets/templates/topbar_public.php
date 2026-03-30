<header class="sidebar" id="sidebar">
  <div class="logo" onclick="toggleSidebar()">
    <img src="../assets/images/Gambar_SMKN_1SUBANG.png" alt="SMKN 1 Subang" id="logoImg">
  </div>
  <ul id="menuList">
    <li><a href="index.php">Beranda</a></li>
    <li><a href="guru.php">Data Guru</a></li>
    <li><a href="siswa.php">Data Siswa</a></li>
    <li><a href="jadwal.php">Jadwal</a></li>
    <li><a href="wali_kelas.php">Wali Kelas</a></li>
    <li style="margin-top:12px;">
    <?php if(!empty($_SESSION['admin'])): ?>
      <a class="btn" href="logout.php" style="background:#ef4444;">Logout</a>
    <?php else: ?>
      <a class="btn" href="login.php">Masuk</a>
    <?php endif; ?>
    </li>
  </ul>
</header>
<script>
function toggleSidebar() {
  const sidebar = document.getElementById('sidebar');
  const mainContent = document.querySelector('.main-content');
  const footer = document.getElementById('footer');
  const menuList = document.getElementById('menuList');
  const logoImg = document.getElementById('logoImg');
  
  sidebar.classList.toggle('closed');
  if(mainContent) mainContent.classList.toggle('sidebar-closed');
  if(footer) footer.classList.toggle('sidebar-closed');
  
  if(sidebar.classList.contains('closed')) {
    menuList.style.display = 'none';
    logoImg.style.width = '40px';
  } else {
    menuList.style.display = 'block';
    logoImg.style.width = '80px';
  }
}
</script>
