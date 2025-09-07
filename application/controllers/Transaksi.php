<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Transaksi extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        // cek session
        if (!$this->session->userdata('admin_logged_in')) {
            redirect('user/login_admin');
        }

        $this->load->model('Transaksi_model');
    }

    // Menampilkan semua data anggota
    public function index()
    {
        $data['transaksi'] = $this->Transaksi_model->get_all_transaksi();

        // Tambahan: ambil data anggota dan buku
        $this->load->model('Anggota_model');
        $this->load->model('Buku_model');

        // Tambahin model anggota dan buku biar bisa auto fill di add transaksi aww
        $data['anggota'] = $this->Anggota_model->get_all_anggota();
        $data['buku'] = $this->Buku_model->get_all_buku();

        $this->load->view('admin/transaksi', $data);
    }

    // Ambil data Anggota buat Auto fill
    public function get_all_anggota()
    {
        return $this->db->get('anggota')->result();
    }

    // Ambil data Buku buat Auto fill
    public function get_all_buku()
    {
        return $this->db->get('buku')->result();
    }

    // Ubah menjadi dikembalikan
    public function kembalikan()
    {
        $id_transaksi = $this->input->post('id_transaksi');

        // Ambil data transaksi untuk tahu id_buku
        $transaksi = $this->db->where('id_transaksi', $id_transaksi)
            ->get('transaksi')
            ->row();

        if ($transaksi) {
            $id_buku = $transaksi->id_buku;

            // Update status transaksi menjadi 'dikembalikan'
            $this->db->where('id_transaksi', $id_transaksi);
            $this->db->update('transaksi', [
                'status'          => 'dikembalikan',
                'tanggal_kembali' => date('Y-m-d')
            ]);

            // Tambahkan stock buku +1
            $this->db->set('stock', 'stock+1', FALSE);
            $this->db->where('id_buku', $id_buku);
            $this->db->update('buku');
        }

        // Kembali ke halaman transaksi
        redirect('transaksi');
    }


    // Perpanjang tanggal dikembalikan menjadi +7 hari
    public function perpanjang()
    {
        $id = $this->input->post('id_transaksi');

        // Ambil tanggal_kembali sekarang
        $transaksi = $this->db->get_where('transaksi', ['id_transaksi' => $id])->row();

        if ($transaksi) {
            $tanggal_lama = $transaksi->tanggal_kembali;
            $tanggal_baru = date('Y-m-d', strtotime($tanggal_lama . ' +7 days'));

            // Update tanggal_kembali baru
            $this->db->where('id_transaksi', $id);
            $this->db->update('transaksi', ['tanggal_kembali' => $tanggal_baru]);
        }

        redirect('transaksi');
    }

    // Update data peminjam
    public function update()
    {
        $id = $this->input->post('id_transaksi');

        $data = [
            'tanggal_pinjam' => $this->input->post('tanggal_pinjam'),
            'tanggal_kembali' => $this->input->post('tanggal_kembali'),
            'status' => $this->input->post('status')
        ];

        $this->db->where('id_transaksi', $id);
        $this->db->update('transaksi', $data);

        redirect('transaksi');
    }

    // Hapus Data Transaksi
    public function delete()
    {
        $id = $this->input->post('id_transaksi');

        $this->db->where('id_transaksi', $id);
        $this->db->delete('transaksi');

        redirect('transaksi');
    }

    // Tambah Transaksi
    public function tambah()
    {
        $id_anggota = $this->input->post('id_anggota');
        $id_buku    = $this->input->post('id_buku');

        // Cek berapa buku yang sedang dipinjam oleh anggota ini
        $this->db->where('id_anggota', $id_anggota);
        $this->db->where('status', 'dipinjam');
        $jumlah_pinjaman = $this->db->count_all_results('transaksi');

        if ($jumlah_pinjaman >= 2) {
            // Jika sudah meminjam 2 buku atau lebih, tolak
            $this->session->set_flashdata('error', 'Peminjaman ditolak! Anggota ini sudah meminjam lebih dari 2 buku.');
            redirect('transaksi');
        } else {
            // Cek stock buku dulu sebelum meminjam
            $stock = $this->db->select('stock')
                ->where('id_buku', $id_buku)
                ->get('buku')
                ->row();

            if (!$stock || $stock->stock <= 0) {
                $this->session->set_flashdata('error', 'Stock buku habis! Peminjaman tidak dapat dilakukan.');
                redirect('transaksi');
            }

            // Jika stock ada, lanjut insert transaksi
            $data = [
                'id_anggota'      => $id_anggota,
                'id_buku'         => $id_buku,
                'tanggal_pinjam'  => $this->input->post('tanggal_pinjam'),
                'tanggal_kembali' => $this->input->post('tanggal_kembali'),
                'status'          => $this->input->post('status'),
            ];

            $this->db->insert('transaksi', $data);

            // Kurangi stock buku (stock = stock - 1)
            $this->db->set('stock', 'stock-1', FALSE);
            $this->db->where('id_buku', $id_buku);
            $this->db->update('buku');

            $this->session->set_flashdata('success', 'Peminjaman berhasil ditambahkan.');
            redirect('transaksi');
        }
    }



    // Cari Transaksi
    public function search()
    {
        // Ambil kata kunci pencarian dari URL query parameter
        $keyword = $this->input->get('keyword');

        // Jika tidak ada kata kunci, tampilkan semua anggota
        if ($keyword) {
            $data['transaksi'] = $this->Transaksi_model->search_transaksi($keyword);
        } else {
            // Jika tidak ada pencarian, tampilkan semua anggota
            $data['transaksi'] = $this->Transaksi_model->get_all_transaksi();
        }

        // Tampilkan view dengan data transaksi yang sesuai
        $this->load->view('admin/transaksi', $data);
    }

    // Unduh Data Transaksi All
    public function export()
    {
        $this->load->helper('download');
        $this->load->database();

        $this->db->select('transaksi.id_transaksi, anggota.nama AS nama_anggota, anggota.no_anggota, buku.judul AS judul_buku, buku.no_buku, transaksi.tanggal_pinjam, transaksi.tanggal_kembali, transaksi.status');
        $this->db->from('transaksi');
        $this->db->join('anggota', 'anggota.id_anggota = transaksi.id_anggota');
        $this->db->join('buku', 'buku.id_buku = transaksi.id_buku');
        $query = $this->db->get();

        $delimiter = ",";
        $newline = "\r\n";
        $filename = "data_transaksi.csv";

        $data = '';

        // Header
        $fields = $query->list_fields();
        $data .= implode($delimiter, $fields) . $newline;

        // Data rows
        foreach ($query->result_array() as $row) {
            $data .= implode($delimiter, $row) . $newline;
        }

        force_download($filename, $data);
    }
}
