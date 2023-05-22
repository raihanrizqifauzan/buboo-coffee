<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
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
        $data['title_page'] = "Halaman Dashboard - Buboo Coffee";
        $this->load->view('admin/structure/V_head', $data);
        $this->load->view('admin/structure/V_topbar');
        $this->load->view('admin/structure/V_sidebar');
		$this->load->view('admin/V_dashboard');
        $this->load->view('admin/structure/V_foot');
	}

    public function saveIdOnesignal()
    {
        $userId = $this->input->post('userId', TRUE);
        $data = [
            'user_id' => $userId,
        ];

        $check = $this->M_notif->getUserIdOneSignal($userId);
        if (empty($check)) {
            $this->M_notif->registerOneSignal($data);
        }
        echo json_encode($this->input->post('userId'));
    }

    public function test()
    {
        $this->load->helper("onesignal");
        $getIdOnesignal = $this->M_notif->getUserIdOneSignal();
        $temponesignal = [];
        foreach ($getIdOnesignal as $key => $idonesignal) {
            $temponesignal[] = $idonesignal->user_id;
        }

        $title = "Hi, Ada Pesanan Baru";
        $message = "Pesanan baru dari meja No. 8";
        $url_notif = base_url("admin/");
        echo send_message($message, $title, $temponesignal, $url_notif);
    }

}


?>