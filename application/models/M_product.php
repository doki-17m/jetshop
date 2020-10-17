<?php

class M_product extends CI_Model
{
	private $_table = 'm_product';
	public $m_product_id;

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
			$number++;
			$row[] = $value->m_product_id;
			$row[] = $number;
			$row[] = $value->value;
			$row[] = $value->name;
			if ($value->m_product_category_id == 1) {
				$row[] = 'Baju';
			} else if ($value->m_product_category_id == 2) {
				$row[] = 'Lain-Lain';
			}
			if ($value->unitmeasure == 'pcs') {
				$row[] = 'Pcs';
			} else if ($value->unitmeasure == 'pk') {
				$row[] = 'Pack';
			} else {
				$row[] = 'Each';
			}
			// $row[] = $value->qtyonhand;
			$row[] = $value->costprice;
			$row[] = $value->sellprice;
			if ($value->isactive == 'Y') {
				$row[] = '<span class="badge badge-success">Active</span>';
			} else {
				$row[] = '<span class="badge badge-danger">Non-active</span>';
			}
			$row[] = '<center>
                        <a class="btn" onclick="delete_data(' . "'" . $value->m_product_id . "'" . ')" title="Delete"><i class="fas fa-trash-alt text-danger"></i></a>
                    </center>';
			$data[] = $row;
		}
		$result = array('data' => $data);
		return $result;
	}

	public function insert($post)
	{
		$this->value = $post['pro_code'];
		$this->name = $post['pro_name'];
		$this->description = $post['pro_desc'];
		$this->m_product_category_id = $post['pro_catg'];
		$this->unitmeasure = $post['pro_uom'];
		$this->weight = $post['pro_weight'];
		$this->minorder = $post['pro_minorder'];
		$this->sellprice = $post['pro_slsidr'];
		$this->costprice = $post['pro_purchidr'];
		$this->isactive = $post['isactive'];
		return $this->db->insert($this->_table, $this);
	}

	public function detail($id)
	{
		return $this->db->get_where($this->_table, array('m_product_id' => $id));
	}

	public function update($id, $post)
	{
		$this->value = $post['pro_code'];
		$this->name = $post['pro_name'];
		$this->description = $post['pro_desc'];
		$this->m_product_category_id = $post['pro_catg'];
		$this->unitmeasure = $post['pro_uom'];
		$this->weight = $post['pro_weight'];
		$this->minorder = $post['pro_minorder'];
		$this->sellprice = $post['pro_slsidr'];
		$this->costprice = $post['pro_purchidr'];
		$this->isactive = $post['isactive'];
		$where = array('m_product_id' => $id);
		return $this->db->where($where)
			->update($this->_table, $this);
	}

	public function delete($id)
	{
		return $this->db->delete($this->_table, array('m_product_id' => $id));
	}

	public function getProduct($params)
	{
		$this->db->select('m_product_id,
							name,
							sellprice');
		$this->db->from($this->_table);
		$this->db->where('isactive', $params);
		return $this->db->get();
	}
}
