<?php

use phpDocumentor\Reflection\Types\Null_;

class M_inventory extends CI_Model
{
	private $_table = 'trx_inventory';

	private $_tableline = 'trx_inventoryline';

	private $Docstatus_DR = 'DR';
	private $Docstatus_CO = 'CO';
	private $Docstatus_VO = 'VO';

	private $MovementIn = 'I+';
	private $MovementOut = 'I-';

	public function __construct()
	{
		parent::__construct();
		$this->load->model('m_product');
		$this->load->model('m_transaction');
	}

	public function show_invoiceno()
	{
		$firstCode = "MIO"; //material In Out
		$lastCode = "";
		$sql = $this->db->query("SELECT
							MAX(RIGHT(documentno,4)) AS maxcode
								FROM " . $this->_table . "
							WHERE SUBSTRING(documentno,4,6) = DATE_FORMAT(CURDATE(), '%y%m%d')");
		$sql->row();
		if ($sql->num_rows() > 0) {
			foreach ($sql->result() as $value) :
				$intCode = ((int)$value->maxcode) + 1;
				$lastCode = sprintf("%04s", $intCode);
			endforeach;
		} else {
			$lastCode = "0001";
		}
		return $firstCode . date('ymd') . $lastCode;
	}

	public function insert($table, $post)
	{
		$this->documentno = $this->show_invoiceno();
		$this->docstatus = $this->Docstatus_CO;
		$this->movementdate = date('Y-m-d');
		$this->db->insert($this->_table, $this);
		$last_id = $this->db->insert_id();

		$post_invent = (object) [
			'trx_inventory_id'	=> $last_id,
			'table'				=> $table
		];

		$post_merge = (object) array_merge(
			(array) $post,
			(array) $post_invent
		);
		return $this->insert_line($post_merge);
	}

	public function insert_line($post)
	{
		$transaction = $this->m_transaction;
		$product = $this->m_product;

		$table = $post->table;
		$inventory_id = $post->trx_inventory_id;
		$product_id = $post->id;
		$qty_entered = $post->qty_entered;
		$stockIn = $post->qtyIn;

		if ($table == 'trx_inventory') {
			$stockOut = $post->qtyOut;

			if ($stockIn == 'Y') {
				$qty = $qty_entered;
				$post->qty_entered = $qty;
				$post_type = (object) ['movementtype' => $this->MovementIn];
			} else if ($stockOut == 'Y') {
				$qty = - ($qty_entered);
				$post->qty_entered = $qty;
				$post_type = (object) ['movementtype' => $this->MovementOut];
			}
			$row = $product->detail($product_id, null)->row();
			$pricelist = $row->salesprice;
		} else {
			$qty = $qty_entered;
			$pricelist = $post->pro_slsidr;
			$post_type = (object) ['movementtype' => $this->MovementIn];
			$post->table = $this->_table;
		}

		$dataLine = [
			'trx_inventory_id' 	=> $inventory_id,
			'qtyentered' 		=> $qty,
			'pricelist' 		=> replaceFormat($pricelist)
		];

		$insert = $this->db->insert($this->_tableline, $dataLine);

		if ($insert) {
			$lastline_id = $this->db->insert_id();

			//set array object
			$post_line = (object) [
				'trx_inventoryline_id'	=> $lastline_id,
				'movementdate'			=> date('Y-m-d')
			];

			//update table inventory
			$data = [
				'amount'	=> replaceFormat($pricelist)
			];

			$where = ['trx_inventory_id' => $inventory_id];
			$this->db->where($where)->update($this->_table, $data);

			//merge object array
			$post_merge = (object) array_merge(
				(array) $post,
				(array) $post_type,
				(array) $post_line
			);
			//insert into transaction
			return $transaction->insert($post_merge);
		} else {
			return false;
		}
	}

	public function callbackQty($post)
	{
		$validation = $this->form_validation;
		$product = $this->m_product;

		$product_id = $post['id'];
		$qtyEntered = $post['qty_entered'];
		$stockIn = $post['qtyIn'];
		$stockOut = $post['qtyOut'];

		$row = $product->detail($product_id, null)->row();
		$qtyAvailable = $row->qty;

		if ($qtyEntered !== '') {
			if ($qtyEntered < 1) {
				$validation->set_message('check_qtyentered', 'The %s cannot be zero');
				return false;
			} else if ($qtyEntered > $qtyAvailable && $stockOut == 'Y') {
				$validation->set_message('check_qtyentered', 'The %s greater than Quantity Available: ' . $qtyAvailable);
				return false;
			} else {
				return true;
			}
		}
	}

	public function form_error()
	{
		return [
			'error'					=> true,
			'error_qty_entered'		=> form_error('qty_entered')
		];
	}
}
