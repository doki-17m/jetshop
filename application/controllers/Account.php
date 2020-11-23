<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Account extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('m_account');
	}

	public function index()
	{
		$view = $this->views;
		$this->template->load($view->OVERVIEW, $view->VIEW_ACCOUNT);
	}

	public function showAll()
	{
		$account = $this->m_account;
		$response = $account->setDataList();
		echo json_encode($response);
	}

	public function create()
	{
		$status = $this->status;
		$account = $this->m_account;
		$validation = $this->form_validation;
		$post = $this->input->post(NULL, TRUE);

		$validation->set_rules([
			[
				'field'		=>	'acc_bank',
				'label'		=>	'Bank',
				'rules'		=>	'required'
			],
			[
				'field'		=>	'acc_accountno',
				'label'		=>	'Account Number',
				'rules'		=>	'required|is_unique[m_account.accountno]',
				'errors'	=> 	[
					'is_unique'	=> 'This %s already exists.'
				],
			],
			[
				'field'		=>	'acc_name',
				'label'		=>	'Name',
				'rules'		=>	'required'
			]
		]);

		if ($validation->run()) {
			$account->insert($post);
			$response = $status->SUCCESS_INSERT;
		} else {
			$response = $account->form_error();
		}
		echo json_encode($response);
	}

	public function show($id)
	{
		$account = $this->m_account;
		$response = $account->detail($id)->row();
		echo json_encode($response);
	}

	public function edit($id)
	{
		$status = $this->status;
		$account = $this->m_account;
		$validation = $this->form_validation;
		$post = $this->input->post(NULL, TRUE);

		$validation->set_rules([
			[
				'field'		=>	'acc_bank',
				'label'		=>	'Bank',
				'rules'		=>	'required'
			],
			[
				'field'		=>	'acc_accountno',
				'label'		=>	'Account Number',
				'rules'		=>	'required|callback_check_accountno',
				'errors'	=> 	[
					'check_accountno'	=> 'This %s already exists.'
				],
			],
			[
				'field'		=>	'acc_name',
				'label'		=>	'Name',
				'rules'		=>	'required'
			]
		]);

		if ($validation->run()) {
			$account->update($id, $post);
			$response = $status->SUCCESS_UPDATE;
		} else {
			$response = $account->form_error();
		}
		echo json_encode($response);
	}

	public function destroy($id)
	{
		$account = $this->m_account;
		$response = $account->delete($id);
		echo json_encode($response);
	}

	public function showBank()
	{
		$status = $this->status;
		$account = $this->m_account;
		$isActive = $status->ACTIVE;
		$response = $account->listBank($isActive)->result();
		echo json_encode($response);
	}

	public function showAccount()
	{
		$status = $this->status;
		$account = $this->m_account;
		$isActive = $status->ACTIVE;
		$response = $account->listAccount($isActive)->result();
		echo json_encode($response);
	}

	public function check_accountno()
	{
		$status = $this->status;
		$account = $this->m_account;
		$zero = $status->ZERO;

		$post = $this->input->post(NULL, TRUE);
		$rows = $account->callbackAccountNo($post)->num_rows();
		return $rows > $zero ? false : true;
	}
}
