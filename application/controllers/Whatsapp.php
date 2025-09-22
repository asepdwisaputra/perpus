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

        $pesan = "Assalamu'alaikum,\n\nYth. Bapak/Ibu/Wali/Saudara/Saudari,\n\nKami informasikan bahwa siswa dengan detail berikut:\n\nNama       : {$transaksi->nama}\nJudul Buku : {$transaksi->judul}\n\nmemiliki keterlambatan pengembalian buku perpustakaan. Mohon informasi ini dapat diteruskan kepada yang bersangkutan agar segera mengembalikan buku tersebut.\n\nTerima kasih atas kerja samanya.\n\nTertanda,\nPerpustakaan SMP Istiqomah Sambas";

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.fonnte.com/send',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => array(
                'target' => $transaksi->telepon,
                'message' => $pesan,
                'countryCode' => '62',
            ),
            CURLOPT_HTTPHEADER => array(
                'Authorization: Q3CNLUzuTYyEDFwxvjia'
            ),
        ));

        $response = curl_exec($curl);

        if (curl_errno($curl)) {
            $error_msg = curl_error($curl);
            curl_close($curl);
            echo json_encode(['status' => false, 'error' => $error_msg]);
            return;
        }

        curl_close($curl);
        $result = json_decode($response, true);

        if (isset($result['status']) && $result['status'] == true) {
            echo json_encode(['status' => true]);
        } else {
            echo json_encode(['status' => false, 'error' => $result['detail'] ?? 'Gagal kirim pesan']);
        }
    }

    // Fungsi private untuk mengirim WA-- simpen aja dulu kali aja nanti butuh
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
                'Authorization: Q3CNLUzuTYyEDFwxvjia' // Ini buat isi token
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
