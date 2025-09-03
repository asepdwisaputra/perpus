<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Whatsapp extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Denda_model'); // kalau data dari transaksi denda
    }

    public function kirim($id_transaksi)
    {
        $this->load->model('Denda_model');
        $transaksi = $this->Denda_model->get_transaksi_by_id($id_transaksi);

        // Kirim WA via cURL (Fonnte)
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.fonnte.com/send',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => array(
                'target' => $transaksi->telepon,
                'message' => "Assalamu'alaikum,\n\nYth. Wali Kelas,\n\nKami informasikan bahwa siswa dengan detail berikut:\n\nNama       : {$transaksi->nama}\nJudul Buku : {$transaksi->judul}\n\nmemiliki keterlambatan pengembalian buku perpustakaan. Mohon informasi ini dapat diteruskan kepada yang bersangkutan atau orangtua murid agar segera mengembalikan buku tersebut.\n\nTerima kasih atas kerja samanya.\n\nTertanda,\nPerpustakaan SMP Istiqomah Sambas",
                'countryCode' => '62',
            ),
            CURLOPT_HTTPHEADER => array(
                'Authorization: Q3CNLUzuTYyEDFwxvjia'
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);

        // Beri respon JSON ke AJAX
        echo json_encode(['status' => true]);
    }

    // Fungsi private untuk mengirim WA
    private function _send_wa($nomor, $pesan)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.fonnte.com/send',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array(
                'target' => $nomor,
                'message' => $pesan,
                'countryCode' => '62',
            ),
            CURLOPT_HTTPHEADER => array(
                'Authorization: Q3CNLUzuTYyEDFwxvjia' // Ganti dengan token kamu
            ),
        ));

        $response = curl_exec($curl);
        if (curl_errno($curl)) {
            log_message('error', 'WA Error: ' . curl_error($curl));
        }
        curl_close($curl);

        return $response;
    }
}
