<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Product extends CI_Controller
{
	private $ID = 0;

	private $CODE = 0;

	public function __construct()
	{
		parent::__construct();
		$this->load->model('m_product');
	}

	public function index()
	{
		$view = $this->views;
		$this->template->load($view->OVERVIEW, $view->VIEW_PRODUCT);
	}

	public function showAll()
	{
		$product = $this->m_product;
		$response = $product->setDataList();
		echo json_encode($response);
	}

	public function create()
	{
		$status = $this->status;
		$product = $this->m_product;
		$validation = $this->form_validation;
		$post = $this->input->post(NULL, TRUE);
		$image = $post['pro_img'];

		$validation->set_rules([
			[
				'field'		=>	'pro_code',
				'label'		=>	'Code Product',
				'rules'		=>	'required|is_unique[m_product.value]',
				'errors'	=> 	[
					'is_unique'	=> 'This %s already exists.'
				]
			],
			[
				'field'		=>	'pro_name',
				'label'		=>	'Brand Product',
				'rules'		=>	'required|is_unique[m_product.name]',
				'errors'	=> 	[
					'is_unique'	=> 'This %s already exists.'
				]
			],
			[
				'field'		=>	'pro_weight',
				'label'		=>	'Weight',
				'rules'		=>	'required'
			],
			[
				'field'		=>	'pro_purchidr',
				'label'		=>	'Purchase IDR',
				'rules'		=>	'required'
			],
			[
				'field'		=>	'pro_slsidr',
				'label'		=>	'Sales IDR',
				'rules'		=>	'required'
			],
			[
				'field'		=>	'pro_minorder',
				'label'		=>	'Minimum Order',
				'rules'		=>	'required|callback_check_prominorder',
				'errors'	=> 	[
					'check_prominorder'	=> 'The %s cannot smaller than 1'
				]
			],
			[
				'field'		=>	'pro_catg',
				'label'		=>	'Product Category',
				'rules'		=>	'required'
			],
			[
				'field'		=>	'pro_qty',
				'label'		=>	'Quantity',
				'rules'		=>	'required|callback_check_proqty',
				'errors'		=>	[
					'check_proqty'	=> 'The %s cannot smaller than 1'
				]
			]
		]);

		if ($validation->run()) {
			if (!empty($image)) {
				$this->move_image($image);
			}
			$product->insert($post);
			$response = $status->SUCCESS_INSERT;
		} else {
			$response = $product->form_error();
		}

		echo json_encode($response);
	}

	public function show($id)
	{
		$product = $this->m_product;
		$status = $this->status;

		$this->ID = $id;
		$this->CODE = $status->ZERO;
		$response = $product->detail($this->ID, $this->CODE)->row();
		echo json_encode($response);
	}

	public function edit($id)
	{
		$status = $this->status;
		$path = $this->path;
		$product = $this->m_product;
		$validation = $this->form_validation;
		$post = $this->input->post(NULL, TRUE);
		$image = $post['pro_img'];

		$this->ID = $id;
		$this->CODE = $status->ZERO;
		$img = $product->detail($this->ID, $this->CODE)->row()->ad_image_id;

		$validation->set_rules([
			[
				'field'		=>	'pro_code',
				'label'		=>	'Code Product',
				'rules'		=>	'required|callback_check_procode',
				'errors'	=> 	[
					'check_procode'	=> 'This %s already exists.'
				]
			],
			[
				'field'		=>	'pro_name',
				'label'		=>	'Brand Product',
				'rules'		=>	'required|callback_check_proname',
				'errors'	=> 	[
					'check_proname'	=> 'This %s already exists.'
				]
			],
			[
				'field'		=>	'pro_weight',
				'label'		=>	'Weight',
				'rules'		=>	'required'
			],
			[
				'field'		=>	'pro_purchidr',
				'label'		=>	'Purchase IDR',
				'rules'		=>	'required'
			],
			[
				'field'		=>	'pro_slsidr',
				'label'		=>	'Sales IDR',
				'rules'		=>	'required'
			],
			[
				'field'		=>	'pro_minorder',
				'label'		=>	'Minimum Order',
				'rules'		=>	'required|callback_check_prominorder',
				'errors'	=> 	[
					'check_prominorder'	=> 'The %s cannot smaller than 1'
				]
			],
			[
				'field'		=>	'pro_catg',
				'label'		=>	'Product Category',
				'rules'		=>	'required'
			],
			[
				'field'		=>	'pro_qty',
				'label'		=>	'Quantity',
				'rules'		=>	'required|callback_check_proqty',
				'errors'		=>	[
					'check_proqty'	=> 'The %s cannot smaller than 1'
				]
			]
		]);

		if ($validation->run()) {
			if (!empty($image)) { //image not null
				if (strcmp($img, $image) !== 0) { //do upload different image at database
					$this->move_image($image);
					if (!empty($img)) {
						unlink($path->IMG_PATH . $img);
					}
				}
			} else {
				if (!empty($img)) {
					unlink($path->IMG_PATH . $img);
				}
				$product->delete_image($id);
			}
			$product->update($id, $post);
			$response = $status->SUCCESS_UPDATE;
		} else {
			$response = $product->form_error();
		}
		echo json_encode($response);
	}

	public function destroy($id)
	{
		$path = $this->path;
		$status = $this->status;
		$product = $this->m_product;

		$this->ID = $id;
		$this->CODE = $status->ZERO;
		$img = $product->detail($this->ID, $this->CODE)->row()->ad_image_id;
		if (!empty($img)) {
			unlink($path->TMP . $img);
		}
		$response = $product->delete($id);
		echo json_encode($response);
	}

	public function showProduct()
	{
		$product = $this->m_product;
		$response = $product->getProduct($_GET['term']);
		echo json_encode($response);
	}

	public function upload_image()
	{
		$path = $this->path;
		$config['upload_path'] = $path->TMP;
		$config['allowed_types'] = 'jpg|png';
		$config['max_size'] = 1024; //satuan KB
		$config['encrypt_name'] = TRUE;
		$this->load->library('upload', $config);

		$upload = $this->upload;
		if ($upload->do_upload('pro_image')) {
			$data = array('upload_data' => $upload->data());
			$response = ['success' => $data['upload_data']['file_name']];
		} else {
			$response = ['error' => $upload->display_errors()];
		}
		echo json_encode($response);
	}

	public function destroy_image()
	{
		$path = $this->path;
		$product = $this->m_product;
		$post = $this->input->post(NULL, TRUE);

		$src = $post['src'];
		$setSave = $post['set'];
		$existImage = $product->checkExistImage($src);
		$tmp_target = $path->TMP . $src;

		if ($setSave == 'add' && !empty($src)) {
			$response = unlink($tmp_target);
		} else if ($setSave == 'close' && !empty($src) && $existImage) {
			$response = false;
		} else if ($setSave == 'close' && !empty($src)) {
			$response = unlink($tmp_target);
		} else {
			$response = false;
		}

		echo json_encode($response);
	}

	public function check_procode()
	{
		$status = $this->status;
		$product = $this->m_product;
		$zero = $status->ZERO;
		$post = $this->input->post(NULL, TRUE);
		$rows = $product->callbackCode($post)->num_rows();
		return $rows > $zero ? false : true;
	}

	public function check_proname()
	{
		$status = $this->status;
		$product = $this->m_product;
		$zero = $status->ZERO;
		$post = $this->input->post(NULL, TRUE);
		$rows = $product->callbackName($post)->num_rows();
		return $rows > $zero ? false : true;
	}

	public function check_prominorder()
	{
		$post = $this->input->post(NULL, TRUE);
		$minOrder = $post['pro_minorder'];
		if ($minOrder !== '') {
			return $minOrder < 1 ? false : true;
		}
	}

	public function check_proqty()
	{
		$post = $this->input->post(NULL, TRUE);
		$qty = $post['pro_qty'];
		if ($qty !== '') {
			return $qty < 1 ? false : true;
		}
	}

	public function move_image($src)
	{
		$path = $this->path;
		return rename($path->TMP . $src, $path->IMG_PATH . $src); //move file from tmp to images
	}
}
