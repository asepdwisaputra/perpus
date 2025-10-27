<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Whatsapp extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Denda_model'); // kalau data dari transaksi denda
    }

    // FUNGSI INI SAYA NONAKTIFKAN KARENA PERMINTAAN DOSEN UNTUH FORMAT BARU
    // public function kirim($id_transaksi)
    // {
    //     $this->load->model('Denda_model');
    //     $transaksi = $this->Denda_model->get_transaksi_by_id($id_transaksi);

    //     $pesan = "Assalamu'alaikum,\n\nYth. Bapak/Ibu/Wali/Saudara/Saudari,\n\nKami informasikan bahwa siswa dengan detail berikut:\n\nNama       : {$transaksi->nama}\nJudul Buku : {$transaksi->judul}\n\nmemiliki keterlambatan pengembalian buku perpustakaan. Mohon informasi ini dapat diteruskan kepada yang bersangkutan agar segera mengembalikan buku tersebut.\n\nTerima kasih atas kerja samanya.\n\nTertanda,\nPerpustakaan SMP Istiqomah Sambas";

    //     $curl = curl_init();
    //     curl_setopt_array($curl, array(
    //         CURLOPT_URL => 'https://api.fonnte.com/send',
    //         CURLOPT_RETURNTRANSFER => true,
    //         CURLOPT_POST => true,
    //         CURLOPT_POSTFIELDS => array(
    //             'target' => $transaksi->telepon,
    //             'message' => $pesan,
    //             'countryCode' => '62',
    //         ),
    //         CURLOPT_HTTPHEADER => array(
    //             'Authorization: Q3CNLUzuTYyEDFwxvjia'
    //         ),
    //     ));

    //     $response = curl_exec($curl);

    //     if (curl_errno($curl)) {
    //         $error_msg = curl_error($curl);
    //         curl_close($curl);
    //         echo json_encode(['status' => false, 'error' => $error_msg]);
    //         return;
    //     }

    //     curl_close($curl);
    //     $result = json_decode($response, true);

    //     if (isset($result['status']) && $result['status'] == true) {
    //         echo json_encode(['status' => true]);
    //     } else {
    //         echo json_encode(['status' => false, 'error' => $result['detail'] ?? 'Gagal kirim pesan']);
    //     }
    // }

    public function kirim($id_transaksi)
    {
        $this->load->model('Denda_model');
        $transaksi = $this->Denda_model->get_transaksi_by_id($id_transaksi);

        // --- Hitung denda otomatis berdasarkan tanggal kembali ---
        $tanggal_kembali = new DateTime($transaksi->tanggal_kembali);
        $hari_ini = new DateTime();
        $denda = 0;
        $tarif_denda_per_hari = 1000; // kamu bisa ubah nanti jadi ambil dari tabel setting

        if ($hari_ini > $tanggal_kembali) {
            $selisih = $hari_ini->diff($tanggal_kembali)->days;
            $denda = $selisih * $tarif_denda_per_hari;
        }

        // Format denda ke bentuk rupiah
        $nominal_denda = 'Rp ' . number_format($denda, 0, ',', '.');

        // 🟢 Pesan resmi & singkat
        $pesan = "Assalamu'alaikum,\n\n"
            . "Yth. Bapak/Ibu/Wali/Saudara/Saudari,\n\n"
            . "Kami informasikan bahwa siswa dengan detail berikut:\n\n"
            . "Nama       : {$transaksi->nama}\n"
            . "Judul Buku : {$transaksi->judul}\n"
            . "Denda      : {$nominal_denda}\n\n"
            . "memiliki keterlambatan dalam pengembalian buku perpustakaan. "
            . "Mohon agar segera mengembalikan buku tersebut dan menyelesaikan administrasi dendanya di perpustakaan.\n\n"
            . "Terima kasih atas perhatian dan kerja samanya.\n\n"
            . "Tertanda,\n"
            . "Perpustakaan SMP Istiqomah Sambas";

        // --- Kirim via API Fonnte ---
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
