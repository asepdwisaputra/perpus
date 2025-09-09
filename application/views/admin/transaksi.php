<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Transaksi</title>
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
    rel="stylesheet" />
  <link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" />
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="<?php echo base_url('assets/admin/css/style.css'); ?>" />
  <script src="<?= base_url('assets/admin/js/script.js'); ?>"></script>
  <!-- FavIcon -->
  <link
    rel="icon"
    href="<?= base_url('assets/img/LogoSMP.webp') ?>"
    type="image/webp">

  <!-- DataTables CSS -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">

  <!-- DataTables FixedHeader CSS -->
  <link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.4.0/css/fixedHeader.bootstrap5.min.css">

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
        <a href="<?= base_url('transaksi') ?>" class="nav-link active">
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
    <h2>Transaksi Peminjaman dan Pengembalian</h2>

    <!-- Flash Data Penambahan Data -->
    <?php if ($this->session->flashdata('error')): ?>
      <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
        <?= $this->session->flashdata('error'); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    <?php endif; ?>

    <?php if ($this->session->flashdata('success')): ?>
      <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
        <?= $this->session->flashdata('success'); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    <?php endif; ?>


    <div class="row mt-4">
      <div class="col-12">
        <div class="card">
          <div
            class="card-header bg-success text-white d-flex align-items-center gap-2 flex-nowrap">
            <!-- Tombol Unduh -->
            <button class="btn btn-light flex-shrink-0" data-bs-toggle="modal" data-bs-target="#modalUnduh">
              <i class="bi bi-download"></i>
              <span class="d-none d-md-inline">Unduh Data</span>
            </button>


            <!-- Form Pencarian Transaksi -->
            <form action="<?= base_url('transaksi/search') ?>" method="get" class="flex-grow-1">
              <div class="input-group">
                <input
                  type="text"
                  name="keyword"
                  class="form-control"
                  placeholder="Cari transaksi..."
                  value="<?= isset($_GET['keyword']) ? $_GET['keyword'] : '' ?>" />
                <button type="submit" class="input-group-text bg-light" style="border: none; background: transparent;">
                  <i class="bi bi-search"></i>
                </button>
              </div>
            </form>


            <!-- Tombol Tambah Transaksi -->
            <button
              class="btn btn-light flex-shrink-0"
              data-bs-toggle="modal"
              data-bs-target="#modalTambahTransaksi">
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
                    <th>Nama Peminjam</th>
                    <th>Nomor Anggota</th>
                    <th>Judul Buku</th>
                    <th>ID Buku</th>
                    <th>Tanggal Pinjam</th>
                    <th>Tanggal Kembali</th>
                    <th>Status</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $no = 1;
                  foreach ($transaksi as $row): ?>
                    <tr>
                      <td><?= $no++ ?></td>
                      <td><?= $row->nama ?></td>
                      <td><?= $row->no_anggota ?></td>
                      <td><?= $row->judul ?></td>
                      <td><?= $row->no_buku ?></td>
                      <td><?= $row->tanggal_pinjam ?></td>
                      <td><?= $row->tanggal_kembali ?></td>
                      <td><?= $row->status ?></td>
                      <td>
                        <!-- Tombol Kembalikan -->
                        <form method="post" action="<?= base_url('transaksi/kembalikan') ?>" style="display:inline;">
                          <input type="hidden" name="id_transaksi" value="<?= $row->id_transaksi ?>">
                          <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('Yakin ingin mengembalikan buku ini?')">
                            <i class="bi bi-check-circle"></i> Kembalikan
                          </button>
                        </form>


                        <!-- Tombol Perpanjang -->
                        <form method="post" action="<?= base_url('transaksi/perpanjang') ?>" style="display:inline;">
                          <input type="hidden" name="id_transaksi" value="<?= $row->id_transaksi ?>">
                          <button type="submit" class="btn btn-warning btn-sm" onclick="return confirm('Perpanjang 7 hari dari tanggal kembali?')">
                            <i class="bi bi-arrow-repeat"></i> Perpanjang
                          </button>
                        </form>


                        <!-- Tombol Edit -->
                        <button
                          class="btn btn-primary btn-sm"
                          data-bs-toggle="modal"
                          data-bs-target="#modalEdit"
                          data-id="<?= $row->id_transaksi ?>"
                          data-nama="<?= $row->nama ?>"
                          data-judul="<?= $row->judul ?>"
                          data-tanggal_pinjam="<?= $row->tanggal_pinjam ?>"
                          data-tanggal_kembali="<?= $row->tanggal_kembali ?>"
                          data-status="<?= $row->status ?>"
                          onclick="setEditTransaksi(this)">
                          <i class="bi bi-pencil"></i> Edit
                        </button>



                        <!-- Tombol Hapus -->
                        <button
                          class="btn btn-danger btn-sm"
                          data-id="<?= $row->id_transaksi ?>"
                          data-bs-toggle="modal"
                          data-bs-target="#modalHapus"
                          onclick="setDeleteTransaksi(this)">
                          Hapus
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

    <!-- Modal Edit -->
    <div
      class="modal fade"
      id="modalEdit"
      tabindex="-1"
      aria-labelledby="modalEditLabel"
      aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalEditLabel">Edit Transaksi</h5>
            <button
              type="button"
              class="btn-close"
              data-bs-dismiss="modal"
              aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form method="post" action="<?= base_url('transaksi/update') ?>">
              <input type="hidden" name="id_transaksi" id="editIdTransaksi">

              <div class="mb-3">
                <label class="form-label">Nama Peminjam</label>
                <input type="text" class="form-control" id="editNamaPeminjam" readonly>
              </div>

              <div class="mb-3">
                <label class="form-label">Judul Buku</label>
                <input type="text" class="form-control" id="editJudulBuku" readonly>
              </div>

              <div class="mb-3">
                <label class="form-label">Tanggal Pinjam</label>
                <input type="date" class="form-control" id="editTanggalPinjam" name="tanggal_pinjam" required>
              </div>

              <div class="mb-3">
                <label class="form-label">Tanggal Kembali</label>
                <input type="date" class="form-control" id="editTanggalKembali" name="tanggal_kembali" required>
              </div>

              <div class="mb-3">
                <label class="form-label">Status</label>
                <select class="form-control" name="status" id="editStatus" required>
                  <option value="dipinjam">Dipinjam</option>
                  <option value="dikembalikan">Dikembalikan</option>
                </select>
              </div>

              <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </form>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal Hapus -->
    <div class="modal fade" id="modalHapus" tabindex="-1" aria-labelledby="modalHapusLabel" aria-hidden="true">
      <div class="modal-dialog">
        <form method="post" action="<?= base_url('transaksi/delete') ?>">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="modalHapusLabel">Konfirmasi Hapus</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <input type="hidden" name="id_transaksi" id="hapusIdTransaksi">
              <p>Apakah Anda yakin ingin menghapus transaksi ini?</p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
              <button type="submit" class="btn btn-danger">Hapus</button>
            </div>
          </div>
        </form>
      </div>
    </div>

    <!-- Modal Tambah Transaksi -->
    <div class="modal fade" id="modalTambahTransaksi" tabindex="-1" aria-labelledby="modalTambahLabel" aria-hidden="true">
      <div class="modal-dialog">
        <form method="post" action="<?= base_url('transaksi/tambah') ?>">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="modalTambahLabel">Tambah Transaksi</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">

              <!-- Pilih Anggota
              <div class="mb-3">
                <label class="form-label">Pilih Anggota</label>
                <select name="id_anggota" class="form-control" onchange="isiNama(this)" required>
                  <option value="">-- Pilih Anggota --</option>
                  <?php foreach ($anggota as $a): ?>
                    <option value="<?= $a->id_anggota ?>" data-nama="<?= $a->nama ?>">
                      <?= $a->no_anggota ?> - <?= $a->nama ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              </div> -->

              <!-- Nama Peminjam -->
              <div class="mb-3">
                <label class="form-label">Nama Peminjam</label>
                <select name="id_anggota" class="form-control" required>
                  <option value="">-- Pilih Anggota --</option>
                  <?php foreach ($anggota as $a): ?>
                    <option value="<?= $a->id_anggota ?>">
                      <?= $a->nama ?> (<?= $a->no_anggota ?>)
                    </option>
                  <?php endforeach; ?>
                </select>
              </div>

              <!-- Pilih Buku -->
              <div class="mb-3">
                <label class="form-label">Pilih Buku</label>
                <select name="id_buku" class="form-control" onchange="isiJudul(this)" required>
                  <option value="">-- Pilih Buku --</option>
                  <?php foreach ($buku as $b): ?>
                    <option value="<?= $b->id_buku ?>" data-judul="<?= $b->judul ?>">
                      <?= $b->no_buku ?> - <?= $b->judul ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              </div>

              <!-- Judul Buku
              <div class="mb-3">
                <label class="form-label">Judul Buku</label>
                <select name="id_buku" class="form-control" required>
                  <option value="">-- Pilih Buku --</option>
                  <?php foreach ($buku as $b): ?>
                    <option value="<?= $b->id_buku ?>">
                      <?= $b->judul ?> (<?= $b->no_buku ?>)
                    </option>
                  <?php endforeach; ?>
                </select>
              </div> -->

              <!-- Tanggal Pinjam -->
              <div class="mb-3">
                <label class="form-label">Tanggal Pinjam</label>
                <input type="date" name="tanggal_pinjam" class="form-control" id="tanggalPinjam" required>
              </div>

              <!-- Tanggal Kembali -->
              <div class="mb-3">
                <label class="form-label">Tanggal Kembali</label>
                <input type="date" name="tanggal_kembali" class="form-control" id="tanggalKembali" required>
              </div>

              <!-- Status -->
              <div class="mb-3">
                <label class="form-label">Status</label>
                <input type="text" name="status" class="form-control" value="Dipinjam" readonly>
              </div>

            </div>

            <div class="modal-footer">
              <button type="submit" class="btn btn-success">Simpan</button>
            </div>
          </div>
        </form>
      </div>
    </div>

    <!-- Modal Unduh Data dengan Rentang Tanggal -->
    <div class="modal fade" id="modalUnduh" tabindex="-1" aria-labelledby="modalUnduhLabel" aria-hidden="true">
      <div class="modal-dialog">
        <form method="get" action="<?= base_url('transaksi/export') ?>"> <!-- 🔧 ganti method sesuai controller kamu -->
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="modalUnduhLabel">Unduh Data Transaksi</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <div class="mb-3">
                <label for="tanggal_awal" class="form-label">Tanggal Awal</label>
                <input type="date" class="form-control" id="tanggal_awal" name="tanggal_awal" required>
              </div>
              <div class="mb-3">
                <label for="tanggal_akhir" class="form-label">Tanggal Akhir</label>
                <input type="date" class="form-control" id="tanggal_akhir" name="tanggal_akhir" required>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
              <button type="submit" class="btn btn-success">
                <i class="bi bi-download"></i> Unduh
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>

