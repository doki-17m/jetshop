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
	
	// Stock In Out
	public function getStock($startDate, $endDate)
	{
		$sql = "SELECT *,
		m_product.value as kode_product,
		m_product.name as brand_product,
		trx_inventory.documentno as nomor_mio,
		trx_order.documentno as nomor_invoice,
		m_transaction.movementdate as tanggal_pindah
		-- sum(trx_orderline.qtyordered) as qtyordered,
		-- sum(trx_inventoryline.qtyentered) as qtyentered,
		-- sum(m_transaction.movementqty) as stock_akhir
		FROM m_transaction
		LEFT JOIN trx_inventoryline on trx_inventoryline.trx_inventoryline_id = m_transaction.trx_inventoryline_id
		LEFT JOIN trx_inventory on trx_inventory.trx_inventory_id = trx_inventoryline.trx_inventory_id
		LEFT JOIN m_product on m_product.m_product_id = m_transaction.m_product_id
		LEFT JOIN trx_orderline on trx_orderline.trx_orderline_id = m_transaction.trx_orderline_id
		LEFT JOIN trx_order on trx_order.trx_order_id = trx_orderline.trx_order_id
		WHERE m_transaction.movementdate BETWEEN '$startDate' AND '$endDate'
		ORDER BY m_product.m_product_id ASC, m_transaction.updated_at ASC, trx_inventory.documentno";
		return $this->db->query($sql);
	}
}
