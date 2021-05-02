<?php

class M_order extends CI_Model
{
	private $_table = 'trx_order';

	private $_tableline = 'trx_orderline';
	private $v_order_detail = 'v_order_detail';

	private $Docstatus_CO = 'CO';
	private $Docstatus_VO = 'VO';

	private $MovementIn = 'O+';
	private $MovementOut = 'O-';

	public function __construct()
	{
		parent::__construct();
		$this->load->model('m_product');
		$this->load->model('m_courier');
		$this->load->model('m_transaction');
	}

	public function show_invoiceno()
	{
		$firstCode = "INV"; //karakter depan kodenya
		$lastCode = ""; //kode awal
		$sql = $this->db->query("SELECT
							MAX(RIGHT(documentno,4)) AS maxcode
								FROM " . $this->_table . "
							WHERE LEFT(documentno,6	) = DATE_FORMAT(CURDATE(), '%y%m%d')");
		$sql->row();
		if ($sql->num_rows() > 0) {
			foreach ($sql->result() as $value) {
				$intCode = ((int)$value->maxcode) + 1;
				$lastCode = sprintf("%04s", $intCode);
			}
		} else {
			$lastCode = "0001";
		}
		return date('ymd') . $lastCode;
	}

	public function listData()
	{
		$this->db->select('*,
						count(trx_orderline_id) as total_line');
		$this->db->group_by('trx_order_id');
		$this->db->order_by('documentno', 'DESC');
		return $this->db->get($this->v_order_detail);
	}

	public function setDataList()
	{
		$status = $this->status;
		$list = $this->listData()->result();
		$data = array();
		$number = 0;
		foreach ($list as $value) {
			$row = array();
			$number++;
			$ID = $value->trx_order_id;
			$destination = $value->type . ' ' . $value->city;
			$row[] = $ID;
			$row[] = $number;
			$row[] = $value->documentno;
			$row[] = $value->bpartner;
			$row[] = date('d-m-Y', strtotime($value->dateordered));
			$row[] = $value->address;
			$row[] = $destination;
			$row[] = $value->courier;
			$row[] = $value->service;
			$row[] = $value->total_line;
			$row[] = formatRupiah($value->totalweight) . ' gram';
			$row[] = formatRupiah($value->grandtotal);
			$row[] = $value->cashier;
			$row[] = isMember($value->ismember);
			$row[] = docStatus($ID, $value->docstatus);
			$row[] = listAction($ID, $status->PRINT);
			$data[] = $row;
		}
		$result = array('data' => $data);
		return $result;
	}

	public function show_cart($arrData)
	{
		$status = $this->status;
		$content = $arrData['content'];
		$total = $arrData['total'];
		$data = array();
		$number = 0;
		foreach ($content as $items) {
			$row = array();
			$number++;
			$ID = $items['id'];
			$ROWID = $items['rowid'];
			$name = $items['name'];
			$qty = $items['qty'];
			$price = $items['price'];
			$subtotal = $items['subtotal'];

			$row[] = $ID;
			$row[] = $qty;
			$row[] = $number;
			$row[] = $name;
			$row[] = '<div class="input-group">' .
				'<div class="input-group-prepend">' .
				'<button type="button" class="btn btn-default btn-sm button-minus" id="button-minus" value="' . $ROWID . '"  title="Minus Quantity" data-button="quantity">' .
				'<span class="fas fa-minus"></span>' .
				'</button>' .
				'</div>' .
				'<input type="number" class="form-control quantity-field" id="' . $ROWID . '" name="quantity" step="1" max="" value="' . $qty . '">' .
				'<div class="input-group-append">' .
				'<button type="button" class="btn btn-default btn-sm button-plus" id="button-plus" value="' . $ROWID . '" title="Plus Quantity" data-button="quantity">' .
				'<span class="fas fa-plus"></span>' .
				'</button>' .
				'</div>' .
				'</div>';
			$row[] = formatRupiah($price);
			$row[] = formatRupiah($subtotal);
			$row[] = listAction($ROWID, $status->DELCART);
			$data[] = $row;
		}
		$result = array(
			'data' => $data,
			'total' => $total
		);
		return $result;
	}

	public function insert_cart($value, $qty)
	{
		$product = $this->m_product;
		$cart = $this->cart;
		$product_row = $product->detail(0, $value)->row();
		if (!empty($product_row)) {
			$id = $product_row->m_product_id;
			$sellprice = $product_row->salesprice;
			$name = $product_row->value;

			$arrData = array(
				'id'	=> $id,
				'qty'	=> $qty,
				'price'	=> replaceFormat($sellprice),
				'name'	=> $name,
			);

			$cart->product_name_rules = '[:print:]';
			$cart->insert($arrData);
			$arrCart = array(
				'content' => $cart->contents(),
				'total' => $cart->total()
			);
		} else {
			$arrCart = array(
				'content' => $cart->contents(),
				'total' => $cart->total()
			);
		}
		return $this->show_cart($arrCart);
	}

	public function update_cart($id, $qty)
	{
		$cart = $this->cart;
		$arrData = array(
			'rowid' => $id,
			'qty' => $qty,
		);
		$cart->update($arrData);
		$arrCart = array(
			'content' => $cart->contents(),
			'total' => $cart->total()
		);
		return $this->show_cart($arrCart);
	}

	public function deleteall_cart()
	{
		$cart = $this->cart;
		$cart->destroy();
		$arrCart = array(
			'content' => $cart->contents(),
			'total' => $cart->total()
		);
		return $this->show_cart($arrCart);
	}

	public function calculate_weight($arrData)
	{
		$product = $this->m_product;
		$list = $arrData['data'];
		$total = array();

		foreach ($list as $value) {
			$ID = $value[0];
			$qty = $value[1];
			$result = $product->getProductArrBy($ID)->result();
			foreach ($result as $row) {
				$weight = $row->weight;
				$total[] = ($weight * $qty);
			}
		}
		return array_sum($total);
	}

	public function calculate_cost($post)
	{
		$api = $this->api;
		$origin = $post['origin'];
		$destination = $post['destination'];
		$weight = $post['weight'];
		$courier = $post['courier'];
		$apiData = $api->check_cost($origin, $destination, $weight, $courier);
		$status = $apiData->rajaongkir->status;
		if ($status->description === 'OK') {
			return $apiData->rajaongkir->results[0]->costs;
		} else {
			return $status;
		}
	}

	public function insert($post)
	{
		$courier = $this->m_courier;

		if ($post['ismember'] === 'Y') {
			$this->m_bpartner_id = $post['pos_cust_id'];
		} else {
			$this->customer = $post['pos_cust_name'];
		}

		$this->cashier_id = $post['pos_cashier'];
		$this->documentno = $this->show_invoiceno();
		$this->docstatus = $this->Docstatus_CO;
		$this->dateordered = $post['pos_date'];
		$this->phone = $post['pos_phone'];
		$this->totalweight = $post['pos_total_weight'];

		if ($post['isurgent'] === 'N') {
			$delivery_service = $post['pos_delivery'];
			$length = strpos($post['pos_delivery'], "/");
			$this->address = $post['pos_address'];
			$this->m_city_id = $post['pos_city'];
			$service = substr($delivery_service, 0, $length);
			$this->service = $service;
		}

		if ($post['pos_courier'] !== '') {
			$row = $courier->getByValue($post['pos_courier'])->row();
			$this->m_courier_id = $row->m_courier_id;
		}

		$this->order_note = $post['pos_note'];
		$this->orderreference = $post['pos_job_market'];
		$this->ismember = $post['ismember'];
		$this->paymentmethod = $post['pos_payment'];
		$this->m_account_id = $post['pos_bankacc'];
		$this->createdby = $this->session->userdata('user_id');
		$this->updatedby = $this->session->userdata('user_id');
		$this->salesrep_id = $post['pos_sales'];

		$this->db->insert($this->_table, $this);
		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	public function insert_line($post)
	{
		$transaction = $this->m_transaction;
		$product = $this->m_product;
		$last_id = $post['id'];
		$data = $post['data'];

		$num_rows = $this->update_byline($data, $last_id);

		if ($num_rows > 0) {
			foreach ($data as $row) {
				$product_id = $row['product_id'];
				$qty = $row['qty'];
				$amount = $row['amount'];

				$list = $product->getProductArrBy($product_id)->result();
				foreach ($list as $value) {
					$pricelist = $value->salesprice;
					$purchprice = $value->purchprice;
					$isobral = $value->isobral;

					$unitprice = ($amount / $qty);
					$listOrderLine = array(
						'trx_order_id'		=> $last_id,
						'm_product_id' 		=> $product_id,
						'qtyordered'		=> $qty,
						'qtyreturn'			=> $qty,
						'unitprice'			=> $unitprice,
						'pricelist'			=> $pricelist, //harga jual
						'lineamount'		=> $amount,
						'costprice'			=> $purchprice, //harga beli
						'isobral'			=> $isobral,
						'createdby'			=> $this->session->userdata('user_id'),
						'updatedby'			=> $this->session->userdata('user_id')
					);
					$this->db->insert($this->_tableline, $listOrderLine);
					$lastline_id = $this->db->insert_id();

					$post_line = (object) [
						'trx_orderline_id'		=> $lastline_id,
						'movementdate'			=> date('Y-m-d'),
						'qty_entered'			=> - ($qty),
						'movementtype'			=> $this->MovementOut,
						'id'					=> $product_id,
						'table'					=> $this->_table
					];
					$result = $transaction->insert($post_line);
				}
			}
			return $result;
		}
		return false;
	}

	public function update_byline($data, $last_id)
	{
		foreach ($data as $row) {
			$ongkir = $row['ongkir'];
			$grandtotal = $row['grandtotal'];

			$listOrder = array(
				'deliveryfee' 	=> $ongkir,
				'grandtotal'	=> $grandtotal
			);

			$where_id = array('trx_order_id' => $last_id);
			$this->db->where($where_id)
				->update($this->_table, $listOrder);

			$num_rows = $this->db->affected_rows();
			return $num_rows;
		}
	}

	public function detail($id)
	{
		return $this->db->get_where($this->v_order_detail, array('trx_order_id' => $id));
	}

	public function processStatus($id, $action)
	{
		$this->docstatus = $action;
		$where = array('trx_order_id' => $id);
		return $this->db->where($where)
			->update($this->_table, $this);
	}

	public function getInsentif($salesrep, $obral, $date)
	{
		$this->db->select('COALESCE(count(trx_orderline_id), 0) AS item_product');
		$this->db->where([
			'salesrep_id'	=> $salesrep,
			'isobral' 		=> $obral,
			'dateordered'	=> $date
		]);
		$this->db->group_by('dateordered');
		$this->db->order_by('dateordered', 'ASC');
		return $this->db->get($this->v_order_detail);
	}

	// Keuntungan
	public function getKeuntungan($startDate, $endDate)
	{
		$sql = "SELECT *,
		((unitprice * qtyordered)- (costprice * qtyordered)) as keuntungan,
		sys_user.name as nama_sales,
		right(accountno,3) as accountbank
		FROM v_order_detail
		LEFT JOIN sys_user on sys_user.sys_user_id = v_order_detail.salesrep_id
		WHERE dateordered BETWEEN '$startDate' AND '$endDate'
		ORDER BY dateordered ASC";
		return $this->db->query($sql);
	}

	public function check_qty($post)
	{
		$product = $this->m_product;
		$data = $post['data'];

		$listProduct = array();
		foreach ($data as $row) {
			$product_id = $row['product_id'];
			$qtyordered = $row['qty'];
			$list = $product->getProductArrBy($product_id)->result();
			foreach ($list as $value) {
				$product_name = $value->name;
				$qty = $value->qty;

				if ($qty == 0) {
					$listProduct[] = array('zero' => $product_name . ' quantity cannot available: ' . $qty);
				} else if ($qtyordered > $qty) {
					$listProduct[] = array('more' => $product_name . ' quantity greather than: ' . $qty);
				}
			}
		}
		return $listProduct;
	}

	public function todayOmzet()
	{
		$this->db->select('SUM(grandtotal) AS total_omzet');
		$this->db->from($this->_table)
			->where('docstatus', 'CO')
			->where('DATE(dateordered)', 'CURDATE()', false);
		return $this->db->get();
	}

	public function todayTransaction()
	{
		$this->db->from($this->_table)
			->where('docstatus', 'CO')
			->where('DATE(dateordered)', 'CURDATE()', false);
		return $this->db->get();
	}

	public function form_error()
	{
		return [
			'error'					=> true,
			'error_pos_cust_id'		=> form_error('pos_cust_id'),
			'error_pos_cust_name'	=> form_error('pos_cust_name'),
			'error_pos_phone'		=> form_error('pos_phone'),
			'error_pos_courier'		=> form_error('pos_courier'),
			'error_pos_city'		=> form_error('pos_city'),
			'error_pos_faddress'	=> form_error('pos_address'),
			'error_pos_delivery'	=> form_error('pos_delivery'),
			'error_pos_payment'		=> form_error('pos_payment'),
			'error_pos_bankacc'		=> form_error('pos_bankacc')
		];
	}
}
