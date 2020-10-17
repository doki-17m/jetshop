<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('m_user');
	}

	public function index()
	{
		$view = $this->views;
		$this->template->load($view->OVERVIEW, $view->VIEW_USER);
	}

	public function showAll()
	{
		$user = $this->m_user;
		$response = $user->setDataList();
		echo json_encode($response);
	}

	public function create()
	{
		$status = $this->status;
		$user = $this->m_user;
		$validation = $this->form_validation;
		$post = $this->input->post(NULL, TRUE);
		
		$validation->set_rules([
			[
				'field'		=>	'usr_username',
				'label'		=>	'Username',
				'rules'		=>	'required|max_length[10]|is_unique[sys_user.value]',
				'errors'	=> 	[
					'is_unique'	=> 'This %s already exists.'
				]
			],
			[
				'field'		=>	'usr_name',
				'label'		=>	'Name',
				'rules'		=>	'required'
			],
			[
				'field'		=>	'usr_password',
				'label'		=>	'Password',
				'rules'		=>	'required'
			],
			[
				'field'		=>	'usr_email',
				'label'		=>	'Email',
				'rules'		=>	'trim|valid_email|max_length[60]|is_unique[sys_user.email]',
				'errors'	=> 	[
					'is_unique'	=> 'This %s already exists.'
				],
			]
		]);

		if ($validation->run()) {
			$user->insert($post);
			$response = $status->SUCCESS_INSERT;
		} else {
			$response = $user->form_error();
		}
		echo json_encode($response);
	}

	public function show($id)
	{
		$user = $this->m_user;
		$response = $user->detail($id)->row();
		echo json_encode($response);
	}

	public function edit($id)
	{
		$status = $this->status;
		$user = $this->m_user;
		$validation = $this->form_validation;
		$post = $this->input->post(NULL, TRUE);
		
		$validation->set_rules([
			[
				'field'		=>	'usr_username',
				'label'		=>	'Username',
				'rules'		=>	'required|max_length[10]|callback_check_usrname',
				'errors'	=> 	[
					'check_usrname'	=> 'This %s already exists.'
				]
			],
			[
				'field'		=>	'usr_name',
				'label'		=>	'Name',
				'rules'		=>	'required'
			],
			[
				'field'		=>	'usr_email',
				'label'		=>	'Email',
				'rules'		=>	'trim|valid_email|max_length[60]|callback_check_usremail',
				'errors'	=> 	[
					'check_usremail'	=> 'This %s already exists.'
				],
			]
		]);

		if ($post['usr_password']) {
			$validation->set_rules(
				[
					'field'		=>	'usr_password',
					'label'		=>	'Password',
					'rules'		=>	'required'
				]
			);
		}

		if ($validation->run()) {
			$user->update($id, $post);
			$response = $status->SUCCESS_UPDATE;
		} else {
			$response = $user->form_error();
		}
		echo json_encode($response);
	}

	public function destroy($id)
	{
		$user = $this->m_user;
		$response = $user->delete($id);
		echo json_encode($response);
	}

	public function showUser()
	{
		$status = $this->status;
		$user = $this->m_user;
		$isActive = $status->ACTIVE;
		$response = $user->listUser($isActive)->result();
		echo json_encode($response);
	}

	public function showSales()
	{
		$status = $this->status;
		$user = $this->m_user;
		$isSales = $status->SALESREP;
		$response = $user->listSales($isSales)->result();
		echo json_encode($response);
	}

	public function check_usrname()
	{
		$status = $this->status;
		$user = $this->m_user;
		$zero = $status->ZERO;
		$post = $this->input->post(NULL, TRUE);
		$rows = $user->callbackUsername($post)->num_rows();
		return $rows > $zero ? false : true;
	}	

	public function check_usremail()
	{
		$status = $this->status;
		$user = $this->m_user;
		$zero = $status->ZERO;
		$post = $this->input->post(NULL, TRUE);
		$rows = $user->callbackEmail($post)->num_rows();
		return $rows > $zero ? false : true;
	}	
}
