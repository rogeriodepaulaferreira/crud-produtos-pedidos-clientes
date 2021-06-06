<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LoginController extends CI_Controller {


	public function index()
	{

		if ($this->input->server('REQUEST_METHOD') === 'POST'){
			$this->form_validation->set_rules('user','Login','required');
			$this->form_validation->set_rules('pass','Senha','required');

			if ($this->form_validation->run()){

				$user = $this->input->post('user');
				$pass = $this->input->post('pass');
				$this->load->model('LoginModel','model_login');

				if ($this->model_login->login($user,$pass)){

					$session_data = array(
						'user' => $user
					);
					$this->session->set_userdata($session_data);

				}else{

					$this->session->set_flashdata('error','Login ou senha inválido');

				}
			}
		}


		$data = array();
		$data['canonical'] = site_url();
		if ($this->session->has_userdata('user')){
			$data['styles'] = array(base_url('assets/css/dashboard.css'));
		}else{
			$data['styles'] = array(base_url('assets/css/login.css'));
		}

		$header = $this->load->view('common/header', $data, TRUE);

		$data = array();
		if ($this->session->has_userdata('user')){
			$data['scripts'] = array(base_url('assets/js/dashboard.js'));
		}

		$footer = $this->load->view('common/footer', $data, TRUE);

		$data = array();
		$data['user_name'] = $this->session->user;
		$data['logout'] = site_url('sair');
		$content_top = $this->load->view('common/content_top', $data, TRUE);
		$content_bottom = $this->load->view('common/content_bottom', '', TRUE);

		$data = array();
		$data['header'] = $header;
		$data['footer'] = $footer;


		if ($this->session->has_userdata('user')){

			$data['content_top'] = $content_top;
			$data['content_bottom'] = $content_bottom;
			$data['user_name'] = $this->session->user;

			$this->load->view('dashboard',$data);

		}else{
			$this->load->view('login',$data);

		}
	}


	function logout()
	{
		$this->session->unset_userdata('user');
		redirect(base_url());
	}

}
