<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Sales extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('m_order');
		$this->load->model('m_user');
	}

	public function index()
	{
		$view = $this->views;
		$data['invoiceno'] = $this->m_order->show_invoiceno();
		$data['cashier'] = $this->m_user->detail($this->session->userdata('user_id'))->row();
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

		if ($post['isurgent'] === 'N') {
			$validation->set_rules([
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
				'field'		=>	'pos_payment',
				'label'		=>	'Payment Method',
				'rules'		=>	'required'
			],
			[
				'field'		=>	'pos_sales',
				'label'		=>	'Sales',
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
		$post = $this->input->post();
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

	public function cetak_struk()
	{
		// me-load library escpos
		$this->load->library('escpos');

		// membuat connector printer ke shared printer bernama "printer_a" (yang telah disetting sebelumnya)
		$connector = new Escpos\PrintConnectors\WindowsPrintConnector("printer_a");

		// membuat objek $printer agar dapat di lakukan fungsinya
		$printer = new Escpos\Printer($connector);


		/* ---------------------------------------------------------
         * Teks biasa | text()
         */
		$printer->initialize();
		$printer->text("Ini teks biasa \n");
		$printer->text("\n");

		/* ---------------------------------------------------------
         * Select print mode | selectPrintMode()
         */
		// Printer::MODE_FONT_A
		$printer->initialize();
		$printer->selectPrintMode(Escpos\Printer::MODE_FONT_A);
		$printer->text("teks dengan MODE_FONT_A \n");
		$printer->text("\n");

		// Printer::MODE_FONT_B
		$printer->initialize();
		$printer->selectPrintMode(Escpos\Printer::MODE_FONT_B);
		$printer->text("teks dengan MODE_FONT_B \n");
		$printer->text("\n");

		// Printer::MODE_EMPHASIZED
		$printer->initialize();
		$printer->selectPrintMode(Escpos\Printer::MODE_EMPHASIZED);
		$printer->text("teks dengan MODE_EMPHASIZED \n");
		$printer->text("\n");

		// Printer::MODE_DOUBLE_HEIGHT
		$printer->initialize();
		$printer->selectPrintMode(Escpos\Printer::MODE_DOUBLE_HEIGHT);
		$printer->text("teks dengan MODE_DOUBLE_HEIGHT \n");
		$printer->text("\n");

		// Printer::MODE_DOUBLE_WIDTH
		$printer->initialize();
		$printer->selectPrintMode(Escpos\Printer::MODE_DOUBLE_WIDTH);
		$printer->text("teks dengan MODE_DOUBLE_WIDTH \n");
		$printer->text("\n");

		// Printer::MODE_UNDERLINE
		$printer->initialize();
		$printer->selectPrintMode(Escpos\Printer::MODE_UNDERLINE);
		$printer->text("teks dengan MODE_UNDERLINE \n");
		$printer->text("\n");


		/* ---------------------------------------------------------
         * Teks dengan garis bawah  | setUnderline()
         */
		$printer->initialize();
		$printer->setUnderline(Escpos\Printer::UNDERLINE_DOUBLE);
		$printer->text("Ini teks dengan garis bawah \n");
		$printer->text("\n");

		/* ---------------------------------------------------------
         * Rata kiri, tengah, dan kanan (JUSTIFICATION) | setJustification()
         */
		// Teks rata kiri JUSTIFY_LEFT
		$printer->initialize();
		$printer->setJustification(Escpos\Printer::JUSTIFY_LEFT);
		$printer->text("Ini teks rata kiri \n");
		$printer->text("\n");

		// Teks rata tengah JUSTIFY_CENTER
		$printer->initialize();
		$printer->setJustification(Escpos\Printer::JUSTIFY_CENTER);
		$printer->text("Ini teks rata tengah \n");
		$printer->text("\n");

		// Teks rata kanan JUSTIFY_RIGHT
		$printer->initialize();
		$printer->setJustification(Escpos\Printer::JUSTIFY_RIGHT);
		$printer->text("Ini teks rata kanan \n");
		$printer->text("\n");


		/* ---------------------------------------------------------
         * Font A, B dan C | setFont()
         */
		// Teks dengan font A
		$printer->initialize();
		$printer->setFont(Escpos\Printer::FONT_A);
		$printer->text("Ini teks dengan font A \n");
		$printer->text("\n");

		// Teks dengan font B
		$printer->initialize();
		$printer->setFont(Escpos\Printer::FONT_B);
		$printer->text("Ini teks dengan font B \n");
		$printer->text("\n");

		// Teks dengan font C
		$printer->initialize();
		$printer->setFont(Escpos\Printer::FONT_C);
		$printer->text("Ini teks dengan font C \n");
		$printer->text("\n");

		/* ---------------------------------------------------------
         * Jarak perbaris 40 (linespace) | setLineSpacing()
         */
		$printer->initialize();
		$printer->setLineSpacing(40);
		$printer->text("Ini paragraf dengan \nline spacing sebesar 40 \ndi printer dotmatrix \n");
		$printer->text("\n");

		/* ---------------------------------------------------------
         * Jarak dari kiri (Margin Left) | setPrintLeftMargin()
         */
		$printer->initialize();
		$printer->setPrintLeftMargin(10);
		$printer->text("Ini teks berjarak 10 dari kiri (Margin left) \n");
		$printer->text("\n");

		/* ---------------------------------------------------------
         * membalik warna teks (background menjadi hitam) | setReverseColors()
         */
		$printer->initialize();
		$printer->setReverseColors(TRUE);
		$printer->text("Warna Teks ini terbalik \n");
		$printer->text("\n");


		/* ---------------------------------------------------------
         * Menyelesaikan printer
         */
		$printer->feed(4); // mencetak 2 baris kosong, agar kertas terangkat ke atas
		$printer->close();
	}
}
