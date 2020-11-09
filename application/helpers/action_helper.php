<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	function isActive($string)
	{
		if ($string == 'Y') {
			return '<center><span class="badge badge-success">Active</span></center>';
		} else {
			return '<center><span class="badge badge-danger">Non-active</span></center>';
		}
	}

	function isSales($string)
	{
		if ($string == 'Y') {
			return '<center><span class="badge badge-success">Yes</span></center>';
		} else {
			return '<center><span class="badge badge-danger">No</span></center>';
		}
	}

	function listAction($id, $string)
	{
		if ($string === 'D') {
			$list = '<center>
						<a class="btn" onclick="Destroy(' . "'" . $id . "'" . ')" title="Delete"><i class="fas fa-trash-alt text-danger"></i></a>
					</center>';
		} else if ($string === 'C') {
			$list = '<center>
						<a class="btn cart" id="'.$id.'" title="Cart"><i class="fas fa-cart-plus text-danger"></i></a>
					</center>';
		} else if ($string === 'DC') {
			$list = '<center>
						<a class="btn" onclick="destroyCart(' . "'" . $id . "'" . ')" title="Delete Cart"><i class="fas fa-trash-alt text-danger"></i></a>
					</center>';
		} else if ($string === 'P') {
			$list = '<center>
						<a class="btn" onclick="Print(' . "'" . $id . "'" . ')" title="Cart"><i class="fas fa-print text-primary"></i></a>
					</center>';
		} else {
			$list = '<center>
						<a class="btn" onclick="Print(' . "'" . $id . "'" . ')" title="Cart"><i class="fas fa-print text-primary"></i></a>
						<a class="btn" onclick="Destroy(' . "'" . $id . "'" . ')" title="Delete"><i class="fas fa-trash-alt text-danger"></i></a>
					</center>';
		}
		return $list;
	}

	function showImage($img)
	{
		$CI = &get_instance();
		$CI->load->library('path');
		$path = $CI->path;
		$image_path = $path->IMG_PATH . $img;
		if (!empty($img)) {
			return '<center><img src="'.base_url().$image_path.'" style="height: 100px; width: 100px;" /></center>';
		} else {
			return null;
		}
	}
	
	function inputQty()
	{
		return '<input type="number" style="width: 50px">';
	}

	function isLogin() {
        $ci =& get_instance();
        $user_session = $ci->session->userdata('user_id');
        if($user_session) {
            redirect();
        }
	}
	
	function isNotLogin() {
        $ci =& get_instance();
        $user_session = $ci->session->userdata('user_id');
        if(!$user_session) {
            redirect('auth');
        }
	}

	function replaceFormat($rupiah) {
		return preg_replace("/\./", "", $rupiah);
	}

	function formatRupiah($numeric) {
        return number_format($numeric, 0, '', '.');
    }
