<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Denda</title>
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
        <a href="<?= base_url('denda') ?>" class="nav-link active">
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
    <h2>Denda Keterlambatan</h2>
    <div class="row mt-4">
      <div class="col-12">
        <div class="card">
          <div class="card-header bg-danger text-white d-flex align-items-center gap-2 flex-nowrap">

            <!-- Tombol Unduh -->
            <a href="<?= base_url('denda/export_csv') ?>" class="btn btn-light flex-shrink-0">
              <i class="bi bi-download"></i>
              <span class="d-none d-md-inline">Unduh Data</span>
            </a>


            <!-- Input Pencarian -->
            <form action="<?= base_url('denda') ?>" method="get" class="input-group flex-grow-1">
              <input type="text" name="keyword" class="form-control" placeholder="Cari data..." value="<?= $this->input->get('keyword') ?>">
              <button type="submit" class="input-group-text bg-light">
                <i class="bi bi-search"></i>
              </button>
            </form>

          </div>

          <div class="card-body">
            <div class="table-responsive">

              <!-- Alert muncul saat tombol WA ditekan -->
              <div id="alertBox" class="alert alert-success d-none" role="alert">
                WhatsApp berhasil dikirim!
              </div>

              <table class="table table-striped">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Nama Peminjam</th>
                    <th>Nomor Anggota</th>
                    <th>Judul Buku</th>
                    <th>ID Buku</th>
                    <th>Tanggal Kembali</th>
                    <th>Hari Terlambat</th>
                    <th>Total Denda</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $no = 1;
                  $denda_per_hari = 1000;
                  foreach ($denda as $row):
                    $tgl_kembali = new DateTime($row->tanggal_kembali);
                    $hari_ini = new DateTime();
                    $selisih = $hari_ini->diff($tgl_kembali)->days;
                    $total_denda = $selisih * $denda_per_hari;
                  ?>
                    <tr>
                      <td><?= $no++ ?></td>
                      <td><?= $row->nama ?></td>
                      <td><?= $row->no_anggota ?></td>
                      <td><?= $row->judul ?></td>
                      <td><?= $row->no_buku ?></td>
                      <td><?= $row->tanggal_kembali ?></td>
                      <td><?= $selisih ?></td>
                      <td>Rp <?= number_format($total_denda, 0, ',', '.') ?></td>
                      <td>
                        <a href="<?= base_url('whatsapp/kirim/' . $row->id_transaksi) ?>"
                          class="btn btn-success btn-sm kirim-wa"
                          data-id="<?= $row->id_transaksi ?>">
                          <i class="bi bi-whatsapp"></i> WhatsApp
                        </a>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Edit Denda -->
  <div
    class="modal fade"
    id="modalEditDenda"
    tabindex="-1"
    aria-labelledby="modalEditDendaLabel"
    aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalEditDendaLabel">Edit Denda</h5>
          <button
            type="button"
            class="btn-close"
            data-bs-dismiss="modal"
            aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form>
            <div class="mb-3">
              <label class="form-label">Nama Peminjam</label>
              <input
                type="text"
                class="form-control"
                id="editNamaPeminjam"
                readonly />
            </div>
            <div class="mb-3">
              <label class="form-label">Total Denda</label>
              <input
                type="text"
                class="form-control"
                id="editTotalDenda"
                required />
            </div>
            <button type="submit" class="btn btn-primary">
              Simpan Perubahan
            </button>
          </form>
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
            const alertBox = document.getElementById('alertBox');

            if (data.status) {
              alertBox.textContent = "✅ WhatsApp berhasil dikirim!";
              alertBox.classList.remove('d-none', 'alert-danger');
              alertBox.classList.add('alert-success');
            } else {
              alertBox.textContent = "❌ Gagal mengirim WhatsApp: " + (data.error || "Unknown error");
              alertBox.classList.remove('d-none', 'alert-success');
              alertBox.classList.add('alert-danger');
            }

            // Sembunyikan otomatis setelah 3 detik
            setTimeout(() => {
              alertBox.classList.add('d-none');
            }, 3000);
          })
          .catch(error => {
            const alertBox = document.getElementById('alertBox');
            alertBox.textContent = "⚠️ Terjadi kesalahan: " + error;
            alertBox.classList.remove('d-none', 'alert-success');
            alertBox.classList.add('alert-danger');

            setTimeout(() => {
              alertBox.classList.add('d-none');
            }, 3000);
          });
      });
    });
  </script>

</body>

</html>