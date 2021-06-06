<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AddressesModel extends CI_Model {

	public function getAddresses()
	{

		$this->db->select("id, customer_id , zipcode, address, number, complement, district, city, state");
		$result = $this->db->get("addresses")->result();
		return $result;

	}

	public function getAddress($id)
	{

		$this->db->select("id, customer_id , zipcode, address, number, complement, district, city, state");
		$this->db->where('id', $id);
		$result = $this->db->get("addresses")->first_row();
		return $result;

	}

	public function getAddressByCustomer($customer_id )
	{

		$this->db->select("id, customer_id , zipcode, address, number, complement, district, city, state");
		$this->db->where('customer_id ', $customer_id);
		$result = $this->db->get("addresses")->result();
		return $result;

	}

	public function add($data)
	{
		if ($this->db->insert('addresses',$data))
		{

			return $this->db->insert_id();

		}else{

			return false;

		}
	}

	public function edit($data,$id)
	{
		$this->db->where('id', $id);
		if ($this->db->update('addresses',$data))
		{
			return true;

		}else {

			return false;

		}
	}

	public function remove($id)
	{
		$this->db->where('id', $id);
		if ($this->db->delete('addresses'))
		{
			return true;

		}else{

			return false;

		}
	}


	public function removeByCustomer($customer_id)
	{
		$this->db->where('customer_id ', $customer_id);
		if ($this->db->delete('addresses'))
		{
			return true;

		}else{

			return false;

		}
	}

}
