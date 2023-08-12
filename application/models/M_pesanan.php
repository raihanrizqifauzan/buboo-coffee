<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_pesanan extends CI_Model
{

    // Datatable Function //
	public function _query_get_pesanan($status = "", $no_hp = false)
	{
        $column_order = array('datetime_order');
        $column_search = array('no_pesanan', 'nama_customer');
        $order_by = array('datetime_order' => 'desc');

        $this->db->select('tb_order.*, tb_detailorder.nama_menu, tb_detailorder.nama_kategori, tb_menu.thumbnail');
        $this->db->from('tb_order');
        $this->db->join('tb_detailorder', 'tb_detailorder.id_order = tb_order.id_order');
        $this->db->join('tb_menu', 'tb_menu.id_menu = tb_detailorder.id_menu');
        if (!empty($status)) {
            $this->db->where('tb_order.status_order', $status);
        }
		if ($no_hp !== false) {
            $this->db->where('tb_order.no_hp', $no_hp);
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

		$this->db->group_by('tb_order.id_order');

		if (isset($_POST['order'])) { // here order processing
			$this->db->order_by($column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} else if (isset($order_by)) {
			$order = $order_by;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	public function get_datatables_pesanan($status = "", $no_hp = false)
	{
		$this->_query_get_pesanan($status, $no_hp);
		if (@$_POST['length'] != -1)
			$this->db->limit(@$_POST['length'], @$_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	public function count_filtered_pesanan($status = "", $no_hp = false)
	{
		$this->_query_get_pesanan($status, $no_hp);
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all_pesanan($status = "", $no_hp = false)
	{
        $this->db->from('tb_order');
        if (!empty($status)) {
            $this->db->where('status_order', $status);
        }

		if ($no_hp !== false) {
            $this->db->where('no_hp', $no_hp);
		}
		return $this->db->count_all_results();
	}
	// End Datatable Function //
}