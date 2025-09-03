<?php
class Denda_model extends CI_Model
{
    // Ambil 1 Transaksi spesifik untuk kirim WA
    public function get_transaksi_by_id($id_transaksi)
    {
        $this->db->select('transaksi.*, anggota.nama, anggota.telepon, buku.judul');
        $this->db->from('transaksi');
        $this->db->join('anggota', 'anggota.id_anggota = transaksi.id_anggota');
        $this->db->join('buku', 'buku.id_buku = transaksi.id_buku');
        $this->db->where('transaksi.id_transaksi', $id_transaksi);
        return $this->db->get()->row();
    }

    public function search_transaksi_terlambat($keyword)
    {
        $today = date('Y-m-d');

        $this->db->select('transaksi.*, anggota.nama, anggota.no_anggota, buku.judul, buku.no_buku');
        $this->db->from('transaksi');
        $this->db->join('anggota', 'anggota.id_anggota = transaksi.id_anggota');
        $this->db->join('buku', 'buku.id_buku = transaksi.id_buku');
        $this->db->where('transaksi.status', 'Dipinjam');
        $this->db->where('transaksi.tanggal_kembali <', $today);

        // Tambahkan filter berdasarkan keyword di beberapa kolom
        $this->db->group_start();
        $this->db->like('anggota.nama', $keyword);
        $this->db->or_like('anggota.no_anggota', $keyword);
        $this->db->or_like('buku.judul', $keyword);
        $this->db->or_like('buku.no_buku', $keyword);
        $this->db->group_end();

        return $this->db->get()->result();
    }


    public function get_transaksi_terlambat()
    {
        // Ambil tanggal hari ini dalam format Y-m-d
        $today = date('Y-m-d');

        // Query untuk ambil transaksi yang statusnya masih Dipinjam dan sudah melewati tanggal kembali
        $this->db->select('transaksi.*, anggota.nama, anggota.no_anggota, buku.judul, buku.no_buku');
        $this->db->from('transaksi');
        $this->db->join('anggota', 'anggota.id_anggota = transaksi.id_anggota');
        $this->db->join('buku', 'buku.id_buku = transaksi.id_buku');
        $this->db->where('transaksi.status', 'Dipinjam');
        $this->db->where('transaksi.tanggal_kembali <', $today);

        // echo $today;
        // echo date_default_timezone_get();


        // Eksekusi dan kembalikan hasilnya
        return $this->db->get()->result();
    }
}
