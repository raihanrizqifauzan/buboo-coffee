<?php 
defined('BASEPATH') or exit('No direct script access allowed');
class M_report extends CI_Model
{
    function countRowOmset($start, $end) {
        $this->db->select("SUM(total_order - diskon)");
        $this->db->from("tb_order");
        $this->db->where("status_order != ", "pending");
        $this->db->where("status_order != ", "cancel");
        $this->db->where("datetime_order >= ", $start);
        $this->db->where("datetime_order <= ", $end);
        $this->db->group_by("DATE(datetime_order)");
        return $this->db->get()->num_rows();
    }

    function getOmsetPerHari($start, $end) {
        $this->db->select("DATE(datetime_order) as datetime_order, SUM(total_order - diskon) as total_order");
        $this->db->from("tb_order");
        $this->db->where("status_order != ", "pending");
        $this->db->where("status_order != ", "cancel");
        $this->db->where("datetime_order >= ", $start);
        $this->db->where("datetime_order <= ", $end);
        $this->db->group_by("DATE(datetime_order)");
        return $this->db->get()->result_array();
    }

    function getDataOrder($start, $end) {
        $this->db->select("id_order, no_pesanan, nama_customer, no_hp, datetime_order, total_order, diskon, judul_voucher");
        $this->db->from("tb_order");
        $this->db->join("tb_promo_voucher", "tb_order.id_promo_voucher = tb_promo_voucher.id_voucher", "left");
        $this->db->where("status_order != ", "pending");
        $this->db->where("status_order != ", "cancel");
        $this->db->where("datetime_order >= ", $start);
        $this->db->where("datetime_order <= ", $end);
        return $this->db->get()->result_array();
    }

    function getDetailOrder($start, $end) {
        $this->db->select("tb_detailorder.id_order, no_pesanan, datetime_order, nama_menu, nama_kategori, quantity, harga, potongan, keterangan, judul_voucher");
        $this->db->from("tb_detailorder");
        $this->db->join("tb_order", "tb_order.id_order = tb_detailorder.id_order");
        $this->db->join("tb_promo_voucher", "tb_order.id_promo_voucher = tb_promo_voucher.id_voucher", "left");
        $this->db->where("status_order != ", "pending");
        $this->db->where("status_order != ", "cancel");
        $this->db->where("datetime_order >= ", $start);
        $this->db->where("datetime_order <= ", $end);
        return $this->db->get()->result_array();
    }

}