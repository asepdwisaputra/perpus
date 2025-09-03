<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Anggota extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        // cek session
        if (!$this->session->userdata('admin_logged_in')) {
            redirect('user/login_admin');
        }

        $this->load->model('Anggota_model');
        // Memuat library session
        $this->load->library('session');
    }

    // Menampilkan semua data anggota
    public function index()
    {
        $data['anggota'] = $this->Anggota_model->get_all_anggota();
        $this->load->view('admin/anggota', $data);
    }

    // Menambah anggota baru
    public function add()
    {
        // Ambil data dari form
        $data = [
            'nama'      => $this->input->post('nama'),
            'no_anggota' => $this->input->post('no_anggota'),
            'telepon'   => $this->input->post('telepon'),
        ];

        // Cek apakah nomor anggota sudah terdaftar
        if ($this->Anggota_model->is_no_anggota_exists($data['no_anggota'])) {
            // Jika sudah ada, set pesan error
            $this->session->set_flashdata('form_error', 'Nomor Anggota sudah terdaftar');
            $this->session->set_flashdata('old_input', $data);  // Menyimpan input lama agar bisa ditampilkan kembali

            // Redirect kembali ke halaman anggota untuk menampilkan error
            redirect('anggota');
        }

        // Jika tidak ada error, simpan data ke database
        $this->Anggota_model->tambah_anggota($data);

        // Redirect kembali ke halaman anggota setelah berhasil
        redirect('anggota');
    }



    // Mengedit data anggota
    public function update()
    {
        $no_anggota_lama = $this->input->post('no_anggota_lama'); // dipakai untuk WHERE
        $data = [
            'nama' => $this->input->post('nama'),
            'no_anggota' => $this->input->post('no_anggota'),
            'telepon' => $this->input->post('telepon')
        ];

        $this->db->where('no_anggota', $no_anggota_lama);
        $this->db->update('anggota', $data);

        redirect('anggota');
    }







    // Menghapus anggota
    public function delete()
    {
        // Ambil nomor anggota dari form
        $no_anggota = $this->input->post('no_anggota');

        // Lakukan query untuk menghapus anggota berdasarkan nomor anggota
        $this->db->where('no_anggota', $no_anggota);
        $this->db->delete('anggota');

        // Redirect ke halaman anggota setelah menghapus
        redirect('anggota');
    }

    // Cari Anggota
    public function search()
    {
        // Ambil kata kunci pencarian dari URL query parameter
        $keyword = $this->input->get('keyword');

        // Jika tidak ada kata kunci, tampilkan semua anggota
        if ($keyword) {
            $data['anggota'] = $this->Anggota_model->search_anggota($keyword);
        } else {
            // Jika tidak ada pencarian, tampilkan semua anggota
            $data['anggota'] = $this->Anggota_model->get_all_anggota();
        }

        // Tampilkan view dengan data anggota yang sesuai
        $this->load->view('admin/anggota', $data);
    }

    // Unduh All Data
    public function export_csv()
    {
        // Ambil data anggota
        $dataAnggota = $this->Anggota_model->get_all_anggota(); // Ganti dengan model kamu

        // Atur header untuk file CSV
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment;filename="data_anggota.csv"');

        // Buka output stream
        $output = fopen('php://output', 'w');

        // Header kolom CSV
        fputcsv($output, ['No', 'Nama', 'Nomor Anggota', 'Telepon']);

        $no = 1;
        foreach ($dataAnggota as $anggota) {
            // Menambahkan tanda petik satu pada nomor anggota dan nomor telepon
            $noAnggota = "'" . $anggota->no_anggota;
            $telepon = "'" . $anggota->telepon;

            // Tulis data anggota ke CSV
            fputcsv($output, [
                $no++,
                $anggota->nama,
                $noAnggota, // Nomor anggota dengan tanda petik satu
                $telepon    // Nomor telepon dengan tanda petik satu
            ]);
        }

        fclose($output);
        exit;
    }
}
