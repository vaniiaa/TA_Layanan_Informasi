<header id="header" class="header">

    <!-- Tombol Sidebar -->
    <button id="toggleSidebar" class="menu-btn">☰</button>

    <!-- Logout -->
    <form id="logoutForm" action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="button" class="logout-btn" onclick="confirmLogout()">
            Logout
        </button>
    </form>

</header>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
function confirmLogout() {
    Swal.fire({
        title: 'Konfirmasi Logout',
        text: 'Apakah Anda yakin ingin keluar dari sistem?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#022D57',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Logout',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('logoutForm').submit();
        }
    });
}
</script>
<style>
/* HEADER */
.header {
  position: fixed;
  top: 0;
  left: 250px;
  width: calc(100% - 250px);
  height: 60px;
  background: #022D57;

  display: flex;
  align-items: center;
  justify-content: space-between; /* ⬅️ penting untuk kiri-kanan */

  padding: 0 20px;
  transition: all 0.3s ease;
  z-index: 1050;
}

/* SAAT SIDEBAR DITUTUP */
.header.full {
  left: 0;
  width: 100%;
}

/* TOMBOL MENU */
.menu-btn {
  background: none;
  border: none;
  color: #ffffff;
  font-size: 24px;
  cursor: pointer;
  padding: 4px 8px;
  line-height: 1;
}

/* TOMBOL LOGOUT */
.logout-btn {
  color: white;
  background: none;
  border: none;
  cursor: pointer;
  font-size: 14px;
}

.logout-btn:hover {
  text-decoration: underline;
}
</style>