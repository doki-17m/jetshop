<?php
defined('BASEPATH') OR exit ('No direct script access allowed');

class App extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		isNotLogin();
	}

	public function index()
	{
		$view = $this->views;
		$this->template->load($view->OVERVIEW, $view->VIEW_DASHBOARD);
	}
}
