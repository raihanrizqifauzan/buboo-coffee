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

    public function getOrderByNoPesanan($no_pesanan, $no_hp = false)
	{
        $this->db->select("tb_order.*, tb_detailorder.nama_menu, tb_detailorder.nama_kategori, tb_menu.thumbnail, tb_menu.harga");
        $this->db->from("tb_order");
        $this->db->join('tb_detailorder', 'tb_detailorder.id_order = tb_order.id_order');
        $this->db->join('tb_menu', 'tb_menu.id_menu = tb_detailorder.id_menu');
        $this->db->where("tb_order.no_pesanan", $no_pesanan);
        if ($no_hp !== false) {
            $this->db->where("tb_order.no_hp", $no_hp);
        }
		$this->db->group_by('tb_order.id_order');
        return $this->db->get()->row();
    }

    public function getDetailOrder($id_order)
    {
        $this->db->select("tb_detailorder.*, tb_menu.thumbnail");
        $this->db->from("tb_detailorder");
        $this->db->join('tb_menu', 'tb_menu.id_menu = tb_detailorder.id_menu');
        $this->db->where("id_order", $id_order);
        return $this->db->get()->result();
    }

    public function getDetailOrderWithoutPromo($id_order)
    {
        $this->db->select("tb_detailorder.*, tb_menu.thumbnail");
        $this->db->from("tb_detailorder");
        $this->db->join('tb_menu', 'tb_menu.id_menu = tb_detailorder.id_menu');
        $this->db->where("id_order", $id_order);
        $this->db->where("keterangan is NULL");
        $this->db->group_by("tb_menu.id_menu");
        return $this->db->get()->result();
    }

    public function insertBatchLogStock($data)
    {
        return $this->db->insert_batch("log_perubahan_stock", $data);
    }

    public function updateDataOrder($id_order, $data)
    {
        $this->db->set($data);
        $this->db->where('id_order', $id_order);
        return $this->db->update('tb_order');
    }

    public function saveLogStatusOrder($data)
    {
        return $this->db->insert("log_status_order", $data);
    }

    public function getTotalOmset($datetime_start, $datetime_end) {
        $this->db->select("SUM(total_order - diskon) as total_omset");
        $this->db->from("tb_order");
        $this->db->where("datetime_order >=", $datetime_start);
        $this->db->where("datetime_order <=", $datetime_end);
        $this->db->where("status_order !=", "cancel");
        $this->db->where("status_order !=", "pending");
        $data = $this->db->get()->row();
        if (empty($data)) {
            $total_omset = 0;
        } else {
            $total_omset = $data->total_omset;
        }
        return empty($total_omset) ? 0 : $total_omset;
    }

    public function getJumlahOrder($datetime_start, $datetime_end) {
        $this->db->select("id_order");
        $this->db->from("tb_order");
        $this->db->where("datetime_order >=", $datetime_start);
        $this->db->where("datetime_order <=", $datetime_end);
        $this->db->where("status_order !=", "cancel");
        $this->db->where("status_order !=", "pending");
        $jumlah_order = $this->db->get()->num_rows();
        return $jumlah_order;
    }

    public function deleteDetailOrder($id_order) {
        $this->db->where("id_order", $id_order);
        return $this->db->delete("tb_detailorder");
    }

    public function updateOrder($data, $id_order) {
        $this->db->set($data);
        $this->db->where("id_order", $id_order);
        return $this->db->update("tb_order");
    }

    public function getItemOrder($id_order)
    {
        $this->db->select("tb_detailorder.*, SUM(tb_detailorder.quantity) as qty, tb_menu.thumbnail");
        $this->db->from("tb_detailorder");
        $this->db->join('tb_menu', 'tb_menu.id_menu = tb_detailorder.id_menu');
        $this->db->where("id_order", $id_order);
        $this->db->group_by("tb_detailorder.id_menu");
        return $this->db->get()->result();
    }
}

?>