<style>
  /* === SIDEBAR STYLE === */
  .sidebar {
    width: 250px;
    background: #022D57;
    color: white;
    height: 100vh;
    position: fixed;
    top: 0;
    left: 0;
    padding-top: 60px;
    transition: transform 0.3s ease;
    z-index: 999;
    overflow-y: auto;
    box-shadow: 2px 0 10px rgba(0, 0, 0, 0.2);
    border-right: 1px solid rgba(255, 255, 255, 0.1);
  }

.sidebar.closed {
  transform: translateX(-250px);
}


  .sidebar ul {
    list-style: none;
    padding: 0;
    margin: 0;
  }

  .sidebar li {
    padding: 10px 18px;
    transition: all 0.3s ease;
  }

  .sidebar li:hover {
    background-color: rgba(255, 255, 255, 0.1);
    border-left: 4px solid #4FC3F7;
  }

  .sidebar a {
    color: white;
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 14px;
  }

  .sidebar a svg {
    width: 16px;
    height: 16px;
  }

  .toggle-btn {
    font-weight: 600;
    margin-top: 8px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    width: 100%;
    cursor: pointer;
    background: none;
    border: none;
    color: inherit;
    padding: 10px 18px;
    font-size: 14px;
    transition: all 0.3s ease;
  }

  .toggle-btn:hover {
    background-color: rgba(255, 255, 255, 0.1);
    border-left: 4px solid #4FC3F7;
  }

  .submenu {
    margin-left: 20px;
    margin-top: 5px;
    display: none;
  }

  .submenu.show {
    display: block;
    animation: fadeIn 0.3s ease;
  }

  @keyframes fadeIn {
    from {
      opacity: 0;
      transform: translateY(-5px);
    }
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }

  svg {
    transition: transform 0.3s ease;
  }

  .rotate-180 {
    transform: rotate(180deg);
  }

  /* Scrollbar halus */
  .sidebar::-webkit-scrollbar {
    width: 6px;
  }

  .sidebar::-webkit-scrollbar-thumb {
    background-color: rgba(255, 255, 255, 0.2);
    border-radius: 4px;
  }

  /* Judul di atas */
  .sidebar-title {
    text-align: center;
    font-weight: 700;
    font-size: 16px;
    letter-spacing: 1px;
    margin-bottom: 20px;
    color: #E3F2FD;
  }

  .divider {
    border-bottom: 1px solid rgba(255, 255, 255, 0.2);
    margin: 10px 0;
  }
    #togglePemberantasan, 
  #toggleRehab {
    justify-content: flex-start !important;
    text-align: left !important;
    gap: 10px;
  }

  /* Panah tetap di kanan */
  #togglePemberantasan svg, 
  #toggleRehab svg {
    margin-left: auto;
  }
</style>

<div class="sidebar" id="sidebar">
  <div class="sidebar-title">SILOFI ADMIN</div>
  <div class="divider"></div>

  <ul>
    <!-- Dashboard -->
    <li>
      <a href="/admin/dashboard">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M3 12l2-2m0 0l7-7 7 7m-9 2v8m4-8v8m5 0h2m-2 0a2 2 0 002-2v-8m0 0l-2-2m2 2l-7-7m0 0L5 10m0 0v8a2 2 0 002 2h2" />
        </svg>
        Dashboard
      </a>
    </li>
     <!-- Dashboard -->
    <li>
      <a href="/admin/tambah_akun">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 640 512" fill="currentColor">
    <path d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm89.6 32h-16.7c-22.2 10.3-46.9 16-72.9 16s-50.6-5.7-72.9-16h-16.7C60.1 288 0 348.1 0 422.4C0 471.9 40.1 512 89.6 512H358.4c-5.4-17.2-8.4-35.4-8.4-54.4c0-70.7 41.2-131.8 100.8-160.8C420.2 291.1 367.8 288 313.6 288zm302.4 96l-26.6-4.4c-2.2-7.3-5.1-14.2-8.5-20.8l15.7-22c6.5-9.1 5.4-21.5-2.6-29.5l-28.3-28.3c-8-8-20.4-9.1-29.5-2.6l-22 15.7c-6.6-3.4-13.5-6.3-20.8-8.5l-4.4-26.6c-1.8-10.8-11.2-18.8-22.2-18.8h-40c-11 0-20.4 8-22.2 18.8l-4.4 26.6c-7.3 2.2-14.2 5.1-20.8 8.5l-22-15.7c-9.1-6.5-21.5-5.4-29.5 2.6l-28.3 28.3c-8 8-9.1 20.4-2.6 29.5l15.7 22c-3.4 6.6-6.3 13.5-8.5 20.8l-26.6 4.4c-10.8 1.8-18.8 11.2-18.8 22.2v40c0 11 8 20.4 18.8 22.2l26.6 4.4c2.2 7.3 5.1 14.2 8.5 20.8l-15.7 22c-6.5 9.1-5.4 21.5 2.6 29.5l28.3 28.3c8 8 20.4 9.1 29.5 2.6l22-15.7c6.6 3.4 13.5 6.3 20.8 8.5l4.4 26.6c1.8 10.8 11.2 18.8 22.2 18.8h40c11 0 20.4-8 22.2-18.8l4.4-26.6c7.3-2.2 14.2-5.1 20.8-8.5l22 15.7c9.1 6.5 21.5 5.4 29.5-2.6l28.3-28.3c8-8 9.1-20.4 2.6-29.5l-15.7-22c3.4-6.6 6.3-13.5 8.5-20.8l26.6-4.4c10.8-1.8 18.8-11.2 18.8-22.2v-40c0-11-8-20.4-18.8-22.2zM480 448a64 64 0 1 1 0-128 64 64 0 1 1 0 128z"/>
