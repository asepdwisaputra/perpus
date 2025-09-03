<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Denda extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // cek session
        if (!$this->session->userdata('admin_logged_in')) {
            redirect('user/login_admin');
        }

        $this->load->model('Denda_model'); // <-- ini WAJIB ada
    }

    public function index()
    {
        $this->load->model('Denda_model');

        // Ambil keyword pencarian dari input GET
        $keyword = $this->input->get('keyword');

        // Jika ada keyword, gunakan fungsi pencarian
        if (!empty($keyword)) {
            $data['denda'] = $this->Denda_model->search_transaksi_terlambat($keyword);
        } else {
            // Jika tidak ada keyword, tampilkan semua yang terlambat
            $data['denda'] = $this->Denda_model->get_transaksi_terlambat();
        }

        // Tampilkan view
        $this->load->view('admin/denda', $data);
    }

    public function export_csv()
    {
        $this->load->model('Denda_model');

        // Ambil semua transaksi yang terlambat
        $dataTerlambat = $this->Denda_model->get_transaksi_terlambat();

        // Header untuk CSV
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment;filename="data_denda.csv"');

        // Buka output stream
        $output = fopen('php://output', 'w');

        // Tulis header kolom
        fputcsv($output, [
            'No',
            'Nama Peminjam',
            'Nomor Anggota',
            'Judul Buku',
            'ID Buku',
            'Tanggal Kembali',
            'Hari Terlambat',
            'Total Denda'
        ]);

        // Format data dan tulis ke CSV
        $no = 1;
        $today = date('Y-m-d');
        $dendaPerHari = 1000;

        foreach ($dataTerlambat as $row) {
            $tanggalKembali = $row->tanggal_kembali;
            $terlambat = max(0, (strtotime($today) - strtotime($tanggalKembali)) / 86400);
            $totalDenda = $terlambat * $dendaPerHari;

            fputcsv($output, [
                $no++,
                $row->nama,
                $row->no_anggota,
                $row->judul,
                $row->no_buku,
                $tanggalKembali,
                $terlambat,
                'Rp ' . number_format($totalDenda, 0, ',', '.')
            ]);
        }

        fclose($output);
        exit;
    }
}
