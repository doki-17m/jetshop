<?php

class M_user extends CI_Model
{
	private $_table = 'sys_user';

	private $v_sysuser_detail = 'v_sysuser_detail';

	public function __construct()
	{
		parent::__construct();
	}

	public function getAll()
	{
		return $this->db->get($this->v_sysuser_detail);
	}

	public function setDataList()
	{
		$status = $this->status;
		$list = $this->getAll()->result();
		$data = array();
		$number = 0;
		foreach ($list as $value) {
			$row = array();
			$ID = $value->sys_user_id;
			$isSalesrep = $value->issalesrep;
			$isActive = $value->isactive;
			$number++;
			$row[] = $ID;
			$row[] = $number;
			$row[] = $value->username;
			$row[] = $value->name;
			$row[] = $value->phone;
			$row[] = $value->job;
			$row[] = $value->address;
			$row[] = isSales($isSalesrep);
			$row[] = isActive($isActive);
			$row[] = listAction($ID, $status->DELETE);
			$data[] = $row;
		}
		$result = array('data' => $data);
		return $result;
	}

	public function insert($post)
	{
		$this->value = $post['usr_username'];
		$this->name = $post['usr_name'];
		$this->password = password_hash($post['usr_password'], PASSWORD_BCRYPT);
		$this->email = $post['usr_email'];
		$this->phone = $post['usr_phone'];
		$this->phone2 = $post['usr_phone2'];
		$this->address = $post['usr_address'];
		$this->birthday = $post['usr_birthday'];
		$this->description = $post['usr_desc'];
		$this->issalesrep = $post['issalesrep'];
		$this->m_greeting_id = $post['usr_greeting'];
		$this->m_job_id = $post['usr_job'];
		$this->isactive = $post['isactive'];
		$this->createdby = $this->session->userdata('user_id');
		$this->updatedby = $this->session->userdata('user_id');
		return $this->db->insert($this->_table, $this);
	}

	public function detail($id)
	{
		return $this->db->get_where($this->_table, array('sys_user_id' => $id));
	}

	public function update($id, $post)
	{
		$this->value = $post['usr_username'];
		$this->name = $post['usr_name'];
		if (!empty($post['usr_password'])) {
			$this->password = password_hash($post['usr_password'], PASSWORD_BCRYPT);
			$this->datepasswordchanged = date('Y-m-d H:i:s');
		}
		$this->email = $post['usr_email'];
		$this->phone = $post['usr_phone'];
		$this->phone2 = $post['usr_phone2'];
		$this->address = $post['usr_address'];
		$this->birthday = $post['usr_birthday'];
		$this->description = $post['usr_desc'];
		$this->issalesrep = $post['issalesrep'];
		if ($post['usr_greeting'] !== 'undefined') {
			$this->m_greeting_id = $post['usr_greeting'];
		}
		if ($post['usr_job'] !== 'undefined') {
			$this->m_job_id = $post['usr_job'];
		}
		$this->isactive = $post['isactive'];
		$this->updated_at = date('Y-m-d H:i:s');
		$this->updatedby = $this->session->userdata('user_id');
		$where = array('sys_user_id' => $id);
		return $this->db->where($where)
			->update($this->_table, $this);
	}

	public function delete($id)
	{
		return $this->db->delete($this->_table, array('sys_user_id' => $id));
	}

	public function updatePassword($post)
	{
		$this->password = password_hash($post['chg_newpass'], PASSWORD_BCRYPT);
		$this->updated_at = date('Y-m-d H:i:s');
		$this->updatedby = $this->session->userdata('user_id');
		$this->datepasswordchanged = date('Y-m-d H:i:s');
		$where = array('sys_user_id' => $post['id']);
		return $this->db->where($where)
			->update($this->_table, $this);
	}

	public function listSales($params)
	{
		return $this->db->order_by('name', 'ASC')->get_where($this->_table, array(
			'isactive' => 'Y',
			'issalesrep' => $params
		));
	}

	public function listCashier()
	{
		$this->db->from($this->v_sysuser_detail);
		$this->db->where([
			'sys_user_id' => $this->session->userdata('user_id')
		]);
		return $this->db->order_by('job', 'ASC')->get();
	}

	public function callbackUsername($post)
	{
		$this->db->select('value');
		$this->db->from($this->_table);
		$this->db->where(
			array(
				'value'			 	=> $post['usr_username'],
				'sys_user_id !='	=> $post['id']
			)
		);
		return $this->db->get();
	}

	public function callbackEmail($post)
	{
		$email = $post['usr_email'];
		$this->db->select('email');
		$this->db->from($this->_table);
		if ($email != '') {
			$this->db->where('email', $email);
		} else {
			$this->db->where('email IS NULL');
		}
		$this->db->where('sys_user_id !=', $post['id']);
		return $this->db->get();
	}

	public function callbackPassword($post)
	{
		$user_id = $post['id'];
		$oldpass = $post['chg_oldpass'];
		$row = $this->detail($user_id)->row();
		return password_verify($oldpass, $row->password);
	}

	public function checkLogin($username, $isactive)
	{
		return $this->db->get_where(
			$this->_table,
			array(
				'value' 	=> $username,
				'isactive'	=> $isactive
			)
		);
	}

	public function updateLastLogin($id)
	{
		$sql = "UPDATE {$this->_table} SET datelastlogin = now() WHERE sys_user_id = {$id}";
		return $this->db->query($sql);
	}

	public function form_error()
	{
		return [
			'error'					=> true,
			'error_usr_username'	=> form_error('usr_username'),
			'error_usr_name'		=> form_error('usr_name'),
			'error_usr_password'	=> form_error('usr_password'),
			'error_usr_email'		=> form_error('usr_email'),
		];
	}
}
