<?php 
defined('BASEPATH') or exit('No direct script access allowed');
class M_promo extends CI_Model
{
    // Datatable Function //
	public function _query_get_promo($filter)
	{
        date_default_timezone_set("Asia/Jakarta");
        $tgl_sekarang = date("Y-m-d H:i:s");
        $column_order = array('datetime_start');
        $column_search = array('judul_voucher', 'kode_voucher');
        $order_by = array('datetime_start' => 'desc');

        $this->db->select('*');
        $this->db->from('tb_promo_voucher');
        if ($filter == "berjalan") {
            $this->db->where('datetime_start <=', $tgl_sekarang);
            $this->db->where('datetime_end >=', $tgl_sekarang);
        } else if ($filter == "mendatang") {
            $this->db->where('datetime_start >', $tgl_sekarang);
        } else if ($filter == "selesai") {
            $this->db->where('datetime_start <', $tgl_sekarang);
            $this->db->where('datetime_end <=', $tgl_sekarang);
        }

		$i = 0;
		foreach ($column_search as $item) { // loop column 
			if (@$_POST['search']['value']) { // if datatable send POST for search
				if ($i === 0) { // first loop
					$this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
					$this->db->like($item, $_POST['search']['value']);
				} else {
					$this->db->or_like($item, $_POST['search']['value']);
				}
				if (count($column_search) - 1 == $i) //last loop
					$this->db->group_end(); //close bracket
			}
			$i++;
		}

		if (isset($_POST['order'])) { // here order processing
			$this->db->order_by($column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} else if (isset($order_by)) {
			$order = $order_by;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	public function get_datatables_promo($filter)
	{
		$this->_query_get_promo($filter);
		if (@$_POST['length'] != -1)
			$this->db->limit(@$_POST['length'], @$_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	public function count_filtered_promo($filter)
	{
		$this->_query_get_promo($filter);
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all_promo($filter)
	{
        date_default_timezone_set("Asia/Jakarta");
        $tgl_sekarang = date("Y-m-d H:i:s");
        $this->db->from('tb_promo_voucher');
        if ($filter == "berjalan") {
            $this->db->where('datetime_start >=', $tgl_sekarang);
            $this->db->where('datetime_end <=', $tgl_sekarang);
        } else if ($filter == "mendatang") {
            $this->db->where('datetime_start >', $tgl_sekarang);
        } else if ($filter == "selesai") {
            $this->db->where('datetime_start <', $tgl_sekarang);
            $this->db->where('datetime_end <', $tgl_sekarang);
        }
		return $this->db->count_all_results();
	}
	// End Datatable Function //

    public function insertPromoVoucher($data) {
        $this->db->insert("tb_promo_voucher", $data);
        $insert_id = $this->db->insert_id();
        if ($this->db->affected_rows() > 0) {
            return $insert_id;
        } else {
            return false;
        }
    }

    public function updatePromo($id, $data) {
        $this->db->where('id_voucher', $id);
        return $this->db->update("tb_promo_voucher", $data);
    }

    public function getDetailPromo($id) {
        $this->db->select("*");
        $this->db->from("tb_promo_voucher");
        $this->db->where("id_voucher", $id);
        return $this->db->get()->row();
    }

    public function getPromoActive() {
        date_default_timezone_set("Asia/Jakarta");
        $tgl_sekarang = date("Y-m-d H:i:s");
        $this->db->select("*");
        $this->db->from("tb_promo_voucher");
        $this->db->where("status_voucher", "on");
        $this->db->where('datetime_start <=', $tgl_sekarang);
        $this->db->where('datetime_end >=', $tgl_sekarang);
        return $this->db->get()->result();
    }

    public function getPenggunaanVoucher($no_hp, $id_promo_voucher) {
        $this->db->select("*");
        $this->db->from("tb_order");
        $this->db->where("no_hp", $no_hp);
        $this->db->where('id_promo_voucher', $id_promo_voucher);
        return $this->db->get()->num_rows();
    }
}
