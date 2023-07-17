<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Promo extends CI_Controller
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
        $data['title_page'] = "Promosi Toko - Buboo Coffee";
        $data['judul'] = "Promo";
        $data['back_url'] = base_url('admin');
        $data['list_menu'] = $this->M_menu->getAllMenu();
        $this->load->view('admin/structure/V_head', $data);
        $this->load->view('admin/structure/V_topbar');
        $this->load->view('admin/structure/V_sidebar');
		$this->load->view('admin/V_manage_promo');
        $this->load->view('admin/structure/V_foot');
    }

    function ajax_get_promo() {
        $filter_status = $_POST['filter_status'];
        if ($filter_status == "semua" || empty($filter_status)) {
            $filter_status = "";
        }
        $list = $this->M_promo->get_datatables_promo($filter_status);
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $item) {
            $row = [];
            $checked = "";
            if ($item->status_voucher == "on") {
                $checked = "checked";
            }

            if ($item->jenis_promo == "potongan harga") {
                $label_jenis = '<span class="badge badge-info badge-jenis">Potongan Harga</span>';
            } else {
                $label_jenis = '<span class="badge badge-success badge-jenis">Buy x Get y</span>';
            }

            $switch_status = '
			<label class="switch mt-1">
				<input type="checkbox" class="status_voucher" data-id="'.$item->id_voucher.'" data-status="'.$item->status_voucher.'" '.$checked.'>
				<span class="slider round"></span>
			</label>';

            $row[] = '
            <div class="d-flex justify-content-between">
                <div>

                </div>
                
                <div class="mx-3 w-100" style="position:relative">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="w-100 title-product mr-2">
                            <div class="mb-1">'.$label_jenis.'</div>
                            <b>'.$item->judul_voucher.'</b>
                            <div><small>Kode : '.$item->kode_voucher.' <b class="copy-voucher"><i style="cursor:pointer" class="fa fa-files-o" onclick="copyKodeVoucher(\''.$item->kode_voucher.'\')"></i><b></small></div>
                        </div>
                        <div class="text-right">
                            <a href="javascript:void(0)" class="edit_voucher text-default" data-id="'.$item->id_voucher.'"><i class="fa fa-edit"></i></a>
                            '.$switch_status.'
                        </div>
                    </div>
                </div>
            </div>';
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->M_promo->count_all_promo($filter_status),
            "recordsFiltered" => $this->M_promo->count_filtered_promo($filter_status),
            "data" => $data,
        );

        echo json_encode($output);
    }

    public function create_promo() {
        $jenis_promo = $this->input->post('jenis_promo', TRUE);
        $judul_voucher = $this->input->post('judul_voucher', TRUE);
        $kode_voucher = $this->input->post('kode_voucher', TRUE);
        $tipe_potongan = $this->input->post('tipe_potongan', TRUE);
        $nilai_potongan = $this->input->post('nilai_potongan', TRUE);
        $max_potongan = $this->input->post('max_potongan', TRUE);
        $max_penggunaan = $this->input->post('max_penggunaan', TRUE);
        $syarat_quantity = $this->input->post('syarat_quantity', TRUE);
        $quantity_gratisan = $this->input->post('quantity_gratisan', TRUE);
        $menu_promo = $this->input->post('menu_promo', TRUE);
        $datetime_start = $this->input->post('datetime_start', TRUE);
        $datetime_end = $this->input->post('datetime_end', TRUE);

        try {
			$this->db->trans_start();
            if ($jenis_promo == "potongan harga") {
                $list_required = ['jenis_promo', 'judul_voucher', 'kode_voucher', 'tipe_potongan', 'nilai_potongan', 'max_potongan', 'max_penggunaan', 'datetime_start', 'datetime_end'];
            } else {
                $list_required = ['jenis_promo', 'judul_voucher', 'kode_voucher', 'quantity_gratisan', 'syarat_quantity', 'max_penggunaan', 'datetime_start', 'datetime_end'];
            }

            foreach ($list_required as $key => $field) {
                if (empty($this->input->post($field))) {
                    $field = ucwords(strtolower(str_replace("_", " ", $field)));
                    throw new Exception("$field Harus diisi");
                }
            }

            if (!is_array($menu_promo)) {
                throw new Exception("Menu Promo tidak valid");
            }

            if (count($menu_promo) == 0) {
                throw new Exception("Pilih menu yang termasuk kedalam promo ini");
            }

            if ($jenis_promo == "potongan harga") {
                if ($tipe_potongan != "fix" && $tipe_potongan != "persen") {
                    throw new Exception("Tipe Potongan tidak valid");
                }

                if (!is_numeric($nilai_potongan) || $nilai_potongan <= 0) {
                    throw new Exception("Nilai potongan tidak valid");
                } else if (!is_numeric($max_potongan) || $max_potongan <= 0) {
                    throw new Exception("Max potongan tidak valid");
                } 

                if ($nilai_potongan > 100 && $tipe_potongan == 'persen') {
                    throw new Exception("Maksimal potongan 100%");
                }
            } else {
                if (!is_numeric($max_penggunaan) || $max_penggunaan <= 0) {
                    throw new Exception("Max penggunaan tidak valid");
                }
            }

            if (!is_numeric($max_penggunaan) || $max_penggunaan <= 0) {
                throw new Exception("Max penggunaan tidak valid");
            }

            if ($datetime_end <= $datetime_start) {
                throw new Exception("Tanggal selesai harus lebih lama dari tanggal mulai");
            }

            $list_menu_promo = [];
            foreach ($menu_promo as $key => $row) {
                $check_menu = $this->M_menu->getMenuById($row);
                if (empty($check_menu)) {
                    throw new Exception("Terdapat menu yang tidak valid !");
                }

                $list_menu_promo[] = [
                    'id_menu' => $row,
                    'nama_menu' => $check_menu->nama_menu
                ];
            }

            if ($jenis_promo == "potongan harga") {
                $data = [
                    'jenis_promo' => $jenis_promo,
                    'judul_voucher' => $judul_voucher,
                    'kode_voucher' => $kode_voucher,
                    'tipe_potongan' => $tipe_potongan,
                    'nilai_potongan' => $nilai_potongan,
                    'max_potongan' => $max_potongan,
                    'max_penggunaan' => $max_penggunaan,
                    'menu_promo' => json_encode($list_menu_promo),
                    'datetime_start' => $datetime_start,
                    'datetime_end' => $datetime_end,
                ];
            } else {
                $data = [
                    'jenis_promo' => $jenis_promo,
                    'judul_voucher' => $judul_voucher,
                    'kode_voucher' => $kode_voucher,
                    'quantity_gratisan' => $quantity_gratisan,
                    'syarat_quantity' => $syarat_quantity,
                    'max_penggunaan' => $max_penggunaan,
                    'menu_promo' => json_encode($list_menu_promo),
                    'datetime_start' => $datetime_start,
                    'datetime_end' => $datetime_end,
                ];
            }

            $this->M_promo->insertPromoVoucher($data);
            $this->db->trans_commit();
            echo json_encode(['status' => true, 'message' => "Promo berhasil dibuat"]);
        } catch (Exception $e) {
            $this->db->trans_rollback();
            echo json_encode(['status' => false, 'message' => $e->getMessage()]);
        }
    }

    public function get_detail() {
        $id = $this->input->get('id');

        $detail_promo = $this->M_promo->getDetailPromo($id);
        if (empty($detail_promo)) {
            echo json_encode(['status' => false, 'message' => "Promo tidak ditemukan"]);
        } else {
            $result = $detail_promo;
            $list_menu = json_decode($detail_promo->menu_promo, TRUE);
            $result->menu_promo = $list_menu;
            echo json_encode(['status' => true, 'message' => "Success get promo", 'data' => $result]);
        }
    }

    public function update_promo() {
        $id_voucher = $this->input->post('id_voucher', TRUE);
        $jenis_promo = $this->input->post('jenis_promo', TRUE);
        $judul_voucher = $this->input->post('judul_voucher', TRUE);
        $kode_voucher = $this->input->post('kode_voucher', TRUE);
        $tipe_potongan = $this->input->post('tipe_potongan', TRUE);
        $nilai_potongan = $this->input->post('nilai_potongan', TRUE);
        $max_potongan = $this->input->post('max_potongan', TRUE);
        $max_penggunaan = $this->input->post('max_penggunaan', TRUE);
        $syarat_quantity = $this->input->post('syarat_quantity', TRUE);
        $quantity_gratisan = $this->input->post('quantity_gratisan', TRUE);
        $menu_promo = $this->input->post('menu_promo', TRUE);
        $datetime_start = $this->input->post('datetime_start', TRUE);
        $datetime_end = $this->input->post('datetime_end', TRUE);

        try {
			$this->db->trans_start();
            if ($jenis_promo == "potongan harga") {
                $list_required = ['jenis_promo', 'judul_voucher', 'kode_voucher', 'tipe_potongan', 'nilai_potongan', 'max_potongan', 'max_penggunaan', 'datetime_start', 'datetime_end'];
            } else {
                $list_required = ['jenis_promo', 'judul_voucher', 'kode_voucher', 'quantity_gratisan', 'syarat_quantity', 'max_penggunaan', 'datetime_start', 'datetime_end'];
            }

            $data_promo = $this->M_promo->getDetailPromo($id_voucher);
            if (empty($data_promo)) {
                throw new Exception("Promo tidak ditemukan");
            }

            foreach ($list_required as $key => $field) {
                if (empty($this->input->post($field))) {
                    $field = ucwords(strtolower(str_replace("_", " ", $field)));
                    throw new Exception("$field Harus diisi");
                }
            }

            if (!is_array($menu_promo)) {
                throw new Exception("Menu Promo tidak valid");
            }

            if (count($menu_promo) == 0) {
                throw new Exception("Pilih menu yang termasuk kedalam promo ini");
            }

            if ($jenis_promo == "potongan harga") {
                if ($tipe_potongan != "fix" && $tipe_potongan != "persen") {
                    throw new Exception("Tipe Potongan tidak valid");
                }

                if (!is_numeric($nilai_potongan) || $nilai_potongan <= 0) {
                    throw new Exception("Nilai potongan tidak valid");
                } else if (!is_numeric($max_potongan) || $max_potongan <= 0) {
                    throw new Exception("Max potongan tidak valid");
                } 

                if ($nilai_potongan > 100 && $tipe_potongan == 'persen') {
                    throw new Exception("Maksimal potongan 100%");
                }
            } else {
                if (!is_numeric($max_penggunaan) || $max_penggunaan <= 0) {
                    throw new Exception("Max penggunaan tidak valid");
                }
            }

            if (!is_numeric($max_penggunaan) || $max_penggunaan <= 0) {
                throw new Exception("Max penggunaan tidak valid");
            }

            if ($datetime_end <= $datetime_start) {
                throw new Exception("Tanggal selesai harus lebih lama dari tanggal mulai");
            }

            $list_menu_promo = [];
            foreach ($menu_promo as $key => $row) {
                $check_menu = $this->M_menu->getMenuById($row);
                if (empty($check_menu)) {
                    throw new Exception("Terdapat menu yang tidak valid !");
                }

                $list_menu_promo[] = [
                    'id_menu' => $row,
                    'nama_menu' => $check_menu->nama_menu
                ];
            }

            if ($jenis_promo == "potongan harga") {
                $data = [
                    'jenis_promo' => $jenis_promo,
                    'judul_voucher' => $judul_voucher,
                    'kode_voucher' => $kode_voucher,
                    'tipe_potongan' => $tipe_potongan,
                    'nilai_potongan' => $nilai_potongan,
                    'max_potongan' => $max_potongan,
                    'max_penggunaan' => $max_penggunaan,
                    'menu_promo' => json_encode($list_menu_promo),
                    'datetime_start' => $datetime_start,
                    'datetime_end' => $datetime_end,
                ];
            } else {
                $data = [
                    'jenis_promo' => $jenis_promo,
                    'judul_voucher' => $judul_voucher,
                    'kode_voucher' => $kode_voucher,
                    'quantity_gratisan' => $quantity_gratisan,
                    'syarat_quantity' => $syarat_quantity,
                    'max_penggunaan' => $max_penggunaan,
                    'menu_promo' => json_encode($list_menu_promo),
                    'datetime_start' => $datetime_start,
                    'datetime_end' => $datetime_end,
                ];
            }

            $this->M_promo->updatePromo($id_voucher, $data);
            $this->db->trans_commit();
            echo json_encode(['status' => true, 'message' => "Promo berhasil dibuat"]);
        } catch (Exception $e) {
            $this->db->trans_rollback();
            echo json_encode(['status' => false, 'message' => $e->getMessage()]);
        }
    }

    public function update_status_voucher() {
        $id_voucher = $this->input->get('id');

        $data_promo = $this->M_promo->getDetailPromo($id_voucher);
        if (empty($data_promo)) {
            $response = json_encode(['status' => false, 'message' => "Promo tidak ditemukan"]);
        } else {
            $new_status = $data_promo->status_voucher == "on" ? "off" : "on";
            $data = ['status_voucher' => $new_status];
            $this->M_promo->updatePromo($id_voucher, $data);
            $response = json_encode(['status' => true, 'message' => "Status Promo berhasil diperbarui"]);
        }
        echo $response;
    }
}