<?php

class Expense extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('m_expense');
	}

	public function index()
	{
		$view = $this->views;
		$this->template->load($view->OVERVIEW, $view->VIEW_EXPENSE);
	}

	public function showAll()
	{
		$expense = $this->m_expense;
		$response = $expense->setDataList();
		echo json_encode($response);
	}

	public function create()
	{
		$expense = $this->m_expense;
		$validation = $this->form_validation;
		$post = $this->input->post(NULL, TRUE);

		$validation->set_rules([
			[
				'field'		=>	'exp_date',
				'label'		=>	'Date Report',
				'rules'		=>	'required'
			],
			[
				'field'		=>	'exp_payment',
				'label'		=>	'Payment Method',
				'rules'		=>	'required'
			]
		]);

		if ($post['exp_payment'] == 2) {
			$validation->set_rules([
				[
					'field'		=>	'exp_bankacc',
					'label'		=>	'Bank Account',
					'rules'		=>	'required'
				]
			]);
		}

		if ($validation->run()) {
			$response = $expense->insert($post);
		} else {
			$response = $expense->form_error();
		}
		echo json_encode($response);
	}

	public function create_line()
	{
		$status = $this->status;
		$expense = $this->m_expense;
		$post = $this->input->post(NULL, TRUE);
		$insert = $expense->insert_line(null, $post);
		if ($insert) {
			$response = $status->SUCCESS_INSERT;
		} else {
			$response = $insert;
		}
		echo json_encode($response);
	}

	public function show($id)
	{
		$expense = $this->m_expense;
		$response = $expense->detail($id)->result();
		echo json_encode($response);
	}

	public function edit($id)
	{
		$expense = $this->m_expense;
		$validation = $this->form_validation;
		$post = $this->input->post(NULL, TRUE);

		$validation->set_rules([
			[
				'field'		=>	'exp_date',
				'label'		=>	'Date Report',
				'rules'		=>	'required'
			],
			[
				'field'		=>	'exp_payment',
				'label'		=>	'Payment Method',
				'rules'		=>	'required'
			]
		]);

		if ($post['exp_payment'] == 2) {
			$validation->set_rules([
				[
					'field'		=>	'exp_bankacc',
					'label'		=>	'Bank Account',
					'rules'		=>	'required'
				]
			]);
		}

		if ($validation->run()) {
			$response = $expense->update($id, $post);
		} else {
			$response = $expense->form_error();
		}
		echo json_encode($response);
	}

	public function update_line()
	{
		$status = $this->status;
		$expense = $this->m_expense;
		$post = $this->input->post(NULL, TRUE);
		$update = $expense->update_line($post);
		if ($update) {
			$response = $status->SUCCESS_INSERT;
		} else {
			$response = $update;
		}
		echo json_encode($response);
	}

	public function destroy_line()
	{
		$expense = $this->m_expense;
		$line_id = $_GET['id'];
		$response = $expense->delete_line($line_id);
		echo json_encode($response);
	}

	public function processDocaction()
	{
		$status = $this->status;
		$expense = $this->m_expense;
		$id = $_GET['id'];
		$docaction = $_GET['docaction'];
		$result = $expense->processStatus($id, $docaction);
		if ($result) {
			$response = $status->SUCCESS_DOCACTION;
		} else {
			$response = $status->ERROR_LINE;
		}
		echo json_encode($response);
	}

	public function get_docno()
	{
		$expense = $this->m_expense;
		$response = $expense->show_docno();
		echo json_encode($response);
	}
}
