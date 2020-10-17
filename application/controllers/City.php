<?php
defined('BASEPATH') or exit('No direct script access allowed');

class City extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('m_city');
	}

	public function index()
	{
		$view = $this->views;
		$this->template->load($view->OVERVIEW, $view->VIEW_CITY);
	}

	public function showAll()
	{
		$city = $this->m_city;
		$response = $city->setDataList();
		echo json_encode($response);
	}

	public function create()
	{
		$api = $this->api;
		$city = $this->m_city;
		$arrCity = $api->check_city(null);
		$response = $city->insert($arrCity);
		echo json_encode($response);
	}

	public function show($id)
	{
		$city = $this->m_city;
		$response = $city->detail($id)->row();
		echo json_encode($response);
	}

	public function edit($id)
	{
		$status = $this->status;
		$city = $this->m_city;
		$post = $this->input->post(NULL, TRUE);
		$city->update($id, $post);
		$response = $status->SUCCESS_UPDATE;
		echo json_encode($response);
	}

	public function destroy($id)
	{
		$city = $this->m_city;
		$response = $city->delete($id);
		echo json_encode($response);
	}

	public function showCity()
	{
		$status = $this->status;
		$city = $this->m_city;
		$isActive = $status->ACTIVE;
		$post = $this->input->post(NULL, TRUE);
		$response = $city->listCity($isActive, $post)->result();
		echo json_encode($response);
	}
}
