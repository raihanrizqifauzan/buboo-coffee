<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Penjualan extends CI_Controller
{
    public function __construct(Type $var = null) {
        parent::__construct();
        $this->load->model(["M_login", "M_notif", "M_infoweb", "M_menu", "M_promo"]);
        if(empty($this->session->userdata('username'))) {
            redirect(base_url('admin/login'));
        }
    }

    public function index() {
        $data['data_toko'] = $this->M_infoweb->getInfoWeb();
        $data['title_page'] = "Penjualan - Buboo Coffee";
        $data['judul'] = "Penjualan";
        $data['back_url'] = base_url('admin');
        $this->load->view('admin/structure/V_head', $data);
        $this->load->view('admin/structure/V_topbar');
        $this->load->view('admin/structure/V_sidebar');
		$this->load->view('admin/V_penjualan');
        $this->load->view('admin/structure/V_foot');
    }

    function ajax_get_menu() {
        $filter_status = $_POST['filter_status'];
        if ($filter_status == "semua" || empty($filter_status)) {
            $filter_status = "";
        }
        $list = $this->M_menu->get_datatables_menu($filter_status);
        $data = array();
        $no = $_POST['start'];

        $map_array = [];
        $idx = -1;
        for ($i=0; $i < count($list); $i++) { 
            if ($i == 0 || ($i+1)%4 == 0) {
                $idx++;
            }

            $temp = [
                'id_menu' => $list[$i]->id_menu,
                'nama_menu' => $list[$i]->nama_menu,
                'harga' => $list[$i]->harga,
                'thumbnail' => base_url('assets/public/img/menu/'.$list[$i]->thumbnail),
            ];
            $map_array[$idx][] = $temp;
        }

        foreach ($map_array as $list_menu) {
            $row = [];
            $html = '<div class="row mt-1 no-wrap" style="flex-wrap:nowrap!important">';
            foreach ($list_menu as $i => $item) {
                $html .= '
                <div class="col-xs-6 col-sm-4 p-2 pt-3 card-barang" data-id="'.$item['id_menu'].'" style="box-shadow:0px -4px 17px 0px #eee;">
                    <div class="text-center">
                        <img src="'.$item['thumbnail'].'" alt="" width="60" height="60">
                    </div>
                    <div class="w-100 text-center mt-2" style="position:relative">
                        <div class="d-flex justify-content-between">
                            <div class="w-100 title-product">
                                <b>'.$item['nama_menu'].'</b>
                            </div>
                        </div>
                        <div>Rp'.number_format($item['harga'], 0, "", ".").'</div>
                    </div>
                </div>';
            }
            $html .= '</div>';

            $row[] = $html;
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->M_menu->count_all_menu($filter_status),
            "recordsFiltered" => $this->M_menu->count_filtered_menu($filter_status),
            "data" => $data,
        );

        echo json_encode($output);
    }

    public function add_to_cart() {
        $this->load->model('M_menu');
        $id_menu = $this->input->post('id_menu');
        $quantity = $this->input->post('quantity');

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
            } else if ($menu->status == "nonaktif") {
                throw new Exception("$menu->nama_menu sudah habis");
            }

            $result = [
                'id_menu' => $menu->id_menu,
                'nama_menu' => $menu->nama_menu,
                'quantity' => $quantity,
                'harga' => $menu->harga,
            ];
            $res = ['status' => true, 'message' => "Success add to cart", 'data' => $result];
        } catch (Exception $e) {
            $res = ['status' => false, 'message' => $e->getMessage()];
        }

        echo json_encode($res);
    }

    public function create_order() {
        $nama_customer = $this->input->post('nama_customer', TRUE);
        $no_meja = $this->input->post('no_meja', TRUE);
        $diskon = $this->input->post('diskon_cart', TRUE);
        $menu_cart = $this->input->post('list_menu', TRUE);

        try {
			$this->db->trans_start();

            if (empty($nama_customer) || empty($no_meja)) {
                throw new Exception("Nama dan Nomor meja harus diisi");
            }

            if (empty($menu_cart)) {
                throw new Exception("Pilih menu terlebih dahulu");
            }

            $list_menu_order = [];
            $total_order = 0;
            $data_stock = [];
            foreach ($menu_cart as $i => $cart) {
                $data_menu = $this->M_menu->getMenuById($cart['id_menu']);
                $sisa_stock = $data_menu->stock - $cart['quantity'];
                if ($data_menu->status == "nonaktif") {
                    throw new Exception($data_menu->nama_menu." sudah habis");
                } else if ($sisa_stock < 0) {
                    if ($data_menu->stock == 0) {
                        throw new Exception($data_menu->nama_menu." sudah habis");
                    } else {
                        throw new Exception($data_menu->nama_menu." tersisa ".$data_menu->stock);
                    }
                }

                $total_order += $data_menu->harga * $cart['quantity'];
                $temp = [
                    'id_menu' => $cart['id_menu'],
                    'nama_menu' => $data_menu->nama_menu,
                    'id_kategori' => $data_menu->id_kategori,
                    'nama_kategori' => $data_menu->nama_kategori,
                    'harga' => $data_menu->harga,
                    'quantity' => $cart['quantity'],
                ];
                $data_stock[$cart['id_menu']] = $data_menu->stock;
                $list_menu_order[] = $temp;
                $total_order += $temp['harga'];
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
            ];

            $id_order_inserted = $this->M_order->insertNewOrder($data_order);
            if ($id_order_inserted === false) {
                throw new Exception("Terjadi Kesalahan saat menyimpan data");
            }

            $detail_order = [];
            $log_perubahan_stock = [];
            foreach ($list_menu_order as $key => $detail) {
                $temp = $detail;
                $temp['id_order'] = $id_order_inserted;
                $detail_order[] = $temp;

                $stock_akhir = $data_stock[$detail['id_menu']] - $detail['quantity'];
                $selisih_stock = $data_stock[$detail['id_menu']] - $stock_akhir;
                $log_stock = [
                    'id_menu' => $detail['id_menu'],
                    'keterangan' => "Pesanan No. $id_order_inserted",
                    'stock_awal' => $data_stock[$detail['id_menu']],
                    'selisih' => $selisih_stock,
                    'stock_akhir' => $stock_akhir,
                    'url_action' => base_url('order/create_order'),
                    'datetime_action' => $tgl_sekarang,
                ];
                $log_perubahan_stock[] = $log_stock;
            }

            $save_detailorder = $this->M_order->insertBatchDetailOrder($detail_order);
            if ($save_detailorder === false) {
                throw new Exception("Terjadi Kesalahan saat menyimpan data");
            }

            $this->M_order->insertBatchLogStock($log_perubahan_stock);

            $new_status = ['status_order' => 'on process', 'status_pembayaran' => 'approved'];
            $log_status_order = [
                'datetime_action' => $tgl_sekarang,
                'username_pegawai' => $this->session->userdata('username'),
                'url_action' => base_url('admin/penjualan'),
                'id_order' => $id_order_inserted,
                'no_pesanan' => $no_pesanan,
                'status_awal' => 'pending',
                'status_akhir' => 'on process',
            ];
            $this->M_order->saveLogStatusOrder($log_status_order);
            $this->M_order->updateDataOrder($id_order_inserted, $new_status);

            $this->db->trans_complete();
            $this->db->trans_commit();
            echo json_encode(['status' => true, 'message' => "Berhasil membuat order No. Pesanan $no_pesanan"]);
        } catch (Exception $e) {
            $this->db->trans_rollback();
            echo json_encode(['status' => false, 'message' => $e->getMessage()]);
        }
    }

    public function edit($no_pesanan = null) {
        $this->load->model("M_order");
        if (empty($no_pesanan)) {
            redirect(base_url('admin/pesanan'));
        }
        $data_order = $this->M_order->getOrderByNoPesanan($no_pesanan);
        if (empty($data_order)) {
            redirect(base_url('admin/pesanan'));
        }
        $data_order->thumbnail = base_url('assets/public/img/menu/').$data_order->thumbnail;
        $data_order->datetime_order = date("d M Y H:i", strtotime($data_order->datetime_order));
        $detail_order = $this->M_order->getDetailOrderWithoutPromo($data_order->id_order);
        foreach ($detail_order as $key => $dt) {
            $detail_order[$key]->thumbnail = base_url('assets/public/img/menu/').$dt->thumbnail;
        }
        $data['title_page'] = "Edit Pesanan - Buboo Coffee";
        $data['judul'] = "Edit Pesanan";
        $data['back_url'] = base_url('admin/pesanan');
        $data['data_order'] = $data_order;
        $data['detail_order'] = $detail_order;
        $this->load->view('admin/structure/V_head', $data);
        $this->load->view('admin/structure/V_topbar');
        $this->load->view('admin/structure/V_sidebar');
		$this->load->view('admin/V_penjualan_edit');
        $this->load->view('admin/structure/V_foot');
    }

    public function update_order() {
        $this->load->model("M_order");
        date_default_timezone_set('Asia/Jakarta');
        $tgl_sekarang = date('Y-m-d H:i:s');
        $id_promo_selected = $this->input->post('id_promo_selected', TRUE);
        $no_pesanan = $this->input->post('no_pesanan', TRUE);
        $menu_cart = $this->input->post('list_menu', TRUE);

        try {
			$this->db->trans_start();

            $list_menu_order = [];
            $total_order = 0;
            $data_stock = [];
            $data_pesanan = $this->M_order->getOrderByNoPesanan($no_pesanan);

            if (!empty($menu_cart)) {
                $decode_keranjang = $menu_cart;
                foreach ($decode_keranjang as $i => $cart) {
                    $data_menu = $this->M_menu->getMenuById($cart['id_menu']);
                    $sisa_stock = $data_menu->stock - $cart['quantity'];
                    if ($data_menu->status == "nonaktif") {
                        throw new Exception($data_menu->nama_menu." sudah habis");
                    } else if ($sisa_stock < 0) {
                        if ($data_menu->stock == 0) {
                            throw new Exception($data_menu->nama_menu." sudah habis");
                        } else {
                            throw new Exception($data_menu->nama_menu." tersisa ".$data_menu->stock);
                        }
                    }

                    $decode_keranjang[$i]['nama_menu'] = $data_menu->nama_menu;
                    $decode_keranjang[$i]['id_menu'] = $data_menu->id_menu;
                    $decode_keranjang[$i]['harga'] = $data_menu->harga;
                    $decode_keranjang[$i]['thumbnail'] = $data_menu->thumbnail;
                    $decode_keranjang[$i]['quantity'] = $cart['quantity'];
                }

                $diskon = 0;
                if (empty($id_promo_selected)) {
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
                        $data_stock[$cart['id_menu']] = $data_menu->stock;
                        $list_menu_order[] = $temp;
                        // $total_order += $temp['harga'];
                    }
                } else {
                    $data_promo = $this->M_promo->getDetailPromo($id_promo_selected);
                    if (empty($data_promo) || $data_promo->status_voucher == "off" || $data_promo->datetime_start > $tgl_sekarang || $data_promo->datetime_end < $tgl_sekarang) {
                        throw new Exception("Voucher tidak ditemukan");
                    } 

                    $menu_promo = json_decode($data_promo->menu_promo, TRUE);
                    $list_menu_kena_promo = [];
                    foreach ($decode_keranjang as $i => $cart) {
                        $idx_check = array_search($cart['id_menu'], array_column($menu_promo, 'id_menu'));
                        if ($idx_check !== false) {
                            $list_menu_kena_promo[$cart['id_menu']] = $cart;
                        }
                    }
                    if (count($list_menu_kena_promo) == 0) {
                        throw new Exception("Voucher tidak valid");
                    }

                    if ($data_promo->jenis_promo == "potongan harga") {
                        $id_menu_kena_promo = 0;
                        $harga_max = 0;
                        foreach ($list_menu_kena_promo as $x => $menu_promo) {
                            if ($harga_max < $menu_promo['harga']) {
                                $harga_max = $menu_promo['harga'];
                                $id_menu_kena_promo = $menu_promo['id_menu'];
                            }
                        }
    
                        if ($data_promo->tipe_potongan == "fix") {
                            $harga_diskon = $list_menu_kena_promo[$id_menu_kena_promo]['harga'] - $data_promo->nilai_potongan;
                        } else {
                            $nilai_potongan = $list_menu_kena_promo[$id_menu_kena_promo]['harga'] * $data_promo->nilai_potongan / 100;
                            if ($nilai_potongan > $data_promo->max_potongan) {
                                $nilai_potongan = $data_promo->max_potongan;
                            }
                            $harga_diskon = $list_menu_kena_promo[$id_menu_kena_promo]['harga'] - $nilai_potongan;
                        }
    
                        if ($harga_diskon < 0) {
                            $harga_diskon = 0;
                        }
                        $list_menu_kena_promo[$id_menu_kena_promo]['harga_diskon'] = $harga_diskon;
    
                        foreach ($decode_keranjang as $key => $cart) {
                            if ($cart['id_menu'] == $id_menu_kena_promo) {
                                $decode_keranjang[$key]['harga_diskon'] = $list_menu_kena_promo[$id_menu_kena_promo]['harga_diskon'];
                            } else {
                                $decode_keranjang[$key]['harga_diskon'] = "0";
                            }
                        }
                    } else {
                        $syarat_quantity = $data_promo->syarat_quantity;
                        $quantity_gratisan = $data_promo->quantity_gratisan;
                        $list_menu_buyxgety = [];
                        $menu_promo = json_decode($data_promo->menu_promo, TRUE);
                        foreach ($decode_keranjang as $i => $cart) {
                            $idx_check = array_search($cart['id_menu'], array_column($menu_promo, 'id_menu'));
                            if ($idx_check !== false && $cart['quantity'] >= $data_promo->syarat_quantity) {
                                $list_menu_buyxgety[] = $cart;
                            }
                        }
    
                        $id_menu_kena_promo = 0;
                        $harga_max = 0;
                        foreach ($list_menu_buyxgety as $x => $row) {
                            if ($harga_max < $row['harga']) {
                                $harga_max = $row['harga'];
                                $id_menu_kena_promo = $row['id_menu'];
                            }
                        }
    
                        $list_menu_kena_promo[$id_menu_kena_promo]['quantity'] = $quantity_gratisan;
                        $list_menu_kena_promo[$id_menu_kena_promo]['harga'] = 0;
                        $list_menu_kena_promo[$id_menu_kena_promo]['keterangan'] = 'free';
                        $decode_keranjang[] = $list_menu_kena_promo[$id_menu_kena_promo];
                    }

                    foreach ($decode_keranjang as $i => $cart) {
                        $data_menu = $this->M_menu->getMenuById($cart['id_menu']);    
                        // $total_order += $data_menu->harga * $cart['quantity'];
                        $temp = [
                            'id_menu' => $cart['id_menu'],
                            'nama_menu' => $data_menu->nama_menu,
                            'id_kategori' => $data_menu->id_kategori,
                            'nama_kategori' => $data_menu->nama_kategori,
                            'harga' => $cart['harga'],
                            'quantity' => $cart['quantity'],
                        ];
                        if (isset($cart['keterangan'])) {
                            $temp['keterangan'] = $cart['keterangan'];
                        } else {
                            $temp['keterangan'] = NULL;
                        }
                        if (isset($cart['harga_diskon']) && $cart['harga_diskon'] > 0) {
                            $temp['potongan'] = $data_menu->harga - $cart['harga_diskon'];
                            $total_order += $cart['harga_diskon'] * $cart['quantity'];
                            $diskon += $temp['potongan'] * $cart['quantity'];
                        } else {
                            $temp['potongan'] = 0;
                            $total_order += $temp['harga'] * $cart['quantity'];
                        }
                        $data_stock[$cart['id_menu']] = $data_menu->stock;
                        $list_menu_order[] = $temp;
                    }
                }
            } else {
                throw new Exception("Keranjang masih kosong");
            }

            $this->load->helper("order");
            $data_order = [
                'datetime_order' => $tgl_sekarang,
                'total_order' => $total_order,
                'diskon' => $diskon,
                'status_order' => 'on process',
                'status_pembayaran' => 'approved'
            ];

            if (!empty($id_promo_selected)) {
                $data_order['id_promo_voucher'] = $id_promo_selected;
            }
            
            $this->M_order->updateOrder($data_order, $data_pesanan->id_order);

            $detail_order = [];
            $log_perubahan_stock = [];
            foreach ($list_menu_order as $key => $detail) {
                $temp = $detail;
                $temp['id_order'] = $data_pesanan->id_order;
                $detail_order[] = $temp;
            }

            $this->M_order->deleteDetailOrder($data_pesanan->id_order);
            $save_detailorder = $this->M_order->insertBatchDetailOrder($detail_order);
            if ($save_detailorder === false) {
                throw new Exception("Terjadi Kesalahan saat menyimpan data");
            }

            $this->db->trans_complete();
            $this->db->trans_commit();

            echo json_encode(['status' => true, 'message' => "Berhasil mengupdate order No. Pesanan $no_pesanan"]);
        } catch (Exception $e) {
            $this->db->trans_rollback();
            echo json_encode(['status' => false, 'message' => $e->getMessage()]);
        }
    }

}