<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Buku_model extends CI_Model
{

    // Fungsi untuk mendapatkan data buku
    public function get_all_buku()
    {
        return $this->db->get('buku')->result();
    }

    // Tambah buku baru
    public function tambah_buku($data)
    {
        return $this->db->insert('buku', $data);
    }

    // Fungsi untuk mengecek apakah nomor buku sudah ada
    public function is_no_buku_exists($no_buku)
    {
        $this->db->where('no_buku', $no_buku);
        $query = $this->db->get('buku');

        // Jika ditemukan, berarti nomor buku sudah ada
        if ($query->num_rows() > 0) {
            return true;
        }

        // Jika tidak ditemukan, berarti nomor buku belum ada
        return false;
    }

    // Fungsi cari buku
    public function search_buku($keyword)
    {
        $this->db->like('judul', $keyword);
        $this->db->or_like('no_buku', $keyword);
        $this->db->or_like('penulis', $keyword);
        $this->db->or_like('penerbit', $keyword);
        $this->db->or_like('rak', $keyword);
        return $this->db->get('buku')->result();
    }

    // Fungsi untuk mendapatkan data buku berdasarkan nomor buku
    public function get_buku_by_no($no_buku)
    {
        $this->db->where('no_buku', $no_buku);
        return $this->db->get('buku')->row();
    }

    // Fungsi untuk mengupdate data buku
    public function update_buku($no_buku, $data)
    {
        $this->db->where('no_buku', $no_buku);
        return $this->db->update('buku', $data);
    }

    // Fungsi untuk menghapus buku
    public function hapus_buku($no_buku)
    {
        $this->db->where('no_buku', $no_buku);
        return $this->db->delete('buku');
    }

    // ambil data buku >0 untuk user/katalog
    public function get_buku_tersedia()
    {
        $this->db->where('stock >', 0);
        return $this->db->get('buku')->result();
    }
}
