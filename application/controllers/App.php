<?php
defined('BASEPATH') or exit('No direct script access allowed');

class App extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('m_order');
		$this->load->model('m_product');
		isNotLogin();
	}

	public function index()
	{
		$data['omset'] = $this->m_order->todayOmzet()->row();
		$data['transaksi'] = $this->m_order->todayTransaction();
		$data['product'] = $this->m_product->totalProduct();
		$view = $this->views;
		$this->template->load($view->OVERVIEW, $view->VIEW_DASHBOARD, $data);
	}
}
