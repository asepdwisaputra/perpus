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
}
