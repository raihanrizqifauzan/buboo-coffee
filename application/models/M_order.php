<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_order extends CI_Model
{
	public function getMejaByNumber($no_meja)
	{
        $this->db->select("*");
        $this->db->from("tb_meja");
        $this->db->where("no_meja", $no_meja);
        return $this->db->get()->row();
    }
}

?>