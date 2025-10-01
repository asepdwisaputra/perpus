<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Anggota</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" />
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="<?php echo base_url('assets/admin/css/style.css'); ?>" />
  <script src="<?= base_url('assets/admin/js/script.js'); ?>"></script>

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
        <img src="https://tse4.mm.bing.net/th?id=OIP.pTrDvyZYuYmCE1Op-cARRwHaHa&pid=Api&P=0&h=220" alt="Logo"
          style="width: 100px; height: auto; margin-bottom: 10px" />
      </li>
      <li class="nav-item">
        <a href="<?= base_url('dashboard') ?>" class="nav-link">
          <i class="bi bi-house"></i> <span>Dashboard</span>
        </a>
      </li>
      <li class="nav-item">
        <a href="<?= base_url('anggota') ?>" class="nav-link active">
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
    </ul>
  </div>

  <div class="content">
    <h2>Data Anggota</h2>
    <div class="row mt-4">
      <div class="col-12">
        <div class="card">
          <div class="card">
            <div class="card-header bg-success text-white d-flex align-items-center gap-2 flex-nowrap">

              <!-- Tombol Unduh -->
              <button class="btn btn-light flex-shrink-0" onclick="window.location.href='<?= base_url('anggota/export') ?>'">
                <i class="bi bi-download"></i>
                <span class="d-none d-md-inline">Unduh Data</span>
              </button>

              <!-- Input Pencarian -->
              <form action="<?= base_url('anggota/search') ?>" method="get" class="input-group flex-grow-1">
                <input type="text" id="searchInput" name="keyword" class="form-control" placeholder="Cari anggota..." value="<?= isset($_GET['keyword']) ? $_GET['keyword'] : '' ?>" />
                <button type="submit" class="input-group-text bg-light" style="border: none; background: transparent;">
                  <i class="bi bi-search"></i>
                </button>
              </form>




              <!-- Tombol Tambah -->
              <button class="btn btn-light flex-shrink-0" data-bs-toggle="modal" data-bs-target="#modalTambahAnggota">
                <i class="bi bi-plus-circle"></i>
                <span class="d-none d-md-inline">Tambah</span>
              </button>

            </div>
          </div>


        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table id="tableAnggota" class="table table-striped">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Nama</th>
                  <th>Nomor Anggota</th>
                  <th>Nomor Telepon</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php $no = 1;
                foreach ($anggota as $row): ?>
                  <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $row->nama ?></td>
                    <td><?= $row->no_anggota ?></td>
                    <td><?= $row->telepon ?></td>
                    <td>
                      <!-- Tombol Edit -->
                      <!-- <button
                        class="btn btn-warning btn-sm"
                        data-bs-toggle="modal"
                        data-bs-target="#modalEditAnggota"
                        onclick="setEditData('<?= htmlspecialchars($row->nama, ENT_QUOTES) ?>', '<?= $row->no_anggota ?>', '<?= $row->telepon ?>')">
                        <i class="bi bi-pencil"></i> Edit
                      </button> -->
                      <button
                        class="btn btn-warning btn-sm"
                        data-bs-toggle="modal"
                        data-bs-target="#modalEditAnggota"
                        data-nama="<?= htmlspecialchars($row->nama, ENT_QUOTES) ?>"
                        data-no_anggota="<?= htmlspecialchars($row->no_anggota, ENT_QUOTES) ?>"
                        data-telepon="<?= htmlspecialchars($row->telepon, ENT_QUOTES) ?>"
                        onclick="setEditData(this)">
                        <i class="bi bi-pencil"></i> Edit
                      </button>


                      <!-- Tombol Hapus -->
                      <button class="btn btn-danger btn-sm"
                        data-bs-toggle="modal"
                        data-bs-target="#modalHapus"
                        onclick="setDeleteData('<?= htmlspecialchars($row->no_anggota, ENT_QUOTES) ?>')">
                        <i class="bi bi-trash"></i> Hapus
                      </button>
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

  <!-- Modal Tambah Anggota -->
  <div class="modal fade" id="modalTambahAnggota" tabindex="-1" aria-labelledby="modalTambahAnggotaLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalTambahAnggotaLabel">
            Tambah Anggota
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <!-- Untuk #modalTambahAnggota agar ketika error masih ada riwayat isinya -->
          <?php
          $old_input = $this->session->flashdata('old_input');
          $form_error = $this->session->flashdata('form_error');
          ?>
          <!-- FORM DIMULAI -->
          <form action="<?= base_url('anggota/add') ?>" method="post">
            <div class="mb-3">
              <label class="form-label">Nama</label>
              <input type="text" name="nama" class="form-control" placeholder="Masukkan Nama"
                value="<?= isset($old_input['nama']) ? $old_input['nama'] : '' ?>" required />
            </div>
            <div class="mb-3">
              <label class="form-label">Nomor Anggota</label>
              <input type="text" name="no_anggota" class="form-control <?= isset($form_error) ? 'is-invalid' : '' ?>"
                placeholder="Masukkan Nomor Anggota"
                value="<?= isset($old_input['no_anggota']) ? $old_input['no_anggota'] : '' ?>" required />
              <?php if (isset($form_error)): ?>
                <div class="invalid-feedback"><?= $form_error ?></div>
              <?php endif; ?>
            </div>

            <div class="mb-3">
              <label class="form-label">Nomor Telepon</label>
              <input type="text" name="telepon" class="form-control" placeholder="Masukkan Nomor Telepon"
                value="<?= isset($old_input['telepon']) ? $old_input['telepon'] : '' ?>" required />
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
              <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
          </form>
          <!-- FORM BERAKHIR -->
        </div>
      </div>
    </div>
  </div>


  <!-- Modal Edit Anggota -->
  <div class="modal fade" id="modalEditAnggota" tabindex="-1" aria-labelledby="modalEditAnggotaLabel" aria-hidden="true">
    <div class="modal-dialog">
      <form action="<?= base_url('anggota/update') ?>" method="post">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Edit Anggota</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <input type="hidden" name="no_anggota_lama" id="editNoAnggotaLama">

            <div class="mb-3">
              <label>Nama</label>
              <input type="text" class="form-control" name="nama" id="editNama" required>
            </div>
            <div class="mb-3">
              <label>Nomor Anggota</label>
              <input type="text" class="form-control" name="no_anggota" id="editNoAnggota" required>
            </div>
            <div class="mb-3">
              <label>Telepon</label>
              <input type="text" class="form-control" name="telepon" id="editTelepon" required>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
          </div>
        </div>
      </form>
    </div>
  </div>


  <!-- Modal Hapus -->
  <div
    class="modal fade"
    id="modalHapus"
    tabindex="-1"
    aria-labelledby="modalHapusLabel"
    aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalHapusLabel">Konfirmasi Hapus</h5>
          <button
            type="button"
            class="btn-close"
            data-bs-dismiss="modal"
            aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p>Apakah Anda yakin ingin menghapus anggota ini?</p>
        </div>
        <div class="modal-footer">
          <button
            type="button"
            class="btn btn-secondary"
            data-bs-dismiss="modal">
            Batal
          </button>
          <!-- Form hapus dengan input hidden untuk nomor anggota -->
          <form action="<?= base_url('anggota/delete') ?>" method="POST">
            <input type="hidden" name="no_anggota" id="deleteNoAnggota"> <!-- Hidden input untuk nomor anggota -->
            <button type="submit" class="btn btn-danger">Hapus</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  </div>
  <script>
    // Menampilkan modal secara otomatis setelah halaman dimuat
    <?php if ($this->session->flashdata('form_error')): ?>
      var modalTambah = new bootstrap.Modal(document.getElementById('modalTambahAnggota'));
      modalTambah.show();
    <?php endif; ?>

    // EDIT ANGGOTA berdasar No Anggota - MODAL
    function setEditData(btn) {
      const nama = btn.dataset.nama;
      const noAnggota = btn.dataset.no_anggota;
      const telepon = btn.dataset.telepon;

      document.getElementById("editNama").value = nama;
      document.getElementById("editNoAnggota").value = noAnggota;
      document.getElementById("editNoAnggotaLama").value = noAnggota; // tetap dipakai di WHERE
      document.getElementById("editTelepon").value = telepon;
    }
  </script>

</body>

</html>