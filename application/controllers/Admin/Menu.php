<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Menu extends CI_Controller
{
    public function __construct(Type $var = null) {
        parent::__construct();
        $this->load->model(["M_kategori", "M_menu"]);
        if(empty($this->session->userdata('username'))) {
            redirect(base_url('admin/login'));
        }
    }

    public function index()
	{
        $data['title_page'] = "Manajemen Menu - Buboo Coffee";
        $this->load->view('admin/structure/V_head', $data);
        $this->load->view('admin/structure/V_topbar');
        $this->load->view('admin/structure/V_sidebar');
		$this->load->view('admin/V_manage_menu');
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
        foreach ($list as $item) {
            $row = array();
            $thumbnail = json_decode($item->json_gambar, TRUE)[0];
            $checked = "";
            if ($item->status == "aktif") {
                $checked = "checked";
            }
            $switch_status = '
			<label class="switch">
				<input type="checkbox" class="status_aktif" data-id="'.$item->id_menu.'" data-status="'.$item->status.'" '.$checked.'>
				<span class="slider round"></span>
			</label>';
            // $row[] = '<div class="text-center"><a href="'.base_url('assets/public/img/menu/'.$thumbnail).'" target="_blank"><img src="'.base_url('assets/public/img/menu/'.$thumbnail).'" width="50px"></a></div>';
            // $row[] = '<div class="mb-2"><span class="badge badge-secondary"><i class="fa fa-tag"></i> '.$item->nama_kategori.'</span><div>
            // <div>'.$item->nama_menu.'<div>';
            // $row[] = "Rp".number_format($item->harga, 0, '', '.');
            // $row[] = '<div class="text-center">'.$switch_status.'</div>';
            // $row[] = '
            // <div class="text-center">
            //     <a href="'.base_url('admin/menu/edit/').$item->id_menu.'" class="btn btn-sm btn-circle btn-info editMenu" data-id="'.$item->id_menu.'"><i class="fa fa-edit"></i></a>
            // </div>';
            $row[] = '
            <div class="d-flex justify-content-between ">
                <div>
                    <img src="'.base_url('assets/public/img/menu/'.$thumbnail).'" alt="" width="100" height="100">
                </div>
                <div class="mx-2 w-100">
                    '.$item->nama_menu.'
                    <div><small>Rp'.number_format($item->harga, 0, "", ".").'</small></div>
                </div>
                <div class="w-100 d-flex justify-content-end" style="position:relative">
                    '.$switch_status.'
                    <div style="position:absolute;bottom:0px;">
                        <a class="" href="'.base_url('admin/menu/edit/').$item->id_menu.'" class="text-dark editMenu" data-id="'.$item->id_menu.'"><i class="fa fa-edit"></i></a>
                    </div>
                </div>
            </div>';
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

    public function add()
    {
        $data['title_page'] = "Add Menu - Buboo Coffee";
        $data['list_kategori'] = $this->M_kategori->getAllKategori();
        $this->load->view('admin/structure/V_head', $data);
        $this->load->view('admin/structure/V_topbar');
        $this->load->view('admin/structure/V_sidebar');
		$this->load->view('admin/V_manage_menu_add');
        $this->load->view('admin/structure/V_foot');
    }

    public function edit($id_menu = NULL)
    {
        $data_menu = $this->M_menu->getMenuById($id_menu);
        if (empty($data_menu)) {
            $flashdata = ['notif_message' => "Menu tidak ditemukan", 'notif_icon' => "warning"];
			$this->session->set_flashdata($flashdata);
            redirect(base_url('admin/menu'));
        }
        $data['title_page'] = "Add Menu - Buboo Coffee";
        $data['list_kategori'] = $this->M_kategori->getAllKategori();
        $data['menu'] = $data_menu;
        $this->load->view('admin/structure/V_head', $data);
        $this->load->view('admin/structure/V_topbar');
        $this->load->view('admin/structure/V_sidebar');
		$this->load->view('admin/V_manage_menu_edit');
        $this->load->view('admin/structure/V_foot');
    }

    public function create_menu()
    {
        $nama_menu = $this->input->post('nama_menu', TRUE);
        $harga = $this->input->post('harga', TRUE);
        $id_kategori = $this->input->post('id_kategori', TRUE);
        $deskripsi = $this->input->post('deskripsi', TRUE);

        try {
			$this->db->trans_start();
            $arr_gambar_menu = [];
            if (empty($nama_menu) || empty($harga) || empty($id_kategori) || empty($deskripsi)) {
                throw new Exception("Harap lengkapi inputan");
            }

            if (!is_numeric($harga)) {
                throw new Exception("Harga tidak valid");
            }

            $check_kategori = $this->M_kategori->getKategoriById($id_kategori);
            if (empty($check_kategori)) {
                throw new Exception("Kategori tidak ditemukan");
            }

            if (!isset($_FILES['gambar_menu']) && empty($_FILES['gambar_menu']['name'])) {
                throw new Exception("Gambar harus diisi");
            }

            for ($i=0; $i < count($_FILES['gambar_menu']['name']); $i++) {
                $image_name = $_FILES['gambar_menu']['name'][$i];
                $gambar_menu_tmp = $_FILES['gambar_menu']['tmp_name'][$i];
                $file_type = $_FILES['gambar_menu']['type'][$i];
                $explode_name = explode('.', $image_name);
                $img_file_ext = pathinfo($image_name, PATHINFO_EXTENSION);
                $allowed_extension = array('', 'jpg', 'JPG', 'JPEG', 'jpeg', 'PNG', 'png');
                $batas = 2000000;
    
                if (!in_array($img_file_ext, $allowed_extension)) {
                    throw new Exception("Mohon upload dengan file jpg / png !");
                } else if ($_FILES["gambar_menu"]["size"][$i] > $batas) {
                    throw new Exception("Size Photo gambar_menu melebihi 2 MB !");   
                }
    
                if (!move_uploaded_file($gambar_menu_tmp, "./assets/public/img/menu/".$image_name)) {
                    throw new Exception("Terjadi Kesalahan saat menyimpan gambar menu");   
                } else {
                    $arr_gambar_menu[] = $image_name;
                }
            }
            
            $data = [
                'nama_menu' => $nama_menu,
                'id_kategori' => $id_kategori,
                'harga' => $harga,
                'deskripsi' => $deskripsi,
                'json_gambar' => json_encode($arr_gambar_menu),
                'thumbnail' => $arr_gambar_menu[0]
            ];

            $id_menu_inserted = $this->M_menu->insertMenu($data);
            if ($id_menu_inserted == false) {
                throw new Exception("Terjadi kesalahan saat menyimpan data ke database");   
            }

            $menu_inserted = $this->M_menu->getMenuById($id_menu_inserted);
            $data_log = json_decode(json_encode($menu_inserted), TRUE);
            unset($data_log['datetime_create']);
            unset($data_log['nama_kategori']);
            $data_log['username_admin'] = $this->session->userdata('username');
            
            $insert_log = $this->M_menu->insertLogMenu($data_log);
            $this->db->trans_complete();
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                throw new Exception("Terjadi kesalahan saat menyimpan data ke database");   
            } else {
                $this->db->trans_commit();
                $response = ['status' => true, 'message' => 'Berhasil Menyimpan Data'];
            }

            echo json_encode($response);
        } catch (Exception $e) {
            foreach ($arr_gambar_menu as $i => $img) {
                if (file_exists('./assets/public/img/menu/'.$img)) {
                    unlink('./assets/public/img/menu/'.$img);
                }
            }
            $this->db->trans_rollback();
            echo json_encode(['status' => false, 'message' => $e->getMessage()]);
        }
    }

    public function update_status_menu()
    {
        $id_menu = $this->input->get('id');

        try {
			$this->db->trans_start();
            $data_menu = $this->M_menu->getMenuById($id_menu);
            if (empty($data_menu)) {
                throw new Exception("Menu tidak ditemukan");  
            }

            $new_status = "aktif";
            if ($data_menu->status == "aktif") {
                $new_status = "nonaktif";
            }
            
            $update_menu = $this->M_menu->updateMenu($id_menu, ['status' => $new_status]);
            if ($update_menu == false) {
                throw new Exception("Terjadi kesalahan saat menyimpan data ke database");   
            }

            $menu_updated = $this->M_menu->getMenuById($id_menu);
            $data_log = json_decode(json_encode($menu_updated), TRUE);
            unset($data_log['datetime_create']);
            unset($data_log['nama_kategori']);
            $data_log['username_admin'] = $this->session->userdata('username');
            
            $insert_log = $this->M_menu->insertLogMenu($data_log);
            
            $this->db->trans_complete();
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                throw new Exception("Terjadi kesalahan saat menyimpan data ke database");   
            } else {
                $this->db->trans_commit();
                $response = ['status' => true, 'message' => 'Berhasil Menyimpan Data'];
            }
            echo json_encode($response);
        } catch (Exception $e) {
            $this->db->trans_rollback();
            echo json_encode(['status' => false, 'message' => $e->getMessage()]);
        }
    }

    public function update_menu()
    {
        $id_menu = $this->input->post('id_menu', TRUE);
        $nama_menu = $this->input->post('nama_menu', TRUE);
        $harga = $this->input->post('harga', TRUE);
        $id_kategori = $this->input->post('id_kategori', TRUE);
        $deskripsi = $this->input->post('deskripsi', TRUE);
        $idx_change_gambar = $this->input->post('idx_change_gambar', TRUE);

        try {
			$this->db->trans_start();
            $new_image_file = [];

            $data_menu = $this->M_menu->getMenuById($id_menu);
            if (empty($data_menu)) {
                throw new Exception("Menu tidak ditemukan");
            }
            $arr_gambar_menu = json_decode($data_menu->json_gambar, TRUE);

            if (empty($nama_menu) || empty($harga) || empty($id_kategori) || empty($deskripsi)) {
                throw new Exception("Harap lengkapi inputan");
            }

            if (!is_numeric($harga)) {
                throw new Exception("Harga tidak valid");
            }

            $check_kategori = $this->M_kategori->getKategoriById($id_kategori);
            if (empty($check_kategori)) {
                throw new Exception("Kategori tidak ditemukan");
            }

            if (isset($_FILES['gambar_menu']) && !empty($_FILES['gambar_menu']['name'])) {
                sort($idx_change_gambar);
                for ($i=0; $i < count($_FILES['gambar_menu']['name']); $i++) {
                    $image_name = $_FILES['gambar_menu']['name'][$i];
                    $gambar_menu_tmp = $_FILES['gambar_menu']['tmp_name'][$i];
                    $file_type = $_FILES['gambar_menu']['type'][$i];
                    $explode_name = explode('.', $image_name);
                    $img_file_ext = pathinfo($image_name, PATHINFO_EXTENSION);
                    $allowed_extension = array('', 'jpg', 'JPG', 'JPEG', 'jpeg', 'PNG', 'png', 'jfif');
                    $batas = 2000000;
        
                    if (!in_array($img_file_ext, $allowed_extension)) {
                        throw new Exception("Mohon upload dengan file jpg / png !");
                    } else if ($_FILES["gambar_menu"]["size"][$i] > $batas) {
                        throw new Exception("Size Photo gambar_menu melebihi 2 MB !");   
                    }
        
                    if (!move_uploaded_file($gambar_menu_tmp, "./assets/public/img/menu/".$image_name)) {
                        throw new Exception("Terjadi Kesalahan saat menyimpan gambar menu");   
                    } else {
                        $arr_gambar_menu[$idx_change_gambar[$i]] = $image_name;
                        $new_image_file = $image_name;
                    }
                }
            }


            $thumbnail = $arr_gambar_menu[0];
            $data = [
                'nama_menu' => $nama_menu,
                'id_kategori' => $id_kategori,
                'harga' => $harga,
                'deskripsi' => $deskripsi,
                'json_gambar' => json_encode($arr_gambar_menu),
                'thumbnail' => $thumbnail
            ];

            $update_menu = $this->M_menu->updateMenu($id_menu, $data);
            if ($update_menu == false) {
                throw new Exception("Terjadi kesalahan saat menyimpan data ke database");   
            }

            $menu_updated = $this->M_menu->getMenuById($id_menu);
            $data_log = json_decode(json_encode($menu_updated), TRUE);
            unset($data_log['datetime_create']);
            unset($data_log['nama_kategori']);
            $data_log['username_admin'] = $this->session->userdata('username');
            
            $insert_log = $this->M_menu->insertLogMenu($data_log);
            $this->db->trans_complete();
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                throw new Exception("Terjadi kesalahan saat menyimpan data ke database");   
            } else {
                $this->db->trans_commit();
                $response = ['status' => true, 'message' => 'Berhasil Menyimpan Data'];
            }
            echo json_encode($response);die;
        } catch (Exception $e) {
            foreach ($new_image_file as $i => $img) {
                if (file_exists('./assets/public/img/menu/'.$img)) {
                    unlink('./assets/public/img/menu/'.$img);
                }
            }
            $this->db->trans_rollback();
            echo json_encode(['status' => false, 'message' => $e->getMessage()]);
        }
    }
}