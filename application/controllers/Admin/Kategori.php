<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kategori extends CI_Controller
{
    public function __construct(Type $var = null) {
        parent::__construct();
        $this->load->model("M_kategori");
        if(empty($this->session->userdata('username'))) {
            redirect(base_url('admin/login'));
        }
    }

	public function index()
	{
        $data['title_page'] = "Manajemen Kategori - Buboo Coffee";
        $data['judul'] = "Kategori Menu";
        $data['back_url'] = base_url('admin');
        $this->load->view('admin/structure/V_head', $data);
        $this->load->view('admin/structure/V_topbar');
        $this->load->view('admin/structure/V_sidebar');
		$this->load->view('admin/V_manage_kategori');
        $this->load->view('admin/structure/V_foot');
	}

    public function create()
    {
        $this->load->library('form_validation');
        $rules = [
            [ 'field' => 'nama_kategori', 'label' => 'Nama Kategori', 'rules' => 'required'],
        ];
        $this->form_validation->set_rules($rules);

        if ($this->form_validation->run() === FALSE) {
            $flashdata = ['notif_message' => validation_errors(), 'notif_icon' => "error"];
			$this->session->set_flashdata($flashdata);
            redirect(base_url('admin/kategori'));
        } 

        $nama_kategori = $this->input->post('nama_kategori', TRUE);
        $icon_kategori = $this->input->post('icon_kategori', TRUE);
        $check_kategori = $this->M_kategori->getKategoriByName($nama_kategori);
        if (!empty($check_kategori)) {
            $flashdata = ['notif_message' => "Kategori $nama_kategori sudah ada", 'notif_icon' => "warning"];
			$this->session->set_flashdata($flashdata);
            redirect(base_url('admin/kategori'));
        }

        $data = [
            'nama_kategori' => $nama_kategori,
        ];

        $this->M_kategori->createKategori($data);

        $flashdata = ['notif_message' => "Berhasil menyimpan Kategori", 'notif_icon' => "success"];
        $this->session->set_flashdata($flashdata);
        redirect(base_url('admin/kategori'));
    }

    public function ajax_get_kategori(Type $var = null)
    {
        $list = $this->M_kategori->get_datatables_kategori();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $item) {
            $row = array();
            // $row[] = $item->nama_kategori;
            // $row[] = '<span class="iconify fa-2x" data-icon="openmoji:'.$item->icon_kategori.'"></span>';
            // $row[] = '
            // <div class="text-center">
            //     <button class="btn btn-sm btn-circle btn-info editKategori" data-id="'.$item->id_kategori.'"><i class="fa fa-edit"></i></button>
            //     <button class="btn btn-sm btn-circle btn-danger deleteKategori" data-id="'.$item->id_kategori.'"><i class="fa fa-trash"></i></button>
            // </div>';
            $row[] = '
            <div class="d-flex justify-content-between">
                <div>'.$item->nama_kategori.'</div>
                <div class="dropdown">
                    <span class="iconify dropdown-toggle"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-icon="basil:other-2-solid"></span>
                    
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a href="javascript:void(0)" class="dropdown-item editKategori" data-id="'.$item->id_kategori.'">Edit</a>
                        <a href="javascript:void(0)" class="dropdown-item deleteKategori" data-id="'.$item->id_kategori.'">Hapus</a>
                    </div>
                </div>
            </div>';
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->M_kategori->count_all_kategori(),
            "recordsFiltered" => $this->M_kategori->count_filtered_kategori(),
            "data" => $data,
        );

        echo json_encode($output);
    }

    public function detail($id = null)
    {
        if (empty($id)) {
            $response = ['status' => false, 'message' => 'Data tidak ditemukan', 'data' => null];
        } else {
            $data = $this->M_kategori->getKategoriById($id);
            if (empty($data)) {
                $response = ['status' => false, 'message' => 'Data tidak ditemukan', 'data' => null];
            } else {
                $response = ['status' => true, 'message' => 'Success Get Kategori', 'data' => $data];
            }
        }
        echo json_encode($response);
    }

    public function delete($id_kategori = null)
    {
        $data = $this->M_kategori->getKategoriById($id_kategori);
        if (empty($data)) {
            $flashdata = ['notif_message' => "Kategori tidak ditemukan", 'notif_icon' => "error"];
			$this->session->set_flashdata($flashdata);
            redirect(base_url('admin/kategori'));
        } else {
            $check_menu_kategori = $this->M_kategori->getMenuByKategori($id_kategori);
            if (!empty($check_menu_kategori)) {
                $flashdata = ['notif_message' => "Terdapat menu yang ada di kategori ini, silahkan pindahkan ke kategori lain sebelum menghapus kategori ini", 'notif_icon' => "error"];
                $this->session->set_flashdata($flashdata);
                redirect(base_url('admin/kategori'));
            }
        }
        $this->M_kategori->deleteKategori($id_kategori);

        $flashdata = ['notif_message' => "Berhasil menghapus kategori", 'notif_icon' => "success"];
        $this->session->set_flashdata($flashdata);
        redirect(base_url('admin/kategori'));
    }

    public function update()
    {
        $this->load->library('form_validation');
        $rules = [
            [ 'field' => 'nama_kategori', 'label' => 'Nama Kategori', 'rules' => 'required'],
        ];
        $this->form_validation->set_rules($rules);

        if ($this->form_validation->run() === FALSE) {
            $flashdata = ['notif_message' => validation_errors(), 'notif_icon' => "error"];
			$this->session->set_flashdata($flashdata);
            redirect(base_url('admin/kategori'));
        } 

        $id_kategori = $this->input->post('id_kategori', TRUE);
        $nama_kategori = $this->input->post('nama_kategori', TRUE);
        $check_kategori = $this->M_kategori->getKategoriById($id_kategori);
        if (empty($check_kategori)) {
            $flashdata = ['notif_message' => "Kategori tidak ditemukan", 'notif_icon' => "warning"];
			$this->session->set_flashdata($flashdata);
            redirect(base_url('admin/kategori'));
        }

        $check_kategori_name = $this->M_kategori->getKategoriByName($nama_kategori);
        if (!empty($check_kategori) && $check_kategori->id_kategori != $id_kategori) {
            $flashdata = ['notif_message' => "Kategori $nama_kategori sudah ada", 'notif_icon' => "warning"];
			$this->session->set_flashdata($flashdata);
            redirect(base_url('admin/kategori'));
        }
        $data = [
            'nama_kategori' => $this->input->post('nama_kategori', TRUE),
        ];

        $this->M_kategori->updateKategori($id_kategori, $data);

        $flashdata = ['notif_message' => "Berhasil mengupdate Kategori", 'notif_icon' => "success"];
        $this->session->set_flashdata($flashdata);
        redirect(base_url('admin/kategori'));
    }

}


?>