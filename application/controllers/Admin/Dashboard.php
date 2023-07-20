<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
    public function __construct(Type $var = null) {
        parent::__construct();
        $this->load->model(["M_login", "M_notif", "M_order"]);
        if(empty($this->session->userdata('username'))) {
            redirect(base_url('admin/login'));
        }
    }


	public function index()
	{
        date_default_timezone_set("Asia/Jakarta");
        $datetime_start = date("Y-m-d 00:00:00");
        $datetime_end = date("Y-m-d 23:59:59");
        $data['title_page'] = "Halaman Dashboard - Buboo Coffee";
        $data['judul'] = "Buboo Coffee";
        $data['back_url'] = "";
        $data['total_omset'] = $this->M_order->getTotalOmset($datetime_start, $datetime_end);
        $today_order = $this->M_order->getJumlahOrder($datetime_start, $datetime_end);
        $yesterday_order = $this->M_order->getJumlahOrder(date("Y-m-d 00:00:00", strtotime("-1 day", strtotime(date('Y-m-d')))), date("Y-m-d 23:59:59", strtotime("-1 day", strtotime(date('Y-m-d')))));
        // $today_order = 2;
        // $yesterday_order = 10;
        if ($today_order < $yesterday_order) {
            $persentase = round(($yesterday_order - $today_order) / $yesterday_order * 100, 2);
            $persentase *= -1; 
        } else {
            $persentase = "+".round(($today_order - $yesterday_order) / $today_order * 100, 2);
        }
        $data['jumlah_order'] = $today_order;
        $data['persentase_jumlah_order'] = $persentase;
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

    public function get_omset_per_week() {
        date_default_timezone_set("Asia/Jakarta");
        $datetime_start = date("Y-m-d 00:00:00");
        $datetime_end = date("Y-m-d 23:59:59");
        $result = [];
        $result[] = [
            'hari' => date("D"),
            'omset' => $this->M_order->getTotalOmset($datetime_start, $datetime_end)
        ];

        for ($i=1; $i <= 6; $i++) { 
            $datetime_start = date("Y-m-d 00:00:00", strtotime("-$i day", strtotime(date('Y-m-d'))));
            $datetime_end = date("Y-m-d 23:59:59", strtotime("-$i day", strtotime(date('Y-m-d'))));
            $result[] = [
                'hari' => date("D", strtotime("-$i day", strtotime(date('Y-m-d')))),
                'omset' => $this->M_order->getTotalOmset($datetime_start, $datetime_end),
            ];
        }
        $result = array_reverse($result);
        echo json_encode($result);
    }

}


?>