<?php
class Contact_us_c extends CI_Controller
{
	var $pageHeader,$page_redirect;	
	public function __construct()
	{
		parent::__construct();
		$this->pageHeader='Contact us';
		$this->page_redirect="admin/contact_us_c";								
		$this->load->model("contact_us_m");
	}
	public function index()
	{		
		$this->load->view('template/header');
		$this->load->view('template/left');		
		$data['pageHeader'] = $this->pageHeader;
		$data["action_url"]=array(0=>"{$this->page_redirect}/add",1=>"{$this->page_redirect}/edit",2=>"{$this->page_redirect}/delete"/*,"{$this->page_redirect}/change_password"*/);							
		$data["tbl_hdr"]=array("Phone1","Email","User create","Date create","User update","Date update");		
		$row=$this->contact_us_m->index();		
		$i=0;
		if($row==TRUE)
		{
			foreach($row as $value):
			$data["tbl_body"][$i]=array(
										"<a href=".base_url($this->page_redirect.'/contact_us_detail/'.$value->cnt_us_id)." title='Contact us Detail'>".$value->phone1."</a>",										
										$value->email,																														
										$value->user_crea,
										date("d-m-Y",strtotime($value->date_crea)),							
										$value->user_updt,
										$value->date_updt==NULL?NULL:date("d-m-Y",strtotime($value->date_updt)),
										$value->cnt_us_id
									);
			$i=$i+1;
		endforeach;
		}											
		$this->load->view('admin/page_view',$data);
		$this->load->view('template/footer');
	}
	public function contact_us_detail($id="")
	{
		$data["detail"]=$this->contact_us_m->index($id);		
		$data['cancel'] = $this->page_redirect;
		$this->load->view('template/header');
		$this->load->view('template/left');		
		$this->load->view('admin/contact_us_detail.php',$data);
		$this->load->view('template/footer');	
	}
	public function validation()
	{		
		$this->form_validation->set_rules('txtPhone1','Phone1','trim|required|regex_match[/^[0-9\-\+]{9,15}+$/]');
		$this->form_validation->set_rules('txtPhone2','Phone2','trim|regex_match[/^[0-9\-\+]{9,15}+$/]');
		$this->form_validation->set_rules('txtPhone3','Phone3','trim|regex_match[/^[0-9\-\+]{9,15}+$/]');
		$this->form_validation->set_rules('txtEmail','Email','trim|required|valid_email');
		$this->form_validation->set_rules('txtAddr','Address','trim|required');		
		if($this->form_validation->run()==TRUE){return TRUE;}
		else{return FALSE;}
	}	
	public function add()
	{						
		$data['ctrl'] = $this->createCtrl($row="");		
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
					$row=$this->contact_us_m->add();															              
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
			$row=$this->contact_us_m->index($id);			
			if($row==TRUE)
			{																														
				$data['ctrl'] = $this->createCtrl($row);			
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
			if($this->validation()==TRUE)
			{	
				$row=$this->contact_us_m->edit($id);	
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
			$row=$this->contact_us_m->delete($id);
			if($row==TRUE){redirect("{$this->page_redirect}/");}
		}
		else{return FALSE;}
	}
	public function createCtrl($row="")
		{	
			if($row!="")
			{			
					$row1=$row->phone1;
					$row2=$row->phone2;
					$row3=$row->phone3;
					$row4=$row->email;					
					$row5=$row->fb_messager;
					$row6=$row->whatApp;
					$row7=$row->line;
					$row8=$row->viber;
					$row9=$row->addr;																															
			}											
			//$ctrl = array();
			$ctrl = array(
							array(
									'type'=>'text',
									'name'=>'txtPhone1',
									'id'=>'txtPhone1',									
									'value'=>$row==""? set_value("txtPhone1") : $row1,					
									'placeholder'=>'Enter Phone1 here...',									
									'class'=>'form-control',
									'label'=>'Phone1'																								
								),
							array(
									'type'=>'text',
									'name'=>'txtPhone2',
									'id'=>'txtPhone2',									
									'value'=>$row==""? set_value("txtPhone2") : $row2,					
									'placeholder'=>'Enter Phone2 here...',									
									'class'=>'form-control',
									'label'=>'Phone2'																								
								),
							array(
									'type'=>'text',
									'name'=>'txtPhone3',
									'id'=>'txtPhone3',									
									'value'=>$row==""? set_value("txtPhone3") : $row3,					
									'placeholder'=>'Enter Phone3 here...',									
									'class'=>'form-control',
									'label'=>'Phone3'																								
								),
							array(
									'type'=>'text',
									'name'=>'txtEmail',
									'id'=>'txtEmail',									
									'value'=>$row==""? set_value("txtEmail") : $row4,					
									'placeholder'=>'Enter Email here...',									
									'class'=>'form-control',
									'label'=>'Email'																								
								),
							array(
								'type'=>'text',
								'name'=>'txtFbMessager',
								'id'=>'txtFbMessager',									
								'value'=>$row==""? set_value("txtFbMessager") : $row5,					
								'placeholder'=>'Enter Facebook Messager here...',									
								'class'=>'form-control',
								'label'=>'Facebook Messager'																								
							),
							array(
								'type'=>'text',
								'name'=>'txtWatApp',
								'id'=>'txtWatApp',									
								'value'=>$row==""? set_value("txtWatApp") : $row6,					
								'placeholder'=>'Enter WatApp here...',									
								'class'=>'form-control',
								'label'=>'WhatApp'																								
							),
							array(
								'type'=>'text',
								'name'=>'txtLine',
								'id'=>'txtLine',									
								'value'=>$row==""? set_value("txtLine") : $row7,					
								'placeholder'=>'Enter Line here...',									
								'class'=>'form-control',
								'label'=>'Line'																								
							),
							array(
								'type'=>'text',
								'name'=>'txtViber',
								'id'=>'txtViber',									
								'value'=>$row==""? set_value("txtViber") : $row8,					
								'placeholder'=>'Enter Viber here...',									
								'class'=>'form-control',
								'label'=>'Viber'																								
							),																																																						
							array(
									'type'=>'textarea',
									'name'=>'txtAddr',
									'value'=>$row==""? set_value("txtAddr") : $row9,
									'label'=>'Address'
								),							
							);
			return $ctrl;
		}
}
?>