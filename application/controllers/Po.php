<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Po extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('m_product', 'modpro');
	}

	public function index()
	{
		$this->template->load('overview', 'purchase/v_purchase');
	}

	public function store()
	{
		$response = $this->modpro->setData();
		echo json_encode($response);
	}

	public function create()
	{
		$post = $this->input->post(NULL, TRUE);
		$response = $this->modpro->insert($post);
		echo json_encode($response);
	}

	public function show($id)
	{
		$response = $this->modpro->detail($id)->row();
		echo json_encode($response);
	}

	public function edit($id)
	{
		$post = $this->input->post(NULL, TRUE);
		$response = $this->modpro->update($id, $post);
		echo json_encode($response);
	}

	public function destroy($id)
	{
		$response = $this->modpro->delete($id);
		echo json_encode($response);
	}
}
