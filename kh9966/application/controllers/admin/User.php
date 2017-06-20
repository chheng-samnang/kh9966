<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class User extends CI_Controller {
	function __construct(){
					parent::__construct();
					$this->pageHeader='User';		
					$this->cancelString = 'admin/User';
					$this->load->model('User_m','um');
					//$this->load->library('Message');
			 }
    public function index()
	{
		echo $this->message->success_msg("fasdfdsf");
		$this->load->view('template/header');
		$this->load->view('template/left');
		$page="admin/User";
		$data['pageHeader'] = $this->pageHeader;
		$data["action_url"]=array(0=>"{$page}/add",1=>"{$page}/edit",3=>"{$page}/change_password");
		$data["tbl_hdr"]=array("User name","User Code","Descr","Type","Status","User create","Date create","User update","Date update");	
		$id="";	
		$row=$this->um->index($id);		
		$i=0;		
		foreach($row as $value):			
			$data["tbl_body"][$i]=array(
										$value->user_name,
										$value->user_code,
										$value->user_desc,
										$value->user_type,										
										$value->user_status==1?'Enable':'Disable',
										$value->user_crea,
										$value->date_crea,
										$value->user_updt,
										$value->date_updt,
										$value->user_id
									);
		    $i=$i+1;
		endforeach;								
		$this->load->view('admin/page_view',$data);
		$this->load->view('template/footer');
    }
    public function add()
	{   
		$row="";
		$option= array('1'=>'Enable','0'=>'Disable');
		$option1=array(''=>'User Type','admin'=>'admin','general'=>'general','editer'=>'editer','super'=>'super');
		$data['ctrl'] = $this->createCtrl($row,$option,$option1);
		$data['action'] = 'admin/User/add';
		$data['pageHeader'] = $this->pageHeader;		
		$data['cancel'] = $this->cancelString;
		if(isset($_POST['btnSubmit']))
		{ 
		   $this->form_validation->set_rules('txtUserCode','User Code','required');
		   $this->form_validation->set_rules('txtUsername','User Name','required');
		   $this->form_validation->set_rules('txtPassword','User Password','required');
		   if($this->form_validation->run()==false){
				$this->load->view('template/header');
				$this->load->view('template/left');
				$this->load->view('admin/page_add',$data);
				$this->load->view('template/footer');
			   }else{
			   	$this->um->user_create();	
				redirect('admin/User');
			   }
		}else
		{
			
			$this->load->view('template/header');
			$this->load->view('template/left');
			$this->load->view('admin/page_add',$data);
			$this->load->view('template/footer');			
		}
	}
	public function edit($id){
		$option = array('1'=>'Enable','0'=>'Disable');
		$option1=array(''=>'User Type','admin'=>'admin','general'=>'general','editer'=>'editer','super'=>'super');
		 if($id!==""){
		 	$row=$this->um->index($id);
		 }
		$data['ctrl'] = $this->createCtrl($row,$option,$option1);
		$data['action'] = "admin/User/edit/{$id}";
		$data['pageHeader'] = $this->pageHeader;		
		$data['cancel'] = $this->cancelString;
		if(isset($_POST['btnSubmit']))
		{
		  $this->um->user_udate($id);
		 redirect('admin/User');
		}else
		{	 
			$this->load->view('template/header');
			$this->load->view('template/left');
			$this->load->view('admin/page_edit',$data);
			$this->load->view('template/footer');
		}
	}
	public function createCtrl($row,$option,$option1)
		{			
		if($row!==""){
				foreach ($row as  $value) {
				$value_1=$value->user_code;	 	
			    $value_2=$value->user_name;
			    $value_3=$value->user_desc;
			    $value_4=$value->user_status;
			    $value_5=$value->user_id;
			    }
			    $ctrl = array( 
							array(
									'type'=>'text',
									'name'=>'txtUsercode',
									'id'=>'txtUserCode',
									'placeholder'=>'Enter user code here...',
									'class'=>'form-control',
									'label'=>'USer Code',
									'value'=>$value_1?$value_1:NULL,
									'required'=>'',
								),
							array(
									'type'=>'text',
									'name'=>'txtUsername',
									'id'=>'txtUsername',
									'placeholder'=>'Enter user name here...',
									'class'=>'form-control',
									'label'=>'User Name',
									'value'=>$value_2?$value_2:NULL
								),
							array(
									'type'=>'dropdown',
									'name'=>'ddlStatus',
									'option'=>$option,
									'selected'=>$value_4,
									'class'=>'class="form-control"',
									'label'=>'Status'
								),
							array(
									'type'=>'textarea',
									'name'=>'txtDesc',
									'class'=>'form-control',
									'label'=>'Description',
									'value'=>$value_3?$value_3:NULL
								)
							
				);
			}else
			{
		        $ctrl = array(
					array(
							'type'=>'text',
							'name'=>'txtUserCode',
							'id'=>'txtUserCode',
							'placeholder'=>'Enter user code here...',
							'class'=>'form-control',
							'label'=>'USer Code',
							'required'=>'',
						),
					array(
							'type'=>'text',
							'name'=>'txtUsername',
							'id'=>'txtUsername',
							'placeholder'=>'Enter user name here...',
							'class'=>'form-control',
							'label'=>'User Name',
						),
					array(
						'type'=>'password',
						'name'=>'txtPassword',
						'id'=>'txtPassword',
						'placeholder'=>'Enter password here...',
						'class'=>'form-control',
						'label'=>'Password'
					),
					array(
						'type'=>'password',
						'name'=>'txtConfirm',
						'id'=>'txtConfirm',
						'placeholder'=>'confirm password here...',
						'class'=>'form-control',
						'label'=>'comfirm Password'
					),
					array(
							'type'=>'dropdown',
							'name'=>'txtUsertype',
							'option'=>$option1,
							'class'=>'class="form-control"',
							'label'=>'User Type'
						),
					array(
							'type'=>'dropdown',
							'name'=>'ddlStatus',
							'option'=>$option,
							'class'=>'class="form-control"',
							'label'=>'Status'
						),
					array(
							'type'=>'textarea',
							'name'=>'txtDesc',
							'class'=>'form-control',
							'label'=>'Description',
						)
					);
				}
			return $ctrl;
		}
	public function delete($id){
     if($id!==""){
     	 $this->um->delete($id);
     	 redirect('admin/');
     	}
	}

	public function change_password($id){
		$data['option'] = array('1'=>'Enable','0'=>'Disable');
		$row=$this->um->index($id);
		foreach ($row as  $value) {
		}
		$user_passwd=$value->user_pass;
		$data['ctrl'] = $this->changeCtrl();
		$data['action'] = "index.php/admin/User/change_password/{$id}";
		$data['pageHeader'] = $this->pageHeader;		
		$data['cancel'] = $this->cancelString;
		if(isset($_POST['btnSubmit']))
		{	
			$this->form_validation->set_rules('txtPasswd','Password','required');
			$this->form_validation->set_rules('txtNewPassword','New Password','required');
			$this->form_validation->set_rules('txtConfirm','Comfirm Password','required');
			if($this->form_validation->run()==false){	
			$this->load->view('template/header');
			$this->load->view('template/left');
			$this->load->view('admin/change_passwd',$data);  	  
			}else
			{	
				echo $user_passwd;	
				echo "<br>";			
				echo do_hash($this->input->post('txtPasswd'));
				if($user_passwd==do_hash($this->input->post('txtPasswd'))){
			      $this->um->updatePassword($id);
				  redirect('index.php/admin/User');
				}else{
					 //redirect('index.php/admin/User/change_password');
				}
			}
		}else
		{	 
			$this->load->view('template/header');
			$this->load->view('template/left');
			$this->load->view('admin/change_passwd',$data);  
		}
	}
	public function changeCtrl()
		{			
			    $ctrl = array(
			    			array(
									'type'=>'password',
									'name'=>'txtPasswd',
									'id'=>'txtpasswd',
									'placeholder'=>'Enter Password...',
									'class'=>'form-control',
									'label'=>'New Password',
									'required'=>''
								), 
							array(
									'type'=>'password',
									'name'=>'txtNewPassword',
									'id'=>'txtNewPassword',
									'placeholder'=>'Enter password here...',
									'class'=>'form-control',
									'label'=>'New Password',
									'required'=>''
								),
							array(
									'type'=>'password',
									'name'=>'txtConfirm',
									'id'=>'txtConfirm',
									'placeholder'=>'Password here...',
									'class'=>'form-control',
									'label'=>'Confirm',
									'required'=>''
								)
				);
				return $ctrl;
		}
	function logout()
	{
		session_destroy();
		$data['msg'] = 'This user has been logout successfully.';	
		$this->load->view('template/login',$data);
	}
}
