<?php

class M_city extends CI_Model
{
	private $_table = 'm_city';

	public function __construct()
	{
		parent::__construct();
		$this->load->model('m_province');
	}

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
			$ID = $value->m_city_id;
			$number++;
			$row[] = $ID;
			$row[] = $number;
			$row[] = $value->name;
			$row[] = $value->city;
			$row[] = $value->type;
			$row[] = $value->province;
			$row[] = $value->postal;
			$row[] = isActive($value->isactive);
			$row[] = listAction($ID, $status->DELETE);
			$data[] = $row;
		}
		$result = array('data' => $data);
		return $result;
	}

	public function insert($arrData)
	{
		$cityList = $this->getAll()->result();
		$arrListID = array();
		foreach ($cityList as $value) :
			$arrListID[] = $value->related_city_id;
		endforeach;

		$list = $arrData->rajaongkir->results;
		$result = array();
		$response = array();
		foreach ($list as $row) :
			$city_id = $row->city_id;
			$city = $row->city_name;
			$postal = $row->postal_code;
			$type = $row->type;
			$province = $row->province;
			$province_id = $row->province_id;
			if (!in_array($city_id, $arrListID)) {
				$arrData = array(
					'name'					=> $city,
					'city'					=> $city,
					'postal'				=> $postal,
					'type'					=> $type,
					'related_city_id'		=> $city_id,
					'province'				=> $province,
					'ref_province_id'		=> $province_id,
					'createdby'				=> $this->session->userdata('user_id'),
					'updatedby'				=> $this->session->userdata('user_id')
				);
				$this->db->insert($this->_table, $arrData);
				$result[] = $this->db->affected_rows();
				if (count($result) > 0) {
					$response[] = $city;
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
		return $this->db->get_where($this->_table, array('m_city_id' => $id));
	}

	public function update($id, $post)
	{
		$this->isactive = $post['isactive'];
		$this->updated_at = date('Y-m-d H:i:s');
		$this->updatedby = $this->session->userdata('user_id');
		$where = array('m_city_id' => $id);
		return $this->db->where($where)
			->update($this->_table, $this);
	}

	public function delete($id)
	{
		return $this->db->delete($this->_table, array('m_city_id' => $id));
	}

	public function listCity($active, $post)
	{
		$province = $this->m_province;
		$id = $post['id'];

		if (!empty($id)) {
			$province_id = $province->detail($id)->row()->related_province_id;
			return $this->db->order_by('name', 'ASC')->get_where(
				$this->_table,
				array(
					'isactive' 			=>	$active,
					'ref_province_id'	=>	$province_id
				)
			);
		} else {
			return $this->db->order_by('name', 'ASC')->get_where(
				$this->_table,
				array(
					'isactive' 			=>	$active
				)
			);
		}
	}
}
