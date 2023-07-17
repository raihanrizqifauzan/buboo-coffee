<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_login extends CI_Model
{

	public function checkLogin($username, $password)
	{
        $this->db->select("*");
        $this->db->from("tb_admin");
        $this->db->where(['username' => $username, "password" => $password]);
        return $this->db->get()->row();
    }
}

?>