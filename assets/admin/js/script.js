//sidebar toggle
function toggleSidebar() {
	const sidebar = document.getElementById("sidebar");
	const overlay = document.getElementById("overlay");
	if (window.innerWidth <= 768) {
		sidebar.classList.toggle("active");
		overlay.classList.toggle("active");
	} else {
		sidebar.classList.toggle("collapsed");
	}
}

//sidebar menyala di background
document.querySelectorAll(".sidebar .nav-link").forEach((link) => {
	link.addEventListener("click", function () {
		document.querySelectorAll(".sidebar .nav-link").forEach((item) => {
			item.classList.remove("active");
		});
		this.classList.add("active");
	});
});

// menghilangkan burger saat mode dialog
document.addEventListener("DOMContentLoaded", function () {
	let mobileMenuButton = document.querySelector(".mobile-menu-button");

	document.querySelectorAll(".modal").forEach((modal) => {
		modal.addEventListener("show.bs.modal", function () {
			mobileMenuButton.style.display = "none";
		});

		modal.addEventListener("hidden.bs.modal", function () {
			mobileMenuButton.style.display = "";
		});
	});
});

// peminjaman
function cariAnggota() {
	let keyword = document.getElementById("searchAnggota").value;
	if (keyword.trim() === "") return;

	// Simulasi pencarian anggota
	let anggota = {
		id: "AG001",
		nama: "Arya Pratama",
		telepon: "081234567890",
	};

	document.getElementById("detailAnggota").innerHTML = `
    <div class='alert alert-info'>
      <strong>ID:</strong> ${anggota.id} <br>
      <strong>Nama:</strong> ${anggota.nama} <br>
      <strong>Telepon:</strong> ${anggota.telepon}
    </div>
  `;
}

function cariBuku() {
	let keyword = document.getElementById("searchBuku").value;
	if (keyword.trim() === "") return;

	// Simulasi pencarian buku
	let buku = {
		id: "BK001",
		judul: "Pemrograman Web",
		penulis: "John Doe",
	};

	document.getElementById("detailBuku").innerHTML = `
    <div class='alert alert-info'>
      <strong>ID:</strong> ${buku.id} <br>
      <strong>Judul:</strong> ${buku.judul} <br>
      <strong>Penulis:</strong> ${buku.penulis}
    </div>
  `;
}

// Contoh data dummy untuk anggota dan buku
const dataAnggota = [
	{ id: "AG001", nama: "Arya Pratama", telepon: "081234567890" },
	{ id: "AG002", nama: "Budi Santoso", telepon: "081234567891" },
];

const dataBuku = [
	{ id: "BK001", judul: "Pemrograman Web", penulis: "John Doe" },
	{ id: "BK002", judul: "Database MySQL", penulis: "Jane Smith" },
];

// Fungsi mencari anggota
function cariAnggotaEdit() {
	let keyword = document
		.getElementById("editCariAnggota")
		.value.trim()
		.toLowerCase();
	let anggota = dataAnggota.find(
		(a) =>
			a.id.toLowerCase() === keyword || a.nama.toLowerCase().startsWith(keyword)
	);

	if (anggota) {
		document.getElementById("editDetailAnggota").innerHTML = `
          <strong>ID:</strong> ${anggota.id} <br>
          <strong>Nama:</strong> ${anggota.nama} <br>
          <strong>Telepon:</strong> ${anggota.telepon}
        `;
		document.getElementById("editDetailAnggota").classList.remove("d-none");
	} else {
		document.getElementById("editDetailAnggota").innerHTML =
			"<strong>Anggota tidak ditemukan!</strong>";
		document.getElementById("editDetailAnggota").classList.remove("d-none");
	}
}

// Fungsi mencari buku
function cariBukuEdit() {
	let keyword = document
		.getElementById("editCariBuku")
		.value.trim()
		.toLowerCase();
	let buku = dataBuku.find(
		(b) =>
			b.id.toLowerCase() === keyword ||
			b.judul.toLowerCase().startsWith(keyword)
	);

	if (buku) {
		document.getElementById("editDetailBuku").innerHTML = `
          <strong>ID:</strong> ${buku.id} <br>
          <strong>Judul:</strong> ${buku.judul} <br>
          <strong>Penulis:</strong> ${buku.penulis}
        `;
		document.getElementById("editDetailBuku").classList.remove("d-none");
	} else {
		document.getElementById("editDetailBuku").innerHTML =
			"<strong>Buku tidak ditemukan!</strong>";
		document.getElementById("editDetailBuku").classList.remove("d-none");
	}
}

// EDIT ANGGOTA berdasar No Anggota - MODAL ---> Pindah di bawah view/admin/anggota.php

// HAPUS ANGGOTA berdasarkan No Anggota - Modal
function setDeleteData(noAnggota) {
	document.getElementById("deleteNoAnggota").value = noAnggota;
}

// EDIT BUKU berdasarkan No Buku - MODAL
// Di bawah view buku.php karena terkendala tidak bisa terbaca sudah di debug di F12 browser

// HAPUS BUKU berdasarkan No Buku - Modal
// Di bawah view buku.php karena terkendala tidak bisa terbaca sudah di debug di F12 browser

// EDIT Data Peminnjamm
// Di bawah view transaksi.php karena terkendala tidak bisa terbaca sudah di debug di F12 browser
