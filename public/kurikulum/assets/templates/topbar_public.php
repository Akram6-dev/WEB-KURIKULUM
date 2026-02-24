<header class="sidebar" id="sidebar">
  <div class="logo" onclick="toggleSidebar()">
    <img src="/kurikulum/assets/images/Gambar_SMKN_1SUBANG.png" alt="SMKN 1 Subang">
  </div>
  <ul>
    <li><a href="/kurikulum/index.php">Beranda</a></li>
    <li><a href="/kurikulum/pages/guru.php">Data Guru</a></li>
    <li><a href="/kurikulum/pages/siswa.php">Data Siswa</a></li>
    <li><a href="/kurikulum/pages/jadwal.php">Jadwal</a></li>
    <li style="margin-top:12px;">
    <?php if(!empty($_SESSION['admin'])): ?>
      <a class="btn" href="/kurikulum/logout.php" style="background:#ef4444;">Logout</a>
    <?php else: ?>
      <a class="btn" href="/kurikulum/login.php">Masuk</a>
    <?php endif; ?>
    </li>
  </ul>
</header>
<script>
function toggleSidebar() {
  const sidebar = document.getElementById('sidebar');
  const mainContent = document.querySelector('.main-content');
  const footer = document.getElementById('footer');
  
  sidebar.classList.toggle('open');
  if(mainContent) mainContent.classList.toggle('sidebar-open');
  if(footer) footer.classList.toggle('sidebar-open');
  
  // Simpan state ke localStorage
  const isOpen = sidebar.classList.contains('open');
  localStorage.setItem('sidebarOpen', isOpen);
}

// Load state dari localStorage saat halaman dimuat
window.addEventListener('DOMContentLoaded', function() {
  const sidebar = document.getElementById('sidebar');
  const mainContent = document.querySelector('.main-content');
  const footer = document.getElementById('footer');
  const isOpen = localStorage.getItem('sidebarOpen') === 'true';
  
  if(isOpen) {
    sidebar.classList.add('open');
    if(mainContent) mainContent.classList.add('sidebar-open');
    if(footer) footer.classList.add('sidebar-open');
  }
});
</script>