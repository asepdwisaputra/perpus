<?php
class Pemesanan_model extends CI_Model
{
    public function get_all_pemesanan()
    {
        $this->db->select('pemesanan.*, anggota.nama, anggota.no_anggota, buku.judul, buku.no_buku');
        $this->db->from('pemesanan');
        $this->db->join('anggota', 'anggota.id_anggota = pemesanan.id_anggota');
        $this->db->join('buku', 'buku.id_buku = pemesanan.id_buku');
        $this->db->where('pemesanan.status', 'pending'); // 🔥 filter hanya pending
        $this->db->order_by('pemesanan.id_pemesanan', 'DESC');
        return $this->db->get()->result();
    }


    public function terima_pemesanan($id_pemesanan)
    {
        $pemesanan = $this->db->get_where('pemesanan', ['id_pemesanan' => $id_pemesanan])->row();

        if ($pemesanan) {
            // Insert ke transaksi
            $data = [
                'id_anggota'       => $pemesanan->id_anggota,
                'id_buku'          => $pemesanan->id_buku,
                'tanggal_pinjam'   => date('Y-m-d'),
                'tanggal_kembali'  => date('Y-m-d', strtotime('+7 days'))
            ];
            $this->db->insert('transaksi', $data);

            // Update status pemesanan jadi diterima
            $this->db->where('id_pemesanan', $id_pemesanan);
            $this->db->update('pemesanan', ['status' => 'diterima']);
        }
    }

    public function tolak_pemesanan($id_pemesanan)
    {
        $this->db->where('id_pemesanan', $id_pemesanan);
        $this->db->update('pemesanan', ['status' => 'ditolak']);
    }

    public function insert_pemesanan($no_anggota, $id_buku)
    {
        // cari anggota berdasarkan no_anggota
        $anggota = $this->db->get_where('anggota', ['no_anggota' => $no_anggota])->row();

        if (!$anggota) {
            log_message('error', 'No anggota tidak ditemukan: ' . $no_anggota);
            return false; // anggota tidak ada
        }

        // cek apakah buku ada
        $buku = $this->db->get_where('buku', ['id_buku' => $id_buku])->row();
        if (!$buku) {
            log_message('error', 'ID buku tidak ditemukan: ' . $id_buku);
            return false;
        }

        // siapkan data pemesanan
        $data = [
            'id_anggota'    => $anggota->id_anggota,
            'id_buku'       => $id_buku,
            'tanggal_pesan' => date('Y-m-d'),
            'status'        => 'pending'
        ];

        // insert ke tabel pemesanan
        $this->db->insert('pemesanan', $data);

        if ($this->db->affected_rows() > 0) {
            return true; // sukses
        } else {
            log_message('error', 'Insert pemesanan gagal: ' . print_r($data, true));
            return false;
        }
    }

    // public function insert_pemesanan($no_anggota, $id_buku)
    // {
    //     // 🔥 Debug input
    //     echo "<pre>";
    //     echo "DEBUG INPUT:\n";
    //     echo "No Anggota: " . $no_anggota . "\n";
    //     echo "ID Buku: " . $id_buku . "\n";
    //     echo "</pre>";

    //     // cari anggota berdasarkan no_anggota
    //     $anggota = $this->db->get_where('anggota', ['no_anggota' => $no_anggota])->row();

    //     if (!$anggota) {
    //         echo "<p style='color:red'>Anggota tidak ditemukan!</p>";
    //         exit;
    //     }

    //     $data = [
    //         'id_anggota'    => $anggota->id_anggota,
    //         'id_buku'       => $id_buku,
    //         'tanggal_pesan' => date('Y-m-d'),
    //         'status'        => 'pending'
    //     ];

    //     // debug sebelum insert
    //     echo "<pre>DEBUG DATA YANG AKAN DIINSERT:\n";
    //     print_r($data);
    //     echo "</pre>";

    //     $this->db->insert('pemesanan', $data);

    //     if ($this->db->affected_rows() > 0) {
    //         echo "<p style='color:green'>✅ Insert berhasil!</p>";
    //     } else {
    //         echo "<p style='color:red'>❌ Insert gagal!</p>";
    //         echo $this->db->last_query(); // query terakhir
    //     }

    //     exit; // stop biar keliatan hasilnya di browser
    // }
}
