<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Perpustakaan Barul 'Ulum</title>
  <link
    rel="icon"
    href="https://play-lh.googleusercontent.com/uAF15Nq_GbYjxFiRricfK5x18Y5Zu8WhJr65GukdZtmsuaHVk3cNxE8e3S7LO6XMTJc"
    type="image/png" />
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
    rel="stylesheet" />
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css"
    rel="stylesheet" />
  <style>
    h1 {
      margin-top: 40px;
      margin-bottom: 20px;
    }

    .card-icon {
      font-size: 40px;
      color: #0d6efd;
      margin-bottom: 10px;
    }

    .footer {
      background-color: #0d6efd;
      color: white;
      padding: 50px 0 20px;
    }

    .footer i {
      width: 25px;
    }

    .footer a {
      color: #fff;
      text-decoration: none;
    }

    .footer a:hover {
      text-decoration: underline;
    }

    #carouselInformasi img {
      border-radius: 8px;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    }

    /* Navbar brand responsive font */
    @media (max-width: 576px) {

      /* xs/small devices */
      .navbar-brand {
        font-size: 1rem !important;
        /* mengecilkan font brand */
      }

      .navbar-nav .nav-link {
        font-size: 0.9rem;
        /* mengecilkan font menu */
      }
    }
  </style>
</head>

