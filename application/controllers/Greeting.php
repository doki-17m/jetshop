<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Greeting extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('m_greeting');
	}

	public function index()
	{
		$view = $this->views;
		$this->template->load($view->OVERVIEW, $view->VIEW_GREETING);
	}

	public function showAll()
	{
		$greeting = $this->m_greeting;
		$response = $greeting->setDataList();
		echo json_encode($response);
	}

	public function create()
	{
		$status = $this->status;
		$greeting = $this->m_greeting;
		$validation = $this->form_validation;
		$post = $this->input->post(NULL, TRUE);
		
		$validation->set_rules([
			[
				'field'		=>	'gre_sk',
				'label'		=>	'Search Key',
				'rules'		=>	'required|is_unique[m_greeting.value]',
				'errors'	=> 	[
					'is_unique'	=> 'This %s already exists.'
				]
			],
			[
				'field'		=>	'gre_name',
				'label'		=>	'Name',
				'rules'		=>	'required|is_unique[m_greeting.name]',
				'errors'	=> 	[
					'is_unique'	=> 'This %s already exists.'
				],
			]
		]);

		if ($validation->run()) {
			$greeting->insert($post);
			$response = $status->SUCCESS_INSERT;
		} else {
			$response = $greeting->form_error();
		}
		echo json_encode($response);
	}

	public function show($id)
	{
		$greeting = $this->m_greeting;
		$response = $greeting->detail($id)->row();
		echo json_encode($response);
	}

	public function edit($id)
	{
		$status = $this->status;
		$greeting = $this->m_greeting;
		$validation = $this->form_validation;
		$post = $this->input->post(NULL, TRUE);
		
		$validation->set_rules([
			[
				'field'		=>	'gre_sk',
				'label'		=>	'Search Key',
				'rules'		=>	'required|callback_check_gresk',
				'errors'	=> 	[
					'check_gresk'	=> 'This %s already exists.'
				]
			],
			[
				'field'		=>	'gre_name',
				'label'		=>	'Name',
				'rules'		=>	'required|callback_check_grename',
				'errors'	=> 	[
					'check_grename'	=> 'This %s already exists.'
				],
			]
		]);

		if ($validation->run()) {
			$greeting->update($id, $post);
			$response = $status->SUCCESS_UPDATE;
		} else {
			$response = $greeting->form_error();
		}
		echo json_encode($response);
	}

	public function destroy($id)
	{
		$greeting = $this->m_greeting;
		$response = $greeting->delete($id);
		echo json_encode($response);
	}

	public function showGreeting()
	{
		$status = $this->status;
		$greeting = $this->m_greeting;
		$isActive = $status->ACTIVE;
		$response = $greeting->listGreeting($isActive)->result();
		echo json_encode($response);
	}

	public function check_gresk()
	{
		$status = $this->status;
		$zero = $status->ZERO;
		$post = $this->input->post(NULL, TRUE);
		$greeting = $this->m_greeting;
		$rows = $greeting->callbackSearchKey($post)->num_rows();
		return $rows > $zero ? false : true;
	}	

	public function check_grename()
	{
		$status = $this->status;
		$zero = $status->ZERO;
		$post = $this->input->post(NULL, TRUE);
		$greeting = $this->m_greeting;
		$rows = $greeting->callbackName($post)->num_rows();
		return $rows > $zero ? false : true;
	}
}
