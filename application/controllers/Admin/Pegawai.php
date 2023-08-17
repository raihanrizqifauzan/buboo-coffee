<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pegawai extends CI_Controller
{
    public function __construct(Type $var = null) {
        parent::__construct();
        $this->load->model("M_pegawai");
        if(empty($this->session->userdata('username'))) {
            redirect(base_url('admin/login'));
        } else if ($this->session->userdata('role') != "owner") {
            redirect(base_url('admin'));
        }
    }

	public function index()
	{
        $data['title_page'] = "Manajemen Pegawai - Buboo Coffee";
        $data['judul'] = "Manajemen Pegawai";
        $data['back_url'] = base_url('admin');
        $this->load->view('admin/structure/V_head', $data);
        $this->load->view('admin/structure/V_topbar');
        $this->load->view('admin/structure/V_sidebar');
		$this->load->view('admin/V_manage_pegawai');
        $this->load->view('admin/structure/V_foot');
	}

    public function create()
    {
        $nama_lengkap = $this->input->post('nama_lengkap', TRUE);
        $no_hp = $this->input->post('no_hp', TRUE);
        $username = $this->input->post('username', TRUE);
        $password = $this->input->post('password', TRUE);
        $role = $this->input->post('role', TRUE);

        try {
            if (empty($nama_lengkap) || empty($no_hp) || empty($username) || empty($password) || empty($role)) {
                throw new Exception("Inputan tidak lengkap");
            }

            $check_username = $this->M_pegawai->getAdmin(['username' => $username]);
            if (!empty($check_username)) {
                throw new Exception("Username sudah digunakan");
            }

            if (strlen($password) < 6) {
                throw new Exception("Password minimal 6");
            }

            $data = [
                'nama_lengkap' => $nama_lengkap,
                'username' => $username,
                'password' => md5(md5($password)),
                'no_hp' => $no_hp,
                'role' => $role,
            ];

            $this->M_pegawai->createAdmin($data);

            $flashdata = ['notif_message' => "Berhasil menyimpan Pegawai", 'notif_icon' => "success"];
            $this->session->set_flashdata($flashdata);
            redirect(base_url('admin/pegawai'));
        } catch (Exception $e) {
            $flashdata = ['notif_message' => $e->getMessage(), 'notif_icon' => "error"];
            $this->session->set_flashdata($flashdata);
            redirect(base_url('admin/pegawai'));
        }
    }

    public function ajax_get_admin(Type $var = null)
    {
        $list = $this->M_pegawai->get_datatables_admin();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $item) {
            $row = array();
            $row[] = '
            <div class="d-flex justify-content-between">
                <div>
                    <div>Nama : <b>'.$item->nama_lengkap.'</b></div>
                    <div>Username : <b>'.$item->username.'</b></div>
                    <div>No.HP : <b>'.$item->no_hp.'</b></div>
                    <div>Posisi : <b>'.$item->role.'</b></div>
                </div>
                <div class="dropdown">
                    <span class="iconify dropdown-toggle"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-icon="basil:other-2-solid"></span>
                    
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a href="javascript:void(0)" class="dropdown-item btnEdit" data-id="'.$item->id.'">Edit</a>
                        <a href="javascript:void(0)" class="dropdown-item btnDelete" data-id="'.$item->id.'">Hapus</a>
                    </div>
                </div>
            </div>';
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->M_pegawai->count_admin(),
            "recordsFiltered" => $this->M_pegawai->count_filtered_admin(),
            "data" => $data,
        );

        echo json_encode($output);
    }

    public function detail($id = null)
    {
        if (empty($id)) {
            $response = ['status' => false, 'message' => 'Data tidak ditemukan', 'data' => null];
        } else {
            $data = $this->M_pegawai->getAdmin(['id' => $id]);
            if (empty($data)) {
                $response = ['status' => false, 'message' => 'Data tidak ditemukan', 'data' => null];
            } else {
                $response = ['status' => true, 'message' => 'Success Get Admin', 'data' => $data];
            }
        }
        echo json_encode($response);
    }

    public function delete($id_pegawai = null)
    {
        $data = $this->M_pegawai->getAdmin(['id' => $id_pegawai]);
        if (empty($data)) {
            $flashdata = ['notif_message' => "Pegawai tidak ditemukan", 'notif_icon' => "error"];
			$this->session->set_flashdata($flashdata);
            redirect(base_url('admin/pegawai'));
        }
        $this->M_pegawai->deletePegawai($id_pegawai);

        $flashdata = ['notif_message' => "Berhasil menghapus pegawai", 'notif_icon' => "success"];
        $this->session->set_flashdata($flashdata);
        redirect(base_url('admin/pegawai'));
    }

    public function update()
    {
        $id_pegawai = $this->input->post('id_admin', TRUE);
        $nama_lengkap = $this->input->post('nama_lengkap', TRUE);
        $no_hp = $this->input->post('no_hp', TRUE);
        $username = $this->input->post('username', TRUE);
        $password = $this->input->post('password', TRUE);
        $role = $this->input->post('role', TRUE);

        try {
            if (empty($nama_lengkap) || empty($no_hp) || empty($username) || empty($role)) {
                throw new Exception("Inputan tidak lengkap");
            }

            $check_pegawai = $this->M_pegawai->getAdmin(['id' => $id_pegawai]);
            if (empty($check_pegawai)) {
                throw new Exception("Pegawai tidak ditemukan");
            }

            $check_username = $this->M_pegawai->getAdmin(['username' => $username, 'id !=' => $id_pegawai]);
            if (!empty($check_username)) {
                throw new Exception("Username sudah digunakan");
            }

            if (!empty($password)) {
                if (strlen($password) < 6) {
                    throw new Exception("Password minimal 6");
                }

                $data = [
                    'nama_lengkap' => $nama_lengkap,
                    'username' => $username,
                    'password' => md5(md5($password)),
                    'no_hp' => $no_hp,
                    'role' => $role,
                ];
            } else {
                $data = [
                    'nama_lengkap' => $nama_lengkap,
                    'username' => $username,
                    'no_hp' => $no_hp,
                    'role' => $role,
                ];
            }

            $this->M_pegawai->updateAdmin($id_pegawai, $data);

            $flashdata = ['notif_message' => "Berhasil menyimpan Pegawai", 'notif_icon' => "success"];
            $this->session->set_flashdata($flashdata);
            redirect(base_url('admin/pegawai'));
        } catch (Exception $e) {
            $flashdata = ['notif_message' => $e->getMessage(), 'notif_icon' => "error"];
            $this->session->set_flashdata($flashdata);
            redirect(base_url('admin/pegawai'));
        }
    }
    

}


?>