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
			$response =
				[
					'success'		=> true,
					'message'		=> '<h5> Success!</h5> Your cart has been submit successfully!',
					'order_id'		=> $post['id']
				];
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

	// membuat fungsi untuk membuat 1 baris tabel, agar dapat dipanggil berkali-kali dgn mudah
	public function buatBaris4Kolom($kolom1, $kolom2, $kolom3, $kolom4, $escape = null)
	{
		// // Mengatur lebar setiap kolom (dalam satuan karakter)
		$lebar_kolom_1 = 13;
		$lebar_kolom_2 = 3;
		$lebar_kolom_3 = 12;
		$lebar_kolom_4 = 14;

		// Melakukan wordwrap(), jadi jika karakter teks melebihi lebar kolom, ditambahkan \n 
		$kolom1 = wordwrap($kolom1, $lebar_kolom_1, "\n", true);
		$kolom2 = wordwrap($kolom2, $lebar_kolom_2, "\n", true);
		$kolom3 = wordwrap($kolom3, $lebar_kolom_3, "\n", true);
		$kolom4 = wordwrap($kolom4, $lebar_kolom_4, "\n", true);

		// Merubah hasil wordwrap menjadi array, kolom yang memiliki 2 index array berarti memiliki 2 baris (kena wordwrap)
		$kolom1Array = explode("\n", $kolom1);
		$kolom2Array = explode("\n", $kolom2);
		$kolom3Array = explode("\n", $kolom3);
		$kolom4Array = explode("\n", $kolom4);

		// Mengambil jumlah baris terbanyak dari kolom-kolom untuk dijadikan titik akhir perulangan
		$jmlBarisTerbanyak = max(count($kolom1Array), count($kolom2Array), count($kolom3Array), count($kolom4Array));

		// Mendeklarasikan variabel untuk menampung kolom yang sudah di edit
		$hasilBaris = array();

		// Melakukan perulangan setiap baris (yang dibentuk wordwrap), untuk menggabungkan setiap kolom menjadi 1 baris 
		for ($i = 0; $i < $jmlBarisTerbanyak; $i++) {

			// memberikan spasi di setiap cell berdasarkan lebar kolom yang ditentukan, 
			$hasilKolom1 = str_pad((isset($kolom1Array[$i]) ? $kolom1Array[$i] : ""), $lebar_kolom_1, " ");
			$hasilKolom2 = str_pad((isset($kolom2Array[$i]) ? $kolom2Array[$i] : ""), $lebar_kolom_2, " ");

			// memberikan rata kanan pada kolom 3 dan 4 karena akan kita gunakan untuk harga dan total harga
			$hasilKolom3 = str_pad((isset($kolom3Array[$i]) ? $kolom3Array[$i] : ""), $lebar_kolom_3, " ", STR_PAD_LEFT);
			$hasilKolom4 = str_pad((isset($kolom4Array[$i]) ? $kolom4Array[$i] : ""), $lebar_kolom_4, " ", STR_PAD_LEFT);

			// Menggabungkan kolom tersebut menjadi 1 baris dan ditampung ke variabel hasil (ada 1 spasi disetiap kolom)
			$hasilBaris[] = $hasilKolom1 . " " . $hasilKolom2 . $hasilKolom3 . " " . $hasilKolom4;
		}

		// Hasil yang berupa array, disatukan kembali menjadi string dan tambahkan \n disetiap barisnya.
		if ($escape === "nl") {
			return implode("\n", $hasilBaris) . "\n";
		} else {
			return implode("\n", $hasilBaris);
		}
	}

	public function cetak()
	{
		$post = $this->input->post(NULL, TRUE);
		$data = $this->m_order->detail($post['id']);

		$row = $data->row();
		$baris4 = [];
		$subtotal = [];
		$sumTotal = 0;
		if ($data->num_rows() > 0) {
			foreach ($data->result() as $value) :
				$baris4[] = $this->buatBaris4Kolom(strtoupper($value->code), $value->qtyordered . "x", formatRupiah($value->unitprice), formatRupiah($value->lineamount), "nl");
				$sumTotal += $value->lineamount;
			endforeach;

			$subtotal[] = $this->buatBaris4Kolom('Sub Total', "", "Rp.", formatRupiah($sumTotal), "nl");
		}

		$result = [
			'date'			=> date('d M Y'),
			'time'			=> date("H:i"),
			'printed'		=> date("Y-m-d H:i"),
			'invoice'		=> $row->documentno,
			'cashier'		=> $row->cashier,
			'detail1'		=> $baris4,
			'subtotal'		=> $subtotal,
			'salesname'		=> ucwords($row->salesname),
			'bpartner'		=> ucwords($row->bpartner)
		];

		echo json_encode($result);
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
