<?php
defined('BASEPATH') or exit('No direct script access allowed');
// require_once(APPPATH.'controller/variable.php');

class Product extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('m_product', 'modpro');
		require('view_access.php');
	}

	public function index()
	{
		$access = new view_access();
		$this->template->load($access->overview, $access->v_product);
	}

	public function showAll()
	{
		$response = $this->modpro->setDataList();
		echo json_encode($response);
	}

	public function create()
	{
		$post = $this->input->post(NULL, TRUE);
		$response = $this->modpro->insert($post);
		echo json_encode($response);
	}

	public function show($id)
	{
		$response = $this->modpro->detail($id)->row();
		echo json_encode($response);
	}

	public function edit($id)
	{
		$post = $this->input->post(NULL, TRUE);
		$response = $this->modpro->update($id, $post);
		echo json_encode($response);
	}

	public function destroy($id)
	{
		$response = $this->modpro->delete($id);
		echo json_encode($response);
	}

	public function get_product($params)
	{
		$response = $this->modpro->getByActive($params)->result();
		echo json_encode($response);
	}

	public function uploadImage()
	{
		$config['upload_path'] = './assets/cust/images';
		$config['allowed_types'] ='jpg|png';
		$config['max_size'] = 1024; //satuan KB
        $config['encrypt_name'] = TRUE;
        
        $this->load->library('upload',$config);
	    if($this->upload->do_upload('pro_image')){
	        $data = array('upload_data' => $this->upload->data());
			// $judul= $this->upload->data();
			// $image= RemoveSpecialChar($data['upload_data']['file_name']);
			// $image = $data['upload_data']['file_name'];
			// echo '<label class="form-result col-md-6">
			// 		<button type="button" class="close-img" id="btn_delimg" aria-label="Close">
			// 			<span aria-hidden="true">&times;</span>
			// 		</button>
			// 		<img src="'.base_url("assets/cust/images/$image").'"/>
			// 	</label>';
			echo $data['upload_data']['file_name'];
        } else {
			$response = array('error' => $this->upload->display_errors());
			echo json_encode($response);
		}
	}

	// function RemoveSpecialChar($value)
	// {
	// 	$result  = preg_replace('/[^a-zA-Z0-9_ -]/s', '', $value);

	// 	return $result;
	// }

}
