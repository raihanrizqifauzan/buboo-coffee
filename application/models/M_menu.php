<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_menu extends CI_Model
{

    // Datatable Function //
	public function _query_get_menu($status = "")
	{
        $column_order = array(null, 'nama_menu', 'harga', 'status', 'null');
        $column_search = array('nama_menu', 'id_menu', 'harga', 'status');
        $order_by = array('id_menu' => 'asc');

        $this->db->select('tb_menu.*, tb_kategori.nama_kategori');
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

	public function get_datatables_menu($status = "")
	{
		$this->_query_get_menu($status);
		if (@$_POST['length'] != -1)
			$this->db->limit(@$_POST['length'], @$_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	public function count_filtered_menu($status = "")
	{
		$this->_query_get_menu($status);
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all_menu($status = "")
	{
        $this->db->from('tb_menu');
        if (!empty($status)) {
            $this->db->where('status', $status);
        }
		return $this->db->count_all_results();
	}
	// End Datatable Function //

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

    public function countTotalMenu($id_kategori = null)
    {
        $this->db->select("*");
        $this->db->from("tb_menu");
        if ($id_kategori) {
            $this->db->where("id_kategori", $id_kategori);
        }
        return $this->db->get()->num_rows();
    }

    public function getMenuById($id_menu)
    {
        $this->db->select("tb_menu.*, tb_kategori.nama_kategori");
        $this->db->from("tb_menu");
        $this->db->join("tb_kategori", "tb_kategori.id_kategori = tb_menu.id_kategori");
        $this->db->where("tb_menu.id_menu", $id_menu);
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

    public function getBestSellerMenu()
    {
        $this->db->select("*");
        $this->db->from("tb_menu");
        $this->db->where("best_seller", "yes");
        return $this->db->get()->result();
    }

    public function insertMenu($data)
    {
        $this->db->insert("tb_menu", $data);
        $insert_id = $this->db->insert_id();
        if ($this->db->affected_rows() > 0) {
            return $insert_id;
        } else {
            return false;
        }
    }

    public function updateMenu($id_menu, $data)
    {
        $this->db->where('id_menu', $id_menu);
        $this->db->set($data);
        return $this->db->update("tb_menu");
    }

    public function insertLogMenu($data)
    {
        $this->db->insert("log_tb_menu", $data);
        $insert_id = $this->db->insert_id();
        if ($this->db->affected_rows() > 0) {
            return $insert_id;
        } else {
            return false;
        }
    }

    public function countTerjual($id_menu)
    {
        $this->db->select("SUM(CASE 
            WHEN tb_order.status_order != 'cancel' 
            THEN tb_detailorder.quantity 
            ELSE 0 
        END) AS total_terjual");
        $this->db->from("tb_detailorder");
        $this->db->join("tb_order", "tb_detailorder.id_order = tb_order.id_order");
        $this->db->where("id_menu", $id_menu);
        $this->db->group_by("tb_detailorder.id_menu");
        return $this->db->get()->row();
    }

    public function updateTotalView($id_menu)
    {
        $fieldToIncrease = "total_view";
        $this->db->set($fieldToIncrease, $fieldToIncrease."+1", FALSE);
        $this->db->where('id_menu', $id_menu);
        return $this->db->update('tb_menu');
    }
}

?>