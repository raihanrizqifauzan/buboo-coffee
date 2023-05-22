<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_pesanan extends CI_Model
{

    // Datatable Function //
	public function _query_get_menu($status = "")
	{
        $column_order = array('datetime_order');
        $column_search = array('no_pesanan');
        $order_by = array('datetime_order' => 'desc');

        $this->db->select('tb_order.*, DISTINCT(tb_detailorder.nama_kategori)');
        $this->db->from('tb_menu');
        $this->db->join('tb_kategori', 'tb_kategori.id_kategori = tb_menu.id_kategori');
        if (!empty($status)) {
            $this->db->where('tb_menu.status', $status);
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

	public function get_datatables_pesanan($status = "")
	{
		$this->_query_get_pesanan($status);
		if (@$_POST['length'] != -1)
			$this->db->limit(@$_POST['length'], @$_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	public function count_filtered_pesanan($status = "")
	{
		$this->_query_get_pesanan($status);
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all_pesanan($status = "")
	{
        $this->db->from('tb_menu');
        if (!empty($status)) {
            $this->db->where('status', $status);
        }
		return $this->db->count_all_results();
	}
	// End Datatable Function //
}