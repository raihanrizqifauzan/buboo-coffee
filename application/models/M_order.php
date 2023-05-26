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

    public function insertNewOrder($data)
    {
        $this->db->insert("tb_order", $data);
        $insert_id = $this->db->insert_id();
        if ($this->db->affected_rows() > 0) {
            return $insert_id;
        } else {
            return false;
        }
    }

    public function insertBatchDetailOrder($data)
    {
        return $this->db->insert_batch("tb_detailorder", $data);
    }

    public function countOrderToday($date)
	{
        $this->db->select("*");
        $this->db->from("tb_order");
        $this->db->where("datetime_order >=", $date);
        return $this->db->get()->num_rows();
    }

    public function getOrderByNoPesanan($no_pesanan)
	{
        $this->db->select("*");
        $this->db->from("tb_order");
        $this->db->where("no_pesanan", $no_pesanan);
        return $this->db->get()->row();
    }

    public function getDetailOrder($id_order)
    {
        $this->db->select("*");
        $this->db->from("tb_detailorder");
        $this->db->where("id_order", $id_order);
        return $this->db->get()->result();
    }
}

?>