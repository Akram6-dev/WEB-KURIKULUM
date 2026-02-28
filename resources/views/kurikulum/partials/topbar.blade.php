<header class="sidebar" id="sidebar">
  <div class="logo" onclick="toggleSidebar()">
    <img src="{{ asset('kurikulum/assets/images/Gambar_SMKN_1SUBANG.png') }}" alt="SMKN 1 Subang" id="logoImg">
  </div>
  <ul id="menuList">
    <li><a href="{{ route('kurikulum.index') }}">Beranda</a></li>
    <li><a href="{{ route('kurikulum.guru.index') }}">Data Guru</a></li>
    <li><a href="{{ route('kurikulum.siswa.index') }}">Data Siswa</a></li>
    <li><a href="{{ route('kurikulum.jadwal.index') }}">Jadwal</a></li>
    <li style="margin-top:12px;">
    @if(session('admin'))
      <a class="btn" href="{{ route('kurikulum.logout') }}" style="background:#ef4444;">Logout</a>
    @else
      <a class="btn" href="{{ route('kurikulum.login') }}">Masuk</a>
    @endif
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
