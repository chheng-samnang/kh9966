<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/
class Planeticket extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		//$this->load->model('main_m');
	}
	function index()
	{		
		//$data['acc']=$this->main_m->account();
		$this->load->view('template_frontend/header');
		$this->load->view('template_frontend/nav');		
		$this->load->view('Planeticket');
		$this->load->view('template_frontend/footer');
	}
}
?>