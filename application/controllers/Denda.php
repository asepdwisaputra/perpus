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

    public function export_pdf()
    {
        $this->load->model('Denda_model');
        $this->load->library('fpdf');

        $dataTerlambat = $this->Denda_model->get_transaksi_terlambat();

        $pdf = new FPDF('L', 'mm', 'A4');
        $pdf->AddPage();

        // === HEADER TANPA LOGO ===
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(0, 10, 'LAPORAN DATA DENDA', 0, 1, 'C');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(0, 7, 'Perpustakaan Barul \'Ulum', 0, 1, 'C');
        $pdf->Cell(0, 5, 'Tanggal Cetak: ' . date('d-m-Y'), 0, 1, 'C');
        $pdf->Ln(10);

        // === HEADER TABEL ===
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(10, 10, 'No', 1, 0, 'C');
        $pdf->Cell(40, 10, 'Nama Peminjam', 1, 0, 'C');
        $pdf->Cell(30, 10, 'No. Anggota', 1, 0, 'C');
        $pdf->Cell(70, 10, 'Judul Buku', 1, 0, 'C');
        $pdf->Cell(25, 10, 'ID Buku', 1, 0, 'C');
        $pdf->Cell(30, 10, 'Tgl Kembali', 1, 0, 'C');
        $pdf->Cell(25, 10, 'Terlambat', 1, 0, 'C');
        $pdf->Cell(35, 10, 'Total Denda', 1, 1, 'C');

        // === ISI TABEL ===
        $pdf->SetFont('Arial', '', 10);
        $no = 1;
        $today = date('Y-m-d');
        $dendaPerHari = 1000;

        foreach ($dataTerlambat as $row) {
            $tanggalKembali = $row->tanggal_kembali;
            $terlambat = max(0, (strtotime($today) - strtotime($tanggalKembali)) / 86400);
            $totalDenda = $terlambat * $dendaPerHari;

            // Hitung tinggi baris berdasarkan teks terpanjang (judul buku)
            $judul = utf8_decode($row->judul);
            $judulHeight = ceil($pdf->GetStringWidth($judul) / 70) * 8;
            $rowHeight = max(8, $judulHeight);

            $yAwal = $pdf->GetY();

            // Kolom 1–3
            $pdf->Cell(10, $rowHeight, $no++, 1, 0, 'C');
            $pdf->Cell(40, $rowHeight, $row->nama, 1);
            $pdf->Cell(30, $rowHeight, $row->no_anggota, 1);

            // Kolom 4: Judul Buku (pakai MultiCell)
            $xPos = $pdf->GetX();
            $yPos = $pdf->GetY();
            $pdf->MultiCell(70, 8, $judul, 1);
            $pdf->SetXY($xPos + 70, $yPos);

            // Kolom 5–8
            $pdf->Cell(25, $rowHeight, $row->no_buku, 1, 0, 'C');
            $pdf->Cell(30, $rowHeight, date('d-m-Y', strtotime($tanggalKembali)), 1, 0, 'C');
            $pdf->Cell(25, $rowHeight, $terlambat . ' hari', 1, 0, 'C');
            $pdf->Cell(35, $rowHeight, 'Rp ' . number_format($totalDenda, 0, ',', '.'), 1, 1, 'R');

            // Pastikan Y tetap sejajar
            $pdf->SetY(max($yAwal + $rowHeight, $pdf->GetY()));
        }

        // === TANDA TANGAN PETUGAS ===
        $pdf->Ln(15);
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(0, 6, 'Mengetahui,', 0, 1, 'R');
        $pdf->Ln(15);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 6, 'Wahyu Aji Saputra', 0, 1, 'R');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(0, 6, 'NIY. 28060019443', 0, 1, 'R');

        // Output PDF
        $pdf->Output('D', 'data_denda.pdf');
    }

    public function export_pdf_mingguan()
    {
        $this->load->model('Denda_model');
        $this->load->library('fpdf');

        // Ambil data transaksi terlambat mingguan
        $dataTerlambat = $this->Denda_model->get_transaksi_terlambat_mingguan();

        $pdf = new FPDF('L', 'mm', 'A4');
        $pdf->AddPage();

        // === HEADER TANPA LOGO ===
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(0, 10, 'LAPORAN DATA DENDA MINGGUAN', 0, 1, 'C');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(0, 7, 'Perpustakaan Barul \'Ulum', 0, 1, 'C');
        $pdf->Cell(0, 5, 'Periode: ' . date('d-m-Y', strtotime('-7 days')) . ' s/d ' . date('d-m-Y'), 0, 1, 'C');
        $pdf->Cell(0, 5, 'Tanggal Cetak: ' . date('d-m-Y'), 0, 1, 'C');
        $pdf->Ln(10);

        // === HEADER TABEL ===
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(10, 10, 'No', 1, 0, 'C');
        $pdf->Cell(40, 10, 'Nama Peminjam', 1, 0, 'C');
        $pdf->Cell(30, 10, 'No. Anggota', 1, 0, 'C');
        $pdf->Cell(70, 10, 'Judul Buku', 1, 0, 'C');
        $pdf->Cell(25, 10, 'ID Buku', 1, 0, 'C');
        $pdf->Cell(30, 10, 'Tgl Kembali', 1, 0, 'C');
        $pdf->Cell(25, 10, 'Terlambat', 1, 0, 'C');
        $pdf->Cell(35, 10, 'Total Denda', 1, 1, 'C');

        // === ISI TABEL ===
        $pdf->SetFont('Arial', '', 10);
        $no = 1;
        $today = date('Y-m-d');
        $dendaPerHari = 1000;

        foreach ($dataTerlambat as $row) {
            $tanggalKembali = $row->tanggal_kembali;
            $terlambat = max(0, (strtotime($today) - strtotime($tanggalKembali)) / 86400);
            $totalDenda = $terlambat * $dendaPerHari;

            // Hitung tinggi baris berdasarkan teks terpanjang (judul buku)
            $judul = utf8_decode($row->judul_buku);
            $judulHeight = ceil($pdf->GetStringWidth($judul) / 70) * 8;
            $rowHeight = max(8, $judulHeight);

            $yAwal = $pdf->GetY();

            // Kolom 1–3
            $pdf->Cell(10, $rowHeight, $no++, 1, 0, 'C');
            $pdf->Cell(40, $rowHeight, $row->nama_peminjam, 1);
            $pdf->Cell(30, $rowHeight, $row->no_anggota, 1);

            // Kolom 4: Judul Buku (pakai MultiCell)
            $xPos = $pdf->GetX();
            $yPos = $pdf->GetY();
            $pdf->MultiCell(70, 8, $judul, 1);
            $pdf->SetXY($xPos + 70, $yPos);

            // Kolom 5–8
            $pdf->Cell(25, $rowHeight, $row->no_buku, 1, 0, 'C');
            $pdf->Cell(30, $rowHeight, date('d-m-Y', strtotime($tanggalKembali)), 1, 0, 'C');
            $pdf->Cell(25, $rowHeight, $terlambat . ' hari', 1, 0, 'C');
            $pdf->Cell(35, $rowHeight, 'Rp ' . number_format($totalDenda, 0, ',', '.'), 1, 1, 'R');

            // Pastikan Y tetap sejajar
            $pdf->SetY(max($yAwal + $rowHeight, $pdf->GetY()));
        }

        // === TANDA TANGAN PETUGAS ===
        $pdf->Ln(15);
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(0, 6, 'Mengetahui,', 0, 1, 'R');
        $pdf->Ln(15);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 6, 'Wahyu Aji Saputra', 0, 1, 'R');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(0, 6, 'NIY. 28060019443', 0, 1, 'R');

        // Output PDF
        $pdf->Output('D', 'data_denda_mingguan.pdf');
    }

    public function export_pdf_bulanan()
    {
        $this->load->model('Denda_model');
        $this->load->library('fpdf');

        // Ambil data transaksi terlambat bulanan
        $dataTerlambat = $this->Denda_model->get_transaksi_terlambat_bulanan();

        $pdf = new FPDF('L', 'mm', 'A4');
        $pdf->AddPage();

        // === HEADER ===
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(0, 10, 'LAPORAN DATA DENDA BULANAN', 0, 1, 'C');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(0, 7, 'Perpustakaan Barul \'Ulum', 0, 1, 'C');

        // Tampilkan nama bulan sekarang
        $bulan_ini = date('F Y'); // contoh: "October 2025"
        $pdf->Cell(0, 5, 'Periode: ' . $bulan_ini, 0, 1, 'C');
        $pdf->Cell(0, 5, 'Tanggal Cetak: ' . date('d-m-Y'), 0, 1, 'C');
        $pdf->Ln(10);

        // === HEADER TABEL ===
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(10, 10, 'No', 1, 0, 'C');
        $pdf->Cell(40, 10, 'Nama Peminjam', 1, 0, 'C');
        $pdf->Cell(30, 10, 'No. Anggota', 1, 0, 'C');
        $pdf->Cell(70, 10, 'Judul Buku', 1, 0, 'C');
        $pdf->Cell(25, 10, 'ID Buku', 1, 0, 'C');
        $pdf->Cell(30, 10, 'Tgl Kembali', 1, 0, 'C');
        $pdf->Cell(25, 10, 'Terlambat', 1, 0, 'C');
        $pdf->Cell(35, 10, 'Total Denda', 1, 1, 'C');

        // === ISI TABEL ===
        $pdf->SetFont('Arial', '', 10);
        $no = 1;
        $today = date('Y-m-d');
        $dendaPerHari = 1000;

        foreach ($dataTerlambat as $row) {
            $tanggalKembali = $row->tanggal_kembali;
            $terlambat = max(0, (strtotime($today) - strtotime($tanggalKembali)) / 86400);
            $totalDenda = $terlambat * $dendaPerHari;

            $judul = utf8_decode($row->judul_buku);
            $judulHeight = ceil($pdf->GetStringWidth($judul) / 70) * 8;
            $rowHeight = max(8, $judulHeight);

            $yAwal = $pdf->GetY();

            // Kolom 1–3
            $pdf->Cell(10, $rowHeight, $no++, 1, 0, 'C');
            $pdf->Cell(40, $rowHeight, $row->nama_peminjam, 1);
            $pdf->Cell(30, $rowHeight, $row->no_anggota, 1);

            // Kolom 4 (judul buku)
            $xPos = $pdf->GetX();
            $yPos = $pdf->GetY();
            $pdf->MultiCell(70, 8, $judul, 1);
            $pdf->SetXY($xPos + 70, $yPos);

            // Kolom 5–8
            $pdf->Cell(25, $rowHeight, $row->no_buku, 1, 0, 'C');
            $pdf->Cell(30, $rowHeight, date('d-m-Y', strtotime($tanggalKembali)), 1, 0, 'C');
            $pdf->Cell(25, $rowHeight, $terlambat . ' hari', 1, 0, 'C');
            $pdf->Cell(35, $rowHeight, 'Rp ' . number_format($totalDenda, 0, ',', '.'), 1, 1, 'R');

            $pdf->SetY(max($yAwal + $rowHeight, $pdf->GetY()));
        }

        // === TANDA TANGAN ===
        $pdf->Ln(15);
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(0, 6, 'Mengetahui,', 0, 1, 'R');
        $pdf->Ln(15);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 6, 'Wahyu Aji Saputra', 0, 1, 'R');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(0, 6, 'NIY. 28060019443', 0, 1, 'R');

        // Output file PDF
        $pdf->Output('D', 'data_denda_bulanan.pdf');
    }
}
