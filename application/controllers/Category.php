<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Category extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('m_category');
	}

	public function index()
	{
		$view = $this->views;
		$this->template->load($view->OVERVIEW, $view->VIEW_CATEGORY);
	}

	public function showAll()
	{
		$category = $this->m_category;
		$response = $category->setDataList();
		echo json_encode($response);
	}

	public function create()
	{
		$status = $this->status;
		$category = $this->m_category;
		$validation = $this->form_validation;
		$post = $this->input->post(NULL, TRUE);
		
		$validation->set_rules([
			[
				'field'		=>	'cat_sk',
				'label'		=>	'Search Key',
				'rules'		=>	'required|is_unique[m_product_category.value]',
				'errors'	=> 	[
					'is_unique'	=> 'This %s already exists.'
				]
			],
			[
				'field'		=>	'cat_name',
				'label'		=>	'Name',
				'rules'		=>	'required|is_unique[m_product_category.name]',
				'errors'	=> 	[
					'is_unique'	=> 'This %s already exists.'
				],
			]
		]);

		if ($validation->run()) {
			$category->insert($post);
			$response = $status->SUCCESS_INSERT;
		} else {
			$response = $category->form_error();
		}
		echo json_encode($response);
	}

	public function show($id)
	{
		$category = $this->m_category;
		$response = $category->detail($id)->row();
		echo json_encode($response);
	}

	public function edit($id)
	{
		$status = $this->status;
		$category = $this->m_category;
		$validation = $this->form_validation;
		$post = $this->input->post(NULL, TRUE);
		
		$validation->set_rules([
			[
				'field'		=>	'cat_sk',
				'label'		=>	'Search Key',
				'rules'		=>	'required|callback_check_catsk',
				'errors'	=> 	[
					'check_catsk'	=> 'This %s already exists.'
				]
			],
			[
				'field'		=>	'cat_name',
				'label'		=>	'Name',
				'rules'		=>	'required|callback_check_catname',
				'errors'	=> 	[
					'check_catname'	=> 'This %s already exists.'
				],
			]
		]);

		if ($validation->run()) {
			$category->update($id, $post);
			$response = $status->SUCCESS_UPDATE;
		} else {
			$response = $category->form_error();
		}
		echo json_encode($response);
	}

	public function destroy($id)
	{
		$category = $this->m_category;
		$response = $category->delete($id);
		echo json_encode($response);
	}

	public function showCategory()
	{
		$status = $this->status;
		$category = $this->m_category;
		$isActive = $status->ACTIVE;
		$response = $category->listCategory($isActive)->result();
		echo json_encode($response);
	}

	public function check_catsk()
	{
		$status = $this->status;
		$zero = $status->ZERO;
		$post = $this->input->post(NULL, TRUE);
		$category = $this->m_category;
		$rows = $category->callbackSearchKey($post)->num_rows();
		return $rows > $zero ? false : true;
	}	

	public function check_catname()
	{
		$status = $this->status;
		$zero = $status->ZERO;
		$post = $this->input->post(NULL, TRUE);
		$category = $this->m_category;
		$rows = $category->callbackName($post)->num_rows();
		return $rows > $zero ? false : true;
	}	
}
