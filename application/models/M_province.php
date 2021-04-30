<?php

class M_province extends CI_Model
{
	private $_table = 'm_province';

	public function getAll()
	{
		return $this->db->order_by('name', 'ASC')->get($this->_table);
	}

	public function setDataList()
	{
		$status = $this->status;
		$list = $this->getAll()->result();
		$data = array();
		$number = 0;
		foreach ($list as $value) {
			$row = array();
			$ID = $value->m_province_id;
			$number++;
			$row[] = $ID;
			$row[] = $number;
			$row[] = $value->name;
			$row[] = $value->province;
			$row[] = isActive($value->isactive);
			$row[] = listAction($ID, $status->DELETE);
			$data[] = $row;
		}
		$result = array('data' => $data);
		return $result;
	}

	public function insert($arrData)
	{
		$provList = $this->getAll()->result();
		$arrListID = array();
		foreach ($provList as $value) :
			$arrListID[] = $value->related_province_id;
		endforeach;

		$list = $arrData->rajaongkir->results;
		$result = array();
		$response = array();
		foreach ($list as $row) :
			$province_id = $row->province_id;
			$province = $row->province;
			if (!in_array($province_id, $arrListID)) {
				$arrData = array(
					'name'					=> $province,
					'province'				=> $province,
					'related_province_id'	=> $province_id,
					'createdby'				=> $this->session->userdata('user_id'),
					'updatedby'				=> $this->session->userdata('user_id')
				);
				$this->db->insert($this->_table, $arrData);
				$result[] = $this->db->affected_rows();
				if (count($result) > 0) {
					$response[] = $province;
				} else {
					$response = false;
				}
			}
		endforeach;

		if (count($arrListID) == 0) {
			$response[] = 'NR'; //new records
		}

		return $response;
	}

	public function detail($id)
	{
		return $this->db->get_where($this->_table, array('m_province_id' => $id));
	}

	public function update($id, $post)
	{
		$this->isactive = $post['isactive'];
		$this->updated_at = date('Y-m-d H:i:s');
		$this->updatedby = $this->session->userdata('user_id');
		$where = array('m_province_id' => $id);
		return $this->db->where($where)
			->update($this->_table, $this);
	}

	public function delete($id)
	{
		return $this->db->delete($this->_table, array('m_province_id' => $id));
	}

	public function listProvince($params)
	{
		return $this->db->order_by('name', 'ASC')->get_where($this->_table, array('isactive' => $params));
	}
}
