<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Job extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('m_job');
	}

	public function index()
	{
		$view = $this->views;
		$this->template->load($view->OVERVIEW, $view->VIEW_JOB);
	}

	public function showAll()
	{
		$job = $this->m_job;
		$response = $job->setDataList();
		echo json_encode($response);
	}

	public function create()
	{
		$status = $this->status;
		$job = $this->m_job;
		$validation = $this->form_validation;
		$post = $this->input->post(NULL, TRUE);
		
		$validation->set_rules([
			[
				'field'		=>	'job_sk',
				'label'		=>	'Search Key',
				'rules'		=>	'required|is_unique[m_job.value]',
				'errors'	=> 	[
					'is_unique'	=> 'This %s already exists.'
				]
			],
			[
				'field'		=>	'job_name',
				'label'		=>	'Name',
				'rules'		=>	'required|is_unique[m_job.name]',
				'errors'	=> 	[
					'is_unique'	=> 'This %s already exists.'
				],
			]
		]);

		if ($validation->run()) {
			$job->insert($post);
			$response = $status->SUCCESS_INSERT;
		} else {
			$response = $job->form_error();
		}
		echo json_encode($response);
	}

	public function show($id)
	{
		$job = $this->m_job;
		$response = $job->detail($id)->row();
		echo json_encode($response);
	}

	public function edit($id)
	{
		$status = $this->status;
		$job = $this->m_job;
		$validation = $this->form_validation;
		$post = $this->input->post(NULL, TRUE);
		
		$validation->set_rules([
			[
				'field'		=>	'job_sk',
				'label'		=>	'Search Key',
				'rules'		=>	'required|callback_check_jobsk',
				'errors'	=> 	[
					'check_jobsk'	=> 'This %s already exists.'
				]
			],
			[
				'field'		=>	'job_name',
				'label'		=>	'Name',
				'rules'		=>	'required|callback_check_jobname',
				'errors'	=> 	[
					'check_jobname'	=> 'This %s already exists.'
				],
			]
		]);

		if ($validation->run()) {
			$job->update($id, $post);
			$response = $status->SUCCESS_UPDATE;
		} else {
			$response = $job->form_error();
		}
		echo json_encode($response);
	}

	public function destroy($id)
	{
		$job = $this->m_job;
		$response = $job->delete($id);
		echo json_encode($response);
	}

	public function showJob()
	{
		$status = $this->status;
		$job = $this->m_job;
		$isActive = $status->ACTIVE;
		$response = $job->listJob($isActive)->result();
		echo json_encode($response);
	}

	public function check_jobsk()
	{
		$status = $this->status;
		$job = $this->m_job;
		$zero = $status->ZERO;
		$post = $this->input->post(NULL, TRUE);
		$rows = $job->callbackSearchKey($post)->num_rows();
		return $rows > $zero ? false : true;
	}	

	public function check_jobname()
	{
		$status = $this->status;
		$job = $this->m_job;
		$zero = $status->ZERO;
		$post = $this->input->post(NULL, TRUE);
		$rows = $job->callbackName($post)->num_rows();
		return $rows > $zero ? false : true;
	}	
}
