<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CustomersController extends CI_Controller {


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

		$this->load->model("CustomersModel", "customers");
		$result = $this->customers->getCustomers();

		$data['toggle'] = site_url('colaboradores-fornecedores/modificar/');
		$data['add'] = site_url('colaboradores-fornecedores/cadastrar');
		$data['edit'] = site_url('colaboradores-fornecedores/editar/');
		$data['delete'] = site_url('colaboradores-fornecedores/deletar/');

		$data['customers'] = $result;

		$this->load->view('customers/list',$data);
	}

	public function add()
	{
		if (!$this->session->has_userdata('user')){
			redirect(site_url());
		}

		$name = '';
		$email = '';
		$telephone = '';
		$cellphone = '';
		$borndate = '';
		$comments = '';
		$type = '';
		$addresses = '';
		$validate_fornecedores = true;

		if ($this->input->server('REQUEST_METHOD') === 'POST'){

			$name = $this->input->post('name');
			$email = $this->input->post('email');
			$telephone = $this->input->post('telephone');
			$cellphone = $this->input->post('cellphone');
			$borndate = $this->input->post('borndate');
			$comments = $this->input->post('comments');
			$type = $this->input->post('type');
			$addresses = $this->input->post('addresses');

			$this->form_validation->set_rules('name','Nome','required|min_length[3]');
			$this->form_validation->set_rules('email','E-mail','required|is_unique[customers.email]|valid_email');

			if (isset($addresses['zipcode']) == false){
				$this->session->set_flashdata('error','Fornecedores devem ter ao menos 2 endereços !');
				$validate_fornecedores = false;
			}

			if ($type==2 && count($addresses['zipcode']) < 2 ){
				$this->session->set_flashdata('error','Fornecedores devem ter ao menos 2 endereços !');
				$validate_fornecedores = false;
			}

			if (isset($addresses) && is_array($addresses)){
				foreach ($addresses['zipcode'] as $index => $address){
					$this->form_validation->set_rules("addresses[zipcode][{$index}]", 'CEP', 'required');
					$this->form_validation->set_rules("addresses[address][{$index}]", 'Endereço', 'required');
					$this->form_validation->set_rules("addresses[number][{$index}]", 'Número', 'required');
					$this->form_validation->set_rules("addresses[district][{$index}]", 'Bairro', 'required');
					$this->form_validation->set_rules("addresses[city][{$index}]", 'Cidade', 'required');
					$this->form_validation->set_rules("addresses[state][{$index}]", 'Estado', 'required');
				}
			}

			if ($this->form_validation->run() && $validate_fornecedores){

				$data = array();
				$data['name'] = $name;
				$data['email'] = $email;
				$data['telephone']= $telephone;
				$data['cellphone'] = $cellphone;
				$data['borndate'] = $borndate;
				$data['comments'] = $comments;
				$data['type'] = $type;

				$this->load->model('CustomersModel','model_customer');
				$customer_id = $this->model_customer->add($data);

				if ($customer_id){
					if (isset($addresses) && is_array($addresses)){

						$this->load->model('AddressesModel','model_addresses');

						foreach ($addresses['zipcode'] as $index => $address){

							$data = array();
							$data['customer_id'] = $customer_id;
							$data['zipcode'] = $addresses['zipcode'][$index];
							$data['address'] = $addresses['address'][$index];
							$data['number'] = $addresses['number'][$index];
							$data['complement'] = $addresses['complement'][$index];
							$data['district'] = $addresses['district'][$index];
							$data['city'] = $addresses['city'][$index];
							$data['state'] = $addresses['state'][$index];

							$this->model_addresses->add($data);
						}
					}

					$this->session->set_flashdata('success','Cadastro efetuado com sucesso !');

				}else{

					$this->session->set_flashdata('error','O cadastro falhou, contate o administrador !');

				}




				redirect(site_url('colaboradores-fornecedores'));
			}
		}

		$data = array();
		$data['canonical'] = site_url();
		$data['styles'] = array(base_url('assets/css/dashboard.css'));
		$header = $this->load->view('common/header', $data, TRUE);

		$data = array();
		$data['scripts'] = array(base_url('assets/js/dashboard.js'));
		$data['scripts'] = array(base_url('assets/js/customers.js'));
		$footer = $this->load->view('common/footer', $data, TRUE);

		$data = array();
		$data['user_name'] = $this->session->user;
		$data['logout'] = site_url('sair');
		$content_top = $this->load->view('common/content_top', $data, TRUE);
		$content_bottom = $this->load->view('common/content_bottom', '', TRUE);

		$data = array();
		$data['name'] = $name;
		$data['email'] = $email;
		$data['telephone'] = $telephone;
		$data['cellphone'] = $cellphone;
		$data['borndate'] = $borndate;
		$data['comments'] = $comments;
		$data['type'] = $type;
		$data['addresses'] = $addresses;

		$data['header'] = $header;
		$data['footer'] = $footer;
		$data['content_top'] = $content_top;
		$data['content_bottom'] = $content_bottom;

		$data['title'] = 'Cadastro de colaboradores / fornecedores';
		$data['return'] = site_url('colaboradores-fornecedores');

		$this->load->view('customers/form',$data);
	}

	public function edit($id=null)
	{
		if (!$this->session->has_userdata('user')){
			redirect(site_url());
		}
		$addresses = array();

		if ($id && is_numeric($id)){

			if ($this->validade($id)==false){
				redirect(site_url('colaboradores-fornecedores'));
				exit();
			}

			$this->load->model('CustomersModel','model_customer');
			$this->load->model('AddressesModel','model_addresses');

			$result = $this->model_customer->getCustomer($id);
			$query = $this->model_addresses->getAddressByCustomer($id);
			$validate_fornecedores = true;

			if ($result){

				if (isset($query) && is_array($query)){
					foreach ($query as $index => $row){

						$addresses['zipcode'][$index] = $row->zipcode;
						$addresses['address'][$index] = $row->address;
						$addresses['number'][$index] = $row->number;
						$addresses['complement'][$index] = $row->complement;
						$addresses['district'][$index] = $row->district;
						$addresses['city'][$index] = $row->city;
						$addresses['state'][$index] = $row->state;

					}
				}


				$data['canonical'] = site_url();
				$data['styles'] = array(base_url('assets/css/dashboard.css'));
				$header = $this->load->view('common/header', $data, TRUE);

				$data = array();
				$data['scripts'] = array(base_url('assets/js/dashboard.js'));
				$data['scripts'] = array(base_url('assets/js/customers.js'));
				$footer = $this->load->view('common/footer', $data, TRUE);

				$data = array();
				$data['user_name'] = $this->session->user;
				$data['logout'] = site_url('sair');
				$content_top = $this->load->view('common/content_top', $data, TRUE);
				$content_bottom = $this->load->view('common/content_bottom', '', TRUE);

				$data = array();
				$data['name'] = $result->name;
				$data['email'] = $result->email;
				$data['telephone'] = $result->telephone;
				$data['cellphone'] = $result->cellphone;
				$data['borndate'] = $result->borndate;
				$data['comments'] = $result->comments;
				$data['type'] = $result->type;


				if ($this->input->server('REQUEST_METHOD') === 'POST'){

					$this->form_validation->set_rules('name','Nome','required|min_length[3]');
					if ($data['email']==$this->input->post('email')){
						$this->form_validation->set_rules('email','E-mail','required|valid_email');
					}else{
						$this->form_validation->set_rules('email','E-mail','required|is_unique[customers.email]|valid_email');
					}

					if (isset($addresses) && is_array($addresses)){
						foreach ($addresses['zipcode'] as $index => $address){
							$this->form_validation->set_rules("addresses[zipcode][{$index}]", 'CEP', 'required');
							$this->form_validation->set_rules("addresses[address][{$index}]", 'Endereço', 'required');
							$this->form_validation->set_rules("addresses[number][{$index}]", 'Número', 'required');
							$this->form_validation->set_rules("addresses[district][{$index}]", 'Bairro', 'required');
							$this->form_validation->set_rules("addresses[city][{$index}]", 'Cidade', 'required');
							$this->form_validation->set_rules("addresses[state][{$index}]", 'Estado', 'required');
						}
					}

					$data['name'] = $this->input->post('name');
					$data['email'] = $this->input->post('email');
					$data['telephone'] = $this->input->post('telephone');
					$data['cellphone'] = $this->input->post('cellphone');
					$data['borndate'] = $this->input->post('borndate');
					$data['comments'] = $this->input->post('comments');
					$data['type'] = $this->input->post('type');
					$addresses = $this->input->post('addresses');

					if ($data['type']==2 && count($addresses['zipcode']) < 2 ){
						$this->session->set_flashdata('error','Fornecedores devem ter ao menos 2 endereços !');
						$validate_fornecedores = false;
					}

					if ($this->form_validation->run() && $validate_fornecedores){


						if ($this->model_customer->edit($data,$id))
						{
							if (isset($addresses) && is_array($addresses)){
								$this->model_addresses->removeByCustomer($id);
								foreach ($addresses['zipcode'] as $index => $address){

									$data = array();
									$data['customer_id'] = $id;
									$data['zipcode'] = $addresses['zipcode'][$index];
									$data['address'] = $addresses['address'][$index];
									$data['number'] = $addresses['number'][$index];
									$data['complement'] = $addresses['complement'][$index];
									$data['district'] = $addresses['district'][$index];
									$data['city'] = $addresses['city'][$index];
									$data['state'] = $addresses['state'][$index];
									$this->model_addresses->add($data);
								}
							}

							$this->session->set_flashdata('success','Cadastro atualizado com sucesso !');

						}else{

							$this->session->set_flashdata('error','A atualização falhou, contate o administrador !');

						}
						redirect(site_url('colaboradores-fornecedores'));
					}
				}


				$data['addresses'] = $addresses;
				$data['header'] = $header;
				$data['footer'] = $footer;
				$data['content_top'] = $content_top;
				$data['content_bottom'] = $content_bottom;

				$data['title'] = 'Editando o colaboradores / fornecedores';
				$data['return'] = site_url('colaboradores-fornecedores');

				$this->load->view('customers/form',$data);

			}else{

				$this->index();

			}

		}else{

			redirect(site_url('colaboradores-fornecedores'));

		}
	}

	public function delete($id=null)
	{

		if (!$this->session->has_userdata('user')){
			redirect(site_url());
		}

		if ($id && is_numeric($id)){

			if ($this->validade($id)==false){
				redirect(site_url('colaboradores-fornecedores'));
				exit();
			}

			$this->load->model('CustomersModel','model_customer');

			if ($this->model_customer->remove($id)){

				$this->load->model('AddressesModel','model_addresses');
				$this->model_addresses->removeByCustomer($id);

				$this->session->set_flashdata('success','Cadastro excluido com sucesso !');

			}else{

				$this->session->set_flashdata('error','A exclusão falhou, contate o administrador !');

			}

		}

		redirect(site_url('colaboradores-fornecedores'));

	}

	public function toggle($id=null)
	{

		if (!$this->session->has_userdata('user')){
			redirect(site_url());
		}

		if ($id && is_numeric($id)){

			$this->load->model('CustomersModel','model_customer');

			$result = $this->model_customer->getCustomer($id);

			if ($result){
				if ($result->type==1){
					if ($result->status){
						$data = array('status'=>0);
					}else{
						$data = array('status'=>1);
					}

					$this->model_customer->edit($data,$id);
				}
			}

		}

		redirect(site_url('colaboradores-fornecedores'));

	}

	public function validade($id=0){

		$return = false;

		$this->load->model('CustomersModel','model_customer');
		$result = $this->model_customer->getCustomer($id);

		if ($result){
			if ($result->status){
				$return = true;
			}
		}

		return $return;

	}

}
