<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Buku</title>
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
    rel="stylesheet" />
  <link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" />
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="<?php echo base_url('assets/admin/css/style.css'); ?>" />
  <script src="<?= base_url('assets/admin/js/script.js'); ?>"></script>

  <!-- Favicon -->
  <link rel="icon" type="image/png" href="https://tse4.mm.bing.net/th?id=OIP.pTrDvyZYuYmCE1Op-cARRwHaHa&pid=Api&P=0&h=220">
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
        <a href="<?= base_url('buku') ?>" class="nav-link active">
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
    <h2>Data Buku</h2>
    <div class="row mt-4">
      <div class="col-12">
        <div class="card">
          <div
            class="card-header bg-success text-white d-flex align-items-center gap-2 flex-nowrap">
            <!-- Tombol Unduh -->
            <button class="btn btn-light flex-shrink-0" onclick="window.location.href='<?= base_url('buku/export') ?>'">
              <i class="bi bi-download"></i>
              <span class="d-none d-md-inline">Unduh Data</span>
            </button>

            <!-- Input Pencarian -->
            <form action="<?= base_url('buku/search') ?>" method="get" class="input-group flex-grow-1">
              <input type="text" id="searchInput" name="keyword" class="form-control" placeholder="Cari buku..." value="<?= isset($_GET['keyword']) ? $_GET['keyword'] : '' ?>" />
              <button type="submit" class="input-group-text bg-light" style="border: none; background: transparent;">
                <i class="bi bi-search"></i>
              </button>
            </form>

            <!-- Tombol Tambah Buku -->
            <button
              class="btn btn-light flex-shrink-0"
              data-bs-toggle="modal"
              data-bs-target="#modalTambahBuku">
              <i class="bi bi-plus-circle"></i>
              <span class="d-none d-md-inline">Tambah</span>
            </button>
          </div>

          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>No Buku</th>
                    <th>Judul Buku</th>
                    <th>Penulis</th>
                    <th>Penerbit</th>
                    <th>Rak</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $no = 1;
                  foreach ($buku as $row): ?>
                    <tr>
                      <td><?= $no++ ?></td>
                      <td><?= $row->no_buku ?></td>
                      <td><?= $row->judul ?></td>
                      <td><?= $row->penulis ?></td>
                      <td><?= $row->penerbit ?></td>
                      <td><?= $row->rak ?></td>
                      <td>
                        <!-- Tombol Edit -->
                        <button
                          class="btn btn-warning btn-sm"
                          data-bs-toggle="modal"
                          data-bs-target="#modalEditBuku"
                          onclick="setEditBuku('<?= htmlspecialchars($row->no_buku, ENT_QUOTES) ?>', '<?= $row->judul ?>', '<?= $row->penulis ?>', '<?= $row->penerbit ?>', '<?= $row->rak ?>')">
                          <i class="bi bi-pencil"></i> Edit
                        </button>

                        <!-- Tombol Hapus -->
                        <button
                          class="btn btn-danger btn-sm"
                          data-bs-toggle="modal"
                          data-bs-target="#modalHapus"
                          onclick="setDeleteBuku('<?= htmlspecialchars($row->no_buku, ENT_QUOTES) ?>')">
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
            <p>Apakah Anda yakin ingin menghapus buku ini?</p>
          </div>
          <div class="modal-footer">
            <button
              type="button"
              class="btn btn-secondary"
              data-bs-dismiss="modal">
              Batal
            </button>
            <!-- Form hapus dengan input hidden untuk nomor buku -->
            <form action="<?= base_url('buku/delete') ?>" method="POST">
              <input type="hidden" name="no_buku" id="deleteNoBuku"> <!-- Hidden input untuk nomor buku -->
              <button type="submit" class="btn btn-danger">Hapus</button>
            </form>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal Tambah Buku -->
    <div
      class="modal fade"
      id="modalTambahBuku"
      tabindex="-1"
      aria-labelledby="modalTambahBukuLabel"
      aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalTambahBukuLabel">Tambah Buku</h5>
            <button
              type="button"
              class="btn-close"
              data-bs-dismiss="modal"
              aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <!-- Untuk #modalTambahAnggota agar ketika error masih ada riwayat isinya -->
            <?php
            $old_input = $this->session->flashdata('old_input');
            $form_error = $this->session->flashdata('form_error');
            ?>
            <!-- Form Start -->
            <form action="<?= base_url('buku/add') ?>" method="post">
              <div class="mb-3">
                <label class="form-label">No Buku</label>
                <input type="text"
                  name="no_buku"
                  class="form-control <?= isset($form_error) ? 'is-invalid' : '' ?>"
                  placeholder="Masukkan No Buku"
                  value="<?= isset($old_input['no_buku']) ? $old_input['no_buku'] : '' ?>"
                  required />
                <?php if (isset($form_error)): ?>
                  <div class="invalid-feedback"><?= $form_error ?></div>
                <?php endif; ?>
              </div>

              <div class="mb-3">
                <label class="form-label">Judul Buku</label>
                <input type="text"
                  name="judul"
                  class="form-control"
                  placeholder="Masukkan Judul Buku"
                  value="<?= isset($old_input['judul']) ? $old_input['judul'] : '' ?>"
                  required />
              </div>

              <div class="mb-3">
                <label class="form-label">Penulis</label>
                <input type="text"
                  name="penulis"
                  class="form-control"
                  placeholder="Masukkan Nama Penulis"
                  value="<?= isset($old_input['penulis']) ? $old_input['penulis'] : '' ?>"
                  required />
              </div>

              <div class="mb-3">
                <label class="form-label">Penerbit</label>
                <input type="text"
                  name="penerbit"
                  class="form-control"
                  placeholder="Masukkan Nama Penerbit"
                  value="<?= isset($old_input['penerbit']) ? $old_input['penerbit'] : '' ?>"
                  required />
              </div>

              <div class="mb-3">
                <label class="form-label">No Rak</label>
                <input type="number"
                  name="rak"
                  class="form-control"
                  placeholder="Masukkan Nomor Rak"
                  value="<?= isset($old_input['rak']) ? $old_input['rak'] : '' ?>"
                  required />
              </div>

              <button type="submit" class="btn btn-success">Simpan Buku</button>
            </form>
            <!-- Form End -->


          </div>
        </div>
      </div>
    </div>

    <!-- Modal Edit Buku -->
    <div class="modal fade" id="modalEditBuku" tabindex="-1" aria-labelledby="modalEditBukuLabel" aria-hidden="true">
      <div class="modal-dialog">
        <form action="<?= base_url('buku/update') ?>" method="post">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Edit Buku</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
              <!-- Hidden input untuk no_buku lama -->
              <input type="hidden" name="no_buku_lama" id="editNoBukuLama">

              <div class="mb-3">
                <label>No Buku</label>
                <input type="text" class="form-control" name="no_buku" id="editNoBuku" required>
              </div>
              <div class="mb-3">
                <label>Judul Buku</label>
                <input type="text" class="form-control" name="judul" id="editJudulBuku" required>
              </div>
              <div class="mb-3">
                <label>Penulis</label>
                <input type="text" class="form-control" name="penulis" id="editPenulisBuku" required>
              </div>
              <div class="mb-3">
                <label>Penerbit</label>
                <input type="text" class="form-control" name="penerbit" id="editPenerbitBuku" required>
              </div>
              <div class="mb-3">
                <label>No Rak</label>
                <input type="number" class="form-control" name="rak" id="editRak" required>
              </div>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-success">Simpan Perubahan</button>
            </div>
          </div>
        </form>
      </div>
    </div>



  </div>

  <script>
    <?php if ($this->session->flashdata('form_error')): ?>
      var modalTambah = new bootstrap.Modal(document.getElementById('modalTambahBuku'));
      modalTambah.show();
    <?php endif; ?>

    // EDIT BUKU berdasarkan No Buku - MODAL
    function setEditBuku(no_buku, judul, penulis, penerbit, rak) {
      document.getElementById("editNoBuku").value = no_buku;
      document.getElementById("editNoBukuLama").value = no_buku;
      document.getElementById("editJudulBuku").value = judul;
      document.getElementById("editPenulisBuku").value = penulis;
      document.getElementById("editPenerbitBuku").value = penerbit;
      document.getElementById("editRak").value = rak;
    }

    // HAPUS BUKU berdasarkan No Buku - Modal
    function setDeleteBuku(noBuku) {
      document.getElementById("deleteNoBuku").value = noBuku;
    }
  </script>
</body>

</html>