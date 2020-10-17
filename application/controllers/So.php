<?php
defined('BASEPATH') or exit('No direct script access allowed');

class So extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('m_order', 'modor');
	}

	public function index()
	{
		$this->template->load('overview', 'sales/v_so');
	}

	public function store()
	{
		$response = $this->modor->setData();
		echo json_encode($response);
	}

	public function create()
	{
		$post = $this->input->post(NULL, TRUE);
		$response = $this->modor->insert($post);
		echo json_encode($response);
	}

	public function show($id)
	{
		$response = $this->modor->detail($id)->row();
		echo json_encode($response);
	}

	public function edit($id)
	{
		$post = $this->input->post(NULL, TRUE);
		$response = $this->modor->update($id, $post);
		echo json_encode($response);
	}
}
