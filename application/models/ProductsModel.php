<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ProductsModel extends CI_Model {

	public function getProducts()
	{

		$this->db->select("id, code, name, description, status");
		$result = $this->db->get("products")->result();
		return $result;

	}

	public function getProduct($id)
	{

		$this->db->select("id, code, name, description, status");
		$this->db->where('id', $id);
		$result = $this->db->get("products")->first_row();
		return $result;

	}

	public function add($data)
	{
		if ($this->db->insert('products',$data))
		{

			return $this->db->insert_id();

		}else{

			return false;

		}
	}

	public function edit($data,$id)
	{
		$this->db->where('id', $id);
		if ($this->db->update('products',$data))
		{
			return true;

		}else {

			return false;

		}
	}

	public function remove($id)
	{
		$this->db->where('id', $id);
		if ($this->db->delete('products'))
		{
			return true;

		}else{

			return false;

		}
	}

}
