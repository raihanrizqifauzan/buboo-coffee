<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Order extends CI_Controller
{
	public function __construct(Type $var = null) {
        parent::__construct();
        $this->load->model(["M_infoweb", "M_kategori", "M_menu", "M_order", "M_notif"]);
    }

    public function index()
    {
        if (!$this->session->userdata('no_hp')) {
            redirect(base_url('login'));
        }

        if (!$this->session->userdata('no_meja')) {
            redirect(base_url());
        }
        $data['data'] = $this->M_infoweb->getInfoWeb();
		$data['title_of_page'] = 'Checkout | Buboo Coffee';
		$data['judul_halaman'] = 'Checkout';
		$data['back_url'] = base_url('cart');
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
		$this->load->view('public/structure/V_head', $data);
		$this->load->view('public/structure/V_topbar');
		$this->load->view('public/V_checkout');
		$this->load->view('public/structure/V_foot');
    }

	public function book_table()
	{
        $param = $this->input->get('id');
        if (empty($param)) {
            redirect(base_url());
        }

        $no_meja = base64_decode($param);
        $data_meja = $this->M_order->getMejaByNumber($no_meja);
        if (empty($data_meja)) {
            $flashdata = ['notif_message' => "No. Meja tidak ditemukan", 'notif_icon' => "error"];
            $this->session->set_flashdata($flashdata);
            redirect(base_url());
        }

        $array_meja = ['no_meja' => $no_meja];
        $this->session->set_userdata($array_meja);
        redirect(base_url('daftar-menu'));
	}

    public function add_to_cart()
    {
        $id_menu = $this->input->post('id_menu', TRUE);
        $quantity = $this->input->post('quantity', TRUE);

        $menu = $this->M_menu->getMenuById($id_menu);
        try {
            if (empty($quantity) || !is_numeric($quantity) || $quantity < 1) {
                throw new Exception("Harap isi quantity");
            }

            if (empty($menu)) {
                throw new Exception("Menu tidak tersedia");
            } else if ($menu->stock < $quantity) {
                if ($menu->stock > 0) {
                    throw new Exception("$menu->nama_menu stok tersisa $menu->stock");
                } else {
                    throw new Exception("$menu->nama_menu stoknya habis");
                }
            }

            $cari_index = false;
            if (isset($_COOKIE["keranjang"]) && !empty($_COOKIE["keranjang"])) {
                $decode_keranjang = json_decode($_COOKIE["keranjang"], TRUE);
                $cari_index = array_search($id_menu, array_column($decode_keranjang, 'id_menu'));
                if ($cari_index !== false) {
                    $quantity_in_cart = $decode_keranjang[$cari_index]['quantity'];
                } else {
                    $quantity_in_cart = 0;
                }
            } else {
                $quantity_in_cart = 0;
            }

            $total_quantity = $quantity + $quantity_in_cart;
            if ($cari_index !== false) {
                $decode_keranjang[$cari_index]['quantity'] += $quantity;
            } else {
                $decode_keranjang[] = [
                    'id_menu' => $id_menu,
                    'quantity' => $quantity
                ];
            }

            setcookie("keranjang", json_encode($decode_keranjang), time() + (86400 * 1), "/");
            $data['total_keranjang'] = count($decode_keranjang);
            if ($data['total_keranjang'] > 99) {
                $data['total_keranjang'] = "99+";
            }
            $res = ['status' => true, 'message' => "Success add to cart", 'data' => $data];
        } catch (Exception $e) {
            $res = ['status' => false, 'message' => $e->getMessage()];
        }

        echo json_encode($res);
    }

    public function delete_from_cart()
    {
        $id_menu = $this->input->post('id_menu', TRUE);
        if (isset($_COOKIE["keranjang"]) && !empty($_COOKIE["keranjang"])) {
            $decode_keranjang = json_decode($_COOKIE["keranjang"], TRUE);
            $tes = [];
            $cari_index = array_search($id_menu, array_column($decode_keranjang, 'id_menu'));
            if ($cari_index !== false) {
                unset($decode_keranjang[$cari_index]);
                $decode_keranjang = array_values($decode_keranjang);
            } else {
                echo json_encode(['status' => false, 'message' => "Menu tidak ada di dalam keranjang"]);die;
            }
            setcookie("keranjang", json_encode($decode_keranjang), time() + (86400 * 30), "/");
            if (empty($decode_keranjang)) {
                unset($_COOKIE['keranjang']);
                setcookie("keranjang", NULL, time()-3600, "/");
            }
            // return data
            $subtotal = 0;
            foreach ($decode_keranjang as $key => $cart) {
                $data_menu = $this->M_menu->getMenuById($cart['id_menu']);
                $subtotal += $data_menu->harga * $cart['quantity'];
            }
            $data['subtotal'] = $subtotal;
            // end return data
            echo json_encode(['status' => true, 'message' => "Sukses menghapus menu", "data" => $data]);die;
        } else {
            echo json_encode(['status' => false, 'message' => "Menu tidak ada di dalam keranjang"]);die;
        }
    }

    public function update_cart()
    {
        $id_menu = $this->input->post('id_menu', TRUE);
        $quantity = $this->input->post('quantity', TRUE);
        if (isset($_COOKIE["keranjang"]) && !empty($_COOKIE["keranjang"])) {
            $decode_keranjang = json_decode($_COOKIE["keranjang"], TRUE);
            $tes = [];
            $cari_index = array_search($id_menu, array_column($decode_keranjang, 'id_menu'));
            if ($cari_index !== false) {
                $decode_keranjang[$cari_index]['quantity'] = $quantity;
                $decode_keranjang = array_values($decode_keranjang);
            }
            setcookie("keranjang", json_encode($decode_keranjang), time() + (86400 * 30), "/");
            // return data
            $subtotal = 0;
            foreach ($decode_keranjang as $key => $cart) {
                $data_menu = $this->M_menu->getMenuById($cart['id_menu']);
                $subtotal += $data_menu->harga * $cart['quantity'];
            }
            $data['subtotal'] = $subtotal;
            // end return data
            echo json_encode(['status' => true, 'message' => "Sukses mengupdate keranjang", "data" => $data]);die;
        } else {
            echo json_encode(['status' => false, 'message' => "Menu tidak ada di dalam keranjang"]);die;
        }
    }

    function create_order() {
        $nama_customer = $this->input->post('nama_customer', TRUE);
        $no_hp = $this->input->post('no_hp', TRUE);
        $catatan = $this->input->post('catatan', TRUE);
        $no_meja = $this->session->userdata('no_meja');

        try {
            if (empty($nama_customer) || empty($no_hp)) {
                throw new Exception("Nama dan No HP wajib diisi");
            }

            if (empty($no_meja)) {
                throw new Exception("Harap Scan No Meja");
            }

            $list_menu_order = [];
            $total_order = 0;
            if (isset($_COOKIE["keranjang"]) && !empty($_COOKIE["keranjang"])) {
                $decode_keranjang = json_decode($_COOKIE["keranjang"], TRUE);
                foreach ($decode_keranjang as $i => $cart) {
                    $data_menu = $this->M_menu->getMenuById($cart['id_menu']);
                    $total_order += $data_menu->harga * $cart['quantity'];
                    $temp = [
                        'id_menu' => $cart['id_menu'],
                        'nama_menu' => $data_menu->nama_menu,
                        'id_kategori' => $data_menu->id_kategori,
                        'nama_kategori' => $data_menu->nama_kategori,
                        'harga' => $data_menu->harga,
                        'quantity' => $cart['quantity'],
                    ];
                    $list_menu_order[] = $temp;
                    $total_order += $temp['harga'];
                }
            } else {
                throw new Exception("Keranjang masih kosong");
            }

            date_default_timezone_set('Asia/Jakarta');
            $tgl_sekarang = date('Y-m-d H:i:s');
            $this->load->helper("order");
            $no_pesanan = getNomorPesanan();
            $data_order = [
                'no_meja' => $no_meja,
                'datetime_order' => $tgl_sekarang,
                'total_order' => $total_order,
                'nama_customer' => $nama_customer,
                'no_pesanan' => $no_pesanan,
                'no_hp' => $no_hp,
            ];

            $id_order_inserted = $this->M_order->insertNewOrder($data_order);
            if ($id_order_inserted === false) {
                throw new Exception("Terjadi Kesalahan saat menyimpan data");
            }

            $detail_order = [];
            foreach ($list_menu_order as $key => $detail) {
                $temp = $detail;
                $temp['id_order'] = $id_order_inserted;
                $detail_order[] = $temp;
            }

            $save_detailorder = $this->M_order->insertBatchDetailOrder($detail_order);
            if ($save_detailorder === false) {
                throw new Exception("Terjadi Kesalahan saat menyimpan data");
            }

            $encode_id = base64_encode($no_pesanan);
            $encode_id = str_replace("=", "", $encode_id);
            unset($_COOKIE['keranjang']);
            setcookie("keranjang", NULL, time()-3600, "/");
            $data['redirect_url'] = base_url()."order/success?id=$encode_id";

            // Push Notif to Barista
            $this->load->helper("onesignal");
            $getIdOnesignal = $this->M_notif->getUserIdOneSignal();
            $temponesignal = [];
            foreach ($getIdOnesignal as $key => $idonesignal) {
                $temponesignal[] = $idonesignal->user_id;
            }
            $title = "Hi, Ada Pesanan Baru";
            if ($no_meja == "take-away") {
                $message = "Pesanan baru dari Take Away";
            } else {
                $message = "Pesanan baru dari meja No. $no_meja";
            }
            $url_notif = base_url()."admin/pesanan";
            send_message($message, $title, $temponesignal, $url_notif);
            $message_whatsapp = "Pesananmu dengan No. Order $no_pesanan berhasil dibuat. Silahkan lakukan pembayaran di sini : ".$data['redirect_url'];
            send_whatsapp($no_hp, $message_whatsapp);
            echo json_encode(['status' => true, 'message' => "Berhasil melakukan order", 'data' => $data]);
        } catch (Exception $e) {
            echo json_encode(['status' => false, 'message' => $e->getMessage()]);
        }
    }

    public function success()
    {
        $no_pesanan = $this->input->get('id', TRUE);
        $no_pesanan = base64_decode($no_pesanan);
        $data_order = $this->M_order->getOrderByNoPesanan($no_pesanan);
		$data['title_of_page'] = 'Terimakasih | Buboo Coffee';
        if (empty($data_order)) {
            $flashdata = ['notif_message' => "Pesanan tidak ditemukan", 'notif_icon' => "error"];
            $this->session->set_flashdata($flashdata);
            redirect(base_url());
        }

        $data['order'] = $data_order;
        $data['detail_order'] = $this->M_order->getDetailOrder($data_order->id_order);
		$this->load->view('public/structure/V_head', $data);
		$this->load->view('public/structure/V_topbar');
		$this->load->view('public/V_success_order');
		$this->load->view('public/structure/V_foot');
    }
}