</svg>
        Tambah Akun
      </a>
    </li>

    <!-- Bidang P2M -->
    <li>
      <button class="toggle-btn" id="toggleP2M">
        Kelola Bidang P2M
        <svg id="arrowP2M" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
          fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M19 9l-7 7-7-7" />
        </svg>
      </button>
      <ul id="submenuP2M" class="submenu">
        <li><a href="/admin/p2m/data_sekolah">Data Sekolah</a></li>
        <li><a href="/admin/p2m/sosialisasi">Permohonan Sosialisasi</a></li>
        <li><a href="/admin/p2m/kunjungan_wisata">Kunjungan Wisata Edukasi (DOEMBA)</a></li>
        <li><a href="/admin/p2m/materi_edukasi">Materi Edukasi</a></li>
      </ul>
    </li>

    <!-- Bidang Pemberantasan -->
    <li>
      <button class="toggle-btn" id="togglePemberantasan">
        Kelola Bidang Pemberantasan
        <svg id="arrowPemberantasan" xmlns="http://www.w3.org/2000/svg"
          class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M19 9l-7 7-7-7" />
        </svg>
      </button>
      <ul id="submenuPemberantasan" class="submenu">
        <li><a href="/admin/pemberantasan/publikasi_berita">Publikasi Berita</a></li>
        <li><a href="/admin/pemberantasan/data_tahanan">Data Tahanan</a></li>
        <li><a href="/admin/pemberantasan/besuk_tahanan">Besuk Tahanan</a></li>
        <li><a href="/admin/pemberantasan/assessment">Assessment Terpadu (TAT)</a></li>
      </ul>
    </li>

    <div class="divider"></div>
    <!-- Profile -->
    <li>
      <a href="/admin/profile">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M5.121 17.804A4 4 0 018 16h8a4 4 0 012.879 1.804M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
        </svg>
        Profile
      </a>
    </li>
  </ul>
</div>

<script>
  const menus = [
    { toggle: 'toggleUmum', submenu: 'submenuUmum', arrow: 'arrowUmum' },
    { toggle: 'toggleP2M', submenu: 'submenuP2M', arrow: 'arrowP2M' },
    { toggle: 'togglePemberantasan', submenu: 'submenuPemberantasan', arrow: 'arrowPemberantasan' },
    { toggle: 'toggleRehab', submenu: 'submenuRehab', arrow: 'arrowRehab' }
  ];

  menus.forEach(menu => {
    const toggleBtn = document.getElementById(menu.toggle);
    const submenu = document.getElementById(menu.submenu);
    const arrow = document.getElementById(menu.arrow);

    if (toggleBtn && submenu && arrow) {
      toggleBtn.addEventListener('click', () => {
        submenu.classList.toggle('show');
        arrow.classList.toggle('rotate-180');
      });
    }
  });
</script>
