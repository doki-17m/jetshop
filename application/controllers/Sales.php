<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Sales extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('m_order');
	}

	public function index()
	{
		$view = $this->views;
		$order = $this->m_order;
		$data['invoiceno'] = $order->show_invoiceno();
		$this->template->load($view->OVERVIEW, $view->VIEW_POS, $data);
	}

	public function create_cart()
	{
		$order = $this->m_order;
		$product_code = $_GET['code'];
		$product_qty = $_GET['qty'];
		$response = $order->insert_cart($product_code, $product_qty);
		echo json_encode($response);
	}

	public function edit_cart()
	{
		$order = $this->m_order;
		$cart_id = $_GET['id'];
		$product_qty = $_GET['qty'];
		$response = $order->update_cart($cart_id, $product_qty);
		echo json_encode($response);
	}

	public function destroy_allcart()
	{
		$order = $this->m_order;
		$response = $order->deleteall_cart();
		echo json_encode($response);
	}

	public function viewSo()
	{
		$view = $this->views;
		$this->template->load($view->OVERVIEW, $view->VIEW_ORDER);
	}

	public function showAll()
	{
		$order = $this->m_order;
		$response = $order->setDataList();
		echo json_encode($response);
	}

	public function create()
	{
		$order = $this->m_order;
		$validation = $this->form_validation;
		$post = $this->input->post(NULL, TRUE);

		if ($post['ismember'] === 'Y') {
			$validation->set_rules([
				[
					'field'		=>	'pos_cust_id',
					'label'		=>	'Customer',
					'rules'		=>	'required'
				]
			]);
		} else {
			$validation->set_rules([
				[
					'field'		=>	'pos_cust_name',
					'label'		=>	'Customer',
					'rules'		=>	'required'
				]
			]);
		}

		$validation->set_rules([
			[
				'field'		=>	'pos_phone',
				'label'		=>	'Phone',
				'rules'		=>	'required'
			],
			[
				'field'		=>	'pos_courier',
				'label'		=>	'Courier',
				'rules'		=>	'required'
			],
			[
				'field'		=>	'pos_city',
				'label'		=>	'Destination',
				'rules'		=>	'required'
			],
			[
				'field'		=>	'pos_address',
				'label'		=>	'Full Address',
				'rules'		=>	'required'
			],
			[
				'field'		=>	'pos_delivery',
				'label'		=>	'Delivery',
				'rules'		=>	'required'
			],
			[
				'field'		=>	'pos_payment',
				'label'		=>	'Payment Method',
				'rules'		=>	'required'
			]
		]);

		if ($post['pos_payment'] == 2) {
			$validation->set_rules([
				[
					'field'		=>	'pos_bankacc',
					'label'		=>	'Bank Account',
					'rules'		=>	'required'
				]
			]);
		}

		if ($validation->run()) {
			$last_id = $order->insert($post);
			$response = array('last_id' => $last_id);
		} else {
			$response = $order->form_error();
		}
		echo json_encode($response);
	}

	public function create_line()
	{
		$order = $this->m_order;
		$status = $this->status;
		$post = $this->input->post(NULL, TRUE);
		$result = $order->insert_line($post);
		if ($result) {
			$response = $status->SUCCESS_INSERT_CART;
		} else {
			$response = $result;
		}
		echo json_encode($response);
	}

	public function processDocaction()
	{
		$status = $this->status;
		$order = $this->m_order;
		$id = $_GET['id'];
		$docaction = $_GET['docaction'];
		$result = $order->processStatus($id, $docaction);
		if ($result) {
			$response = $status->SUCCESS_DOCACTION;
		} else {
			$response = $status->ERROR_LINE;
		}
		echo json_encode($response);
	}

	public function totalWeight()
	{
		$order = $this->m_order;
		$post = $this->input->post(NULL, TRUE);
		$response = $order->calculate_weight($post);
		echo json_encode($response);
	}

	public function cost()
	{
		$order = $this->m_order;
		$post = $this->input->post(NULL, TRUE);
		$response = $order->calculate_cost($post);
		echo json_encode($response);
	}

	public function checkQty()
	{
		$order = $this->m_order;
		$post = $this->input->post(NULL, TRUE);
		$response = $order->check_qty($post);
		echo json_encode($response);
	}

	public function getDocNo()
	{
		$order = $this->m_order;
		$order_id = $_GET['id'];
		$response = $order->detail($order_id)->row()->documentno;
		echo json_encode($response);
	}
}
