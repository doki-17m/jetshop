<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Customer extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('m_customer');
	}

	public function index()
	{
		$view = $this->views;
		$this->template->load($view->OVERVIEW, $view->VIEW_CUSTOMER);
	}

	public function showAll()
	{
		$status = $this->status;
		$customer = $this->m_customer;
		$isCustomer = $status->CUSTOMER;
		$response = $customer->setDataList($isCustomer);
		echo json_encode($response);
	}

	public function create()
	{
		$status = $this->status;
		$customer = $this->m_customer;
		$validation = $this->form_validation;
		$post = $this->input->post(NULL, TRUE);
		$isCustomer = $status->CUSTOMER;

		$validation->set_rules([
			[
				'field'		=>	'cus_code',
				'label'		=>	'Customer Code',
				'rules'		=>	'required|callback_check_cuscode',
				'errors'	=> 	[
					'check_cuscode'	=> 'This %s already exists.'
				]
			],
			[
				'field'		=>	'cus_name',
				'label'		=>	'Customer Name',
				'rules'		=>	'required|callback_check_cusname',
				'errors'	=> 	[
					'check_cusname'	=> 'This %s already exists.'
				],
			],
			[
				'field'		=>	'cus_email',
				'label'		=>	'Email',
				'rules'		=>	'trim|valid_email|callback_check_cusemail',
				'errors'	=> 	[
					'check_cusemail'	=> 'This %s already exists.'
				],
			],
			[
				'field'		=>	'cus_address',
				'label'		=>	'Address',
				'rules'		=>	'required'
			],
			[
				'field'		=>	'cus_phone',
				'label'		=>	'Phone',
				'rules'		=>	'required'
			],
			[
				'field'		=>	'cus_province',
				'label'		=>	'Province',
				'rules'		=>	'required'
			],
			[
				'field'		=>	'cus_city',
				'label'		=>	'City',
				'rules'		=>	'required'
			]
		]);

		if ($validation->run()) {
			$customer->insert($post, $isCustomer);
			$response = $status->SUCCESS_INSERT;
		} else {
			$response = $customer->form_error();
		}
		echo json_encode($response);
	}

	public function show($id)
	{
		$customer = $this->m_customer;
		$response = $customer->detail($id)->row();
		echo json_encode($response);
	}

	public function edit($id)
	{
		$status = $this->status;
		$customer = $this->m_customer;
		$validation = $this->form_validation;
		$post = $this->input->post(NULL, TRUE);

		$validation->set_rules([
			[
				'field'		=>	'cus_code',
				'label'		=>	'Customer Code',
				'rules'		=>	'required|callback_check_cuscode',
				'errors'	=> 	[
					'check_cuscode'	=> 'This %s already exists.'
				]
			],
			[
				'field'		=>	'cus_name',
				'label'		=>	'Customer Name',
				'rules'		=>	'required|callback_check_cusname',
				'errors'	=> 	[
					'check_cusname'	=> 'This %s already exists.'
				],
			],
			[
				'field'		=>	'cus_email',
				'label'		=>	'Email',
				'rules'		=>	'trim|valid_email|callback_check_cusemail',
				'errors'	=> 	[
					'check_cusemail'	=> 'This %s already exists.'
				],
			],
			[
				'field'		=>	'cus_address',
				'label'		=>	'Address',
				'rules'		=>	'required'
			],
			[
				'field'		=>	'cus_phone',
				'label'		=>	'Phone',
				'rules'		=>	'required'
			],
			[
				'field'		=>	'cus_province',
				'label'		=>	'Province',
				'rules'		=>	'required'
			],
			[
				'field'		=>	'cus_city',
				'label'		=>	'City',
				'rules'		=>	'required'
			]
		]);

		if ($validation->run()) {
			$customer->update($id, $post);
			$response = $status->SUCCESS_UPDATE;
		} else {
			$response = $customer->form_error();
		}
		echo json_encode($response);
	}

	public function destroy($id)
	{
		$customer = $this->m_customer;
		$response = $customer->delete($id);
		echo json_encode($response);
	}

	public function showCustomer()
	{
		$status = $this->status;
		$customer = $this->m_customer;
		$isCustomer = $status->CUSTOMER;
		$isActive = $status->ACTIVE;
		$response = $customer->listCustomer($isActive, $isCustomer)->result();
		echo json_encode($response);
	}

	public function check_cuscode()
	{
		$status = $this->status;
		$customer = $this->m_customer;
		$zero = $status->ZERO;
		$isCustomer = $status->CUSTOMER;
		$post = $this->input->post(NULL, TRUE);
		$rows = $customer->callbackCusCode($post, $isCustomer)->num_rows();
		return $rows > $zero ? false : true;
	}

	public function check_cusname()
	{
		$status = $this->status;
		$customer = $this->m_customer;
		$zero = $status->ZERO;
		$isCustomer = $status->CUSTOMER;
		$post = $this->input->post(NULL, TRUE);
		$rows = $customer->callbackCusName($post, $isCustomer)->num_rows();
		return $rows > $zero ? false : true;
	}

	public function check_cusemail()
	{
		$status = $this->status;
		$customer = $this->m_customer;
		$zero = $status->ZERO;
		$isCustomer = $status->CUSTOMER;
		$post = $this->input->post(NULL, TRUE);
		$rows = $customer->callbackCusEmail($post, $isCustomer)->num_rows();
		return $rows > $zero ? false : true;
	}
}
