<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Informasi_website extends CI_Controller
{
    public function __construct(Type $var = null) {
        parent::__construct();
        $this->load->model("M_infoweb");
        if(empty($this->session->userdata('username'))) {
            redirect(base_url('admin/login'));
        }
    }


	public function index()
	{
        redirect(base_url('admin/informasi-website/contact'));
	}

    public function contact()
	{
        $data['data'] = $this->M_infoweb->getInfoWeb();
        $data['title_page'] = "Halaman Kontak - Buboo Coffee";
        $this->load->view('admin/structure/V_head', $data);
        $this->load->view('admin/structure/V_topbar');
        $this->load->view('admin/structure/V_sidebar');
		$this->load->view('admin/V_manage_kontak');
        $this->load->view('admin/structure/V_foot');
	}

    public function edit_contact()
    {
        $this->load->library('form_validation');
        $rules = [
            [ 'field' => 'latitude_longitude', 'label' => 'Latitude Longitude', 'rules' => 'required'],
            [ 'field' => 'alamat_lengkap', 'label' => 'Alamat Lengkap', 'rules' => 'required'],
            [ 'field' => 'no_telp', 'label' => 'No. Telp', 'rules' => 'required|max_length[15]'],
            [ 'field' => 'hari_operasional', 'label' => 'Hari Operasional', 'rules' => 'required'],
        ];
        $this->form_validation->set_rules($rules);

        if ($this->form_validation->run() === FALSE) {
            $flashdata = ['notif_message' => validation_errors(), 'notif_icon' => "error"];
			$this->session->set_flashdata($flashdata);
            redirect(base_url('admin/informasi-website/contact'));
        } 

        $data = [
            'latitude_longitude' => $this->input->post('latitude_longitude', TRUE),
            'alamat_lengkap' => $this->input->post('alamat_lengkap', TRUE),
            'no_telp' => "+62".$this->input->post('no_telp', TRUE),
            'hari_operasional' => $this->input->post('hari_operasional', TRUE),
        ];

        $this->M_infoweb->updateContact($data);

        $flashdata = ['notif_message' => "Berhasil menyimpan informasi kontak", 'notif_icon' => "success"];
        $this->session->set_flashdata($flashdata);
        redirect(base_url('admin/informasi-website/contact'));
    }

    public function about()
	{
        $data['data'] = $this->M_infoweb->getInfoWeb();
        $data['title_page'] = "Halaman About - Buboo Coffee";
        $this->load->view('admin/structure/V_head', $data);
        $this->load->view('admin/structure/V_topbar');
        $this->load->view('admin/structure/V_sidebar');
		$this->load->view('admin/V_manage_about');
        $this->load->view('admin/structure/V_foot');
	}

    public function edit_about()
	{
        $this->load->library('form_validation');
        $rules = [
            [ 'field' => 'content_about', 'label' => 'Konten About', 'rules' => 'required'],
        ];
        $this->form_validation->set_rules($rules);

        if ($this->form_validation->run() === FALSE) {
            $flashdata = ['notif_message' => validation_errors(), 'notif_icon' => "error"];
			$this->session->set_flashdata($flashdata);
            redirect(base_url('admin/informasi-website/about'));
        } 

        $data = [
            'content_about' => $this->input->post('content_about'),
        ];

        $this->M_infoweb->updateContact($data);

        $flashdata = ['notif_message' => "Berhasil menyimpan konten halaman about", 'notif_icon' => "success"];
        $this->session->set_flashdata($flashdata);
        redirect(base_url('admin/informasi-website/about'));
	}

}


?>