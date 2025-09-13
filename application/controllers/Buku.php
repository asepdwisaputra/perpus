<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Buku extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        // cek session
        if (!$this->session->userdata('admin_logged_in')) {
            redirect('user/login_admin');
        }

        $this->load->model('Buku_model');
    }

    // Menampilkan semua data anggota
    public function index()
    {
        $data['buku'] = $this->Buku_model->get_all_buku();
        $this->load->view('admin/buku', $data);
    }

    // Menambah buku baru
    public function add()
    {
        // Ambil data dari form
        $data = [
            'no_buku'  => $this->input->post('no_buku'),
            'judul'    => $this->input->post('judul'),
            'penulis'  => $this->input->post('penulis'),
            'penerbit' => $this->input->post('penerbit'),
            'rak'      => $this->input->post('rak'),
            'stock'      => $this->input->post('stock'),
        ];

        // Cek apakah ID Buku sudah terdaftar
        if ($this->Buku_model->is_no_buku_exists($data['no_buku'])) {
            // Jika sudah ada, set pesan error
            $this->session->set_flashdata('form_error', 'Nomor Buku sudah terdaftar');
            $this->session->set_flashdata('old_input', $data);  // Simpan input lama

            // Redirect kembali ke halaman buku
            redirect('buku');
        }

        // Jika tidak ada error, simpan data ke database
        $this->Buku_model->tambah_buku($data);

        // Redirect ke halaman buku setelah berhasil
        redirect('buku');
    }

    // Cari Buku
    public function search()
    {
        // Ambil kata kunci pencarian dari URL query parameter
        $keyword = $this->input->get('keyword');

        // Jika tidak ada kata kunci, tampilkan semua anggota
        if ($keyword) {
            $data['buku'] = $this->Buku_model->search_buku($keyword);
        } else {
            // Jika tidak ada pencarian, tampilkan semua anggota
            $data['buku'] = $this->Buku_model->get_all_buku();
        }

        // Tampilkan view dengan data buku yang sesuai
        $this->load->view('admin/buku', $data);
    }

    // Unduh All Data
    public function export_csv()
    {
        // Ambil data buku
        $dataBuku = $this->Buku_model->get_all_buku(); // Ganti dengan model kamu

        // Atur header untuk file CSV
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment;filename="data_buku.csv"');

        // Buka output stream
        $output = fopen('php://output', 'w');

        // Header kolom CSV
        fputcsv($output, ['No', 'Judul', 'Nomor Buku', 'Penulis', 'Penerbit', 'Rak']);

        $no = 1;
        foreach ($dataBuku as $buku) {
            // Menambahkan tanda petik satu pada nomor buku dan nomor telepon
            $noBuku = "'" . $buku->no_buku;
            $rak = "'" . $buku->rak;

            /// Tulis data buku ke CSV
            fputcsv($output, [
                $no++,
                $buku->judul,
                $noBuku,
                $buku->penulis,     // <-- tambahkan ini
                $buku->penerbit,    // <-- dan ini
                $rak
            ]);
        }

        fclose($output);
        exit;
    }

    // Mengedit data buku
    public function update()
    {
        $no_buku_lama = $this->input->post('no_buku_lama'); // dipakai untuk WHERE
        $data = [
            'no_buku'  => $this->input->post('no_buku'),
            'judul'    => $this->input->post('judul'),
            'penulis'  => $this->input->post('penulis'),
            'penerbit' => $this->input->post('penerbit'),
            'rak'      => $this->input->post('rak'),
        ];

        $this->db->where('no_buku', $no_buku_lama);
        $this->db->update('buku', $data);

        // Ini untuk debug waktu kita cek data input itu lhoo
        // echo '<pre>';
        // print_r($this->input->post());
        // exit;

        redirect('buku');
    }

    // Menghapus buku
    public function delete()
    {
        // Ambil nomor buku dari form
        $no_buku = $this->input->post('no_buku');

        // Lakukan query untuk menghapus buku berdasarkan nomor buku
        $this->db->where('no_buku', $no_buku);
        $this->db->delete('buku');

        // Ini untuk DEBUG aja soalnya no_buku ga ketangkep weh
        // echo '<pre>';
        // print_r($this->input->post());
        // exit;

        // Redirect ke halaman buku setelah menghapus
        redirect('buku');
    }
}
