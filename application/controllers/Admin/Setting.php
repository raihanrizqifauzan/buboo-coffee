<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Setting extends CI_Controller
{
    public function __construct(Type $var = null) {
        parent::__construct();
        $this->load->model(["M_Setting", "M_infoweb"]);
        if(empty($this->session->userdata('username'))) {
            redirect(base_url('admin/login'));
        }
    }


    public function index()
	{
        $data['data_toko'] = $this->M_infoweb->getInfoWeb();
        $data['title_page'] = "Setting Toko - Buboo Coffee";
        $data['judul'] = "Setting Toko";
        $data['back_url'] = base_url('admin');
        $this->load->view('admin/structure/V_head', $data);
        $this->load->view('admin/structure/V_topbar');
        $this->load->view('admin/structure/V_sidebar');
		$this->load->view('admin/V_setting_toko');
        $this->load->view('admin/structure/V_foot');
	}

    public function update_data_toko() {
        $nama_toko = $this->input->post('nama_toko', TRUE);
        $no_telp = $this->input->post('no_telp', TRUE);
        $alamat_lengkap = $this->input->post('alamat_lengkap', TRUE);

        try {
            if (empty($nama_toko)) {
                throw new Exception("Nama Toko tidak boleh kosong");
            } else if (empty($no_telp)) {
                throw new Exception("No Telp tidak boleh kosong");
            } else if (empty($alamat_lengkap)) {
                throw new Exception("Alamat lengkap tidak boleh kosong");
            }
            

            if (substr($no_telp, 0, 3) != "+62") {
                throw new Exception("Harus diawali +62");
            }
            
            if (!is_numeric(substr($no_telp, 3))) {
                throw new Exception("No. HP tidak valid");
            }

            if (strlen($no_telp) > 15) {
                throw new Exception("No. HP maksimal 15 digit");
            }
            
			$this->db->trans_start();
            $data_toko = [
                'nama_toko' => $nama_toko,
                'no_telp' => $no_telp,
                'alamat_lengkap' => $alamat_lengkap,
            ];

            $this->M_infoweb->updateContact($data_toko);
            $this->db->trans_commit();
            echo json_encode(['status' => true, 'message' => "Berhasil mengubah data toko"]);
        } catch (Exception $e) {
            $this->db->trans_rollback();
            echo json_encode(['status' => false, 'message' => $e->getMessage()]);
        }
    }

    public function update_jadwal_libur() {
        $datetime_start = $this->input->post('datetime_start', TRUE);
        $datetime_end = $this->input->post('datetime_end', TRUE);
        $keterangan = $this->input->post('keterangan', TRUE);

        try {
            if (!empty($datetime_start) || !empty($datetime_end) || !empty($keterangan)) {
                if (empty($datetime_start) || empty($datetime_end) || empty($keterangan)) {
                    throw new Exception("Lengkapi Data Jadwal Libur");
                }

                if ($datetime_start >= $datetime_end) {
                    throw new Exception("Jadwal Libur tidak valid");
                }
            } else {
                $arr_hari_libur = [
                    'datetime_start' => null,
                    'datetime_end' => null,
                    'keterangan' => null,
                ];
            }
            
			$this->db->trans_start();
            $arr_hari_libur = [
                'datetime_start' => $datetime_start,
                'datetime_end' => $datetime_end,
                'keterangan' => $keterangan,
            ];

            $data = [
                'jadwal_libur' => json_encode($arr_hari_libur),
            ];

            $this->M_infoweb->updateContact($data);
            $this->db->trans_commit();
            echo json_encode(['status' => true, 'message' => "Berhasil menyimpan jadwal libur"]);
        } catch (Exception $e) {
            $this->db->trans_rollback();
            echo json_encode(['status' => false, 'message' => $e->getMessage()]);
        }
    }

    public function update_hari_operasional() {
        $start_time = $this->input->post('start_time', TRUE);
        $end_time = $this->input->post('end_time', TRUE);
        $status = $this->input->post('status', TRUE);

        try {
            $list_hari = [
                'mon' => 'Senin',
                'tue' => 'Selasa',
                'wed' => 'Rabu',
                'thu' => 'Kamis',
                'fri' => 'Jumat',
                'sat' => 'Sabtu',
                'sun' => 'Minggu',
            ];

            $data = [];
            $i = 0;
            foreach ($list_hari as $key => $hari) {
                $temp = [
                    'start_time' => $start_time[$i],
                    'end_time' => $end_time[$i],
                    'status' => $status[$i],
                ];
                $data[$key] = $temp;
                $i++;
            }
            
			$this->db->trans_start();
            $arr_data = [
                'hari_operasional' => json_encode($data),
            ];

            $this->M_infoweb->updateContact($arr_data);
            $this->db->trans_commit();
            echo json_encode(['status' => true, 'message' => "Berhasil menyimpan jadwal operasional"]);
        } catch (Exception $e) {
            $this->db->trans_rollback();
            echo json_encode(['status' => false, 'message' => $e->getMessage()]);
        }
    }
}