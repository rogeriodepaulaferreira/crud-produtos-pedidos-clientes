<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CustomersModel extends CI_Model {

	public function getCustomers()
	{
		$this->db->select("id, name, email, telephone, cellphone, borndate, comments, type, status");
		$result = $this->db->get("customers")->result();
		return $result;
	}

	public function getCustomersByType($type)
	{
		$this->db->select("id, name, email, telephone, cellphone, borndate, comments, type, status");
		$this->db->where('type', $type);
		$result = $this->db->get("customers")->result();
		return $result;
	}

	public function getCustomer($id,$type='object')
	{

		$this->db->select("id, name, email, telephone, cellphone, borndate, comments, type, status");
		$this->db->where('id', $id);
		$result = $this->db->get("customers")->first_row($type);
		return $result;

	}


	public function add($data)
	{
		if ($this->db->insert('customers',$data))
		{

			return $this->db->insert_id();

		}else{

			return false;

		}
	}

	public function edit($data,$id)
	{
		$this->db->where('id', $id);
		if ($this->db->update('customers',$data))
		{
			return true;

		}else {

			return false;

		}
	}

	public function remove($id)
	{
		$this->db->where('id', $id);
		if ($this->db->delete('customers'))
		{
			return true;

		}else{

			return false;

		}
	}

}
