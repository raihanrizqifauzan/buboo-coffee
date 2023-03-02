<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Welcome extends CI_Controller
{
	public function index()
	{
		$data['title_of_page'] = 'Halaman Utama | Buboo Coffee';
		$this->load->view('public/structure/V_head', $data);
		$this->load->view('public/structure/V_topbar');
		$this->load->view('public/V_home');
		$this->load->view('public/structure/V_foot');
	}

	public function daftar_menu()
	{
		$data['title_of_page'] = 'Halaman Utama | Buboo Coffee';
		$this->load->view('public/structure/V_head', $data);
		$this->load->view('public/structure/V_topbar');
		$this->load->view('public/V_list_menu');
		$this->load->view('public/structure/V_foot');
	}

	public function detail_menu()
	{
		$data['title_of_page'] = 'Detail Menu | Buboo Coffee';
		$this->load->view('public/structure/V_head', $data);
		$this->load->view('public/structure/V_topbar');
		$this->load->view('public/V_detail_menu');
		$this->load->view('public/structure/V_foot');
	}
}
