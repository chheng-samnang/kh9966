<?php
class Account_c extends CI_Controller
{
	var $pageHeader,$page_redirect;	
	public function __construct()
	{
		parent::__construct();
		$this->pageHeader='Account';
		$this->page_redirect="admin/account_c";								
		$this->load->model("account_m");
	}
	public function index()
	{		
		$this->load->view('template/header');
		$this->load->view('template/left');		
		$data['pageHeader'] = $this->pageHeader;
		$data["action_url"]=array(0=>"{$this->page_redirect}/add",1=>"{$this->page_redirect}/edit",/*2=>"{$this->page_redirect}/delete"*/3=>"{$this->page_redirect}/change_password");							
		$data["tbl_hdr"]=array("account code","account name","Entity","photo","account status","User create","Date create","User update","Date update");		
		$row=$this->account_m->index();		
		$i=0;
		if($row==TRUE)
		{
			foreach($row as $value):
			$data["tbl_body"][$i]=array(
										"<a href=".base_url($this->page_redirect.'/account_detail/'.$value->acc_id)." title='Account Detail'>".$value->acc_code."</a>",																														
										$value->acc_name,
										$value->acc_company,
										"<img class='img-thumbnail' src='".base_url("assets/uploads/".$value->acc_photo)."' style='width:70px;' />",																				
										$value->acc_status=='1'?'Enable':'Disable',																														
										$value->user_crea,
										date("d-m-Y",strtotime($value->date_crea)),							
										$value->user_updt,
										$value->date_updt==NULL?NULL:date("d-m-Y",strtotime($value->date_updt)),
										$value->acc_id
									);
			$i=$i+1;
		endforeach;
		}											
		$this->load->view('admin/page_view',$data);
		$this->load->view('template/footer');
	}
	public function account_code()
	{
		$row=$this->account_m->account_code();
		if($row==TRUE){return $row->acc_code;}
		
	}
	public function account_detail($id="")
	{
		$data["detail"]=$this->account_m->index($id);		
		$data['cancel'] = $this->page_redirect;
		$this->load->view('template/header');
		$this->load->view('template/left');		
		$this->load->view('admin/account_detail.php',$data);
		$this->load->view('template/footer');	
	}
	public function validation()
	{	
		$this->form_validation->set_rules('txtCompany','Company','trim|required');			
		$this->form_validation->set_rules('txtAccName','Account Name','trim|required');
		$this->form_validation->set_rules('txtAccPass','Account Password','required|min_length[6]|max_length[8]');
		$this->form_validation->set_rules('txtConfirmPass','Confirm Password','required|matches[txtAccPass]');
		$this->form_validation->set_rules('txtEmail','Email','trim|valid_email|required');
		$this->form_validation->set_rules('txtPhone','Phone','trim|required|regex_match[/^[0-9\-\+]{9,15}+$/]');							
		if($this->form_validation->run()==TRUE){return TRUE;}
		else{return FALSE;}
	}
	public function validation1()
	{	
		$this->form_validation->set_rules('txtCompany','Company','trim|required');			
		$this->form_validation->set_rules('txtAccName','Account Name','trim|required');		
		$this->form_validation->set_rules('txtEmail','Email','trim|valid_email|required');
		$this->form_validation->set_rules('txtPhone','Phone','trim|required|regex_match[/^[0-9\-\+]{9,15}+$/]');								
		if($this->form_validation->run()==TRUE){return TRUE;}
		else{return FALSE;}
	}
	public function validation2()
	{		
		$this->form_validation->set_rules('txtOldAccPass','Old Account Password','required|min_length[6]|max_length[8]');		
		$this->form_validation->set_rules('txtAccPass','Account Password','required|min_length[6]|max_length[8]');
		$this->form_validation->set_rules('txtConfirmPass','Confirm Password','required|matches[txtAccPass]');		
		if($this->form_validation->run()==TRUE){return TRUE;}
		else{return FALSE;}
	}	
	public function add()
	{										
		$option1= array('1'=>'Enable','0'=>'Disable');
		$option2= array(''=>'Choose one','individual'=>'Individual','company'=>'Company','recruitment_agency'=>'Recruitment agency','government'=>'Government','Other'=>'Other');																																		
		$data['ctrl'] = $this->createCtrl($row="",$option1,$option2,$this->account_code());		
		$data['action'] = "{$this->page_redirect}/add_value";
		$data['pageHeader'] = $this->pageHeader;		
		$data['cancel'] = $this->page_redirect;
		$this->load->view('template/header');
		$this->load->view('template/left');
		$this->load->view('admin/page_add',$data);
		$this->load->view('template/footer');		
	}
	public function add_value()
	{
		if(isset($_POST["btnSubmit"]))
		{
			
			if($this->validation()==TRUE)
				{									
					$row=$this->account_m->add();															              
	                if($row==TRUE)
	                {	                		                	
						redirect("{$this->page_redirect}/");	
	                }	                                																			
				}
			else{$this->add();}		
		}
	}
	public function edit($id="")
	{		
		if($id!="")
		{
			$row=$this->account_m->index($id);			
			if($row==TRUE)
			{	
				$option1= array('1'=>'Enable','0'=>'Disable');
				$option2= array(''=>'Choose one','individual'=>'Individual','company'=>'Company','recruitment_agency'=>'Recruitment agency','government'=>'Government','Other'=>'Other');																																		
				$data['ctrl'] = $this->createCtrl1($row,$option1,$option2,$this->account_code());			
				$data['action'] = "{$this->page_redirect}/edit_value/{$id}";
				$data['pageHeader'] = $this->pageHeader;		
				$data['cancel'] = $this->page_redirect;
				$this->load->view('template/header');
				$this->load->view('template/left');
				$this->load->view("admin/page_edit",$data);
				$this->load->view('template/footer');
			}
		}
		else{return FALSE;}
	}
	public function edit_value($id="")
	{		
		if(isset($_POST["btnSubmit"]))
		{					
			if($this->validation1()==TRUE)
			{	
				$row=$this->account_m->edit($id);	
				if($row==TRUE)
	            {	                		                	
					redirect("{$this->page_redirect}/");	
	            }																												 																				            	                	                                												
			}
			else 
			{	
				$this->edit($id);													
			}			
		}
	}	

