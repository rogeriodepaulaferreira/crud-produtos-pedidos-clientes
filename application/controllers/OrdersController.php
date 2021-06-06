<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class OrdersController extends CI_Controller {

	public function index()
	{
		if (!$this->session->has_userdata('user')){
			redirect(site_url());
		}

		$data = array();
		$data['canonical'] = site_url();
		$data['styles'] = array(base_url('assets/css/dashboard.css'));
		$header = $this->load->view('common/header', $data, TRUE);

		$data = array();
		$data['scripts'] = array(base_url('assets/js/dashboard.js'));
		$footer = $this->load->view('common/footer', $data, TRUE);

		$data = array();
		$data['user_name'] = $this->session->user;
		$data['logout'] = site_url('sair');
		$content_top = $this->load->view('common/content_top', $data, TRUE);
		$content_bottom = $this->load->view('common/content_bottom', '', TRUE);

		$data = array();
		$data['header'] = $header;
		$data['footer'] = $footer;

		$data['content_top'] = $content_top;
		$data['content_bottom'] = $content_bottom;

		$this->load->model("CustomersModel", "model_customer");
		$this->load->model("OrdersModel", "orders_model");
		$results = array();
		$query = $this->orders_model->getOrders();
		foreach ($query as $index => $result){

			$fornecedor = $this->model_customer->getCustomer($result['fornecedor_id']);
			$colaborador = $this->model_customer->getCustomer($result['colaborador_id']);
			$results[$index] = $result;

			$results[$index]['fornecedor'] = $fornecedor->name;
			$results[$index]['colaborador'] = $colaborador->name;

		}

		$data['toggle'] = site_url('pedidos/modificar/');
		$data['add'] = site_url('pedidos/cadastrar');
		$data['ws'] = site_url('pedidos/ws');
		$data['edit'] = site_url('pedidos/editar/');
		$data['delete'] = site_url('pedidos/deletar/');

		$data['orders'] = $results;

		$this->load->view('orders/list',$data);
	}

	public function add()
	{
		if (!$this->session->has_userdata('user')){
			redirect(site_url());
		}

		$fornecedor_id = '';
		$colaborador_id = '';
		$observacoes = '';
		$orders_itens = '';
		$validate_orders_itens = true;

		$this->load->model("CustomersModel", "customers_model");
		$this->load->model("ProductsModel", "products_model");

		if ($this->input->server('REQUEST_METHOD') === 'POST'){
			$this->form_validation->set_rules('fornecedor_id','Fornecedor','required');
			$this->form_validation->set_rules('colaborador_id','Colaborador','required');

			$fornecedor_id = $this->input->post('fornecedor_id');
			$colaborador_id = $this->input->post('colaborador_id');
			$observacoes = $this->input->post('observacoes');
			$orders_itens = $this->input->post('orders_itens');

			if (isset($orders_itens['product_id']) == false || count($orders_itens['product_id']) < 1 ){
				$this->session->set_flashdata('error','Por favor, adicione ao menos 1 produto ao pedido !');
				$validate_orders_itens = false;
			}

			if (isset($orders_itens) && is_array($orders_itens)){
				foreach ($orders_itens['product_id'] as $index => $itm){
					$this->form_validation->set_rules("orders_itens[product_id][{$index}]", 'Produto', 'required');
					$this->form_validation->set_rules("orders_itens[value][{$index}]", 'Valor', 'required');
					$this->form_validation->set_rules("orders_itens[quantidade][{$index}]", 'Quantidade', 'required');
				}
			}

			if ($this->form_validation->run() && $validate_orders_itens){

				$data = array();
				$data['fornecedor_id'] = $this->input->post('fornecedor_id');
				$data['colaborador_id'] = $this->input->post('colaborador_id');
				$data['observacoes'] = $this->input->post('observacoes');

				$this->load->model('OrdersModel','model_order');

				$order_id = $this->model_order->add($data);

				if ($order_id){

					if (isset($orders_itens) && is_array($orders_itens)){

						foreach ($orders_itens['product_id'] as $index => $address){

							$data = array();
							$data['order_id'] = $order_id;
							$data['product_id'] = $orders_itens['product_id'][$index];
							$data['value'] = $orders_itens['value'][$index];
							$data['quantidade'] = $orders_itens['quantidade'][$index];

							$this->model_order->addItem($data);
						}
					}

					$this->session->set_flashdata('success','Cadastro efetuado com sucesso !');

				}else{

					$this->session->set_flashdata('error','O cadastro falhou, contate o administrador !');

				}
				redirect(site_url('pedidos'));
			}
		}

		$data = array();
		$data['canonical'] = site_url();
		$data['styles'] = array(base_url('assets/css/dashboard.css'));
		$header = $this->load->view('common/header', $data, TRUE);

		$data = array();
		$data['scripts'] = array(base_url('assets/js/dashboard.js'));
		$data['scripts'] = array(base_url('assets/js/orders.js'));
		$footer = $this->load->view('common/footer', $data, TRUE);

		$data = array();
		$data['user_name'] = $this->session->user;
		$data['logout'] = site_url('sair');
		$content_top = $this->load->view('common/content_top', $data, TRUE);
		$content_bottom = $this->load->view('common/content_bottom', '', TRUE);

		$data = array();
		$data['fornecedores'] = $this->customers_model->getCustomersByType(2);
		$data['colaboradores'] = $this->customers_model->getCustomersByType(1);
		$data['products'] = $this->products_model->getProducts();
		$data['fornecedor_id'] = $fornecedor_id;
		$data['colaborador_id'] = $colaborador_id;
		$data['observacoes'] = $observacoes;
		$data['orders_itens'] = $orders_itens;

		$data['header'] = $header;
		$data['footer'] = $footer;
		$data['content_top'] = $content_top;
		$data['content_bottom'] = $content_bottom;

		$data['title'] = 'Cadastro de pedido';
		$data['return'] = site_url('pedidos');

		$this->load->view('orders/form',$data);
	}

	public function edit($id=null)
	{
		if (!$this->session->has_userdata('user')){
			redirect(site_url());
		}

		$orders_itens = array();

		if ($id && is_numeric($id)){

			if ($this->validade($id)==false){
				redirect(site_url('pedidos'));
				exit();
			}

			$this->load->model("CustomersModel", "customers_model");
			$this->load->model("ProductsModel", "products_model");
			$this->load->model('OrdersModel','model_order');

			$result = $this->model_order->getOrder($id);
			$query = $this->model_order->getOrderItens($id);
			$validate_orders_itens = true;

			if ($result){

				if (isset($query) && is_array($query)){
					foreach ($query as $index => $row){

						$orders_itens['product_id'][$index] = $row->product_id;
						$orders_itens['value'][$index] = $row->value;
						$orders_itens['quantidade'][$index] = $row->quantidade;

					}
				}

				$data['canonical'] = site_url();
				$data['styles'] = array(base_url('assets/css/dashboard.css'));
				$header = $this->load->view('common/header', $data, TRUE);

				$data = array();
				$data['scripts'] = array(base_url('assets/js/dashboard.js'));
				$data['scripts'] = array(base_url('assets/js/orders.js'));
				$footer = $this->load->view('common/footer', $data, TRUE);

				$data = array();
				$data['user_name'] = $this->session->user;
				$data['logout'] = site_url('sair');
				$content_top = $this->load->view('common/content_top', $data, TRUE);
				$content_bottom = $this->load->view('common/content_bottom', '', TRUE);

				$data = array();
				$data['fornecedor_id'] = $result->fornecedor_id;
				$data['colaborador_id'] = $result->colaborador_id;
				$data['observacoes'] = $result->observacoes;

				if ($this->input->server('REQUEST_METHOD') === 'POST'){

					$this->form_validation->set_rules('fornecedor_id','Fornecedor','required');
					$this->form_validation->set_rules('colaborador_id','Colaborador','required');



					$fornecedor_id = $this->input->post('fornecedor_id');
					$colaborador_id = $this->input->post('colaborador_id');
					$observacoes = $this->input->post('observacoes');
					$orders_itens = $this->input->post('orders_itens');

					if (isset($orders_itens) && is_array($orders_itens)){
						foreach ($orders_itens['product_id'] as $index => $itm){
							$this->form_validation->set_rules("orders_itens[product_id][{$index}]", 'Produto', 'required');
							$this->form_validation->set_rules("orders_itens[value][{$index}]", 'Valor', 'required');
							$this->form_validation->set_rules("orders_itens[quantidade][{$index}]", 'Quantidade', 'required');
						}
					}

					$data['fornecedor_id'] = $fornecedor_id;
					$data['colaborador_id'] = $colaborador_id;
					$data['observacoes'] = $observacoes;

					if (isset($orders_itens['product_id']) == false || count($orders_itens['product_id']) < 1 ){
						$this->session->set_flashdata('error','Por favor, adicione ao menos 1 produto ao pedido !');
						$validate_orders_itens = false;
					}


					if ($this->form_validation->run() && $validate_orders_itens){


						if ($this->model_order->edit($data,$id))
						{
							$this->model_order->removeItensOrdem($id);
							if (isset($orders_itens) && is_array($orders_itens)){
								foreach ($orders_itens['product_id'] as $index => $address){

									$data = array();
									$data['order_id'] = $id;
									$data['product_id'] = $orders_itens['product_id'][$index];
									$data['value'] = $orders_itens['value'][$index];
									$data['quantidade'] = $orders_itens['quantidade'][$index];

									$this->model_order->addItem($data);
								}
							}

							$this->session->set_flashdata('success','Cadastro atualizado com sucesso !');

						}else{

							$this->session->set_flashdata('error','A atualização falhou, contate o administrador !');

						}
						redirect(site_url('pedidos'));
					}
				}

				$data['orders_itens'] = $orders_itens;
				$data['fornecedores'] = $this->customers_model->getCustomersByType(2);
				$data['colaboradores'] = $this->customers_model->getCustomersByType(1);
				$data['products'] = $this->products_model->getProducts();
				$data['header'] = $header;
				$data['footer'] = $footer;
				$data['content_top'] = $content_top;
				$data['content_bottom'] = $content_bottom;

				$data['title'] = 'Editando o pedido';
				$data['return'] = site_url('pedidos');

				$this->load->view('orders/form',$data);

			}else{

				$this->index();

			}

		}else{

			redirect(site_url('pedidos'));

		}
	}

	public function delete($id=null)
	{

		if (!$this->session->has_userdata('user')){
			redirect(site_url());
		}

		if ($id && is_numeric($id)){

			if ($this->validade($id)==false){
				redirect(site_url('pedidos'));
				exit();
			}

			$this->load->model('OrdersModel','model_order');

			if ($this->model_order->remove($id)){

				$this->session->set_flashdata('success','Cadastro excluido com sucesso !');

			}else{

				$this->session->set_flashdata('error','A exclusão falhou, contate o administrador !');

			}

		}

		redirect(site_url('pedidos'));

	}

	public function toggle($id=null)
	{

		if (!$this->session->has_userdata('user')){
			redirect(site_url());
		}

		if ($id && is_numeric($id)){

			$this->load->model('OrdersModel','model_order');

			$result = $this->model_order->getOrder($id);

			if ($result){

				if ($result->finalizado){
					$data = array('finalizado' => 0);
				}else{
					$data = array('finalizado' => 1);
				}

				$this->model_order->edit($data,$id);

			}

		}

		redirect(site_url('pedidos'));

	}

	public function validade($id=0){

		$return = false;

		$this->load->model('OrdersModel','model_order');
		$result = $this->model_order->getOrder($id);

		if ($result){
			if ($result->finalizado==false){
				$return = true;
			}
		}

		return $return;

	}

	public function export(){

		if (!$this->session->has_userdata('user')){
			redirect(site_url());
		}

		$json = array();

		$this->load->model("OrdersModel", "orders_model");
		$this->load->model("CustomersModel", "model_customer");
		$this->load->model("ProductsModel", "products_model");
		$this->load->model('AddressesModel','model_addresses');

		$ordens = $this->orders_model->getOrders();
		foreach ($ordens as $ordem){
			$array = array();

			$fornecedor = $this->model_customer->getCustomer($ordem['fornecedor_id'],'array');
			$addresses = $this->model_addresses->getAddressByCustomer($ordem['fornecedor_id']);
			$fornecedor['addresses'] = $addresses;;
			$colaborador = $this->model_customer->getCustomer($ordem['colaborador_id'],'array');
			$addresses = $this->model_addresses->getAddressByCustomer($ordem['colaborador_id']);
			$colaborador['addresses'] = $addresses;

			$array['id'] = $ordem['id'];
			$array['observacoes'] = $ordem['observacoes'];
			$array['finalizado'] = $ordem['finalizado'];
			$array['fornecedor'] = $fornecedor;
			$array['colaborador'] = $colaborador;

			$itens = $this->orders_model->getOrderItens($ordem['id'],'array');
			foreach ($itens as $item){
				$array_item = array();

				$array_item = $item;
				unset($array_item['order_id']);
				$array_item['product_description'] = $this->products_model->getProduct($item['product_id']);

				$array['products'] = $array_item;
			}


			$json[] = $array;
		}



		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($json));
	}

}
