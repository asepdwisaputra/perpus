<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Denda</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" />
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="<?php echo base_url('assets/admin/css/style.css'); ?>" />
  <script src="<?php echo base_url('assets/admin/js/script.js'); ?>"></script>
  <!-- FavIcon -->
  <link
    rel="icon"
    href="<?= base_url('assets/img/LogoSMP.webp') ?>"
    type="image/webp">
</head>

<body>
  <button class="mobile-menu-button d-md-none" onclick="toggleSidebar()">
    ☰
  </button>
  <div id="overlay" class="overlay" onclick="toggleSidebar()"></div>

  <div id="sidebar" class="sidebar">
    <ul class="nav flex-column p-3">
      <li class="nav-item text-center">
        <img
          src="https://tse4.mm.bing.net/th?id=OIP.pTrDvyZYuYmCE1Op-cARRwHaHa&pid=Api&P=0&h=220"
          alt="Logo"
          style="width: 100px; height: auto; margin-bottom: 10px" />
      </li>
      <li class="nav-item">
        <a href="<?= base_url('dashboard') ?>" class="nav-link">
          <i class="bi bi-house"></i> <span>Dashboard</span>
        </a>
      </li>
      <li class="nav-item">
        <a href="<?= base_url('anggota') ?>" class="nav-link">
          <i class="bi bi-people"></i> <span>Anggota</span>
        </a>
      </li>
      <li class="nav-item">
        <a href="<?= base_url('buku') ?>" class="nav-link">
          <i class="bi bi-book"></i> <span>Buku</span>
        </a>
      </li>
      <li class="nav-item">
        <a href="<?= base_url('transaksi') ?>" class="nav-link">
          <i class="bi bi-shuffle"></i> <span>Transaksi</span>
        </a>
      </li>
      <li class="nav-item">
        <a href="<?= base_url('denda') ?>" class="nav-link">
          <i class="bi bi-cash"></i> <span>Denda</span>
        </a>
      </li>
      <li class="nav-item">
        <a href="<?= base_url('pemesanan') ?>" class="nav-link">
          <i class="bi bi-journal-bookmark"></i> <span>Pemesanan</span>
        </a>
      </li>
      <li class="nav-item">
        <a href="<?= base_url('auth/confirm_logout') ?>" class="nav-link active ">
          <i class="bi bi-box-arrow-right"></i> <span>Logout</span>
        </a>
      </li>
      <!-- <li class="nav-item">
          <a href="unduh.html" class="nav-link"
            ><i class="bi bi-download"></i> <span>Unduh</span></a
          >
        </li> -->
    </ul>
  </div>

  <div class="content bg-light d-flex align-items-center justify-content-center vh-100">
    <div class="card shadow-lg text-center p-4" style="max-width: 400px; width: 100%;">
      <div class="card-body">
        <i class="bi bi-box-arrow-right display-1 text-danger"></i>
        <h3 class="mt-3 mb-4 text-dark">Anda yakin ingin logout?</h3>

        <div class="d-grid gap-2">
          <a href="<?= base_url('auth/logout') ?>" class="btn btn-danger">
            <i class="bi bi-check-circle me-2"></i>Ya, Logout
          </a>

          <a href="<?= base_url('dashboard') ?>" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-2"></i>Kembali ke Dashboard
          </a>
        </div>
      </div>
    </div>
  </div>


</body>

</html>