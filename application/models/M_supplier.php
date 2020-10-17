<?php

class M_supplier extends CI_Model
{
	private $_table = 'm_bpartner';

	public function getAll($string)
	{
		return $this->db->get_where($this->_table, array('isvendor' => $string));
	}

	public function setDataList($supplier)
	{
		$list = $this->getAll($supplier)->result();
		$data = array();
		$number = 0;
		foreach ($list as $value) {
			$row = array();
			$ID = $value->m_bpartner_id;
			$number++;
			$row[] = $ID;
			$row[] = $number;
			$row[] = $value->value;
			$row[] = $value->name;
			$row[] = $value->address;
			$row[] = $value->phone;
			$row[] = $value->phone2;
			$row[] = $value->email;
			$row[] = isActive($value->isactive);
			$row[] = listAction($ID);
			$data[] = $row;
		}
		$result = array('data' => $data);
		return $result;
	}

	public function insert($post, $suppplier)
	{	
		$this->value = $post['sup_code'];
		$this->name = $post['sup_name'];
		$this->description = $post['sup_desc'];
		$this->address = $post['sup_address'];
		$this->phone = $post['sup_phone'];
		$this->phone2 = $post['sup_phone2'];
		$this->email = $post['sup_email'];
		$this->m_greeting_id = $post['sup_greeting'];
		$this->isvendor = $suppplier;
		$this->isactive = $post['isactive'];
		return $this->db->insert($this->_table, $this);
	}

	public function detail($id)
	{
		return $this->db->get_where($this->_table, array('m_bpartner_id' => $id));
	}

	public function update($id, $post)
	{
		$this->value = $post['sup_code'];
		$this->name = $post['sup_name'];
		$this->description = $post['sup_desc'];
		$this->address = $post['sup_address'];
		$this->phone = $post['sup_phone'];
		$this->phone2 = $post['sup_phone2'];
		$this->email = $post['sup_email'];
		$this->m_greeting_id = $post['sup_greeting'];
		$this->isactive = $post['isactive'];
		$where = array('m_bpartner_id' => $id);
		return $this->db->where($where)
			->update($this->_table, $this);
	}

	public function delete($id)
	{
		return $this->db->delete($this->_table, array('m_bpartner_id' => $id));
	}

	public function callbackSupCode($post, $supplier)
	{
		$this->db->select('value');
		$this->db->from($this->_table);
		$this->db->where('value', $post['sup_code'])
			->where('isvendor', $supplier);
		if (!empty($post['id'])) {
			$this->db->where('m_bpartner_id <>', $post['id']);
		}
		return $this->db->get();
	}

	public function callbackSupName($post, $supplier)
	{
		$this->db->select('name');
		$this->db->from($this->_table);
		$this->db->where('name', $post['sup_name'])
			->where('isvendor', $supplier);
		if (!empty($post['id'])) {
			$this->db->where('m_bpartner_id <>', $post['id']);
		}
		return $this->db->get();
	}

	public function callbackSupEmail($post, $supplier)
	{
		$email = $post['sup_email'];
		$this->db->select('email');
		$this->db->from($this->_table);
		$this->db->where('isvendor', $supplier);
		if ($email != '') {
			$this->db->where('email', $email);
		} else {
			$this->db->where('email IS NULL');
		}

		if (!empty($post['id'])) {
			$this->db->where('m_bpartner_id <>', $post['id']);
		}
		return $this->db->get();
	}

	public function form_error()
	{
		return [
			'error'					=> true,
			'error_sup_code'		=> form_error('sup_code'),
			'error_sup_name'		=> form_error('sup_name'),
			'error_sup_email'		=> form_error('sup_email'),
			'error_sup_address'		=> form_error('sup_address'),
			'error_sup_phone'		=> form_error('sup_phone')
		];
	}
}
