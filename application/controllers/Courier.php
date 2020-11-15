<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Courier extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('m_courier');
	}

	public function index()
	{
		$view = $this->views;
		$this->template->load($view->OVERVIEW, $view->VIEW_COURIER);
	}

	public function showAll()
	{
		$courier = $this->m_courier;
		$response = $courier->setDataList();
		echo json_encode($response);
	}

	public function create()
	{
		$status = $this->status;
		$courier = $this->m_courier;
		$validation = $this->form_validation;
		$post = $this->input->post(NULL, TRUE);

		$validation->set_rules([
			[
				'field'		=>	'cou_code',
				'label'		=>	'Courier Code',
				'rules'		=>	'required|is_unique[m_courier.value]',
				'errors'	=> 	[
					'is_unique'	=> 'This %s already exists.'
				]
			],
			[
				'field'		=>	'cou_name',
				'label'		=>	'Name',
				'rules'		=>	'required|is_unique[m_courier.name]',
				'errors'	=> 	[
					'is_unique'	=> 'This %s already exists.'
				],
			]
		]);

		if ($validation->run()) {
			$courier->insert($post);
			$response = $status->SUCCESS_INSERT;
		} else {
			$response = $courier->form_error();
		}
		echo json_encode($response);
	}

	public function show($id)
	{
		$courier = $this->m_courier;
		$response = $courier->detail($id)->row();
		echo json_encode($response);
	}

	public function edit($id)
	{
		$status = $this->status;
		$courier = $this->m_courier;
		$validation = $this->form_validation;
		$post = $this->input->post(NULL, TRUE);

		$validation->set_rules([
			[
				'field'		=>	'cou_code',
				'label'		=>	'Courier Code',
				'rules'		=>	'required|callback_check_coucode',
				'errors'	=> 	[
					'check_coucode'	=> 'This %s already exists.'
				]
			],
			[
				'field'		=>	'cou_name',
				'label'		=>	'Name',
				'rules'		=>	'required|callback_check_couname',
				'errors'	=> 	[
					'check_couname'	=> 'This %s already exists.'
				],
			]
		]);

		if ($validation->run()) {
			$courier->update($id, $post);
			$response = $status->SUCCESS_UPDATE;
		} else {
			$response = $courier->form_error();
		}
		echo json_encode($response);
	}

	public function destroy($id)
	{
		$courier = $this->m_courier;
		$response = $courier->delete($id);
		echo json_encode($response);
	}

	public function showCourier()
	{
		$status = $this->status;
		$courier = $this->m_courier;
		$isActive = $status->ACTIVE;
		$response = $courier->listCourier($isActive)->result();
		echo json_encode($response);
	}

	public function check_coucode()
	{
		$status = $this->status;
		$zero = $status->ZERO;
		$post = $this->input->post(NULL, TRUE);
		$courier = $this->m_courier;
		$rows = $courier->callbackCode($post)->num_rows();
		return $rows > $zero ? false : true;
	}

	public function check_couname()
	{
		$status = $this->status;
		$zero = $status->ZERO;
		$post = $this->input->post(NULL, TRUE);
		$courier = $this->m_courier;
		$rows = $courier->callbackName($post)->num_rows();
		return $rows > $zero ? false : true;
	}
}
