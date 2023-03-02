<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
    public function __construct(Type $var = null) {
        parent::__construct();
        $this->load->model("M_login");
        if(empty($this->session->userdata('username'))) {
            redirect(base_url('admin/login'));
        }
    }


	public function index()
	{
        $data['title_page'] = "Halaman Dashboard - Buboo Coffee";
        $this->load->view('admin/structure/V_head', $data);
        $this->load->view('admin/structure/V_topbar');
        $this->load->view('admin/structure/V_sidebar');
		$this->load->view('admin/V_dashboard');
        $this->load->view('admin/structure/V_foot');
	}

}


?>