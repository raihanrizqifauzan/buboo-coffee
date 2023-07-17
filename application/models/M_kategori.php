<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_kategori extends CI_Model
{
    // Datatable Function //
	public function _query_get_kategori()
	{
        $column_order = array('nama_kategori', 'icon_kategori', null);
        $column_search = array('nama_kategori');
        $order_by = array('nama_kategori' => 'asc');

        $this->db->select('*');
        $this->db->from('tb_kategori');
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

	public function get_datatables_kategori()
	{
		$this->_query_get_kategori();
		if (@$_POST['length'] != -1)
			$this->db->limit(@$_POST['length'], @$_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	public function count_filtered_kategori()
	{
		$this->_query_get_kategori();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all_kategori()
	{
        $this->db->from('tb_kategori');
		return $this->db->count_all_results();
	}
	// End Datatable Function //

	public function createKategori($data)
	{
        return $this->db->insert("tb_kategori", $data);
    }

	public function getAllKategori()
    {
        $this->db->select("*");
        $this->db->from("tb_kategori");
        return $this->db->get()->result();
    }

    public function getKategoriById($id_kategori)
    {
        $this->db->select("*");
        $this->db->from("tb_kategori");
        $this->db->where("id_kategori", $id_kategori);
        return $this->db->get()->row();
    }

	public function getKategoriByName($nama_kategori)
    {
        $this->db->select("*");
        $this->db->from("tb_kategori");
        $this->db->where("nama_kategori", $nama_kategori);
        return $this->db->get()->row();
    }

    public function updateKategori($id, $data)
    {
        $this->db->set($data);
        $this->db->where('id_kategori', $id);
        return $this->db->update("tb_kategori");
    }

    public function getMenuByKategori($id_kategori)
    {
        $this->db->select("*");
        $this->db->from("tb_menu");
        $this->db->where("id_kategori", $id_kategori);
        return $this->db->get()->result();
    }

    public function deleteKategori($id_kategori)
	{
        $this->db->where("id_kategori", $id_kategori);
        return $this->db->delete("tb_kategori");
    }
}

?>