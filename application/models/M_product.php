<?php

class M_product extends CI_Model
{
	private $_table = 'm_product';

	private $v_product_detail = 'v_product_detail';

	public function __construct()
	{
		parent::__construct();
	}

	public function getAll()
	{
		return $this->db->get($this->v_product_detail);
	}

	public function setDataList()
	{
		$status = $this->status;
		$list = $this->getAll()->result();
		$data = array();
		$number = 0;
		foreach ($list as $value) {
			$row = array();
			$number++;
			$ID = $value->m_product_id;
			$isActive = $value->isactive;
			$image = $value->ad_image_id;
			$row[] = $ID;
			$row[] = $number;
			$row[] = showImage($image);
			$row[] = $value->value;
			$row[] = $value->name;
			$row[] = $value->category;
			// $row[] = $value->minorder;
			$row[] = $value->qty;
			$row[] = $value->unitmeasure;
			$row[] = formatRupiah($value->purchprice);
			$row[] = formatRupiah($value->salesprice);
			$row[] = isActive($isActive);
			$row[] = listAction($ID, $status->DELQTY);
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
		$this->m_uom_id = $post['pro_uom'];
		$this->weight = $post['pro_weight'];
		$this->minorder = $post['pro_minorder'];
		$this->sellprice = replaceFormat($post['pro_slsidr']);
		$this->costprice = replaceFormat($post['pro_purchidr']);
		if (!empty($post['pro_img'])) {
			$this->ad_image_id = $post['pro_img'];
		}
		$this->isactive = $post['isactive'];
		$this->isobral = $post['isobral'];
		return $this->db->insert($this->_table, $this);
	}

	public function detail($id, $value)
	{
		if (!empty($id)) {
			$this->db->where('m_product_id', $id);
		}
		if (!empty($value)) {
			$this->db->like('value', $value, 'after');
		}
		return $this->db->get($this->v_product_detail);
	}

	public function update($id, $post)
	{
		$this->value = $post['pro_code'];
		$this->name = $post['pro_name'];
		$this->description = $post['pro_desc'];
		if ($post['pro_catg'] !== 'undefined') {
			$this->m_product_category_id = $post['pro_catg'];
		}
		if ($post['pro_catg'] !== 'undefined') {
			$this->m_uom_id = $post['pro_uom'];
		}
		$this->weight = $post['pro_weight'];
		$this->minorder = $post['pro_minorder'];
		$this->sellprice = replaceFormat($post['pro_slsidr']);
		$this->costprice = replaceFormat($post['pro_purchidr']);
		if (!empty($post['pro_img'])) {
			$this->ad_image_id = $post['pro_img'];
		}
		$this->isactive = $post['isactive'];
		$this->isobral = $post['isobral'];
		$where = array('m_product_id' => $id);
		return $this->db->where($where)
			->update($this->_table, $this);
	}

	public function delete_image($id)
	{
		$this->ad_image_id = NULL;
		$where = array('m_product_id' => $id);
		return $this->db->where($where)
			->update($this->_table, $this);
	}

	public function delete($id)
	{
		return $this->db->delete($this->_table, array('m_product_id' => $id));
	}

	public function listProduct($active, $string)
	{
		$this->db->where('isactive', $active);
		if (!empty($string)) {
			$this->db->like('value', $string, 'both');
		}
		return $this->db->get($this->v_product_detail);
	}

	public function getProduct($term)
	{
		$path = $this->path;
		$status = $this->status;
		$isActive = $status->ACTIVE;
		$data = array();

		if (isset($term)) {
			$result = $this->listProduct($isActive, $term)->result();
			if (count($result) > 0) {
				foreach ($result as $value) {
					$row = array();
					$slash = ' /';
					$image = $value->ad_image_id;
					$codeBarcode = $value->value;
					$productName = $value->name;
					$priceUom = formatRupiah($value->salesprice) . $slash . $value->unitmeasure;
					$pathImg = $path->IMG_PATH . $image;

					$row['value'] = $codeBarcode;
					if ($image !== '') {
						$row['label'] = '<img src="' . $pathImg . '" />' .
							'<h3>' . $codeBarcode . '</h3>' .
							'<p>' . $productName . '</p>' .
							'<p>' . $priceUom . '</p>';
					} else {
						$row['label'] = '<h3>' . $codeBarcode . '</h3>' .
							'<p>' . $productName . '</p>' .
							'<p>' . $priceUom . '</p>';
					}
					$data[] = $row;
				}
			} else {
				$data[] = array(
					'value'	=> '',
					'label'	=> 'No Record Found'
				);
			}
			return $data;
		}
		return false;
	}

	public function getProductArrBy($arrList)
	{
		$this->db->where_in('m_product_id', $arrList);
		return $this->db->get($this->v_product_detail);
	}

	public function callbackCode($post)
	{
		$this->db->select('value');
		$this->db->from($this->_table);
		$this->db->where(
			array(
				'value'			 	=> $post['pro_code'],
				'm_product_id !='	=> $post['id']
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
				'name'			 	=> $post['pro_name'],
				'm_product_id !='	=> $post['id']
			)
		);
		return $this->db->get();
	}

	public function checkExistImage($image)
	{
		$this->db->select('ad_image_id as image');
		$this->db->from($this->_table);
		$this->db->where('ad_image_id', $image);
		$rows = $this->db->get()->num_rows();
		return $rows > 0 ? true : false;
	}

	public function form_error()
	{
		return [
			'error'					=> true,
			'error_pro_code'		=> form_error('pro_code'),
			'error_pro_name'		=> form_error('pro_name'),
			'error_pro_weight'		=> form_error('pro_weight'),
			'error_pro_purchidr'	=> form_error('pro_purchidr'),
			'error_pro_slsidr'		=> form_error('pro_slsidr'),
			'error_pro_minorder'	=> form_error('pro_minorder'),
			'error_pro_catg'		=> form_error('pro_catg'),
			'error_pro_qty'			=> form_error('pro_qty')
		];
	}
}
