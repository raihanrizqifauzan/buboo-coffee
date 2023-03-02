<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{
    public function __construct(Type $var = null) {
        parent::__construct();
        $this->load->model("M_login");
        if($this->session->userdata('username')) {
            redirect(base_url('admin/dashboard'));
        }
    }

	public function index()
	{
		$this->load->view('admin/V_login');
	}

    public function auth()
    {
        $username = $this->input->post('username', TRUE);
        $password = md5(md5($this->input->post('password', TRUE)));

        $check = $this->M_login->checkLogin($username, $password);
        if ($check) {
            $session_set = [
                'username' => $username,
                'nama_admin' => $check->nama_lengkap
            ];
            $this->session->set_userdata($session_set);
            $flashdata = ['notif_message' => "Berhasil Login", 'notif_icon' => "success"];
			$this->session->set_flashdata($flashdata);
            redirect(base_url('admin/dashboard'));
        } else {
            $flashdata = ['notif_message' => "Gagal Login. Username/Password salah", 'notif_icon' => "error"];
            $this->session->set_flashdata($flashdata);
            redirect(base_url('admin/login'));
        }
    }
}

?>