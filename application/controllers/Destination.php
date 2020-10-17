<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Destination extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('m_province');
	}

	public function index()
	{
		$view = $this->views;
		$this->template->load($view->OVERVIEW, $view->VIEW_DESTINATION);
	}
}
