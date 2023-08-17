<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Meja extends CI_Controller
{
    public function __construct(Type $var = null) {
        parent::__construct();
        $this->load->model(["M_infoweb", "M_order"]);
        if(empty($this->session->userdata('username'))) {
            redirect(base_url('admin/login'));
        }
    }

    public function index()
	{
        $data['data'] = $this->M_infoweb->getInfoWeb();
        $data['jumlah_meja'] = $this->M_infoweb->countMeja();
        $data['title_page'] = "Kelola No. Meja - Buboo Coffee";
        $data['judul'] = "Atur Meja";
        $data['back_url'] = base_url('admin');
        $this->load->view('admin/structure/V_head', $data);
        $this->load->view('admin/structure/V_topbar');
        $this->load->view('admin/structure/V_sidebar');
		$this->load->view('admin/V_manage_meja');
        $this->load->view('admin/structure/V_foot');
	}

    public function generate_qr() {
        $data['info'] = $this->M_infoweb->getInfoWeb();
        $data['jumlah_meja'] = $this->M_infoweb->countMeja();
        $meja = $this->input->get("meja");
        if ($meja != "all") {
            $arr_meja = explode(",", $meja);
            foreach ($arr_meja as $key => $m) {
                $check = $this->M_order->getMejaByNumber($m);
                if (empty($check)) {
                    $flashdata = ['notif_message' => "Harap sesuaikan no meja dengan jumlah meja", 'notif_icon' => "error"];
                    $this->session->set_flashdata($flashdata);
                    redirect(base_url('admin/meja'));
                }
            }
        }

        // $mpdf = new \Mpdf\Mpdf();
		// $view = $this->load->view('admin/V_generate_qr', $data, TRUE);
		// $mpdf->WriteHTML($view);
		// $mpdf->Output();

		$this->load->view('admin/V_generate_qr', $data);
    }

    public function update_meja() {
        $jumlah_meja = $this->input->post('jumlah_meja');
        if ($jumlah_meja < 1) {
            echo json_encode(['status' => false, 'message' => "Jumlah meja tidak valid"]);die;
        } else {
            $this->M_infoweb->updateMeja($jumlah_meja);
            
            $flashdata = ['notif_message' => "Berhasil mengupdate meja", 'notif_icon' => "success"];
			$this->session->set_flashdata($flashdata);
            echo json_encode(['status' => true, 'message' => "Berhasil mengupdate meja"]);die;
        }
    }

}


?>