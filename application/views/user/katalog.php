<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Katalog Buku</title>
  <!-- BS Icon -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

  <link
    rel="icon"
    href="https://play-lh.googleusercontent.com/uAF15Nq_GbYjxFiRricfK5x18Y5Zu8WhJr65GukdZtmsuaHVk3cNxE8e3S7LO6XMTJc"
    type="image/png" />
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
    rel="stylesheet" />
  <link rel="stylesheet" href="<?php echo base_url('assets/admin/css/style.css'); ?>" />
  <style>
    html,
    body {
      height: 100%;
      margin: 0;
      display: flex;
      flex-direction: column;
    }

    main {
      flex: 1;
    }

    body {
      padding-bottom: 100px;
    }

    .footer {
      position: absolute;
      bottom: 0;
      width: 100%;
      height: 5vh;
      background-color: #0d6efd;
      color: white;
      display: flex;
      align-items: center;
      justify-content: center;
    }
  </style>
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
      <a class="navbar-brand" href="<?= base_url() ?>">← Kembali</a>
      <span class="navbar-text text-white">Katalog Buku</span>
    </div>
  </nav>

  <div class="container mt-5">
    <h2 class="text-center">Katalog Buku</h2>
    <p class="text-center mb-4">
      Jelajahi koleksi buku di Perpustakaan Barul 'Ulum. Gunakan pencarian
      untuk menemukan buku yang Anda cari.
    </p>

    <!-- Form Cari.. -->
    <div class="mb-3">
      <form action="<?= base_url('user/katalog/search') ?>" method="get" class="input-group flex-grow-1">
        <input type="text" id="searchInput" name="keyword" class="form-control" placeholder="Cari buku..." value="<?= isset($_GET['keyword']) ? $_GET['keyword'] : '' ?>" />
        <button type="submit" class="input-group-text bg-white text-dark">
          <i class="bi bi-search"></i>
        </button>
      </form>
    </div>

    <!-- Tabel Katalog -->
    <div class="table-responsive">
      <table class="table table-bordered table-striped" id="bookTable">
        <thead class="table-primary">
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
          <?php $no = 1; ?>
          <?php foreach ($buku as $b): ?>
            <tr>
              <td><?= $no++ ?></td>
              <td><?= $b->no_buku ?></td>
              <td><?= $b->judul ?></td>
              <td><?= $b->penulis ?></td>
              <td><?= $b->penerbit ?></td>
              <td><?= $b->rak ?></td>
              <td>
                <button
                  type="button"
                  class="btn btn-sm btn-success"
                  onclick="bukaForm('<?= $b->id_buku ?>', '<?= htmlspecialchars($b->judul, ENT_QUOTES) ?>')">
                  Pinjam
                </button>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>

      </table>
      <p class="mb-4">
        <i>hanya menampilkan buku dengan status tersedia</i>
      </p>
    </div>
  </div>

  <!-- Modal Peminjaman -->
  <div
    class="modal fade"
    id="modalPinjam"
    tabindex="-1"
    aria-labelledby="modalPinjamLabel"
    aria-hidden="true">
    <div class="modal-dialog">
      <form action="<?= base_url('pemesanan/pesan') ?>" method="post" class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalPinjamLabel">
            Formulir Pemesanan Buku
          </h5>
          <button
            type="button"
            class="btn-close"
            data-bs-dismiss="modal"
            aria-label="Tutup"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="no_anggota" class="form-label">Nomor Anggota</label>
            <input type="number" class="form-control" id="no_anggota" name="no_anggota" required />
          </div>
          <div class="mb-3">
            <label for="id_buku" class="form-label">Judul Buku</label>
            <input type="hidden" id="id_buku" name="id_buku" />
            <input type="text" class="form-control" id="buku" readonly />
          </div>
          <div class="mb-3">
            <label for="tanggal" class="form-label">Tanggal Pesan</label>
            <input type="date" class="form-control" id="tanggal" value="<?= date('Y-m-d') ?>" readonly />
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Ajukan</button>
        </div>
      </form>
    </div>
  </div>

  <script>
    function bukaForm(id_buku, judul) {
      // Isi field di modal
      document.getElementById('id_buku').value = id_buku;
      document.getElementById('buku').value = judul;

      // Tampilkan modal
      var modal = new bootstrap.Modal(document.getElementById('modalPinjam'));
      modal.show();
    }
  </script>


  <!-- Footer -->
  <footer class="footer">
    <p class="mb-0">&copy; 2025 Perpustakaan Barul 'Ulum</p>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    function filterTable() {
      const input = document
        .getElementById("searchInput")
        .value.toLowerCase();
      const rows = document.querySelectorAll("#bookTable tbody tr");
      rows.forEach((row) => {
        const title = row.cells[1].textContent.toLowerCase();
        row.style.display = title.includes(input) ? "" : "none";
      });
    }
  </script>
</body>

</html>