<?php

class M_account extends CI_Model
{
	private $_table = 'm_account';

	public function __construct()
	{
		parent::__construct();
	}

	public function getAll()
	{
		return $this->db->get($this->_table);
	}

	public function setDataList()
	{
		$list = $this->getAll()->result();
		$data = array();
		$number = 0;
		foreach ($list as $value) {
			$row = array();
			$ID = $value->m_account_id;
			$number++;
			$row[] = $ID;
			$row[] = $number;
			$row[] = $value->bank;
			$row[] = $value->accountno;
			$row[] = $value->name;
			$row[] = $value->description;
			$row[] = isActive($value->isactive);
			$row[] = listAction($ID);
			$data[] = $row;
		}
		$result = array('data' => $data);
		return $result;
	}

	public function insert($post)
	{
		$this->bank = $post['acc_bank'];
		$this->accountno = $post['acc_accountno'];
		$this->name = $post['acc_name'];
		$this->description = $post['acc_desc'];
		$this->isactive = $post['isactive'];
		return $this->db->insert($this->_table, $this);
	}

	public function detail($id)
	{
		return $this->db->get_where($this->_table, array('m_account_id' => $id));
	}

	public function update($id, $post)
	{
		$this->bank = $post['acc_bank'];
		$this->accountno = $post['acc_accountno'];
		$this->name = $post['acc_name'];
		$this->description = $post['acc_desc'];
		$this->isactive = $post['isactive'];
		$where = array('m_account_id' => $id);
		return $this->db->where($where)
			->update($this->_table, $this);
	}

	public function delete($id)
	{
		return $this->db->delete($this->_table, array('m_account_id' => $id));
	}

	public function callbackAccountNo($post)
	{
		$this->db->select('accountno');
		$this->db->from($this->_table);
		$this->db->where(
				array(
					'accountno'			=> $post['acc_accountno'],
					'm_account_id !='	=> $post['id']
					)
				);
		return $this->db->get();
	}

	public function form_error()
	{
		return [
			'error'					=> true,
			'error_acc_bank'		=> form_error('acc_bank'),
			'error_acc_accountno'	=> form_error('acc_accountno'),
			'error_acc_name'		=> form_error('acc_name')
		];
	}
}
