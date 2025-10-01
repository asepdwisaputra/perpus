<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database(); // load database
        $this->load->library('session');
        $this->load->model('Buku_model');
    }

    public function index()
    {
        $this->load->view('user/index'); // arahkan ke views/user/index.php
    }

    public function katalog()
    {
        // load model buku
        $this->load->model('Buku_model');

        // ambil hanya buku yang stoknya lebih dari 0
        $data['buku'] = $this->Buku_model->get_buku_tersedia();

        $this->load->view('user/katalog', $data);
    }


    public function katalog_search()
    {
        $keyword = $this->input->get('keyword'); // ambil input dari form

        // ambil data buku yang cocok
        $this->db->like('judul', $keyword); // cari berdasarkan judul
        $query = $this->db->get('buku');
        $data['buku'] = $query->result();

        // load view katalog
        $this->load->view('user/katalog', $data);
    }


    public function login_admin()
    {
        $this->load->view('user/login_admin');
    }

    public function do_login()
    {
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        // ambil admin dari database
        $query = $this->db->get_where('admin', ['username' => $username]);
        $admin = $query->row();

        if ($admin && $password === $admin->password) {
            // berhasil login
            $this->session->set_userdata('admin_logged_in', TRUE);
            $this->session->set_userdata('admin_username', $admin->username);
            redirect('dashboard');
        } else {
            $this->session->set_flashdata('error', 'Username atau password salah');
            redirect('user/login_admin');
        }
    }

    // Kontroler untuk melakukan pengajuan di user/katalog
    public function pesan()
    {
        $no_anggota = $this->input->post('no_anggota');
        $id_buku    = $this->input->post('id_buku');

        // ✅ Cek apakah user sudah punya pesanan pending
        $pesanan_pending = $this->db->select('pemesanan.*')
            ->from('pemesanan')
            ->join('anggota', 'anggota.id_anggota = pemesanan.id_anggota')
            ->where('anggota.no_anggota', $no_anggota)
            ->where('pemesanan.status', 'pending')
            ->get()
            ->row();

        if ($pesanan_pending) {
            $this->session->set_flashdata('error', 'Pengajuan ditolak! Anda sudah memiliki pesanan yang belum diproses.');
            redirect('user/katalog');
            return;
        }

        // ✅ Cek stock buku
        $buku = $this->db->select('stock')
            ->where('id_buku', $id_buku)
            ->get('buku')
            ->row();

        if (!$buku || $buku->stock <= 0) {
            $this->session->set_flashdata('error', 'Stock buku habis! Pemesanan tidak dapat dilakukan.');
            redirect('user/katalog');
            return;
        }

        // ✅ Insert pemesanan
        $this->load->model('Pemesanan_model');
        $result = $this->Pemesanan_model->insert_pemesanan($no_anggota, $id_buku);

        if ($result) {
            $this->db->set('stock', 'stock-1', FALSE);
            $this->db->where('id_buku', $id_buku);
            $this->db->update('buku');

            $this->session->set_flashdata('success', 'Pemesanan berhasil dikirim, menunggu konfirmasi.');
        } else {
            $this->session->set_flashdata('error', 'Pemesanan gagal, periksa data Anda.');
        }

        redirect('user/katalog');
    }
}
