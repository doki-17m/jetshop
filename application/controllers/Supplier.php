<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Supplier extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('m_supplier');
	}

	public function index()
	{
		$view = $this->views;
		$this->template->load($view->OVERVIEW, $view->VIEW_SUPPLIER);
	}

	public function showAll()
	{
		$status = $this->status;
		$supplier = $this->m_supplier;
		$isVendor = $status->VENDOR;
		$response = $supplier->setDataList($isVendor);
		echo json_encode($response);
	}

	public function create()
	{
		$status = $this->status;
		$supplier = $this->m_supplier;
		$validation = $this->form_validation;
		$post = $this->input->post(NULL, TRUE);
		$isVendor = $status->VENDOR;

		$validation->set_rules([
			[
				'field'		=>	'sup_code',
				'label'		=>	'Supplier Code',
				'rules'		=>	'required|callback_check_supcode',
				'errors'	=> 	[
					'check_supcode'	=> 'This %s already exists.'
				]
			],
			[
				'field'		=>	'sup_name',
				'label'		=>	'Supplier Name',
				'rules'		=>	'required|callback_check_supname',
				'errors'	=> 	[
					'check_supname'	=> 'This %s already exists.'
				],
			],
			[
				'field'		=>	'sup_email',
				'label'		=>	'Email',
				'rules'		=>	'trim|valid_email|callback_check_supemail',
				'errors'	=> 	[
					'check_supemail'	=> 'This %s already exists.'
				],
			],
			[
				'field'		=>	'sup_address',
				'label'		=>	'Address',
				'rules'		=>	'required'
			],
			[
				'field'		=>	'sup_phone',
				'label'		=>	'Phone',
				'rules'		=>	'required'
			]
		]);

		if ($validation->run()) {
			$supplier->insert($post, $isVendor);
			$response = $status->SUCCESS_INSERT;
		} else {
			$response = $supplier->form_error();
		}
		echo json_encode($response);
	}

	public function show($id)
	{
		$supplier = $this->m_supplier;
		$response = $supplier->detail($id)->row();
		echo json_encode($response);
	}

	public function edit($id)
	{
		$status = $this->status;
		$supplier = $this->m_supplier;
		$validation = $this->form_validation;
		$post = $this->input->post(NULL, TRUE);
		
		$validation->set_rules([
			[
				'field'		=>	'sup_code',
				'label'		=>	'Supplier Code',
				'rules'		=>	'required|callback_check_supcode',
				'errors'	=> 	[
					'check_supcode'	=> 'This %s already exists.'
				]
			],
			[
				'field'		=>	'sup_name',
				'label'		=>	'Supplier Name',
				'rules'		=>	'required|callback_check_supname',
				'errors'	=> 	[
					'check_supname'	=> 'This %s already exists.'
				],
			],
			[
				'field'		=>	'sup_email',
				'label'		=>	'Email',
				'rules'		=>	'trim|valid_email|callback_check_supemail',
				'errors'	=> 	[
					'check_supemail'	=> 'This %s already exists.'
				],
			],
			[
				'field'		=>	'sup_address',
				'label'		=>	'Address',
				'rules'		=>	'required'
			],
			[
				'field'		=>	'sup_phone',
				'label'		=>	'Phone',
				'rules'		=>	'required'
			]
		]);

		if ($validation->run()) {
			$supplier->update($id, $post);
			$response = $status->SUCCESS_UPDATE;
		} else {
			$response = $supplier->form_error();
		}
		echo json_encode($response);
	}

	public function destroy($id)
	{
		$supplier = $this->m_supplier;
		$response = $supplier->delete($id);
		echo json_encode($response);
	}

	public function check_supcode()
	{
		$status = $this->status;
		$supplier = $this->m_supplier;
		$zero = $status->ZERO;
		$isVendor = $status->VENDOR;
		$post = $this->input->post(NULL, TRUE);
		$rows = $supplier->callbackSupCode($post, $isVendor)->num_rows();
		return $rows > $zero ? false : true;
	}	

	public function check_supname()
	{
		$status = $this->status;
		$supplier = $this->m_supplier;
		$zero = $status->ZERO;
		$isVendor = $status->VENDOR;
		$post = $this->input->post(NULL, TRUE);
		$rows = $supplier->callbackSupName($post, $isVendor)->num_rows();
		return $rows > $zero ? false : true;
	}

	public function check_supemail()
	{
		$status = $this->status;
		$supplier = $this->m_supplier;
		$zero = $status->ZERO;
		$isVendor = $status->VENDOR;
		$post = $this->input->post(NULL, TRUE);
		$rows = $supplier->callbackSupEmail($post, $isVendor)->num_rows();
		return $rows > $zero ? false : true;
	}	
}
