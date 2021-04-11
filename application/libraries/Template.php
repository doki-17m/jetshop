<?php

class Template
{

	var $template_data = array();

	public function __construct()
	{
		$this->CI = &get_instance();
		$this->CI->load->model('m_user');
	}

	function set($name, $value)
	{
		$this->template_data[$name] = $value;
	}

	function load($template = '', $view = '', $view_data = array(), $return = FALSE)
	{
		$user_id = $this->CI->session->userdata('user_id');
		$view_data['username'] = $this->CI->m_user->detail($user_id)->row();

		$this->set('contents', $this->CI->load->view($view, $view_data, TRUE));
		return $this->CI->load->view($template, $this->template_data, $return);
	}
}
