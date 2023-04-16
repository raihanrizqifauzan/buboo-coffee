<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Order extends CI_Controller
{
	public function __construct(Type $var = null) {
        parent::__construct();
        $this->load->model(["M_infoweb", "M_kategori", "M_menu", "M_order"]);
    }

    public function index()
    {
        $data['data'] = $this->M_infoweb->getInfoWeb();
		$data['title_of_page'] = 'Checkout | Buboo Coffee';
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
        redirect(base_url());
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
}