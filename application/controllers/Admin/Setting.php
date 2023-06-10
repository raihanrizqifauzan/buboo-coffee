<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Setting extends CI_Controller
{
    public function __construct(Type $var = null) {
        parent::__construct();
        $this->load->model(["M_Setting"]);
        if(empty($this->session->userdata('username'))) {
            redirect(base_url('admin/login'));
        }
    }


    public function index()
	{
        $data['title_page'] = "Setting Toko - Buboo Coffee";
        $data['judul'] = "Setting Toko";
        $data['back_url'] = base_url('admin');
        $this->load->view('admin/structure/V_head', $data);
        $this->load->view('admin/structure/V_topbar');
        $this->load->view('admin/structure/V_sidebar');
		$this->load->view('admin/V_setting_toko');
        $this->load->view('admin/structure/V_foot');
	}
}