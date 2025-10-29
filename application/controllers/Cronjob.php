<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cronjob extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Transaksi_model');
        date_default_timezone_set('Asia/Jakarta');
    }

    // Fungsi otomatis kirim notifikasi H-0 dan H+1
    public function kirim_pengingat()
    {
        echo "🚀 Cronjob Kirim Pengingat Dijalankan<br>";
        echo "Tanggal: " . date('d-m-Y H:i:s') . "<br><br>";

        $transaksi_list = $this->Transaksi_model->get_transaksi_dipinjam();
        $hari_ini = new DateTime();
        $tarif_denda_per_hari = 1000;

        if (empty($transaksi_list)) {
            echo "⚠️ Tidak ada transaksi yang sedang dipinjam.<br>";
        }

        foreach ($transaksi_list as $t) {
            $tanggal_kembali = new DateTime($t->tanggal_kembali);
            $selisih = (int)$hari_ini->diff($tanggal_kembali)->format('%r%a'); // selisih hari (+/-)
            $pesan = '';
            $kirim = false;

            // H-1 → Pengingat sebelum jatuh tempo
            if ($selisih == 0) {
                $pesan = "Assalamu'alaikum,\n\n"
                    . "Halo {$t->nama},\n\n"
                    . "Ini adalah *pengingat* bahwa buku yang Anda pinjam:\n\n"
                    . "📖 Judul Buku : {$t->judul}\n"
                    . "📅 Tanggal Kembali : {$t->tanggal_kembali}\n\n"
                    . "Akan jatuh tempo *besok*. Mohon segera dikembalikan ke perpustakaan.\n\n"
                    . "Terima kasih atas kerja samanya.\n"
                    . "- Perpustakaan SMP Istiqomah Sambas";
                $kirim = true;
            }
            // H+1 → Sudah terlambat 7 hari
            elseif ($selisih <= 7) {
                $denda = abs($selisih) * $tarif_denda_per_hari;
                $nominal_denda = 'Rp ' . number_format($denda, 0, ',', '.');
                $pesan = "Assalamu'alaikum,\n\n"
                    . "Halo {$t->nama},\n\n"
                    . "Buku yang Anda pinjam sudah *terlambat* dikembalikan:\n\n"
                    . "📖 Judul Buku : {$t->judul}\n"
                    . "📅 Tanggal Kembali : {$t->tanggal_kembali}\n"
                    . "💰 Denda Sementara : {$nominal_denda}\n\n"
                    . "Mohon segera mengembalikan buku tersebut dan menyelesaikan administrasi dendanya di perpustakaan.\n\n"
                    . "- Perpustakaan SMP Istiqomah Sambas";
                $kirim = true;
            }

            if ($kirim) {
                $this->_kirim_wa($t->telepon, $pesan);
                echo "📩 Pesan dikirim ke {$t->nama} ({$t->telepon})<br>";
            } else {
                echo "➡️ Tidak perlu kirim ke {$t->nama} — selisih: {$selisih} hari<br>";
            }
        }

        echo "<br>✅ Cronjob selesai dijalankan pada " . date('d-m-Y H:i:s');
    }

    // Fungsi kirim via API Fonnte
    private function _kirim_wa($nomor, $pesan)
    {
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => 'https://api.fonnte.com/send',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => [
                'target' => $nomor,
                'message' => $pesan,
                'countryCode' => '62',
            ],
            CURLOPT_HTTPHEADER => [
                'Authorization: Q3CNLUzuTYyEDFwxvjia'
            ],
        ]);

        $response = curl_exec($curl);
        curl_close($curl);

        $result = json_decode($response, true);
        return isset($result['status']) && $result['status'] == true;
    }
}
