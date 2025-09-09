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
