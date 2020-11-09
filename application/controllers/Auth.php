<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('m_auth');
	}

	public function index()
	{
		isLogin();
		$view = $this->views;
		$this->load->view($view->VIEW_LOGIN);
	}

	public function login()
	{
		$status = $this->status;
		$auth = $this->m_auth;
		$validation = $this->form_validation;
		$post = $this->input->post(NULL, TRUE);
		$isActive = $status->ACTIVE;

		$validation->set_rules([
			[
				'field'		=>	'lgn_username',
				'label'		=>	'Username',
				'rules'		=>	'required'
			],
			[
				'field'		=>	'lgn_pass',
				'label'		=>	'Password',
				'rules'		=>	'required'
			]
		]); 
		
		if ($validation->run()) {
			$response = $auth->setLogin($post, $isActive);
		} else {
			$response = $auth->form_error();
		}
		echo json_encode($response);
	}

	public function check_username($string)
	{
		$status = $this->status;
		$auth = $this->m_auth;
		$isActive = $status->ACTIVE;
		$response = $auth->getUsername($string, $isActive);
		echo json_encode($response);
	}

	public function logout()
	{
		$session = $this->session;
		$arrLogin = ['user_id', 'role_id'];
		$session->unset_userdata($arrLogin);
		$this->cart->destroy();
		redirect('auth');
	}
}
