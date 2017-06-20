<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Login_m','lm');
		$this->load->helper('security');
	}
	public function index()
	{   
		$this->form_validation->set_rules('txtUsername','User Name','required');
		$this->form_validation->set_rules('txtPass','Password','required');
		if($this->form_validation->run()==false)
		{
			$data["msg"] = "";
			$this->load->view('template/login',$data);
		}else
		{//do_hash
			$username = $this->input->post('txtUsername');
			$pass = $this->input->post('txtPass');
			$result = $this->lm->validateUser($username);
			if($result==0)
			{
				$data["msg"] = "Incorrect Username";
				$this->load->view('template/login',$data);	
			}else
			{
				$result = $this->lm->validatePassword($pass);
				if($result!=0)
				{
					$this->session->userLogin = $username;
					redirect("admin/Main");
					exit;
				}else
				{
					$data['msg'] = "Incorrect Password!!!";
					$this->load->view("template/login",$data);
				}
			}
		}		
	}
}
