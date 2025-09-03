<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function logout()
    {
        // Hapus session
        $this->session->unset_userdata('admin_logged_in');
        $this->session->unset_userdata('admin_username');

        // Redirect ke halaman login admin
        redirect('user/login_admin');
    }

    public function confirm_logout()
    {
        // Load view konfirmasi logout
        $this->load->view('admin/logout'); // Sesuaikan nama file view
    }
}
