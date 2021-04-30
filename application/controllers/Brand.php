<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Brand extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('m_brand');
	}

	public function index()
	{
		$this->template->load('overview', 'brand/v_brand');
	}

	public function showAll()
	{
		$response = $this->m_brand->setDataList();
		echo json_encode($response);
	}

	public function create()
	{
		$status = $this->status;
		$validation = $this->form_validation;
		$post = $this->input->post(NULL, TRUE);

		$validation->set_rules([
			[
				'field'		=>	'bra_sk',
				'label'		=>	'Search Key',
				'rules'		=>	'required|is_unique[m_brand.value]',
				'errors'	=> 	[
					'is_unique'	=> 'This %s already exists.'
				]
			],
			[
				'field'		=>	'bra_name',
				'label'		=>	'Name',
				'rules'		=>	'required|is_unique[m_brand.name]',
				'errors'	=> 	[
					'is_unique'	=> 'This %s already exists.'
				],
			]
		]);

		if ($validation->run()) {
			$this->m_brand->insert($post);
			$response = $status->SUCCESS_INSERT;
		} else {
			$response = $this->m_brand->form_error();
		}
		echo json_encode($response);
	}

	public function show($id)
	{
		$response = $this->m_brand->detail($id)->row();
		echo json_encode($response);
	}

	public function edit($id)
	{
		$status = $this->status;
		$validation = $this->form_validation;
		$post = $this->input->post(NULL, TRUE);

		$validation->set_rules([
			[
				'field'		=>	'bra_sk',
				'label'		=>	'Search Key',
				'rules'		=>	'required|callback_check_brask',
				'errors'	=> 	[
					'check_brask'	=> 'This %s already exists.'
				]
			],
			[
				'field'		=>	'bra_name',
				'label'		=>	'Name',
				'rules'		=>	'required|callback_check_braname',
				'errors'	=> 	[
					'check_braname'	=> 'This %s already exists.'
				],
			]
		]);

		if ($validation->run()) {
			$this->m_brand->update($id, $post);
			$response = $status->SUCCESS_UPDATE;
		} else {
			$response = $this->m_brand->form_error();
		}
		echo json_encode($response);
	}

	public function destroy($id)
	{
		$response = $this->m_brand->delete($id);
		echo json_encode($response);
	}

	public function showJob()
	{
		$status = $this->status;
		$isActive = $status->ACTIVE;
		$response = $this->m_brand->listJob($isActive)->result();
		echo json_encode($response);
	}

	public function check_brask()
	{
		$status = $this->status;
		$zero = $status->ZERO;
		$post = $this->input->post(NULL, TRUE);
		$rows = $this->m_brand->callbackSearchKey($post)->num_rows();
		return $rows > $zero ? false : true;
	}

	public function check_braname()
	{
		$status = $this->status;
		$zero = $status->ZERO;
		$post = $this->input->post(NULL, TRUE);
		$rows = $this->m_brand->callbackName($post)->num_rows();
		return $rows > $zero ? false : true;
	}
}
