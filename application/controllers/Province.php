<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Province extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('m_province');
	}

	public function index()
	{
		$view = $this->views;
		$this->template->load($view->OVERVIEW, $view->VIEW_PROVINCE);
	}

	public function showAll()
	{
		$province = $this->m_province;
		$response = $province->setDataList();
		echo json_encode($response);
	}

	public function create()
	{
		$api = $this->api;
		$province = $this->m_province;
		$arrProvince = $api->check_province();
		$response = $province->insert($arrProvince);
		echo json_encode($response);
	}

	public function show($id)
	{
		$province = $this->m_province;
		$response = $province->detail($id)->row();
		echo json_encode($response);
	}

	public function edit($id)
	{
		$status = $this->status;
		$province = $this->m_province;
		$post = $this->input->post(NULL, TRUE);
		$province->update($id, $post);
		$response = $status->SUCCESS_UPDATE;
		echo json_encode($response);
	}

	public function destroy($id)
	{
		$province = $this->m_province;
		$response = $province->delete($id);
		echo json_encode($response);
	}

	public function showProvince()
	{
		$status = $this->status;
		$province = $this->m_province;
		$isActive = $status->ACTIVE;
		$response = $province->listProvince($isActive)->result();
		echo json_encode($response);
	}
}
