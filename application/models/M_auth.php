<?php

class M_auth extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('m_user');
	}

	public function setLogin($post, $active)
	{
		$user = $this->m_user;
		$session = $this->session;

		$login_user = $post['lgn_username'];
		$login_pass = $post['lgn_pass'];

		$row = $user->checkLogin($login_user, $active)->row();
		
		if ($row !== null) {
			$user_id = $row->sys_user_id;
			$role_id = $row->m_role_id;
			$pass_value = $row->password;

			$isPasswordTrue = password_verify($login_pass, $pass_value);

			if ($isPasswordTrue) {
				$arrLogin = array(
					'user_id'		=> $user_id,
					'role_id'		=> $role_id
				);
				$session->set_userdata($arrLogin);
				$user->updateLastLogin($user_id);
				$result = [
					'success'	=> true
				];
			} else {
				$result = [
					'success'	=> false
				];				
			}
		} else {
			$result = [
				'success'	=> false
			];
		}
		return $result;
	}

	public function getUsername($username, $active)
	{
		$user = $this->m_user;
		$row = $user->checkLogin($username, $active)->row();
		return (!empty($row->value)) ? true : false;
	}

	public function form_error()
	{
		return [
			'error'						=> true,
			'error_lgn_username'		=> form_error('lgn_username'),
			'error_lgn_pass'			=> form_error('lgn_pass')
		];
	}
}
