<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Welcome extends CI_Controller
{
	public function __construct(Type $var = null) {
        parent::__construct();
        $this->load->model(["M_infoweb", "M_kategori", "M_menu"]);
    }

	public function index()
	{
		$data['title_of_page'] = 'Home | Buboo Coffee';
		$this->load->view('public/structure/V_head', $data);
		$this->load->view('public/structure/V_topbar');
		$this->load->view('public/V_home');
		$this->load->view('public/structure/V_foot');
	}

	public function daftar_menu()
	{
		$data['list_kategori'] = $this->M_kategori->getAllKategori();
		$data['title_of_page'] = 'Menu | Buboo Coffee';
		$this->load->view('public/structure/V_head', $data);
		$this->load->view('public/structure/V_topbar');
		$this->load->view('public/V_list_menu');
		$this->load->view('public/structure/V_foot');
	}

	public function detail_menu($id_menu)
	{
		if (empty($id_menu)) {
			redirect(base_url('daftar-menu'));
		}
		$explode = explode(".", $id_menu);
		if (count($explode) != 2) {
			redirect(base_url('daftar-menu'));
		}
		$id_menu = $explode[1];
		$data['menu'] = $this->M_menu->getMenuById($id_menu);
		$data['related_menu'] = $this->M_menu->getRelatedMenu($data['menu']->id_kategori, $id_menu);
		$data['title_of_page'] = 'Detail Menu | Buboo Coffee';
		$this->load->view('public/structure/V_head', $data);
		$this->load->view('public/structure/V_topbar');
		$this->load->view('public/V_detail_menu');
		$this->load->view('public/structure/V_foot');
	}

	public function contact()
	{
		$data['data'] = $this->M_infoweb->getInfoWeb();
		$data['title_of_page'] = 'Kontak | Buboo Coffee';
		$this->load->view('public/structure/V_head', $data);
		$this->load->view('public/structure/V_topbar');
		$this->load->view('public/V_contact');
		$this->load->view('public/structure/V_foot');
	}

	public function about()
	{
		$data['data'] = $this->M_infoweb->getInfoWeb();
		$data['title_of_page'] = 'Tentang Kami | Buboo Coffee';
		$this->load->view('public/structure/V_head', $data);
		$this->load->view('public/structure/V_topbar');
		$this->load->view('public/V_about_us');
		$this->load->view('public/structure/V_foot');
	}

	public function ajax_get_menu()
	{
		$perPage = 8;
		$page = $this->input->get("page");
		$id_kategori = $this->input->get("id_kategori");
		$search = $this->input->get("search");
		$order_by = $this->input->get("order_by");
		if(empty($page)) {
			$offset = 0;
			$page = 1;
		} else if($page == 1) {
			$offset = 0;
		} else {
			$offset = $perPage * ($page - 1);
		}

		$menu = $this->M_menu->getListMenu($id_kategori, $offset, $search, $order_by);
		$totalRecords = $this->M_menu->countTotalMenu();
		$data['totalPages'] = ceil($totalRecords / $perPage);
		$data['currentPage'] = $page;
		$data['id_kategori'] = $id_kategori;
		$data['list_menu'] = $menu;
		echo json_encode($data);
	}

	public function scan()
	{
		$data['title_of_page'] = 'Kontak | Buboo Coffee';
		$this->load->view('public/structure/V_head', $data);
		$this->load->view('public/structure/V_topbar');
		$this->load->view('public/V_scan');
		$this->load->view('public/structure/V_foot');
	}
}
