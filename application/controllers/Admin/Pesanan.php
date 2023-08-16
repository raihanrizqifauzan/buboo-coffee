<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pesanan extends CI_Controller
{
    public function __construct(Type $var = null) {
        parent::__construct();
        $this->load->model(["M_login", "M_notif", 'M_pesanan', 'M_order']);
        if(empty($this->session->userdata('username'))) {
            redirect(base_url('admin/login'));
        }
    }

	public function index()
	{
        $this->load->model("M_menu");

        $data['title_page'] = "Manajemen Pesanan - Buboo Coffee";
        $data['judul'] = "Pesanan";
        $data['back_url'] = base_url('admin');
        $data['list_menu'] = $this->M_menu->getAllMenu();
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
            if ($filter_status == "pending") {
                $row[] = $this->generate_row_pesanan_pending($item);
            } else if ($filter_status == "on process") {
                $row[] = $this->generate_row_pesanan_onprocess($item);
            } else if ($filter_status == "success") {
                $row[] = $this->generate_row_pesanan_success($item);
            } else if ($filter_status == "cancel") {
                $row[] = $this->generate_row_pesanan_cancel($item);
            }
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

    public function generate_row_pesanan_pending($item)
    {
        $status_order = '<span class="badge badge-warning">Belum Bayar</span>';
        $meja = $item->no_meja;
        if ($meja == "take-away") {
            $meja = "Take Away";
        }
        $nama_customer = strlen($item->nama_customer) > 10 ? explode(" ", $item->nama_customer)[0] : $item->nama_customer;
        $html = '
        <div class="d-flex justify-content-between p-1 align-items-center" style="border-bottom:1px solid #e9ecef">
            <div>
                <small>'.$nama_customer.'</small>
                <div><small>'.date("d/m/Y H:i", strtotime($item->datetime_order)).'</small></div>
            </div>
            <div><small>'.$status_order.'</small></div>
        </div>
        <div class="d-flex justify-content-between py-2" style="border-bottom:1px solid #e9ecef">
            <div>
                <img src="'.base_url('assets/public/img/menu/'.$item->thumbnail).'" alt="" width="80" height="80">
            </div>
            <div class="mx-3 w-100" style="position:relative">
                <b>#'.$item->no_pesanan.'</b>
                <div><small>Meja : '.$meja.'</small></div>
                <div><small><b>Total : Rp'.number_format($item->total_order, 0, "", ".").'</b></small></div>
            </div>
        </div>
        <div class="d-flex justify-content-between py-2">
            <div>
                <button class="btn btn-sm btn-outline-secondary btnDetail" data-id="'.$item->no_pesanan.'">Lihat</button>
                <button class="btn btn-sm btn-warning btnEdit" data-voucher="'.$item->id_promo_voucher.'" data-id="'.$item->no_pesanan.'">Edit</button>
            </div>
            <div class="d-flex justify-content-end">
                <div class="mx-2">
                    <button class="btn btn-sm btn-outline-danger btnCancel" data-id="'.$item->no_pesanan.'">Cancel</button>
                </div>
                <div>
                    <button class="btn btn-sm btn-primary btnProses" data-id="'.$item->no_pesanan.'">Proses</button>
                </div>
            </div>
        </div>
        <hr style="margin-top:0px">';
        return $html;
    }

    public function generate_row_pesanan_onprocess($item)
    {
        $status_order = '<span class="badge badge-info">Diproses</span>';
        $meja = $item->no_meja;
        if ($meja == "take-away") {
            $meja = "Take Away";
        }
        $nama_customer = strlen($item->nama_customer) > 10 ? explode(" ", $item->nama_customer)[0] : $item->nama_customer;
        $html = '
        <div class="d-flex justify-content-between p-1 align-items-center" style="border-bottom:1px solid #e9ecef">
            <div>
                <small>'.$nama_customer.'</small>
                <div><small>'.date("d/m/Y H:i", strtotime($item->datetime_order)).'</small></div>
            </div>
            <div><small>'.$status_order.'</small></div>
        </div>
        <div class="d-flex justify-content-between py-2" style="border-bottom:1px solid #e9ecef">
            <div>
                <img src="'.base_url('assets/public/img/menu/'.$item->thumbnail).'" alt="" width="80" height="80">
            </div>
            <div class="mx-3 w-100" style="position:relative">
                <b>#'.$item->no_pesanan.'</b>
                <div><small>Meja : '.$meja.'</small></div>
                <div><small><b>Total : Rp'.number_format($item->total_order, 0, "", ".").'</b></small></div>
            </div>
        </div>
        <div class="d-flex justify-content-between py-2">
            <div>
                <button class="btn btn-sm btn-outline-secondary btnDetail" data-id="'.$item->no_pesanan.'">Lihat</button>
            </div>
            <div>
                <!-- <button class="btn btn-sm btn-outline-danger btnCancel" data-id="'.$item->no_pesanan.'">Cancel</button> -->
                <button class="btn btn-sm btn-success btnSend" data-id="'.$item->no_pesanan.'">Siap Diantar</button>
            </div>
        </div>
        <hr style="margin-top:0px">';
        return $html;
    }

    

    public function generate_row_pesanan_success($item)
    {
        $status_order = '<span class="badge badge-success">Sudah Diantarkan</span>';
        $meja = $item->no_meja;
        if ($meja == "take-away") {
            $meja = "Take Away";
        }
        $nama_customer = strlen($item->nama_customer) > 10 ? explode(" ", $item->nama_customer)[0] : $item->nama_customer;
        $html = '
        <div class="d-flex justify-content-between p-1 align-items-center" style="border-bottom:1px solid #e9ecef">
            <div>
                <small>'.$nama_customer.'</small>
                <div><small>'.date("d/m/Y H:i", strtotime($item->datetime_order)).'</small></div>
            </div>
            <div><small>'.$status_order.'</small></div>
        </div>
        <div class="d-flex justify-content-between py-2" style="border-bottom:1px solid #e9ecef">
            <div>
                <img src="'.base_url('assets/public/img/menu/'.$item->thumbnail).'" alt="" width="80" height="80">
            </div>
            <div class="mx-3 w-100" style="position:relative">
                <b>#'.$item->no_pesanan.'</b>
                <div><small>Meja : '.$meja.'</small></div>
                <div><small><b>Total : Rp'.number_format($item->total_order, 0, "", ".").'</b></small></div>
            </div>
        </div>
        <div class="d-flex justify-content-end py-2">
            <div>
                <button class="btn btn-sm btn-outline-secondary btnDetail" data-id="'.$item->no_pesanan.'">Lihat</button>
            </div>
        </div>
        <hr style="margin-top:0px">';
        return $html;
    }

    public function generate_row_pesanan_cancel($item)
    {
        $status_order = '<span class="badge badge-danger">Dibatalkan</span>';
        $meja = $item->no_meja;
        if ($meja == "take-away") {
            $meja = "Take Away";
        }
        $nama_customer = strlen($item->nama_customer) > 10 ? explode(" ", $item->nama_customer)[0] : $item->nama_customer;
        $html = '
        <div class="d-flex justify-content-between p-1 align-items-center" style="border-bottom:1px solid #e9ecef">
            <div>
                <small>'.$nama_customer.'</small>
                <div><small>'.date("d/m/Y H:i", strtotime($item->datetime_order)).'</small></div>
            </div>
            <div><small>'.$status_order.'</small></div>
        </div>
        <div class="d-flex justify-content-between py-2" style="border-bottom:1px solid #e9ecef">
            <div>
                <img src="'.base_url('assets/public/img/menu/'.$item->thumbnail).'" alt="" width="80" height="80">
            </div>
            <div class="mx-3 w-100" style="position:relative">
                <b>#'.$item->no_pesanan.'</b>
                <div><small>Meja : '.$meja.'</small></div>
                <div><small><b>Total : Rp'.number_format($item->total_order, 0, "", ".").'</b></small></div>
            </div>
        </div>
        <div class="d-flex justify-content-end py-2">
            <div>
                <button class="btn btn-sm btn-outline-secondary btnDetail" data-id="'.$item->no_pesanan.'">Lihat</button>
            </div>
        </div>
        <hr style="margin-top:0px">';
        return $html;
    }

    public function cancel_order()
    {
        $this->load->helper('order');
        $no_pesanan = $this->input->get('no_pesanan', TRUE);
        $data_order = $this->M_order->getOrderByNoPesanan($no_pesanan);

        try {
			$this->db->trans_start();
            if (empty($data_order)) {
                throw new Exception("Orderan tidak ditemukan");
            } else if ($data_order->status_order != "pending" && $data_order->status_order == "on process") {
                throw new Exception("Terjadi Kesalahan");
            }

            $new_status = ['status_order' => 'cancel'];
            $log_status_order = [
                'datetime_action' => tgl_sekarang(),
                'username_pegawai' => $this->session->userdata('username'),
                'url_action' => base_url('admin/pesanan/cancel_order?no_pesanan='.$no_pesanan),
                'id_order' => $data_order->id_order,
                'no_pesanan' => $data_order->no_pesanan,
                'status_awal' => $data_order->status_order,
                'status_akhir' => 'cancel',
            ];
            $this->M_order->saveLogStatusOrder($log_status_order);
            $this->M_order->updateDataOrder($data_order->id_order, $new_status);
            $this->db->trans_complete();
            $this->db->trans_commit();
            $message_whatsapp = "Pesananmu dengan No. $no_pesanan atas nama $data_order->nama_customer telah di Cancel";
            send_whatsapp($data_order->no_hp, $message_whatsapp);
            echo json_encode(['status' => true, 'message' => 'No Pesanan '.$no_pesanan.' telah di Cancel']);
        } catch (Exception $e) {
            $this->db->trans_rollback();
            echo json_encode(['status' => false, 'message' => $e->getMessage()]);
        }
    }

    public function process_order()
    {
        $this->load->helper('order');
        $no_pesanan = $this->input->get('no_pesanan', TRUE);
        $data_order = $this->M_order->getOrderByNoPesanan($no_pesanan);

        try {
			$this->db->trans_start();
            if (empty($data_order)) {
                throw new Exception("Orderan tidak ditemukan");
            } else if ($data_order->status_order != "pending") {
                throw new Exception("Terjadi Kesalahan");
            }

            $new_status = ['status_order' => 'on process', 'status_pembayaran' => 'approved'];
            $log_status_order = [
                'datetime_action' => tgl_sekarang(),
                'username_pegawai' => $this->session->userdata('username'),
                'url_action' => base_url('admin/pesanan/process_order?no_pesanan='.$no_pesanan),
                'id_order' => $data_order->id_order,
                'no_pesanan' => $data_order->no_pesanan,
                'status_awal' => $data_order->status_order,
                'status_akhir' => 'on process',
            ];
            $this->M_order->saveLogStatusOrder($log_status_order);
            $this->M_order->updateDataOrder($data_order->id_order, $new_status);
            $this->db->trans_complete();
            $this->db->trans_commit();
            $message_whatsapp = "Pembayaran Pesanan dengan No. $no_pesanan atas nama $data_order->nama_customer telah kami terima dan akan segera kami Proses. Mohon tunggu ya, Terimakasih";
            send_whatsapp($data_order->no_hp, $message_whatsapp);
            echo json_encode(['status' => true, 'message' => 'No Pesanan '.$no_pesanan.' telah dipindahkan statusnya menjadi Diproses']);
        } catch (Exception $e) {
            $this->db->trans_rollback();
            echo json_encode(['status' => false, 'message' => $e->getMessage()]);
        }
    }

    public function send_order()
    {
        $this->load->helper('order');
        $no_pesanan = $this->input->get('no_pesanan', TRUE);
        $data_order = $this->M_order->getOrderByNoPesanan($no_pesanan);

        try {
			$this->db->trans_start();
            if (empty($data_order)) {
                throw new Exception("Orderan tidak ditemukan");
            } else if ($data_order->status_order != "on process") {
                throw new Exception("Terjadi Kesalahan");
            }

            $new_status = ['status_order' => 'success'];
            $log_status_order = [
                'datetime_action' => tgl_sekarang(),
                'username_pegawai' => $this->session->userdata('username'),
                'url_action' => base_url('admin/pesanan/send_order?no_pesanan='.$no_pesanan),
                'id_order' => $data_order->id_order,
                'no_pesanan' => $data_order->no_pesanan,
                'status_awal' => $data_order->status_order,
                'status_akhir' => 'success',
            ];
            $this->M_order->saveLogStatusOrder($log_status_order);
            $this->M_order->updateDataOrder($data_order->id_order, $new_status);
            $this->db->trans_complete();
            $this->db->trans_commit();
            $message_whatsapp = "Pesanan dengan No. $no_pesanan atas nama $data_order->nama_customer telah selesai diproses dan akan diantarkan. Selamat menikmati";
            send_whatsapp($data_order->no_hp, $message_whatsapp);
            echo json_encode(['status' => true, 'message' => 'No Pesanan '.$no_pesanan.' telah selesai Diproses']);
        } catch (Exception $e) {
            $this->db->trans_rollback();
            echo json_encode(['status' => false, 'message' => $e->getMessage()]);
        }
    }

    public function ajax_detail_pesanan()
    {
        $no_pesanan = $this->input->get('no_pesanan', TRUE);
        $data_order = $this->M_order->getOrderByNoPesanan($no_pesanan);

        try {
            if (empty($data_order)) {
                throw new Exception("Pesanan tidak ditemukan");
            }

            $data_order->thumbnail = base_url('assets/public/img/menu/').$data_order->thumbnail;
            $data_order->datetime_order = date("d M Y H:i", strtotime($data_order->datetime_order));
            $detail_order = $this->M_order->getDetailOrderWithoutPromo($data_order->id_order);
            foreach ($detail_order as $key => $dt) {
                $detail_order[$key]->thumbnail = base_url('assets/public/img/menu/').$dt->thumbnail;
            }

            $result = [
                'data_order' => $data_order,
                'detail_order' => $detail_order,
            ];
            echo json_encode(['status' => true, 'message' => "Success get order", 'data' => $result]);
        } catch (Exception $e) {
            echo json_encode(['status' => false, 'message' => $e->getMessage()]);
        }
    }
}