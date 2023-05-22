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
}

?>