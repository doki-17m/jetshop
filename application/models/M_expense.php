<?php

class M_expense extends CI_Model
{
	private $_table = 'trx_expense';

	private $_tableLine = 'trx_expenseline';

	private $Docstatus_DR = 'DR';
	private $Docstatus_CO = 'CO';
	private $Docstatus_VO = 'VO';

	public function __construct()
	{
		parent::__construct();
	}

	public function show_docno()
	{
		$firstCode = "EXP"; //karakter depan kodenya
		$lastCode = ""; //kode awal
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
			$lastCode = "0002";
		}
		return $firstCode . date('ymd') . $lastCode;
	}

	public function getAll($id)
	{
		if (empty($id)) {
			$sql = "SELECT
			e.*,
			COUNT(el.trx_expenseline_id) AS count_line
			FROM " . $this->_table . " e
			LEFT JOIN " . $this->_tableLine . " el ON e.trx_expense_id = el.trx_expense_id
			GROUP BY e.trx_expense_id";
			return $this->db->query($sql);
		} else {
			$sql = "SELECT
			e.*,
			COUNT(el.trx_expenseline_id) AS count_line
			FROM " . $this->_table . " e
			LEFT JOIN " . $this->_tableLine . " el ON e.trx_expense_id = el.trx_expense_id
			WHERE e.trx_expense_id = ?
			GROUP BY e.trx_expense_id";
			return $this->db->query($sql, array($id));
		}
	}

	public function setDataList()
	{
		$list = $this->getAll(null)->result();
		$data = array();
		$number = 0;
		foreach ($list as $value) :
			$row = array();
			$ID = $value->trx_expense_id;
			$number++;
			$row[] = $ID;
			$row[] = $number;
			$row[] = $value->documentno;
			$row[] = date('d-m-Y', strtotime($value->datereport));
			$row[] = $value->description;
			$row[] = $value->count_line;
			$row[] = formatRupiah($value->grandtotal);
			$row[] = docStatus($ID, $value->docstatus);
			$data[] = $row;
		endforeach;
		$result = array('data' => $data);
		return $result;
	}

	public function insert($post)
	{
		$this->documentno = $post['exp_documentno'];
		$this->datereport = $post['exp_date'];
		$this->description = $post['exp_desc'];
		$this->docstatus = $this->Docstatus_DR;
		$this->paymentmethod = $post['exp_payment'];
		if (!empty($post['exp_bankacc'])) {
			$this->m_account_id = $post['exp_bankacc'];
		} else {
			$this->m_account_id = NULL;
		}
		$this->db->insert($this->_table, $this);
		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	public function insert_line($id, $data)
	{
		if (!empty($id)) {
			$expense_id = $id;
			$list = $data;
		} else {
			$expense_id = $data['id'];
			$list = $data['data'];
		}
		$arrTotal = [];
		foreach ($list as $row) :
			$description = $row['desc'];
			$qty = $row['qty'];
			$price = replaceFormat($row['price']);
			$arrTotal[] = $price;

			$expLine = array(
				'trx_expense_id'	=> $expense_id,
				'description'		=> $description,
				'qtyentered'		=> $qty,
				'pricelist'			=> $price
			);
			$result = $this->db->insert($this->_tableLine, $expLine);
		endforeach;

		if (!empty($id)) {
			return $result;
		} else {
			$sumTotal = array_sum($arrTotal);
			if ($result) {
				$this->grandtotal = $sumTotal;
				$where = array('trx_expense_id' => $expense_id);
				return $this->db->where($where)
					->update($this->_table, $this);
			} else {
				return false;
			}
		}
	}

	public function detail($id)
	{
		$sql = "SELECT e.trx_expense_id,
			e.created_at,
			e.createdby,
			e.updated_at,
			e.updatedby,
			e.documentno,
			e.docstatus,
			e.datereport,
			e.description as note,
			e.paymentmethod,
			e.m_account_id,
			e.grandtotal,
			el.trx_expenseline_id,
			el.description as detail,
			el.qtyentered,
			el.pricelist
			FROM " . $this->_table . " e
			LEFT JOIN " . $this->_tableLine . " el ON e.trx_expense_id = el.trx_expense_id
			WHERE e.trx_expense_id = ?";
		return $this->db->query($sql, array($id));
	}

	public function update($id, $post)
	{
		$this->datereport = $post['exp_date'];
		$this->description = $post['exp_desc'];
		$this->paymentmethod = $post['exp_payment'];
		if (!empty($post['exp_bankacc'])) {
			$this->m_account_id = $post['exp_bankacc'];
		} else {
			$this->m_account_id = NULL;
		}
		$where = array('trx_expense_id' => $id);
		$response = $this->db->where($where)
			->update($this->_table, $this);

		return $response ? $id : false;
	}

	public function update_line($data)
	{
		$expense_id = $data['id'];
		$list = $data['data'];

		$arrInsert = [];
		$arrTotal = [];

		foreach ($list as $row) :
			$line_id = $row['id'];
			$description = $row['desc'];
			$qty = $row['qty'];
			$price = replaceFormat($row['price']);
			$arrTotal[] = $price;

			if ($line_id == 'null' || $line_id == '') {
				$arrInsert[] = $row;
			}

			if (!empty($line_id)) {
				$expLine = array(
					'description'		=> $description,
					'qtyentered'		=> $qty,
					'pricelist'			=> $price
				);
				$where = array('trx_expenseline_id' => $line_id);
				$this->db->where($where)->update($this->_tableLine, $expLine);
			}
		endforeach;

		if (count($arrInsert) > 0) {
			$this->insert_line($expense_id, $arrInsert);
		}

		$sumTotal = array_sum($arrTotal);

		$this->grandtotal = $sumTotal;
		$this->updated_at = date('Y-m-d H:i:s');
		$where = array('trx_expense_id' => $expense_id);
		$update = $this->db->where($where)
			->update($this->_table, $this);
		if ($update) {
			return true;
		} else {
			return false;
		}
	}

	public function delete_line($id)
	{
		return $this->db->delete($this->_tableLine, array('trx_expenseline_id' => $id));
	}

	public function processStatus($id, $action)
	{
		$row = $this->getAll($id)->row();
		$line = $row->count_line;

		if ($action === $this->Docstatus_VO) {
			$this->docstatus = $action;
			$where = array('trx_expense_id' => $id);
			return $this->db->where($where)
				->update($this->_table, $this);
			return $this->Docstatus_VO;
		} else {
			if ($line > 0) {
				$this->docstatus = $action;
				$where = array('trx_expense_id' => $id);
				return $this->db->where($where)
					->update($this->_table, $this);
			} else {
				return false;
			}
		}
	}

	public function form_error()
	{
		return [
			'error'				=> true,
			'error_exp_date'	=> form_error('exp_date'),
			'error_exp_payment'	=> form_error('exp_payment'),
			'error_exp_bankacc'	=> form_error('exp_bankacc')
		];
	}
}
