<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property Pemesanan_model $Pemesanan_model
 */

class Pemesanan extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        // cek session
        if (!$this->session->userdata('admin_logged_in')) {
            redirect('user/login_admin');
        }

        $this->load->model('Pemesanan_model');
    }

    public function index()
    {
        $data['pemesanan'] = $this->Pemesanan_model->get_all_pemesanan();
        $this->load->view('admin/pemesanan', $data);
    }

    public function terima($id_pemesanan)
    {
        $this->Pemesanan_model->terima_pemesanan($id_pemesanan);
        redirect('pemesanan');
    }

    public function tolak($id_pemesanan)
    {
        // Ambil data pemesanan dulu untuk tahu id_buku
        $pemesanan = $this->db->where('id_pemesanan', $id_pemesanan)
            ->get('pemesanan')
            ->row();

        if ($pemesanan) {
            $id_buku = $pemesanan->id_buku;

            // Tambahkan stock buku +1
            $this->db->set('stock', 'stock+1', FALSE);
            $this->db->where('id_buku', $id_buku);
            $this->db->update('buku');
        }

        // Panggil model untuk update status pemesanan menjadi ditolak
        $this->Pemesanan_model->tolak_pemesanan($id_pemesanan);

        redirect('pemesanan');
    }
}
