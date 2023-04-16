<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_menu extends CI_Model
{

    public function getListMenu($id_kategori, $offset, $search = "", $order_by = "")
    {
        $this->db->select("*");
        $this->db->from("tb_menu");
        if ($id_kategori) {
            $this->db->where("id_kategori", $id_kategori);
        }
        if ($search) {
            $this->db->like("nama_menu", $search);
        }
        $this->db->limit(8, $offset);
        if ($order_by == "low-high") {
            $this->db->order_by("harga", "ASC");
        } else if ($order_by == "high-low") {
            $this->db->order_by("harga", "DESC");
        }
        return $this->db->get()->result();
    }

    public function countTotalMenu(Type $var = null)
    {
        $this->db->select("*");
        $this->db->from("tb_menu");
        return $this->db->get()->num_rows();
    }

    public function getMenuById($id_menu)
    {
        $this->db->select("*");
        $this->db->from("tb_menu");
        $this->db->where("id_menu", $id_menu);
        return $this->db->get()->row();
    }

    public function getRelatedMenu($id_kategori, $exclude_id)
    {
        $this->db->select("*");
        $this->db->from("tb_menu");
        $this->db->where("id_kategori", $id_kategori);
        $this->db->where("id_menu != ", $exclude_id);
        $this->db->limit(5);
        return $this->db->get()->result();
    }
}

?>