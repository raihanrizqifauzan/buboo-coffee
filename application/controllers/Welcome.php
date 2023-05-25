<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Welcome extends CI_Controller
{
	public function __construct(Type $var = null) {
        parent::__construct();
        $this->load->model(["M_infoweb", "M_kategori", "M_menu", "M_notif"]);
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
		$data['judul_halaman'] = 'Buboo Coffee';
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
			base_url('login');
		}
		$data['list_kategori'] = $this->M_kategori->getAllKategori();
		$data['title_of_page'] = 'Menu | Buboo Coffee';
		$data['judul_halaman'] = 'Buboo Coffee';
		$data['back_url'] = base_url();
		$this->load->view('public/structure/V_head', $data);
		$this->load->view('public/structure/V_topbar');
		$this->load->view('public/V_list_menu');
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
		$data['back_url'] = isset($_SERVER['HTTP_REFERER']) ? base_url('daftar-menu') :$_SERVER['HTTP_REFERER'];
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
		$no_hp = $this->input->post('no_hp');

		do {
			$kode_otp = $this->generateRandomString();
			$check_otp = $this->M_notif->checkKodeOTP($kode_otp);
		} while (!empty($check_otp));

        date_default_timezone_set('Asia/Jakarta');
		$datetime_expired = date('Y-m-d H:i:s', strtotime("+5 min"));
		$data = [
			'kode_otp' => $kode_otp,
			'no_hp' => $no_hp,
			'datetime_expired' => $datetime_expired
		];

		$this->M_notif->createOTP($data);
		echo json_encode(['status' => true]);
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
			'count_send' => $check_otp->count_send + 1,
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
}
