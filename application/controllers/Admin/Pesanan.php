<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pesanan extends CI_Controller
{
    public function __construct(Type $var = null) {
        parent::__construct();
        $this->load->model(["M_login", "M_notif"]);
        if(empty($this->session->userdata('username'))) {
            redirect(base_url('admin/login'));
        }
    }

	public function index()
	{
        $data['title_page'] = "Manajemen Pesanan - Buboo Coffee";
        $this->load->view('admin/structure/V_head', $data);
        $this->load->view('admin/structure/V_topbar');
        $this->load->view('admin/structure/V_sidebar');
		$this->load->view('admin/V_manage_pesanan');
        $this->load->view('admin/structure/V_foot');
	}

    public function ajax_get_pesanan() {
        $filter_status = $_POST['filter_status'];
        if ($filter_status == "semua" || empty($filter_status)) {
            $filter_status = "";
        }
        $list = $this->M_pesanan->get_datatables_pesanan($filter_status);
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $item) {
            $row = array();
            $row[] = $item->no_pesanan;
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->M_pesanan->count_all_pesanan($filter_status),
            "recordsFiltered" => $this->M_pesanan->count_filtered_pesanan($filter_status),
            "data" => $data,
        );

        echo json_encode($output);
    }

}