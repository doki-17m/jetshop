<?php

class M_uom extends CI_Model
{
	private $_table = 'm_uom';

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
			$ID = $value->m_uom_id;
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
		$this->value = $post['uom_code'];
		$this->name = $post['uom_name'];
		$this->description = $post['uom_desc'];
		$this->isactive = $post['isactive'];
		$this->createdby = $this->session->userdata('user_id');
		$this->updatedby = $this->session->userdata('user_id');
		return $this->db->insert($this->_table, $this);
	}

	public function detail($id)
	{
		return $this->db->get_where($this->_table, array('m_uom_id' => $id));
	}

	public function update($id, $post)
	{
		$this->value = $post['uom_code'];
		$this->name = $post['uom_name'];
		$this->description = $post['uom_desc'];
		$this->isactive = $post['isactive'];
		$this->updated_at = date('Y-m-d H:i:s');
		$this->updatedby = $this->session->userdata('user_id');
		$where = array('m_uom_id' => $id);
		return $this->db->where($where)
			->update($this->_table, $this);
	}

	public function delete($id)
	{
		return $this->db->delete($this->_table, array('m_uom_id' => $id));
	}

	public function listUom($params)
	{
		return $this->db->order_by('name', 'ASC')->get_where($this->_table, array('isactive' => $params));
	}

	public function callbackCode($post)
	{
		$this->db->select('value');
		$this->db->from($this->_table);
		$this->db->where(
			array(
				'value'			=> $post['uom_code'],
				'm_uom_id !='	=> $post['id']
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
				'name'			=> $post['uom_name'],
				'm_uom_id !='	=> $post['id']
			)
		);
		return $this->db->get();
	}

	public function form_error()
	{
		return [
			'error'				=> true,
			'error_uom_code'	=> form_error('uom_code'),
			'error_uom_name'	=> form_error('uom_name')
		];
	}
}