</body>

<script>
  // Modal Edit Transaksi
  function setEditTransaksi(button) {
    console.log("Status dari tombol:", button.getAttribute('data-status'));

    document.getElementById('editIdTransaksi').value = button.getAttribute('data-id');
    document.getElementById('editNamaPeminjam').value = button.getAttribute('data-nama');
    document.getElementById('editJudulBuku').value = button.getAttribute('data-judul');
    document.getElementById('editTanggalPinjam').value = button.getAttribute('data-tanggal_pinjam');
    document.getElementById('editTanggalKembali').value = button.getAttribute('data-tanggal_kembali');
    document.getElementById('editStatus').value = button.getAttribute('data-status');
  }

  // Modal Hapus
  function setDeleteTransaksi(button) {
    const id = button.getAttribute('data-id');

    console.log("ID yang mau dihapus:", id); // jujur ga suka debuginggg aaaa

    document.getElementById('hapusIdTransaksi').value = id;
  }

  // Auto set tanggal pinjam hari ini, kembali 7 hari kemudian
  document.addEventListener("DOMContentLoaded", function() {
    const today = new Date();
    const pinjam = today.toISOString().split('T')[0];
    document.getElementById('tanggalPinjam').value = pinjam;

    const kembali = new Date();
    kembali.setDate(kembali.getDate() + 7);
    document.getElementById('tanggalKembali').value = kembali.toISOString().split('T')[0];
  });

  // script auto fill isi Nama
  function isiNama(select) {
    var nama = select.options[select.selectedIndex].getAttribute('data-nama');
    document.getElementById('namaAnggota').value = nama;
  }

  // script auto fill isi Judul
  function isiJudul(select) {
    var judul = select.options[select.selectedIndex].getAttribute('data-judul');
    document.getElementById('judulBuku').value = judul;
  }

  // // Auto-hide setelah 4 detik (4000 ms) elemen flashdata
  document.addEventListener("DOMContentLoaded", function() {
    const alerts = document.querySelectorAll(".alert");
    alerts.forEach(alert => {
      setTimeout(() => {
        alert.classList.remove("show"); // trigger animasi fade out
        setTimeout(() => alert.remove(), 500); // hapus elemen setelah animasi selesai
      }, 4000);
    });
  });
</script>

</html>