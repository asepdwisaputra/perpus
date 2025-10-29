<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Transaksi_model extends CI_Model
{

    // Fungsi untuk mendapatkan data transaksi
    public function get_all_transaksi()
    {
        $this->db->select('transaksi.*, anggota.nama, anggota.no_anggota, buku.judul, buku.no_buku');
        $this->db->from('transaksi');
        $this->db->join('anggota', 'transaksi.id_anggota = anggota.id_anggota');
        $this->db->join('buku', 'transaksi.id_buku = buku.id_buku');
        $this->db->order_by('transaksi.id_transaksi', 'DESC');
        return $this->db->get()->result();
    }

    // Fungsi cari transaksi
    public function search_transaksi($keyword)
    {
        $this->db->select('transaksi.*, anggota.nama, anggota.no_anggota, buku.judul, buku.no_buku');
        $this->db->from('transaksi');
        $this->db->join('anggota', 'anggota.id_anggota = transaksi.id_anggota');
        $this->db->join('buku', 'buku.id_buku = transaksi.id_buku');
        $this->db->group_start();
        $this->db->like('anggota.nama', $keyword);
        $this->db->or_like('anggota.no_anggota', $keyword);
        $this->db->or_like('buku.judul', $keyword);
        $this->db->or_like('buku.no_buku', $keyword);
        $this->db->or_like('transaksi.status', $keyword);
        $this->db->group_end();
        return $this->db->get()->result();
    }

    public function get_transaksi_dipinjam()
    {
        $this->db->select('
        transaksi.id_transaksi,
        transaksi.id_buku,
        transaksi.id_anggota,
        transaksi.tanggal_pinjam,
        transaksi.tanggal_kembali,
        transaksi.status,
        anggota.nama,
        anggota.telepon,
        buku.judul
    ');
        $this->db->from('transaksi');
        $this->db->join('anggota', 'anggota.id_anggota = transaksi.id_anggota');
        $this->db->join('buku', 'buku.id_buku = transaksi.id_buku');
        $this->db->where('transaksi.status', 'Dipinjam');
        return $this->db->get()->result();
    }
}
