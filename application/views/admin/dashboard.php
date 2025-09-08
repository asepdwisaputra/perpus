<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashboard Perpustakaan</title>
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
    rel="stylesheet" />
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
        <a href="<?= base_url('dashboard') ?>" class="nav-link active">
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
        <a href="<?= base_url('auth/confirm_logout') ?>" class="nav-link">
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

  <div class="content">
    <h2>Dashboard Perpustakaan</h2>
    <!-- Cardboard -->
    <div class="row text-center">
      <div class="col-md-4 col-12 mb-3">
        <div class="card text-white bg-primary">
          <a href="<?= base_url('anggota'); ?>" style="color: white; text-decoration: none;">
            <div class="card-body">
              <h5>Total Anggota</h5>
              <p><?= $total_anggota; ?></p>
            </div>
          </a>
        </div>
      </div>
      <div class="col-md-4 col-12 mb-3">
        <div class="card text-white bg-success">
          <a href="<?= base_url('buku'); ?>" style="color: white; text-decoration: none;">
            <div class="card-body">
              <h5>Total Buku</h5>
              <p><?= $total_buku; ?></p>
            </div>
          </a>
        </div>
      </div>
      <div class="col-md-4 col-12 mb-3">
        <div class="card text-white bg-warning">
          <div class="card-body">
            <h5>Peminjam Aktif</h5>
            <p><?= $total_peminjam; ?></p>
          </div>
        </div>
      </div>
    </div>


    <!-- Detail 5 Peminjam Terakhir -->
    <div class="row mt-4">
      <div class="col-12">
        <div class="card">
          <div class="card-header bg-success text-white">
            <h5 class="mb-0">5 Aktivitas Peminjaman Terakhir</h5>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Nama Peminjam</th>
                    <th>Judul Buku</th>
                    <th>Tanggal Pinjam</th>
                    <th>Tanggal Kembali</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if (!empty($peminjaman_terakhir)) : ?>
                    <?php $no = 1;
                    foreach ($peminjaman_terakhir as $p) : ?>
                      <tr>
                        <td><?= $no++; ?></td>
                        <td><?= htmlspecialchars($p->nama_anggota, ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?= htmlspecialchars($p->judul_buku, ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?= htmlspecialchars($p->tanggal_pinjam, ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?= htmlspecialchars($p->tanggal_kembali, ENT_QUOTES, 'UTF-8'); ?></td>
                      </tr>
                    <?php endforeach; ?>
                  <?php else : ?>
                    <tr>
                      <td colspan="5" class="text-center">Belum ada data peminjaman.</td>
                    </tr>
                  <?php endif; ?>
                </tbody>

              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

</html>