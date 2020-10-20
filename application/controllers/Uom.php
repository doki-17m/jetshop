<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Uom extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('m_uom');
	}

	public function index()
	{
		$view = $this->views;
		$this->template->load($view->OVERVIEW, $view->VIEW_UOM);
	}

	public function showAll()
	{
		$uom = $this->m_uom;
		$response = $uom->setDataList();
		echo json_encode($response);
	}

	public function create()
	{
		$status = $this->status;
		$uom = $this->m_uom;
		$validation = $this->form_validation;
		$post = $this->input->post(NULL, TRUE);

		$validation->set_rules([
			[
				'field'		=>	'uom_code',
				'label'		=>	'UOM Code',
				'rules'		=>	'required|is_unique[m_uom.value]',
				'errors'	=> 	[
					'is_unique'	=> 'This %s already exists.'
				]
			],
			[
				'field'		=>	'uom_name',
				'label'		=>	'Name',
				'rules'		=>	'required|is_unique[m_uom.name]',
				'errors'	=> 	[
					'is_unique'	=> 'This %s already exists.'
				],
			]
		]);

		if ($validation->run()) {
			$uom->insert($post);
			$response = $status->SUCCESS_INSERT;
		} else {
			$response = $uom->form_error();
		}
		echo json_encode($response);
	}

	public function show($id)
	{
		$uom = $this->m_uom;
		$response = $uom->detail($id)->row();
		echo json_encode($response);
	}

	public function edit($id)
	{
		$status = $this->status;
		$uom = $this->m_uom;
		$validation = $this->form_validation;
		$post = $this->input->post(NULL, TRUE);

		$validation->set_rules([
			[
				'field'		=>	'uom_code',
				'label'		=>	'UOM Code',
				'rules'		=>	'required|callback_check_uomcode',
				'errors'	=> 	[
					'check_uomcode'	=> 'This %s already exists.'
				]
			],
			[
				'field'		=>	'uom_name',
				'label'		=>	'Name',
				'rules'		=>	'required|callback_check_uomname',
				'errors'	=> 	[
					'check_uomname'	=> 'This %s already exists.'
				],
			]
		]);

		if ($validation->run()) {
			$uom->update($id, $post);
			$response = $status->SUCCESS_UPDATE;
		} else {
			$response = $uom->form_error();
		}
		echo json_encode($response);
	}

	public function destroy($id)
	{
		$uom = $this->m_uom;
		$response = $uom->delete($id);
		echo json_encode($response);
	}

	public function showUom()
	{
		$status = $this->status;
		$uom = $this->m_uom;
		$isActive = $status->ACTIVE;
		$response = $uom->listUom($isActive)->result();
		echo json_encode($response);
	}

	public function check_uomcode()
	{
		$status = $this->status;
		$uom = $this->m_uom;
		$zero = $status->ZERO;
		$post = $this->input->post(NULL, TRUE);
		$rows = $uom->callbackCode($post)->num_rows();
		return $rows > $zero ? false : true;
	}

	public function check_uomname()
	{
		$status = $this->status;
		$uom = $this->m_uom;
		$zero = $status->ZERO;
		$post = $this->input->post(NULL, TRUE);
		$rows = $uom->callbackName($post)->num_rows();
		return $rows > $zero ? false : true;
	}
}
