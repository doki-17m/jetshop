<?php

class M_transaction extends CI_Model
{
	private $_table = 'm_transaction';

	public function __construct()
	{
		parent::__construct();
	}

	public function insert($post)
	{
		$table = $post->table;
		$product_id = $post->id;
		$type = $post->movementtype;
		$qty = $post->qty_entered;
		$movementdate = $post->movementdate;

		$this->m_product_id = $product_id;
		$this->movementtype = $type;
		$this->movementdate = $movementdate;
		$this->movementqty = $qty;

		if ($table == 'trx_order') {
			$this->trx_orderline_id = $post->trx_orderline_id;
		}
		if ($table == 'trx_rma') {
			$this->trx_returnline_id = $post->trx_returnline_id;
		}
		if ($table == 'trx_inventory') {
			$this->trx_inventoryline_id = $post->trx_inventoryline_id;
		}

		$this->createdby = $this->session->userdata('user_id');
		$this->updatedby = $this->session->userdata('user_id');
		$this->m_locator_id = 1; //warehouse online
		return $this->db->insert($this->_table, $this);
	}
}
