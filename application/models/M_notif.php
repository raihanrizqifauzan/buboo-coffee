<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_notif extends CI_Model
{

	public function registerOnesignal($data)
	{
        return $this->db->insert("tb_onesignal", $data);
    }

    public function getUserIdOneSignal($userId = false)
    {
        $this->db->select("*");
        $this->db->from("tb_onesignal");
        if ($userId != false) {
            $this->db->where('user_id', $userId);
            return $this->db->get()->row();
        } else {
            return $this->db->get()->result();
        }
    }

    public function getKodeOTPByNoHP($no_hp)
    {
        date_default_timezone_set('Asia/Jakarta');
        $tgl_sekarang = date('Y-m-d H:i:s');
        $this->db->select("*");
        $this->db->from("tb_otp");
        $this->db->where('datetime_expired >', $tgl_sekarang);
        $this->db->where('is_used', 'no');
        $this->db->where('no_hp', $no_hp);
        return $this->db->get()->row();
    }

    public function checkKodeOTP($kode_otp)
    {
        date_default_timezone_set('Asia/Jakarta');
        $tgl_sekarang = date('Y-m-d H:i:s');
        $this->db->select("*");
        $this->db->from("tb_otp");
        $this->db->where('datetime_expired >', $tgl_sekarang);
        $this->db->where('is_used', 'no');
        $this->db->where('kode_otp', $kode_otp);
        return $this->db->get()->row();
    }

    public function getDetailOTP($kode_otp)
    {
        $this->db->select("*");
        $this->db->from("tb_otp");
        $this->db->where('kode_otp', $kode_otp);
        return $this->db->get()->row();
    }

    public function createOTP($data)
    {
        return $this->db->insert('tb_otp', $data);
    }

    public function updateOTP($id, $data)
    {
        $this->db->where("id", $id);
        return $this->db->update('tb_otp', $data);
    }
}

?>