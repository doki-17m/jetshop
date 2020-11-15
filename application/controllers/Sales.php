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
		// $order = $this->m_order;
		// $code = 'AA03';
		// // $post = $this->input->post(NULL, TRUE);
		// $response = $order->insert_cart($code);
		// // $response = array('data' => $code);

		// echo json_encode($response);
	}

	// public function create_cart()
	// {
	// 	$order = $this->m_order;
	// 	$post = $this->input->post(NULL, TRUE);
	// 	$response = $order->insert_cart($post);
	// 	echo json_encode($response);
	// }
	public function create_cart()
	{
		$order = $this->m_order;
		$product_code = $_GET['code'];
		$product_qty = $_GET['qty'];
		$response = $order->insert_cart($product_code, $product_qty);
		echo json_encode($response);
	}

	// public function update_cart()
	// {
	// 	$post = $this->input->post(NULL, TRUE);
	// 	$data = array(
	// 		'rowid' => $post['id'],
	// 		'qty' => $post['qty'],
	// 	);
	// 	$this->cart->update($data);
	// 	$response = array(
	// 		'content' => $this->cart->contents(),
	// 		'total' => $this->cart->total()
	// 	);
	// 	echo json_encode($response);
	// }

	public function edit_cart()
	{
		$order = $this->m_order;
		$cart_id = $_GET['id'];
		$product_qty = $_GET['qty'];
		$response = $order->update_cart($cart_id, $product_qty);
		echo json_encode($response);
	}

	// public function destroy_cart($id)
	// {
	// 	$data = array(
	// 		'rowid' => $id,
	// 		'qty' => 0,
	// 	);
	// 	$this->cart->update($data);
	// 	$response = array(
	// 		'content' => $this->cart->contents(),
	// 		'total' => $this->cart->total()
	// 	);
	// 	echo json_encode($response);
	// }

	public function destroy_allcart()
	{
		$order = $this->m_order;
		$response = $order->deleteall_cart();
		echo json_encode($response);
	}

	public function listCart()
	{
		$order = $this->m_order;
		$post = $this->input->post(NULL, TRUE);
		$response = $order->detail_cart($post);
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

	public function check_cart()
	{
		$response = array(
			'content' => $this->cart->contents(),
			'total' => $this->cart->total()
		);
		echo json_encode($response);
	}

	public function show($id)
	{
		$response = $this->modor->detail($id)->row();
		echo json_encode($response);
	}

	public function edit($id)
	{
		$post = $this->input->post(NULL, TRUE);
		$response = $this->modor->update($id, $post);
		echo json_encode($response);
	}
}
