<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ProductsController extends CI_Controller {


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

		$this->load->model("ProductsModel", "products");
		$result = $this->products->getProducts();

		$data['toggle'] = site_url('produtos/modificar/');
		$data['add'] = site_url('produtos/cadastrar');
		$data['edit'] = site_url('produtos/editar/');
		$data['delete'] = site_url('produtos/deletar/');

		$data['products'] = $result;

		$this->load->view('products/list',$data);
	}

	public function add()
	{
		if (!$this->session->has_userdata('user')){
			redirect(site_url());
		}

		$code = '';
		$name = '';
		$description = '';

		if ($this->input->server('REQUEST_METHOD') === 'POST'){
			$this->form_validation->set_rules('code','Código','required|min_length[3]');
			$this->form_validation->set_rules('name','Nome','required|min_length[3]');

			$code = $this->input->post('code');
			$name = $this->input->post('name');
			$description = $this->input->post('description');

			if ($this->form_validation->run()){

				$data = array();
				$data['code'] = $this->input->post('code');
				$data['name'] = $this->input->post('name');
				$data['description'] = $this->input->post('description');

				$this->load->model('ProductsModel','model_product');

				if ($this->model_product->add($data)){

					$this->session->set_flashdata('success','Cadastro efetuado com sucesso !');

				}else{

					$this->session->set_flashdata('error','O cadastro falhou, contate o administrador !');

				}
				redirect(site_url('produtos'));
			}
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
		$data['code'] = $code;
		$data['name'] = $name;
		$data['description'] = $description;

		$data['header'] = $header;
		$data['footer'] = $footer;
		$data['content_top'] = $content_top;
		$data['content_bottom'] = $content_bottom;

		$data['title'] = 'Cadastro de produto';
		$data['return'] = site_url('produtos');

		$this->load->view('products/form',$data);
	}

	public function edit($id=null)
	{
		if (!$this->session->has_userdata('user')){
			redirect(site_url());
		}

		if ($id && is_numeric($id)){
			if ($this->validade($id)==false){
				redirect(site_url('produtos'));
				exit();
			}

			$this->load->model('ProductsModel','model_product');

			$result = $this->model_product->getProduct($id);

			if ($result){

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
				$data['name'] = $result->name;
				$data['code'] = $result->code;
				$data['description'] = $result->description;

				if ($this->input->server('REQUEST_METHOD') === 'POST'){

					$this->form_validation->set_rules('code','Código','required|min_length[3]');
					$this->form_validation->set_rules('name','Nome','required|min_length[3]');

					$code = $this->input->post('code');
					$name = $this->input->post('name');
					$description = $this->input->post('description');

					$data['name'] = $name;
					$data['code'] = $code;
					$data['description'] = $description;

					if ($this->form_validation->run() && $id && is_numeric($id)){

						if ($this->model_product->edit($data,$id))
						{

							$this->session->set_flashdata('success','Cadastro atualizado com sucesso !');

						}else{

							$this->session->set_flashdata('error','A atualização falhou, contate o administrador !');

						}
						redirect(site_url('produtos'));
					}
				}


				$data['header'] = $header;
				$data['footer'] = $footer;
				$data['content_top'] = $content_top;
				$data['content_bottom'] = $content_bottom;

				$data['title'] = 'Editando o produto';
				$data['return'] = site_url('produtos');

				$this->load->view('products/form',$data);

			}else{

				$this->index();

			}

		}else{

			redirect(site_url('produtos'));

		}
	}

	public function delete($id=null)
	{

		if (!$this->session->has_userdata('user')){
			redirect(site_url());
		}

		if ($id && is_numeric($id)){

			if ($this->validade($id)==false){
				redirect(site_url('produtos'));
				exit();
			}

			$this->load->model('ProductsModel','model_product');

			if ($this->model_product->remove($id)){

				$this->session->set_flashdata('success','Cadastro excluido com sucesso !');

			}else{

				$this->session->set_flashdata('error','A exclusão falhou, contate o administrador !');

			}

		}

		redirect(site_url('produtos'));

	}

	public function toggle($id=null)
	{

		if (!$this->session->has_userdata('user')){
			redirect(site_url());
		}

		if ($id && is_numeric($id)){

			$this->load->model('ProductsModel','model_product');

			$result = $this->model_product->getProduct($id);

			if ($result){

				if ($result->status){
					$data = array('status'=>0);
				}else{
					$data = array('status'=>1);
				}

				$this->model_product->edit($data,$id);

			}

		}

		redirect(site_url('produtos'));

	}

	public function validade($id=0){

		$return = false;

		$this->load->model('ProductsModel','model_product');
		$result = $this->model_product->getProduct($id);

		if ($result){
			if ($result->status){
				$return = true;
			}
		}

		return $return;

	}

}
