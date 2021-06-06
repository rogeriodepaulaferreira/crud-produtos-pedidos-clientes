<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class OrdersModel extends CI_Model {

	public function getOrders()
	{

		$this->db->select("id, fornecedor_id, colaborador_id, observacoes, finalizado");
		$result = $this->db->get("orders")->result_array();
		return $result;

	}

	public function getOrder($id)
	{

		$this->db->select("id, fornecedor_id, colaborador_id, observacoes, finalizado");
		$this->db->where('id', $id);
		$result = $this->db->get("orders")->first_row();
		return $result;

	}

	public function getOrderItens($order_id,$type='object')
	{

		$this->db->select("id, order_id, product_id, value, quantidade");
		$this->db->where('order_id', $order_id);
		$result = $this->db->get("orders_itens")->result($type);
		return $result;

	}

	public function add($data)
	{
		if ($this->db->insert('orders',$data))
		{

			return $this->db->insert_id();

		}else{

			return false;

		}
	}

	public function addItem($data)
	{
		if ($this->db->insert('orders_itens',$data))
		{

			return $this->db->insert_id();

		}else{

			return false;

		}
	}

	public function edit($data,$id)
	{
		$this->db->where('id', $id);
		if ($this->db->update('orders',$data))
		{
			return true;

		}else {

			return false;

		}
	}

	public function remove($id)
	{
		$this->db->where('id', $id);
		if ($this->db->delete('orders'))
		{
			$this->db->where('order_id', $id);
			$this->db->delete('orders_itens');

			return true;

		}else{

			return false;

		}
	}

	public function removeItensOrdem($id)
	{
		$this->db->where('order_id', $id);
		if ($this->db->delete('orders_itens'))
		{
			return true;

		}else{

			return false;

		}
	}

}
