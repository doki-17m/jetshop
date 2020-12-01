<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Inventory extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('m_inventory');
	}

	public function create()
	{
		$table = 'trx_inventory';
		$status = $this->status;
		$inventory = $this->m_inventory;
		$validation = $this->form_validation;
		$post = $this->input->post(NULL, TRUE);

		$validation->set_rules([
			[
				'field'		=>	'qty_entered',
				'label'		=>	'Quantity',
				'rules'		=>	'required|callback_check_qtyentered',
			]
		]);

		if ($validation->run()) {
			$inventory->insert($table, $post);
			$response = $status->SUCCESS_INSERT;
		} else {
			$response = $inventory->form_error();
		}
		echo json_encode($response);
	}

	public function check_qtyentered()
	{
		$inventory = $this->m_inventory;
		$post = $this->input->post(NULL, TRUE);
		return $inventory->callbackQty($post);
	}
}
