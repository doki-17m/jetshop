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

	function listAction($id)
	{
		$list = '<center>
					<a class="btn" onclick="Destroy(' . "'" . $id . "'" . ')" title="Delete"><i class="fas fa-trash-alt text-danger"></i></a>
				</center>';
		return $list;
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
