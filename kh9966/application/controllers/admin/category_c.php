<?php
class Category_c extends CI_Controller
{
	var $pageHeader,$page_redirect;	
	public function __construct()
	{
		parent::__construct();
		$this->pageHeader='Category';
		$this->page_redirect="admin/category_c";								
		$this->load->model("category_m");
	}
	public function index()
	{		
		$this->load->view('template/header');
		$this->load->view('template/left');		
		$data['pageHeader'] = $this->pageHeader;
		$data["action_url"]=array(0=>"{$this->page_redirect}/add",1=>"{$this->page_redirect}/edit",2=>"{$this->page_redirect}/delete"/*,"{$this->page_redirect}/change_password"*/);							
		$data["tbl_hdr"]=array("Category type","Item name","Item name khmer","Description","User create","Date create","User update","Date update");		
		$row=$this->category_m->index();		
		$i=0;
		if($row==TRUE)
		{
			foreach($row as $value):
			$data["tbl_body"][$i]=array(
										$value->cat_type=='jb'?'JOB':($value->cat_type=='sk'?'SKILL':'CV'),
										$value->cat_name,
										$value->cat_name_kh,
										$value->cat_desc,																				
										$value->user_crea,
										date("d-m-Y",strtotime($value->date_crea)),							
										$value->user_updt,
										$value->date_updt==NULL?NULL:date("d-m-Y",strtotime($value->date_updt)),
										$value->cat_id
									);
			$i=$i+1;
		endforeach;
		}											
		$this->load->view('admin/page_view',$data);
		$this->load->view('template/footer');
	}
	public function validation()
	{		
		$this->form_validation->set_rules('ddlCategoryType','Category type','trim|required');
		$this->form_validation->set_rules('txtCategoryName','Item name','trim|required');
		if($this->form_validation->run()==TRUE){return TRUE;}
		else{return FALSE;}
	}	
	public function add()
	{	
		$option = array(NULL=>'Chose once','cv'=>'CV','jb'=>'JOB','sk'=>"SKILL");			
		$data['ctrl'] = $this->createCtrl($row="",$option);		
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
					$row=$this->category_m->add();															              
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
			$row=$this->category_m->index($id);			
			if($row==TRUE)
			{																										
				$option = array(''=>'Chose once','cv'=>'CV','jb'=>'JOB','sk'=>'SKILL');			
				$data['ctrl'] = $this->createCtrl($row,$option);			
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
				$row=$this->category_m->edit($id);	
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
			$row=$this->category_m->delete($id);
			if($row==TRUE){redirect("{$this->page_redirect}/");}
		}
		else{return FALSE;}
	}
	public function createCtrl($row="",$option)
		{	
			if($row!="")
			{			
					$row1=$row->cat_type;
					$row2=$row->cat_name;
					$row3=$row->cat_name_kh;
					$row4=$row->cat_desc;																												
			}											
			//$ctrl = array();
			$ctrl = array(
							array(
									'type'=>'dropdown',
									'name'=>'ddlCategoryType',									
									'option'=>$option,
									'selected'=>$row==""? NULL : $row1,
									'class'=>'class="form-control"',
									'label'=>'Category type',									
								),
							array(
									'type'=>'text',
									'name'=>'txtCategoryName',
									'id'=>'txtCategoryName',									
									'value'=>$row==""? set_value("txtCategoryName") : $row2,					
									'placeholder'=>'Enter Item name here...',									
									'class'=>'form-control',
									'label'=>'Item name'																								
								),
							array(
									'type'=>'text',
									'name'=>'txtCategoryNameKh',
									'id'=>'txtCategoryNameKh',									
									'value'=>$row==""? set_value("txtCategoryNameKh") : $row3,					
									'placeholder'=>'Enter Item name khmer here...',									
									'class'=>'form-control',
									'label'=>'Item name khmer'																								
								),							
							array(
									'type'=>'textarea',
									'name'=>'txtDesc',
									'value'=>$row==""? set_value("textarea") : $row4,
									'label'=>'Description'
								),
							);
			return $ctrl;
		}
}
?>