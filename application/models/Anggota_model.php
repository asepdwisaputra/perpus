<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Anggota_model extends CI_Model
{

    // Fungsi untuk mendapatkan data anggota
    public function get_all_anggota()
    {
        return $this->db->get('anggota')->result();
    }

    // Fungsi untuk menambahkan anggota baru
    public function tambah_anggota($data)
    {
        return $this->db->insert('anggota', $data);
    }

    // Fungsi untuk mendapatkan data anggota berdasarkan nomor anggota
    public function get_anggota_by_no($no_anggota)
    {
        $this->db->where('no_anggota', $no_anggota);
        return $this->db->get('anggota')->row();
    }

    // Fungsi untuk mengupdate data anggota
    public function update_anggota($no_anggota, $data)
    {
        $this->db->where('no_anggota', $no_anggota);
        return $this->db->update('anggota', $data);
    }

    // Fungsi untuk menghapus anggota
    public function hapus_anggota($no_anggota)
    {
        $this->db->where('no_anggota', $no_anggota);
        return $this->db->delete('anggota');
    }

    // Fungsi cari anggota
    public function search_anggota($keyword)
    {
        $this->db->like('nama', $keyword);
        $this->db->or_like('no_anggota', $keyword);
        return $this->db->get('anggota')->result();
    }

    public function get_by_no_anggota($no_anggota)
    {
        return $this->db->get_where('anggota', ['no_anggota' => $no_anggota])->row();
    }

    // Fungsi untuk mengecek apakah nomor anggota sudah ada
    public function is_no_anggota_exists($no_anggota)
    {
        $this->db->where('no_anggota', $no_anggota);
        $query = $this->db->get('anggota');

        // Jika ditemukan, berarti nomor anggota sudah ada
        if ($query->num_rows() > 0) {
            return true;
        }

        // Jika tidak ditemukan, berarti nomor anggota belum ada
        return false;
    }
}
