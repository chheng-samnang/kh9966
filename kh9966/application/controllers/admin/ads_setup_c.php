<?php
class Ads_setup_c extends CI_Controller
{
	var $pageHeader,$page_redirect;	
	public function __construct()
	{
		parent::__construct();
		$this->pageHeader='Advertisement';
		$this->page_redirect="admin/ads_setup_c";								
		$this->load->model("ads_setup_m");
	}
	public function index()
	{		
		$this->load->view('template/header');
		$this->load->view('template/left');		
		$data['pageHeader'] = $this->pageHeader;
		$data["action_url"]=array(0=>"{$this->page_redirect}/add",1=>"{$this->page_redirect}/edit",2=>"{$this->page_redirect}/delete"/*,"{$this->page_redirect}/change_password"*/);							
		$data["tbl_hdr"]=array("Advertise type","Duration","Size","Price/Ads","Side Ads 2up discount(%)","Free/month");		
		$row=$this->ads_setup_m->index();		
		$i=0;
		if($row==TRUE)
		{
			foreach($row as $value):
			$data["tbl_body"][$i]=array(
										"<a href=".base_url($this->page_redirect.'/advertise_detail/'.$value->rate_id)." title='Advertise Detail'>".$value->ads_type."</a>",																																																																						
										$value->rate_duration." days",
										$value->ads_size,
										$value->rate_price." $",										
										$value->ads_2_discount." %",
										//$value->key_code.($value->key_type=="bundle_package"?" days":" hours"),										
										$value->rate_id
									);
			$i=$i+1;
		endforeach;
		}											
		$this->load->view('admin/page_view',$data);
		$this->load->view('template/footer1');
	}
	public function	advertise_detail($id)
	{		
		$data["detail"]=$this->ads_setup_m->index($id);		
		$data['cancel'] = $this->page_redirect;
		$this->load->view('template/header');
		$this->load->view('template/left');		
		$this->load->view('admin/advertise_detail.php',$data);
		$this->load->view('template/footer');	
	}		
	public function add()
	{									
		$data['action'] = "{$this->page_redirect}/add_value";
		$data['pageHeader'] = $this->pageHeader;		
		$data['cancel'] = $this->page_redirect;		
		$this->load->view('template/header');		
		$this->load->view('admin/ads_setup_add',$data);
		$this->load->view('template/footer1');		
	}
	public function add_value()
	{
		$row=$this->ads_setup_m->add();															              
        if($row==TRUE)
        {	                		                	
			redirect("{$this->page_redirect}/");	
        }
        else $this->add();		
	}
	public function edit($id="")
	{		
		if($id!="")
		{
			$data['action'] = "{$this->page_redirect}/edit_value/{$id}";
			$data['bundle_package']=$this->ads_setup_m->purchase("bundle_package");
			$data['cv_paid_search']=$this->ads_setup_m->purchase("cv_paid_search");			
			$data['row']=$this->ads_setup_m->index($id);
			$data['pageHeader'] = $this->pageHeader;		
			$data['cancel'] = $this->page_redirect;
			$this->load->view('template/header');				
			$this->load->view("admin/ads_setup_edit",$data);
			$this->load->view('template/footer1');		
			
		}
		else{return FALSE;}
	}
	public function edit_value($id="")
	{
		$row=$this->ads_setup_m->edit($id);
		if($row==TRUE)
		{
			redirect("{$this->page_redirect}/");		
		}						
	}
	public function delete($id="")
	{
		if($id!="")
		{
			$row=$this->ads_setup_m->delete($id);
			if($row==TRUE){redirect("{$this->page_redirect}/");}
		}
		else{return FALSE;}
	}	
}
?>