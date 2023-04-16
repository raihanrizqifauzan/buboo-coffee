<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_infoweb extends CI_Model
{
	public function getInfoWeb()
	{
        $this->db->select("*");
        $this->db->from("tb_informasi_website");
        return $this->db->get()->row();
    }

    public function updateContact($data)
    {
        $this->db->set($data);
        return $this->db->update('tb_informasi_website');
    }
}

?>