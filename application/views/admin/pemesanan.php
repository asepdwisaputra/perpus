<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Pemesanan</title>
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
        <a href="<?= base_url('pemesanan') ?>" class="nav-link active">
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
    <h2>Daftar Pemesanan Buku</h2>

    <div class="row mt-4">
      <div class="col-12">
        <div class="card">
          <div class="card-header bg-primary text-white d-flex align-items-center gap-2 flex-nowrap">
            <!-- Tombol Unduh
            <a href="<?= base_url('pemesanan/export') ?>" class="btn btn-light flex-shrink-0">
              <i class="bi bi-download"></i>
              <span class="d-none d-md-inline">Unduh Data</span>
            </a> -->

            <!-- Form Pencarian -->
            <form action="<?= base_url('pemesanan') ?>" method="get" class="input-group flex-grow-1">
              <input type="text" name="keyword" class="form-control" placeholder="Cari pemesanan..."
                value="<?= $this->input->get('keyword') ?>">
              <button type="submit" class="input-group-text bg-light">
                <i class="bi bi-search"></i>
              </button>
            </form>
          </div>

          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Nama Peminjam</th>
                    <th>Nomor Induk</th>
                    <th>Judul Buku</th>
                    <th>ID Buku</th>
                    <th>Tanggal Pemesanan</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $no = 1;
                  foreach ($pemesanan as $row): ?>
                    <tr>
                      <td><?= $no++ ?></td>
                      <td><?= $row->nama ?></td>
                      <td><?= $row->no_anggota ?></td>
                      <td><?= $row->judul ?></td>
                      <td><?= $row->no_buku ?></td>
                      <td><?= $row->tanggal_pesan ?></td>
                      <td>
                        <!-- Tombol Terima -->
                        <a href="<?= base_url('pemesanan/terima/' . $row->id_pemesanan) ?>" class="btn btn-success btn-sm"
                          onclick="return confirm('Terima pemesanan ini?')">
                          <i class="bi bi-check-circle"></i> Terima
                        </a>

                        <!-- Tombol Tolak -->
                        <a href="<?= base_url('pemesanan/tolak/' . $row->id_pemesanan) ?>" class="btn btn-danger btn-sm"
                          onclick="return confirm('Tolak pemesanan ini?')">
                          <i class="bi bi-x-circle"></i> Tolak
                        </a>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
              <?php if (empty($pemesanan)): ?>
                <div class="alert alert-warning text-center" role="alert">
                  Tidak ada data pemesanan ditemukan.
                </div>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>


  <script>
    // Alert Notif WA
    document.querySelectorAll('.kirim-wa').forEach(function(button) {
      button.addEventListener('click', function(e) {
        e.preventDefault();
        const url = this.getAttribute('href');

        fetch(url)
          .then(response => response.json())
          .then(data => {
            if (data.status) {
              const alertBox = document.getElementById('alertBox');
              alertBox.textContent = "WhatsApp berhasil dikirim!";
              alertBox.classList.remove('d-none');

              setTimeout(() => {
                alertBox.classList.add('d-none');
              }, 1000); // Sembunyikan setelah 3 detik
            } else {
              alert("Gagal mengirim WhatsApp.");
            }
          })
          .catch(error => {
            alert("Terjadi kesalahan saat mengirim.");
          });
      });
    });
  </script>

</body>

</html>