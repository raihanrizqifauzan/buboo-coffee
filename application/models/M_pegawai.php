<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_pegawai extends CI_Model
{
    // Datatable Function //
	public function _query_get_admin()
	{
        $column_search = array('username', 'nama_lengkap', 'no_hp', 'role');
        $order_by = array('id' => 'asc');

        $this->db->select('*');
        $this->db->from('tb_admin');
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
	}

	public function get_datatables_admin()
	{
		$this->_query_get_admin();
		if (@$_POST['length'] != -1)
			$this->db->limit(@$_POST['length'], @$_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	public function count_filtered_admin()
	{
		$this->_query_get_admin();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_admin()
	{
        $this->db->from('tb_admin');
		return $this->db->count_all_results();
	}
	// End Datatable Function //

	public function createAdmin($data)
	{
        return $this->db->insert("tb_admin", $data);
    }

	public function getAllAdmin()
    {
        $this->db->select("*");
        $this->db->from("tb_admin");
        return $this->db->get()->result();
    }

    public function getAdmin($where)
    {
        $this->db->select("*");
        $this->db->from("tb_admin");
        $this->db->where($where);
        return $this->db->get()->row();
    }

	public function getKategoriByName($nama_kategori)
    {
        $this->db->select("*");
        $this->db->from("tb_kategori");
        $this->db->where("nama_kategori", $nama_kategori);
        return $this->db->get()->row();
    }

    public function updateAdmin($id, $data)
    {
        $this->db->set($data);
        $this->db->where('id', $id);
        return $this->db->update("tb_admin");
    }

    public function getMenuByKategori($id_kategori)
    {
        $this->db->select("*");
        $this->db->from("tb_menu");
        $this->db->where("id_kategori", $id_kategori);
        return $this->db->get()->result();
    }

    public function deletePegawai($id_pegawai)
	{
        $this->db->where("id", $id_pegawai);
        return $this->db->delete("tb_admin");
    }
}

?>