<body>
  <!-- Navbar -->
  <nav
    class="navbar navbar-expand-lg navbar-dark"
    style="background: linear-gradient(90deg, #0d6efd, #6610f2)">
    <div class="container py-2">
      <a
        class="navbar-brand d-flex align-items-center fw-bold"
        href="#"
        style="font-size: 1.25rem">
        <img
          src="<?php echo base_url('assets/img/logoSMP.webp'); ?>"
          alt="Logo"
          width="45"
          height="45"
          class="me-2 rounded-circle shadow" />
        <span class="text-white">Perpustakaan Barul 'Ulum</span>
      </a>
      <button
        class="navbar-toggler border-0"
        type="button"
        data-bs-toggle="collapse"
        data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div
        class="collapse navbar-collapse justify-content-end"
        id="navbarNav">
        <ul class="navbar-nav align-items-center">
          <li class="nav-item mx-2">
            <a
              class="nav-link text-white fw-semibold d-flex align-items-center"
              href="<?= base_url('user/katalog') ?>">
              <i class="bi bi-book me-1 fs-5"></i> Katalog Buku
            </a>
          </li>
          <li class="nav-item mx-2">
            <a
              class="nav-link text-white fw-semibold d-flex align-items-center"
              href="<?= base_url('user/login_admin') ?>">
              <i class="bi bi-person-circle me-1 fs-5"></i> Login Admin
            </a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Carousel -->
  <div id="carouselInformasi" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">
      <div class="carousel-item active">
        <img
          src="<?php echo base_url('assets/img/banner1.webp'); ?>"
          class="d-block w-100"
          alt="Slide 1"
          style="max-height: 400px; object-fit: cover" />
      </div>
      <div class="carousel-item">
        <img
          src="<?php echo base_url('assets/img/banner2.webp'); ?>"
          class="d-block w-100"
          alt="Slide 2"
          style="max-height: 400px; object-fit: cover" />
      </div>
    </div>

    <!-- Controls -->
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselInformasi" data-bs-slide="prev">
      <span class="carousel-control-prev-icon"></span>
      <span class="visually-hidden">Sebelumnya</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselInformasi" data-bs-slide="next">
      <span class="carousel-control-next-icon"></span>
      <span class="visually-hidden">Berikutnya</span>
    </button>
  </div>



  <!-- Tentang Perpustakaan -->
  <div class="container text-center">
    <h1 class="fw-bold">Tentang Perpustakaan</h1>
    <p class="lead">
      Perpustakaan Barul 'Ulum merupakan pusat informasi dan literasi di SMP
      Istiqomah Sambas Purbalingga yang hadir untuk mendukung proses belajar
      mengajar serta menumbuhkan budaya baca bagi civitas sekolah.
    </p>
  </div>

  <!-- Visi Misi Nilai -->
  <div class="container my-5">
    <h2 class="text-center mb-4">Visi, Misi & Nilai</h2>
    <div class="row text-center">
      <div class="col-md-4 mb-4">
        <div class="card shadow-sm h-100">
          <div class="card-body">
            <i
              class="bi bi-lightbulb-fill text-primary mb-3"
              style="font-size: 2.5rem"></i>
            <h5 class="card-title fw-bold">Visi</h5>
            <p class="card-text">
              Menjadi perpustakaan unggulan berbasis teknologi yang mendukung
              pembelajaran dan pembentukan karakter literat.
            </p>
          </div>
        </div>
      </div>
      <div class="col-md-4 mb-4">
        <div class="card shadow-sm h-100">
          <div class="card-body">
            <i
              class="bi bi-compass-fill text-success mb-3"
              style="font-size: 2.5rem"></i>
            <h5 class="card-title fw-bold">Misi</h5>
            <p class="card-text">
              Menyediakan akses informasi yang berkualitas, ramah, dan mudah
              dijangkau untuk seluruh warga sekolah.
            </p>
          </div>
        </div>
      </div>
      <div class="col-md-4 mb-4">
        <div class="card shadow-sm h-100">
          <div class="card-body">
            <i
              class="bi bi-gem text-warning mb-3"
              style="font-size: 2.5rem"></i>
            <h5 class="card-title fw-bold">Nilai</h5>
            <p class="card-text">
              Inklusif, integritas, inovasi, kolaboratif, dan pelayanan prima.
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Layanan Kami -->
  <div class="container my-5">
    <h2 class="text-center mb-4">Layanan Kami</h2>
    <div class="row text-center">
      <div class="col-md-3 col-sm-6 mb-4">
        <div class="card shadow-sm h-100">
          <div class="card-body">
            <i class="bi bi-wifi card-icon"></i>
            <h5 class="card-title">Akses Internet</h5>
            <p class="card-text">
              Fasilitas Wi-Fi gratis untuk pengunjung perpustakaan.
            </p>
          </div>
        </div>
      </div>
      <div class="col-md-3 col-sm-6 mb-4">
        <div class="card shadow-sm h-100">
          <div class="card-body">
            <i class="bi bi-journal-bookmark card-icon"></i>
            <h5 class="card-title">Koleksi Buku</h5>
            <p class="card-text">
              Beragam koleksi buku siap dibaca dan dipinjam.
            </p>
          </div>
        </div>
      </div>
      <div class="col-md-3 col-sm-6 mb-4">
        <div class="card shadow-sm h-100">
          <div class="card-body">
            <i class="bi bi-laptop card-icon"></i>
            <h5 class="card-title">Ruang Multimedia</h5>
            <p class="card-text">
              Ruang komputer multimedia dengan perangkat terkini.
            </p>
          </div>
        </div>
      </div>
      <div class="col-md-3 col-sm-6 mb-4">
        <div class="card shadow-sm h-100">
          <div class="card-body">
            <i class="bi bi-headset card-icon"></i>
            <h5 class="card-title">Layanan Konsultasi</h5>
            <p class="card-text">
              Support dari staf perpustakaan.
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Section Katalog Buku -->
  <section class="py-5 bg-light">
    <div class="container text-center">
      <h2 class="fw-bold mb-3">Katalog Buku</h2>
      <p class="lead mb-4">
        Jelajahi koleksi buku di
        <strong>Perpustakaan Barul 'Ulum</strong> dengan mudah dan cepat.
      </p>

      <!-- Grid Preview Buku -->
      <div class="row justify-content-center mb-4">
        <div class="col-md-3 col-6 mb-4">
          <div class="card h-100 shadow-sm">
            <img
              src="https://bukukita.com/babacms/displaybuku/118303_f.jpg"
              class="card-img-top"
              alt="Kartun Fisika" />
            <div class="card-body p-2">
              <p class="card-title small fw-semibold mb-0">Kartun Fisika</p>
            </div>
          </div>
        </div>
        <div class="col-md-3 col-6 mb-4">
          <div class="card h-100 shadow-sm">
            <img
              src="https://cdn.gramedia.com/uploads/items/9786024813338.jpg"
              class="card-img-top"
              alt="Kartun Kimia" />
            <div class="card-body p-2">
              <p class="card-title small fw-semibold mb-0">Kartun Kimia</p>
            </div>
          </div>
        </div>
        <div class="col-md-3 col-6 mb-4">
          <div class="card h-100 shadow-sm">
            <img
              src="https://cdn.gramedia.com/uploads/picture_meta/2023/11/27/kjf6cgigkomf6sy9o5qauu.jpg"
              class="card-img-top"
              alt="Filosofi Teras" />
            <div class="card-body p-2">
              <p class="card-title small fw-semibold mb-0">Filosofi Teras</p>
            </div>
          </div>
        </div>
      </div>

      <a href="<?= base_url('user/katalog') ?>" class="btn btn-primary btn-lg px-4">
        <i class="bi bi-search me-2"></i>Telusuri Katalog
      </a>
    </div>
  </section>

  <!-- Footer + Hubungi Kami -->
  <footer class="footer text-white bg-primary pt-5">
    <div class="container">
      <div class="row text-center text-md-start">
        <div class="col-md-4 mb-4">
          <h5 class="fw-bold">Perpustakaan Barul 'Ulum</h5>
          <p class="small">
            Perpustakaan Barul 'Ulum merupakan pusat informasi dan literasi di
            SMP Istiqomah Sambas Purbalingga yang hadir untuk mendukung proses
            belajar mengajar serta menumbuhkan budaya baca bagi civitas
            sekolah.
          </p>
        </div>
        <div class="col-md-4 mb-4">
          <h6 class="fw-bold mb-3">
            <i class="bi bi-geo-alt-fill me-2"></i>Alamat
          </h6>
          <p class="small mb-2">
            Jl. AW Sumarmo No.52A<br />
            Kabupaten Purbalingga,<br />
            Jawa Tengah 53311
          </p>
          <h6 class="fw-bold mb-3 mt-4">
            <i class="bi bi-clock-fill me-2"></i>Jam Operasional
          </h6>
          <p class="small mb-0">
            <strong>Senin - Jumat</strong> : 06:15 - 14:15 WIB
          </p>
          <p class="small"><strong>Sabtu</strong> : 06:15 - 13:00 WIB</p>
        </div>
        <div class="col-md-4 mb-4">
          <h6 class="fw-bold mb-3">
            <i class="bi bi-telephone-fill me-2"></i>Kontak
          </h6>
          <p class="small mb-1">
            <i class="bi bi-telephone me-2"></i>(0281) 895635
          </p>
          <p class="small mb-1">
            <i class="bi bi-envelope me-2"></i>smpistiqomahsambaspbg@gmail.com
          </p>
        </div>
      </div>
      <hr style="border-color: rgba(255, 255, 255, 0.3)" />
      <p class="text-center small mb-0">
        &copy; 2025 Perpustakaan Barul 'Ulum. All rights reserved.
      </p>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>