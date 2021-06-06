<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LoginModel extends CI_Model {

	public function login($user, $pass)
	{

		$this->db->where('user',$user);
		$this->db->where('pass',$pass);
		$query = $this->db->get('users');

		if ($query->num_rows() > 0)
		{
			return true;
		}else{
			return false;
		}

	}

}
