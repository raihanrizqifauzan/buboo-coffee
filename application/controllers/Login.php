<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{
	public function __construct(Type $var = null) {
        parent::__construct();
        $this->load->model(["M_infoweb", "M_kategori", "M_menu", "M_order", "M_notif"]);
    }

    public function index()
    {
        if ($this->session->userdata('no_hp')) {
            redirect(base_url('daftar-menu'));
        }
		$data['title_of_page'] = 'Masuk/Daftar | Buboo Coffee';
		$data['judul_halaman'] = 'Masuk/Daftar';
		$data['back_url'] = base_url('daftar-menu');
		$this->load->view('public/structure/V_head', $data);
		$this->load->view('public/structure/V_topbar');
		$this->load->view('public/V_login');
		$this->load->view('public/structure/V_foot');
    }
}