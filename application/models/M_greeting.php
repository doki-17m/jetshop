<?php

class M_greeting extends CI_Model
{
	private $_table = 'm_greeting';

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
			$ID = $value->m_greeting_id;
			$number++;
			$row[] = $ID;
			$row[] = $number;
			$row[] = $value->value;
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
		$this->value = $post['gre_sk'];
		$this->name = $post['gre_name'];
		$this->description = $post['gre_desc'];
		$this->isactive = $post['isactive'];
		return $this->db->insert($this->_table, $this);
	}

	public function detail($id)
	{
		return $this->db->get_where($this->_table, array('m_greeting_id' => $id));
	}

	public function update($id, $post)
	{
		$this->value = $post['gre_sk'];
		$this->name = $post['gre_name'];
		$this->description = $post['gre_desc'];
		$this->isactive = $post['isactive'];
		$where = array('m_greeting_id' => $id);
		return $this->db->where($where)
			->update($this->_table, $this);
	}

	public function delete($id)
	{
		return $this->db->delete($this->_table, array('m_greeting_id' => $id));
	}

	public function listGreeting($params)
	{
		return $this->db->order_by('name', 'ASC')->get_where($this->_table, array('isactive' => $params));
	}

	public function callbackSearchKey($post)
	{
		$this->db->select('value');
		$this->db->from($this->_table);
		$this->db->where(
				array(
					'value'				=> $post['gre_sk'],
					'm_greeting_id !='	=> $post['id']
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
					'name'						=> $post['gre_name'],
					'm_greeting_id !='	=> $post['id']
					)
				);
		return $this->db->get();
	}

	public function form_error()
	{
		return [
			'error'				=> true,
			'error_gre_sk'		=> form_error('gre_sk'),
			'error_gre_name'	=> form_error('gre_name')
		];
	}
}
