<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>

<!DOCTYPE html>
<html lang="id">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>404 - Halaman Tidak Ditemukan</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
	<style>
		body {
			background: linear-gradient(135deg, #0d6efd, #6610f2);
			min-height: 100vh;
			display: flex;
			align-items: center;
			justify-content: center;
			color: white;
			text-align: center;
		}

		.error-container {
			max-width: 600px;
		}

		.error-code {
			font-size: 8rem;
			font-weight: bold;
			line-height: 1;
		}

		.btn-home {
			border-radius: 30px;
			padding: 10px 25px;
			font-weight: 500;
			box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
		}

		img.logo {
			width: 80px;
			margin-bottom: 20px;
		}
	</style>
</head>

<body>
	<div class="error-container">
		<div class="error-code">404</div>
		<h2 class="mb-3">Halaman Tidak Ditemukan</h2>
		<p class="mb-4">Ups! Sepertinya halaman yang Anda cari tidak tersedia di Perpustakaan Barul 'Ulum.
			Silakan kembali ke halaman utama untuk melanjutkan.</p>
		<a href="<?= base_url(); ?>" class="btn btn-light btn-home">⬅ Kembali ke Beranda</a>
	</div>
</body>

</html>