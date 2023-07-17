<?php 
// defined('BASEPATH') or exit('No direct script access allowed');
// class M_penjualan extends CI_Model
// {
//     // Datatable Function //
// 	public function _query_get_menu($status = "")
// 	{
//         $column_order = array(null, 'nama_menu', 'harga', 'status', 'null');
//         $column_search = array('nama_menu', 'id_menu', 'harga', 'status');
//         $order_by = array('id_menu' => 'asc');

//         $this->db->select('tb_menu.*, tb_kategori.nama_kategori');
//         $this->db->from('tb_menu');
//         $this->db->join('tb_kategori', 'tb_kategori.id_kategori = tb_menu.id_kategori');
//         if (!empty($status)) {
//             $this->db->where('tb_menu.status', $status);
//         }
// 		$i = 0;
// 		foreach ($column_search as $item) { // loop column 
// 			if (@$_POST['search']['value']) { // if datatable send POST for search
// 				if ($i === 0) { // first loop
// 					$this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
// 					$this->db->like($item, $_POST['search']['value']);
// 				} else {
// 					$this->db->or_like($item, $_POST['search']['value']);
// 				}
// 				if (count($column_search) - 1 == $i) //last loop
// 					$this->db->group_end(); //close bracket
// 			}
// 			$i++;
// 		}

// 		if (isset($_POST['order'])) { // here order processing
// 			$this->db->order_by($column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
// 		} else if (isset($order_by)) {
// 			$order = $order_by;
// 			$this->db->order_by(key($order), $order[key($order)]);
// 		}
// 	}

// 	public function get_datatables_menu($status = "")
// 	{
// 		$this->_query_get_menu($status);
// 		if (@$_POST['length'] != -1)
// 			$this->db->limit(@$_POST['length'], @$_POST['start']);
// 		$query = $this->db->get();
// 		return $query->result();
// 	}

// 	public function count_filtered_menu($status = "")
// 	{
// 		$this->_query_get_menu($status);
// 		$query = $this->db->get();
// 		return $query->num_rows();
// 	}

// 	public function count_all_menu($status = "")
// 	{
//         $this->db->from('tb_menu');
//         if (!empty($status)) {
//             $this->db->where('status', $status);
//         }
// 		return $this->db->count_all_results();
// 	}
// 	// End Datatable Function //
// }
