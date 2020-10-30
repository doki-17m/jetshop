<?php

class M_category extends CI_Model
{
	private $_table = 'm_product_category';

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
			$ID = $value->m_product_category_id;
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
		$this->value = $post['cat_sk'];
		$this->name = $post['cat_name'];
		$this->description = $post['cat_desc'];
		$this->isactive = $post['isactive'];
		return $this->db->insert($this->_table, $this);
	}

	public function detail($id)
	{
		return $this->db->get_where($this->_table, array('m_product_category_id' => $id));
	}

	public function update($id, $post)
	{
		$this->value = $post['cat_sk'];
		$this->name = $post['cat_name'];
		$this->description = $post['cat_desc'];
		$this->isactive = $post['isactive'];
		$where = array('m_product_category_id' => $id);
		return $this->db->where($where)
			->update($this->_table, $this);
	}

	public function delete($id)
	{
		return $this->db->delete($this->_table, array('m_product_category_id' => $id));
	}

	public function listCategory($params)
	{
		return $this->db->order_by('name', 'ASC')->get_where($this->_table, array('isactive' => $params));
	}

	public function callbackSearchKey($post)
	{
		$this->db->select('value');
		$this->db->from($this->_table);
		$this->db->where(
				array(
					'value'						=> $post['cat_sk'],
					'm_product_category_id !='	=> $post['id']
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
					'name'						=> $post['cat_name'],
					'm_product_category_id !='	=> $post['id']
					)
				);
		return $this->db->get();
	}

	public function form_error()
	{
		return [
			'error'				=> true,
			'error_cat_sk'		=> form_error('cat_sk'),
			'error_cat_name'	=> form_error('cat_name')
		];
	}
}
