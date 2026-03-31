<header class="sidebar" id="sidebar">
  <div class="logo" onclick="toggleSidebar()">
    <img src="{{ asset('images/Gambar_SMKN_1SUBANG.png') }}" alt="SMKN 1 Subang" id="logoImg">
  </div>
  <ul id="menuList">
    <li><a href="{{ route('kurikulum.index') }}" class="{{ request()->routeIs('kurikulum.index') ? 'active' : '' }}">Beranda</a></li>
    <li><a href="{{ route('kurikulum.guru.index') }}" class="{{ request()->routeIs('kurikulum.guru.*') ? 'active' : '' }}">Data Guru</a></li>
    <li><a href="{{ route('kurikulum.siswa.index') }}" class="{{ request()->routeIs('kurikulum.siswa.*') ? 'active' : '' }}">Data Siswa</a></li>
    <li><a href="{{ route('kurikulum.jadwal.index') }}" class="{{ request()->routeIs('kurikulum.jadwal.*') ? 'active' : '' }}">Jadwal</a></li>
    <li><a href="{{ route('kurikulum.materi.index') }}" class="{{ request()->routeIs('kurikulum.materi.*') ? 'active' : '' }}">Materi</a></li>
    <li style="margin-top:12px;">
    @if(session('admin'))
      <a class="btn" href="{{ route('kurikulum.logout') }}" style="background:#ef4444;">Logout</a>
    @else
      <a class="btn" href="{{ route('kurikulum.login') }}">Masuk</a>
    @endif
    </li>
  </ul>
</header>
<style>
.sidebar ul li a.active {
  background: rgba(255,255,255,0.2);
  border-left: 4px solid #fff;
  padding-left: 12px;
  font-weight: bold;
  border-radius: 4px;
}
</style>
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
