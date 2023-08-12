<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Welcome extends CI_Controller
{
	public function __construct(Type $var = null) {
        parent::__construct();
        $this->load->model(["M_infoweb", "M_kategori", "M_menu", "M_notif", "M_pesanan", "M_order"]);
    }

	public function index()
	{
		$data['title_of_page'] = 'Buboo Coffee';
		// $data['list_kategori'] = $this->M_kategori->getAllKategori();
		// $data['list_recommendation'] = $this->M_menu->getBestSellerMenu();
		$this->load->view('public/structure/V_head', $data);
		$this->load->view('public/structure/V_topbar');
		$this->load->view('public/V_welcome');
		$this->load->view('public/structure/V_foot');
	}

	public function daftar_menu()
	{
		$opsi = $this->input->get('p');
		if ($opsi == "take-away") {
			$this->session->set_userdata(['no_meja' => 'take-away']);
		}
		$data['list_kategori'] = $this->M_kategori->getAllKategori();
		$data['title_of_page'] = 'Menu | Buboo Coffee';
		$data['judul_halaman'] = getDataToko()->nama_toko;
		$data['back_url'] = base_url();
		$this->load->view('public/structure/V_head', $data);
		$this->load->view('public/structure/V_topbar');
		$this->load->view('public/V_list_menu');
		$this->load->view('public/structure/V_foot');
	}

	public function detail_menu($id_menu)
	{
		if (empty($id_menu)) {
			redirect(base_url('daftar-menu'));
		}
		$explode = explode(".", $id_menu);
		if (count($explode) != 2) {
			redirect(base_url('daftar-menu'));
		}
		$id_menu = $explode[1];
		$data['menu'] = $this->M_menu->getMenuById($id_menu);
		$data['related_menu'] = $this->M_menu->getRelatedMenu($data['menu']->id_kategori, $id_menu);
		$data['title_of_page'] = 'Detail Menu | Buboo Coffee';
		$data['judul_halaman'] = 'Detail Menu';
		$data['back_url'] = base_url('daftar-menu');
		$this->M_menu->updateTotalView($id_menu);
		$this->load->view('public/structure/V_head', $data);
		$this->load->view('public/structure/V_topbar');
		$this->load->view('public/V_detail_menu');
		$this->load->view('public/structure/V_foot');
	}

	public function contact()
	{
		$data['data'] = $this->M_infoweb->getInfoWeb();
		$data['title_of_page'] = 'Kontak | Buboo Coffee';
		$this->load->view('public/structure/V_head', $data);
		$this->load->view('public/structure/V_topbar');
		$this->load->view('public/V_contact');
		$this->load->view('public/structure/V_foot');
	}

	public function about()
	{
		$data['data'] = $this->M_infoweb->getInfoWeb();
		$data['title_of_page'] = 'Tentang Kami | Buboo Coffee';
		$this->load->view('public/structure/V_head', $data);
		$this->load->view('public/structure/V_topbar');
		$this->load->view('public/V_about_us');
		$this->load->view('public/structure/V_foot');
	}

	public function ajax_get_menu()
	{
		$perPage = 8;
		$page = $this->input->get("page");
		$id_kategori = $this->input->get("id_kategori");
		$search = $this->input->get("search");
		$order_by = $this->input->get("order_by");
		if(empty($page)) {
			$offset = 0;
			$page = 1;
		} else if($page == 1) {
			$offset = 0;
		} else {
			$offset = $perPage * ($page - 1);
		}

		$menu = $this->M_menu->getListMenu($id_kategori, $offset, $search, $order_by);
		$totalRecords = $this->M_menu->countTotalMenu($id_kategori);
		$data['totalPages'] = ceil($totalRecords / $perPage);
		$data['currentPage'] = $page;
		$data['id_kategori'] = $id_kategori;
		$data['list_menu'] = $menu;
		echo json_encode($data);
	}

	public function scan()
	{
		$data['title_of_page'] = 'Scan Meja | Buboo Coffee';
		$data['judul_halaman'] = 'Scan QR Meja';
		$data['back_url'] = base_url();
		$this->load->view('public/structure/V_head', $data);
		$this->load->view('public/structure/V_topbar');
		$this->load->view('public/V_scan');
		$this->load->view('public/structure/V_foot');
	}

	public function my_order()
	{
		if (empty($this->session->userdata('no_hp'))) {
			redirect(base_url('login?from=my-order'));
		}
		$data['list_kategori'] = $this->M_kategori->getAllKategori();
		$data['title_of_page'] = 'History Order | Buboo Coffee';
		$data['judul_halaman'] = 'History Order';
		$data['back_url'] = base_url('daftar-menu');
		$this->load->view('public/structure/V_head', $data);
		$this->load->view('public/structure/V_topbar');
		$this->load->view('public/V_riwayat_order');
		$this->load->view('public/structure/V_foot');
	}

	public function cart()
	{
		$data['data'] = $this->M_infoweb->getInfoWeb();
		$data['title_of_page'] = 'Keranjang | Buboo Coffee';
        $total_order = 0;
        $result_keranjang = [];
        if (isset($_COOKIE["keranjang"]) && !empty($_COOKIE["keranjang"])) {
            $decode_keranjang = json_decode($_COOKIE["keranjang"], TRUE);
            foreach ($decode_keranjang as $key => $c) {
                $data_menu = $this->M_menu->getMenuById($c['id_menu']);
                $temp = $data_menu;
                $temp->quantity = $c['quantity'];
                $result_keranjang[] = $temp;
            }
        } 
        $data['keranjang'] = $result_keranjang;
		$data['judul_halaman'] = 'Keranjang';
		$data['back_url'] = base_url('daftar-menu');
		$this->load->view('public/structure/V_head', $data);
		$this->load->view('public/structure/V_topbar');
		$this->load->view('public/V_cart');
		$this->load->view('public/structure/V_foot');
	}

	public function count_keranjang()
	{
		$data_keranjang = [];
        if (isset($_COOKIE["keranjang"]) && !empty($_COOKIE["keranjang"])) {
            $data_keranjang = json_decode($_COOKIE["keranjang"], TRUE);
        } 

		echo json_encode(['data' => count($data_keranjang)]);
	}

	public function send_otp(Type $var = null)
	{
		date_default_timezone_set('Asia/Jakarta');
		$no_hp = $this->input->post('no_hp');

		$check_otp_exist = $this->M_notif->getKodeOTPByNoHP($no_hp);
		if (!empty($check_otp_exist)) {
			$checker_date = date($check_otp_exist->datetime_last_send, strtotime("+1 min"));
			$tgl_sekarang = date("Y-m-d H:i:s");
			if ($tgl_sekarang <= $checker_date) {
				echo json_encode(['status' => false, 'Harap tunggu 1 untuk request ulang OTP']);die;
			}

			$data = [
				'count_send' => $check_otp_exist->count_send + 1,
				'datetime_last_send' => $tgl_sekarang
			];
			$this->M_notif->updateOTP($check_otp_exist->id, $data);
			$kode_otp = $check_otp_exist->kode_otp;
		} else {
			do {
				$kode_otp = $this->generateRandomString();
				$check_otp = $this->M_notif->checkKodeOTP($kode_otp);
			} while (!empty($check_otp));
			$datetime_expired = date('Y-m-d H:i:s', strtotime("+15 min"));
			$data = [
				'kode_otp' => $kode_otp,
				'no_hp' => $no_hp,
				'datetime_expired' => $datetime_expired
			];
			$this->M_notif->createOTP($data);
			$kode_otp = $kode_otp;
		}

		$message = "$kode_otp adalah kode OTP kamu. Kode OTP berlaku selama 15 menit";
		$test = send_whatsapp($no_hp, $message); //kirim OTP
		echo json_encode(['status' => true, 'message' => 'Berhasil kirim OTP', 'data' => $test]);
	}

	public function pakai_otp(Type $var = null)
	{
		$no_hp = $this->input->post('no_hp');
		$kode_otp = $this->input->post('kode_otp');
        date_default_timezone_set('Asia/Jakarta');
		$tgl_sekarang = date('Y-m-d H:i:s');

		$check_otp = $this->M_notif->getDetailOTP($kode_otp);
		if ($check_otp->no_hp != $no_hp) {
			echo json_encode(['status' => false, 'message' => 'Kode OTP tidak valid']);die;
		} else if ($check_otp->datetime_expired < $tgl_sekarang) {
			echo json_encode(['status' => false, 'message' => 'Kode OTP sudah expired']);die;
		} else if ($check_otp->is_used == "yes") {
			echo json_encode(['status' => false, 'message' => 'Kode OTP tidak valid']);die;
		}

		$data = [
			'is_used' => 'yes',
		];
		$id_otp = $check_otp->id;

		$this->M_notif->updateOTP($id_otp, $data);
		$this->session->set_userdata(['no_hp' => $no_hp]);
		echo json_encode(['status' => true]);
	}

	public function generateRandomString($length = 4) {
		$characters = '0123456789';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[random_int(0, $charactersLength - 1)];
		}
		return $randomString;
	}

	public function test_whatsapp(Type $var = null)
	{
		$message = "6588 adalah kode OTP kamu. Kode OTP berlaku selama 15 menit";
		echo send_whatsapp("+6281223147686", $message);
	}

	function table_riwayat_order() {
		if (empty($this->session->no_hp)) {
			$output = array(
				"draw" => $_POST['draw'],
				"recordsTotal" => 0,
				"recordsFiltered" => 0,
				"data" => [],
			);
		} else {
			$filter_status = $_POST['filter_status'];
			$no_hp = $this->session->no_hp;
			if ($filter_status == "semua" || empty($filter_status)) {
				$filter_status = "";
			}
			$list = $this->M_pesanan->get_datatables_pesanan($filter_status, $no_hp);
			$data = array();
			$no = $_POST['start'];
			foreach ($list as $item) {
				$row = array();
				$status_order = '<label class="badge bg-warning text-dark">Belum Dibayar</label>';
				if ($item->status_order == "on process") {
					$status_order = '<label class="badge bg-info text-light">Sedang Diproses</label>';
				} else if ($item->status_order == "success") {
					$status_order = '<label class="badge bg-success text-light">Sudah Diantarkan</label>';
				} else if ($item->status_order == "cancel") {
					$status_order = '<label class="badge bg-danger text-light">Dibatalkan</label>';
				}
				
				$meja = $item->no_meja;
				if ($meja == "take-away") {
					$meja = "Take Away";
				}
				$nama_customer = strlen($item->nama_customer) > 10 ? explode(" ", $item->nama_customer)[0] : $item->nama_customer;
				$row[] = '
				<div style="box-shadow:0px 0px 17px 0px #c0c0c094;border-radius:10px;" class="p-2">
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
				</div>';
				$data[] = $row;
			}
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->M_pesanan->count_all_pesanan($filter_status, $no_hp),
            "recordsFiltered" => $this->M_pesanan->count_filtered_pesanan($filter_status, $no_hp),
            "data" => $data,
        );

        echo json_encode($output);
	}

	function ajax_detail_pesanan() {
		$no_pesanan = $this->input->get('no_pesanan', TRUE);
		$no_hp = $this->session->no_hp;

        try {
			if (empty($no_hp)) {
				throw new Exception("Harap Login");
			}

			$data_order = $this->M_order->getOrderByNoPesanan($no_pesanan, $no_hp);
            if (empty($data_order)) {
                throw new Exception("Pesanan tidak ditemukan");
            }

            $data_order->thumbnail = base_url('assets/public/img/menu/').$data_order->thumbnail;
            $data_order->datetime_order = date("d M Y H:i", strtotime($data_order->datetime_order));
            $detail_order = $this->M_order->getDetailOrder($data_order->id_order);
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
