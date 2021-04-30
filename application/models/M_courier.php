<?php

class M_courier extends CI_Model
{
	private $_table = 'm_courier';

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
		$status = $this->status;
		$list = $this->getAll()->result();
		$data = array();
		$number = 0;
		foreach ($list as $value) {
			$row = array();
			$ID = $value->m_courier_id;
			$number++;
			$row[] = $ID;
			$row[] = $number;
			$row[] = $value->value;
			$row[] = $value->name;
			$row[] = $value->description;
			$row[] = isActive($value->isactive);
			$row[] = listAction($ID, $status->DELETE);
			$data[] = $row;
		}
		$result = array('data' => $data);
		return $result;
	}

	public function insert($post)
	{
		$this->value = $post['cou_code'];
		$this->name = $post['cou_name'];
		$this->description = $post['cou_desc'];
		$this->isactive = $post['isactive'];
		$this->createdby = $this->session->userdata('user_id');
		$this->updatedby = $this->session->userdata('user_id');
		return $this->db->insert($this->_table, $this);
	}

	public function detail($id)
	{
		return $this->db->get_where($this->_table, array('m_courier_id' => $id));
	}

	public function update($id, $post)
	{
		$this->value = $post['cou_code'];
		$this->name = $post['cou_name'];
		$this->description = $post['cou_desc'];
		$this->isactive = $post['isactive'];
		$this->updated_at = date('Y-m-d H:i:s');
		$this->updatedby = $this->session->userdata('user_id');
		$where = array('m_courier_id' => $id);
		return $this->db->where($where)
			->update($this->_table, $this);
	}

	public function delete($id)
	{
		return $this->db->delete($this->_table, array('m_courier_id' => $id));
	}

	public function listCourier($active)
	{
		return $this->db->order_by('name', 'ASC')->get_where($this->_table, array('isactive' => $active));
	}

	public function getByValue($value)
	{
		$this->db->like('value', $value, 'after');
		return $this->db->get($this->_table);
	}

	public function callbackCode($post)
	{
		$this->db->select('value');
		$this->db->from($this->_table);
		$this->db->where(
			array(
				'value'						=> $post['cou_code'],
				'm_courier_id !='	=> $post['id']
			)
		);
		return $this->db->get();
	}

	public function callbackName($post)
	{
		$this->db->select('name');
		$this->db->from($this->_table);
		$this->db->where(
			array(
				'name'						=> $post['cou_name'],
				'm_courier_id !='	=> $post['id']
			)
		);
		return $this->db->get();
	}

	public function form_error()
	{
		return [
			'error'				=> true,
			'error_cou_code'		=> form_error('cou_code'),
			'error_cou_name'	=> form_error('cou_name')
		];
	}
}
