<!DOCTYPE html>
<html lang="id"  data-theme="light">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>BNNP Kepri Dashboard</title>
  <link rel="icon" href="{{ asset('image/logo BNN.png') }}" type="image/jpeg">
  @vite(['resources/css/app.css', 'resources/js/app.js'])

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

  <!-- Bootstrap 4 CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.6.2/css/bootstrap.min.css">
</head>

<body>
  @include('components.pemberantasan.sidebar')
  @include('components.pemberantasan.header')

  <main id="main-content" class="main-content">
    @yield('content')
  </main>

<style>
  .main-content {
  margin-left: 250px;
  margin-top: 60px;
  padding: 20px;
  transition: margin-left 0.3s ease;
}

.main-content.expanded {
  margin-left: 0;
}

</style>

  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.6.2/js/bootstrap.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
  const toggleBtn = document.getElementById('toggleSidebar');
  const sidebar = document.getElementById('sidebar');
  const header = document.getElementById('header');
  const mainContent = document.getElementById('main-content');

  if (toggleBtn && sidebar && header && mainContent) {
    toggleBtn.addEventListener('click', function () {
      sidebar.classList.toggle('closed');

      const isClosed = sidebar.classList.contains('closed');

      // KONTROL HEADER
      header.classList.toggle('full', isClosed);

      // KONTROL MAIN CONTENT
      mainContent.classList.toggle('expanded', isClosed);
    });
  }
});
</script>

</body>
</html>
