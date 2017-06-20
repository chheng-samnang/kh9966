<?php
class Location_c extends CI_Controller
{
	var $pageHeader,$page_redirect;	
	public function __construct()
	{
		parent::__construct();
		$this->pageHeader='Location';
		$this->page_redirect="admin/location_c";								
		$this->load->model("location_m");
	}
	public function index()
	{		
		$this->load->view('template/header');
		$this->load->view('template/left');		
		$data['pageHeader'] = $this->pageHeader;
		$data["action_url"]=array(0=>"{$this->page_redirect}/add",1=>"{$this->page_redirect}/edit",2=>"{$this->page_redirect}/delete"/*,"{$this->page_redirect}/change_password"*/);							
		$data["tbl_hdr"]=array("Location name","User create","Date create","User update","Date update");		
		$row=$this->location_m->index();		
		$i=0;
		if($row==TRUE)
		{
			foreach($row as $value):
			$data["tbl_body"][$i]=array(										
										$value->loc_name,																														
										$value->user_crea,
										date("d-m-Y",strtotime($value->date_crea)),							
										$value->user_updt,
										$value->date_updt==NULL?NULL:date("d-m-Y",strtotime($value->date_updt)),
										$value->loc_id
									);
			$i=$i+1;
		endforeach;
		}											
		$this->load->view('admin/page_view',$data);
		$this->load->view('template/footer');
	}
	public function validation()
	{		
		$this->form_validation->set_rules('txtLocName','Location name','trim|required');		
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
					$row=$this->location_m->add();															              
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
			$row=$this->location_m->index($id);			
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
				$row=$this->location_m->edit($id);	
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
			$row=$this->location_m->delete($id);
			if($row==TRUE){redirect("{$this->page_redirect}/");}
		}
		else{return FALSE;}
	}
	public function createCtrl($row="")
		{	
			if($row!="")
			{			
					$row1=$row->loc_name;																																					
			}											
			//$ctrl = array();
			$ctrl = array(							
							array(
									'type'=>'text',
									'name'=>'txtLocName',
									'id'=>'txtLocName',									
									'value'=>$row==""? set_value("txtLocName") : $row1,					
									'placeholder'=>'Enter Location name here...',									
									'class'=>'form-control',
									'label'=>'Location name'																								
								)														
							);
			return $ctrl;
		}
}
?>