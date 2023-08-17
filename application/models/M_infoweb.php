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

    public function countMeja()
    {
        $this->db->select("*");
        $this->db->from("tb_meja");
        return $this->db->get()->num_rows();
    }

    public function updateMeja($jumlah_meja)
    {
        $this->db->truncate('tb_meja');
        for ($i=1; $i <= $jumlah_meja; $i++) { 
            $data = ['no_meja' => $i];
            $this->db->insert('tb_meja', $data);
        }
        return true;
    }
}

?>