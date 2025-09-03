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
        $this->Pemesanan_model->tolak_pemesanan($id_pemesanan);
        redirect('pemesanan');
    }

    public function pesan()
    {
        $no_anggota = $this->input->post('no_anggota');
        $id_buku    = $this->input->post('id_buku');

        // // 🔥 Debug cetak di browser
        // echo "<pre>";
        // echo "DEBUG INPUT:\n";
        // echo "No Anggota: " . $no_anggota . "\n";
        // echo "ID Buku: " . $id_buku . "\n";
        // echo "</pre>";

        // // hentikan dulu biar keliatan
        // exit;

        $this->load->model('Pemesanan_model');

        $result = $this->Pemesanan_model->insert_pemesanan($no_anggota, $id_buku);

        if ($result) {
            $this->session->set_flashdata('success', 'Pemesanan berhasil dikirim, menunggu konfirmasi.');
        } else {
            $this->session->set_flashdata('error', 'Pemesanan gagal, periksa data Anda.');
        }

        redirect('user/katalog');
    }
}
