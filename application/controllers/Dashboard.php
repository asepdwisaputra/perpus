<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		// cek session
		if (!$this->session->userdata('admin_logged_in')) {
			redirect('user/login_admin');
		}
	}

	public function index()
	{
		// Ambil total data dari database
		$total_anggota = $this->db->count_all('anggota');
		$total_buku = $this->db->count_all('buku');

		// Untuk peminjam aktif (status pinjam = 'dipinjam')
		$this->db->where('status', 'dipinjam');
		$total_peminjam = $this->db->count_all_results('transaksi');

		// Ambil 5 transaksi terbaru
		$this->db->select('transaksi.*, anggota.nama as nama_anggota, buku.judul as judul_buku');
		$this->db->from('transaksi');
		$this->db->join('anggota', 'anggota.id_anggota = transaksi.id_anggota');
		$this->db->join('buku', 'buku.id_buku = transaksi.id_buku');
		$this->db->order_by('transaksi.id_transaksi', 'DESC');
		$this->db->limit(5);
		$query = $this->db->get();
		$data['peminjaman_terakhir'] = $query->result();

		// Kirim data ke view
		$data['total_anggota'] = $total_anggota;
		$data['total_buku'] = $total_buku;
		$data['total_peminjam'] = $total_peminjam;

		$this->load->view('admin/dashboard', $data);
	}
}