	public function delete($id="")
	{
		if($id!="")
		{
			$row=$this->account_m->delete($id);
			if($row==TRUE){redirect("{$this->page_redirect}/");}
		}
		else{return FALSE;}
	}
	public function change_password($id="")
	{																														
		$data['ctrl'] = $this->createCtrl2();			
		$data['action'] = "{$this->page_redirect}/change_passworded/{$id}";
		$data['pageHeader'] = $this->pageHeader;		
		$data['cancel'] = $this->page_redirect;
		$this->load->view('template/header');
		$this->load->view('template/left');
		$this->load->view("admin/page_edit",$data);
		$this->load->view('template/footer');
	}
	public function change_passworded($id="")
	{
		if(isset($_POST["btnSubmit"]))
		{						
			if($this->validation2()==TRUE)
			{	
				$row=$this->account_m->change_password($id);	
				if($row==TRUE)
	            {	                		                	
					redirect("{$this->page_redirect}/");	
	            }
	            else
	            	{
	            		$data['ctrl'] = $this->createCtrl2();			
						$data['action'] = "{$this->page_redirect}/change_passworded/{$id}";
						$data['pageHeader'] = $this->pageHeader;		
						$data['cancel'] = $this->page_redirect;
						$data['error']="Your old account password is not mutch!";
						$this->load->view('template/header');
						$this->load->view('template/left');
						$this->load->view("admin/page_edit",$data);
						$this->load->view('template/footer');	            		
	            	}																												 																				            	                	                                												
			}
			else 
			{	
				$this->change_password($id);													
			}			
		}
	}
	public function createCtrl($row="",$option1,$option2,$acc_code="")
		{
			$acc_code1=substr($acc_code,3);
			if($row!="")
			{			
					$row1=$row->acc_code;
					$row2=$row->acc_name;
					$row3=$row->acc_company;
					$row4=$row->acc_pass;					
					$row6=$row->acc_email;																																					
					$row7=$row->acc_phone;
					$row8=$row->acc_website;					
					$row10=$row->acc_status;
					$row11=$row->acc_photo;
					$row12=$row->acc_addr;
					$row13=$row->acc_desc;					
			}											
			//$ctrl = array();
			$ctrl = array(							
							array(
									'type'=>'text',
									'name'=>'txtAccCode',
									'id'=>'txtAccCode',
									'value'=>$acc_code1!=''?'KJ-'.str_pad($acc_code1+1, 6, "0", STR_PAD_LEFT):'KJ-'.str_pad(1, 6, "0", STR_PAD_LEFT),																											
									'placeholder'=>'Enter Account code here...',									
									'class'=>'form-control',
									'label'=>'Account code',
									'readonly'=>'readonly'																								
								),
							array(
									'type'=>'text',
									'name'=>'txtAccName',
									'id'=>'txtAccName',									
									'value'=>$row==""? set_value("txtAccName") : $row2,					
									'placeholder'=>'Enter Account name here...',									
									'class'=>'form-control',
									'label'=>'Account name'																								
								),
							array(
									'type'=>'dropdown',
									'name'=>'txtCompany',
									'option'=>$option2,
									'selected'=>$row==""? NULL : $row3,																		
									'class'=>'class="form-control"',
									'label'=>'Entity'
								),													
							array(
									'type'=>'password',
									'name'=>'txtAccPass',
									'id'=>'txtAccPass',									
									'value'=>$row==""? set_value("txtAccPass") : $row4,					
									'placeholder'=>'Enter Account password here...',									
									'class'=>'form-control',
									'label'=>'Account password',																		
								),
							array(
									'type'=>'password',
									'name'=>'txtConfirmPass',
									'id'=>'txtConfirmPass',									
									'value'=>$row==""? set_value("txtConfirmPass") : $row4,					
									'placeholder'=>'Enter Confirm password here...',									
									'class'=>'form-control',
									'label'=>'Confirm password',																																
								),							
							array(
									'type'=>'text',
									'name'=>'txtEmail',
									'id'=>'txtEmail',									
									'value'=>$row==""? set_value("txtEmail") : $row6,					
									'placeholder'=>'Enter Email here...',									
									'class'=>'form-control',
									'label'=>'Email'																							
								),
							array(
									'type'=>'text',
									'name'=>'txtPhone',
									'id'=>'txtPhone',									
									'value'=>$row==""? set_value("txtPhone") : $row7,					
									'placeholder'=>'Enter Phone here...',									
									'class'=>'form-control',
									'label'=>'Phone'																							
								),
							array(
									'type'=>'text',
									'name'=>'txtWebsite',
									'id'=>'txtWebsite',									
									'value'=>$row==""? set_value("txtWebsite") : $row8,					
									'placeholder'=>'Enter Website here...',									
									'class'=>'form-control',
									'label'=>'Website'																							
								),														
							array(
									'type'=>'dropdown',
									'name'=>'ddlStatus',
									'option'=>$option1,
									'selected'=>$row==""? NULL : $row10,									
									'class'=>'class="form-control"',
									'label'=>'Status'
								),
							array(
									'type'=>'upload',
									'name'=>'txtUpload',
									'id'=>'txtUpload',
									'value'=>$row==""? set_value("txtUpload") : $row11,																		
									'class'=>'form-control',
									'label'=>'Chose Image',
									"img"=>$row==""? set_value("txtUpload") :"<img class='img-thumbnail' src='".base_url("assets/uploads/".$row11)."' style='width:70px;' />",										
								),
							array(
									'type'=>'textarea',
									'name'=>'txtAddr',
									'value'=>$row==""? set_value("txtAddr") : $row12,
									'label'=>'Address'
								),																				
							array(
									'type'=>'textarea',
									'name'=>'txtDesc',
									'value'=>$row==""? set_value("txtDesc") : $row13,
									'label'=>'About Me'
								),														
							);
			return $ctrl;
		}
	public function createCtrl1($row="",$option1,$option2,$acc_code="")
		{	
			if($row!="")
			{			
					$row1=$row->acc_code;
					$row2=$row->acc_name;
					$row3=$row->acc_company;
					//$row4=$row->acc_pass;					
					$row6=$row->acc_email;																																					
					$row7=$row->acc_phone;
					$row8=$row->acc_website;
					
					$row10=$row->acc_status;
					$row11=$row->acc_photo;
					$row12=$row->acc_addr;
					$row13=$row->acc_desc;					
			}											
			//$ctrl = array();
			$ctrl = array(							
							array(
									'type'=>'text',
									'name'=>'txtAccCode',
									'id'=>'txtAccCode',									
									'value'=>$row1,					
									'placeholder'=>'Enter Account code here...',									
									'class'=>'form-control',
									'label'=>'Account code',
									'readonly'=>'readonly'																								
								),
							array(
									'type'=>'text',
									'name'=>'txtAccName',
									'id'=>'txtAccName',									
									'value'=>$row==""? set_value("txtAccName") : $row2,					
									'placeholder'=>'Enter Account name here...',									
									'class'=>'form-control',
									'label'=>'Account name'																								
								),
							array(
									'type'=>'dropdown',
									'name'=>'txtCompany',
									'option'=>$option2,
									'selected'=>$row==""? NULL : $row3,																		
									'class'=>'class="form-control"',
									'label'=>'Entity'
								),																					
							array(
									'type'=>'text',
									'name'=>'txtEmail',
									'id'=>'txtEmail',									
									'value'=>$row==""? set_value("txtEmail") : $row6,					
									'placeholder'=>'Enter Email here...',									
									'class'=>'form-control',
									'label'=>'Email'																							
								),
							array(
									'type'=>'text',
									'name'=>'txtPhone',
									'id'=>'txtPhone',									
									'value'=>$row==""? set_value("txtPhone") : $row7,					
									'placeholder'=>'Enter Phone here...',									
									'class'=>'form-control',
									'label'=>'Phone'																							
								),
							array(
									'type'=>'text',
									'name'=>'txtWebsite',
									'id'=>'txtWebsite',									
									'value'=>$row==""? set_value("txtWebsite") : $row8,					
									'placeholder'=>'Enter Website here...',									
									'class'=>'form-control',
									'label'=>'Website'																							
								),														
							array(
									'type'=>'dropdown',
									'name'=>'ddlStatus',
									'option'=>$option1,
									'selected'=>$row==""? NULL : $row10,									
									'class'=>'class="form-control"',
									'label'=>'Status'
								),
							array(
									'type'=>'upload',
									'name'=>'txtUpload',
									'id'=>'txtUpload',
									'value'=>$row==""? set_value("txtUpload") : $row11,																		
									'class'=>'form-control',
									'label'=>'Chose Image',
									"img"=>$row==""? set_value("txtUpload") :"<img class='img-thumbnail' src='".base_url("assets/uploads/".$row11)."' style='width:70px;' />",										
								),
							array(
									'type'=>'textarea',
									'name'=>'txtAddr',
									'value'=>$row==""? set_value("txtAddr") : $row12,
									'label'=>'Address'
								),																				
							array(
									'type'=>'textarea',
									'name'=>'txtDesc',
									'value'=>$row==""? set_value("txtDesc") : $row13,
									'label'=>'About Me'
								),														
							);
			return $ctrl;
		}
	public function createCtrl2()
		{															
			//$ctrl = array();
			$ctrl = array(							
							array(
									'type'=>'password',
									'name'=>'txtOldAccPass',
									'id'=>'txtOldAccPass',									
									'value'=>set_value("txtOldAccPass"),					
									'placeholder'=>'Enter Old password here...',									
									'class'=>'form-control',
									'label'=>'Old Account password',																		
								),
							array(
									'type'=>'password',
									'name'=>'txtAccPass',
									'id'=>'txtAccPass',									
									'value'=>set_value("txtAccPass"),					
									'placeholder'=>'Enter Account password here...',									
									'class'=>'form-control',
									'label'=>'Account password',																		
								),
							array(
									'type'=>'password',
									'name'=>'txtConfirmPass',
									'id'=>'txtConfirmPass',									
									'value'=>set_value("txtConfirmPass"),					
									'placeholder'=>'Enter Confirm password here...',									
									'class'=>'form-control',
									'label'=>'Confirm password',																													
								),																					
							);
			return $ctrl;
		}
}
?>