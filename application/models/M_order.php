<?php

class M_order extends CI_Model
{
	private $_table = 'trx_order';

	public function __construct()
	{
		parent::__construct();
		$this->load->model('m_product');
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
		return $this->db->get($this->_table);
	}

	public function setData()
	{
		$list = $this->listData()->result();
		$data = array();
		$number = 0;
		foreach ($list as $value) {
			$row = array();
			// $number++;
			// $row[] = $value->m_product_id;
			// $row[] = $number;
			// $row[] = $value->value;
			// $row[] = $value->name;
			// if ($value->m_product_category_id == 1) {
			// 	$row[] = 'Baju';
			// } else if ($value->m_product_category_id == 2) {
			// 	$row[] = 'Lain-Lain';
			// }
			// if ($value->unitmeasure == 'pcs') {
			// 	$row[] = 'Pcs';
			// } else if ($value->unitmeasure == 'pk') {
			// 	$row[] = 'Pack';
			// } else {
			// 	$row[] = 'Each';
			// }
			// $row[] = $value->qtyonhand;
			// $row[] = $value->costprice;
			// $row[] = $value->sellprice;
			// if ($value->isactive == 'Y') {
			// 	$row[] = '<span class="badge badge-success">Active</span>';
			// } else {
			// 	$row[] = '<span class="badge badge-danger">Non-active</span>';
			// }
			// $row[] = '<center>
			//             <a class="btn" onclick="delete_data(' . "'" . $value->m_product_id . "'" . ')" title="Delete"><i class="fas fa-trash-alt text-danger"></i></a>
			//         </center>';
			$data[] = $row;
		}
		$result = array('data' => $data);
		return $result;
	}

	public function insert($post)
	{
		$this->value = $post['pro_code'];
		$this->name = $post['pro_name'];
		$this->description = $post['pro_desc'];
		$this->m_product_category_id = $post['pro_catg'];
		$this->unitmeasure = $post['pro_uom'];
		$this->sellprice = $post['pro_slsidr'];
		$this->costprice = $post['pro_purchidr'];
		$this->qtyonhand = $post['pro_qty'];
		$this->isactive = $post['isactive'];
		$result = $this->db->insert($this->_table, $this);
		return $result;
	}

	// public function insert_cart($post)
	// {
	// 	$product = $this->m_product;
	// 	$code = $post['product_code'];

	// 	// return $product->detail(0, $code)->row();
	// 	// return $product->detail(0, $code);
	// 	$product_row = $product->detail(0, $code)->row();
	// 	$id = $product_row->m_product_id;
	// 	$qty = $post['product_qty'];
	// 	$sellprice = $product_row->sellprice;
	// 	$name = $product_row->name;

	// 	$arrData = array(
	// 		'id'	=> $id,
	// 		'qty'	=> $qty,
	// 		'price'	=> replaceFormat($sellprice),
	// 		'name'	=> $name,
	// 	);
	// 	$this->cart->insert($arrData);
	// 	return array(
	// 		'content' => $this->cart->contents(),
	// 		'total' => $this->cart->total()
	// 	);
	// }

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
		$id = $product_row->m_product_id;
		$sellprice = $product_row->sellprice;
		$name = $product_row->name;

		$arrData = array(
			'id'	=> $id,
			'qty'	=> $qty,
			'price'	=> replaceFormat($sellprice),
			'name'	=> $name,
		);
		$cart->insert($arrData);
		$arrCart = array(
			'content' => $cart->contents(),
			'total' => $cart->total()
		);
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

	public function detail_cart($arrData)
	{
		$product = $this->m_product;
		$list = $arrData['data'];
		$total = array();

		foreach ($list as $value) {
			$ID = $value[0];
			$qty = $value[1];
			$name = $value[3];
			$price = $value[5];
			$subtotal = $value[6];
			return $product->getProductArrBy($ID)->result();
		}
		// return array_sum($total);
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
		return $apiData->rajaongkir->results[0]->costs;
	}

	public function detail($id, $value)
	{
		if (count($id) > 1) {
			return 'array';
		}
		// $result = $this->db->get_where($this->_table, array('m_product_id' => $id));
		// return $result;
		return false;
		// if (!empty($id)) {
		// 	$this->db->where('m_product_id', $id);
		// }
		// if (!empty($value)) {
		// 	$this->db->like('value', $value, 'after');
		// }
		// return $this->db->get($this->_table);
	}

	public function update($id, $post)
	{
		$this->value = $post['pro_code'];
		$this->name = $post['pro_name'];
		$this->description = $post['pro_desc'];
		$this->m_product_category_id = $post['pro_catg'];
		$this->unitmeasure = $post['pro_uom'];
		$this->sellprice = $post['pro_slsidr'];
		$this->costprice = $post['pro_purchidr'];
		$this->qtyonhand = $post['pro_qty'];
		$this->isactive = $post['isactive'];
		$where = array('m_product_id' => $id);
		$result = $this->db->where($where)
			->update($this->_table, $this);
		return $result;
	}

	public function delete($id)
	{
		$result = $this->db->delete($this->_table, array('m_product_id' => $id));
		return $result;
	}
}
