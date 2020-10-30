<?php

class M_customer extends CI_Model
{
	private $_table = 'm_bpartner';
	
	public function getAll($string)
	{
		return $this->db->get_where($this->_table, array('iscustomer' => $string));
	}

	public function setDataList($customer)
	{
		$status = $this->status;
		$list = $this->getAll($customer)->result();
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
			$row[] = listAction($ID, $status->DELETE);
			$data[] = $row;
		}
		$result = array('data' => $data);
		return $result;
	}

	public function insert($post, $isCustomer)
	{	
		$this->value = $post['cus_code'];
		$this->name = $post['cus_name'];
		$this->description = $post['cus_desc'];
		$this->address = $post['cus_address'];
		$this->phone = $post['cus_phone'];
		$this->phone2 = $post['cus_phone2'];
		$this->email = $post['cus_email'];
		$this->m_greeting_id = $post['cus_greeting'];
		$this->province_id = $post['cus_province'];
		$this->city_id = $post['cus_city'];
		$this->salesrep_id = $post['cus_sales'];
		$this->iscustomer = $isCustomer;
		$this->isactive = $post['isactive'];
		return $this->db->insert($this->_table, $this);
	}

	public function detail($id)
	{
		return $this->db->get_where($this->_table, array('m_bpartner_id' => $id));
	}

	public function update($id, $post)
	{
		$this->value = $post['cus_code'];
		$this->name = $post['cus_name'];
		$this->description = $post['cus_desc'];
		$this->address = $post['cus_address'];
		$this->phone = $post['cus_phone'];
		$this->phone2 = $post['cus_phone2'];
		$this->email = $post['cus_email'];
		if ($post['cus_greeting'] !== 'undefined') {
			$this->m_greeting_id = $post['cus_greeting'];
		}
		if ($post['cus_province'] !== 'undefined') {
			$this->province_id = $post['cus_province'];
		}
		if ($post['cus_city'] !== 'undefined') {
			$this->city_id = $post['cus_city'];
		}
		if ($post['cus_sales'] !== 'undefined') {
			$this->salesrep_id = $post['cus_sales'];
		}
		$this->isactive = $post['isactive'];
		$where = array('m_bpartner_id' => $id);
		return $this->db->where($where)
			->update($this->_table, $this);
	}

	public function delete($id)
	{
		return $this->db->delete($this->_table, array('m_bpartner_id' => $id));
	}

	public function callbackCusCode($post, $customer)
	{
		$this->db->select('value');
		$this->db->from($this->_table);
		$this->db->where('value', $post['cus_code'])
			->where('iscustomer', $customer);
		if (!empty($post['id'])) {
			$this->db->where('m_bpartner_id <>', $post['id']);
		}
		return $this->db->get();
	}

	public function callbackCusName($post, $customer)
	{
		$this->db->select('name');
		$this->db->from($this->_table);
		$this->db->where('name', $post['cus_name'])
			->where('iscustomer', $customer);
		if (!empty($post['id'])) {
			$this->db->where('m_bpartner_id <>', $post['id']);
		}
		return $this->db->get();
	}

	public function callbackCusEmail($post, $customer)
	{
		$email = $post['cus_email'];
		$this->db->select('email');
		$this->db->from($this->_table);
		$this->db->where('iscustomer', $customer);
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
			'error_cus_code'		=> form_error('cus_code'),
			'error_cus_name'		=> form_error('cus_name'),
			'error_cus_email'		=> form_error('cus_email'),
			'error_cus_address'		=> form_error('cus_address'),
			'error_cus_phone'		=> form_error('cus_phone'),
			'error_cus_province'	=> form_error('cus_province'),
			'error_cus_city'		=> form_error('cus_city')
		];
	}
}
