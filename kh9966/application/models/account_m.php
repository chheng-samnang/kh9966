<?php
class Account_m extends CI_Model
{			
	var $userCrea;		
	public function __construct()
	{
		parent::__construct();
		$this->load->helper("security");
		$this->userCrea = isset($this->session->userLogin)?$this->session->userLogin:"N/A";				
	}
	public function index($id="")
	{
		if($id=="")
		{						
			$this->db->order_by('acc_id', 'DESC');
			$query=$this->db->get("tbl_account");
			if($query->num_rows()>0){return $query->result();}			
		}
		else
		{
			$this->db->where("acc_id",$id);
			$query=$this->db->get("tbl_account");
			if($query->num_rows()>0){return $query->row();}
		}
	}
	public function account_code()
	{
		$query=$this->db->query("SELECT acc_code FROM tbl_account ORDER BY acc_code DESC LIMIT 1");
		if($query->num_rows()>0){return $query->row();}				
	}
	public function add()
	{
		$data= array(	
						"acc_code" => $this->input->post("txtAccCode"),
						"acc_name" => $this->input->post("txtAccName"),
						"acc_company" => $this->input->post("txtCompany"),
						"acc_pass" => do_hash($this->input->post("txtAccPass")),						
						"acc_email" => $this->input->post("txtEmail"),
						"acc_phone" => $this->input->post("txtPhone"),
						"acc_addr" => $this->input->post("txtAddr"),
						"acc_website" => $this->input->post("txtWebsite"),						
						"acc_status" => $this->input->post("ddlStatus"),						
						"acc_photo" =>!empty($this->input->post('txtImgName'))?$this->input->post('txtImgName'):"",					
						"acc_desc" => $this->input->post("txtDesc"),												
						"user_crea" => $this->userCrea,
						"date_crea" => date('Y-m-d')
						 );
		$query=$this->db->insert("tbl_account",$data);		
		if($query){return $query;}
	}
	public function edit($id)
	{
		if($id!="")
		{
			if(!empty($this->input->post('txtImgName')))
			{	  	
				
				$row=$this->index($id);						
				unlink("assets/uploads/".$row->acc_photo);	
				$data= array(							
						"acc_name" => $this->input->post("txtAccName"),
						"acc_company" => $this->input->post("txtCompany"),												
						"acc_email" => $this->input->post("txtEmail"),
						"acc_phone" => $this->input->post("txtPhone"),
						"acc_addr" => $this->input->post("txtAddr"),
						"acc_website" => $this->input->post("txtWebsite"),						
						"acc_status" => $this->input->post("ddlStatus"),						
						"acc_photo" =>!empty($this->input->post('txtImgName'))?$this->input->post('txtImgName'):"",					
						"acc_desc" => $this->input->post("txtDesc"),												
						"user_updt" => $this->userCrea,
						"date_updt" => date('Y-m-d')
						 );	
			}
			else
			{
				$data= array(	
						"acc_code" => $this->input->post("txtAccCode"),
						"acc_name" => $this->input->post("txtAccName"),
						"acc_company" => $this->input->post("txtCompany"),						
						"acc_email" => $this->input->post("txtEmail"),
						"acc_phone" => $this->input->post("txtPhone"),
						"acc_addr" => $this->input->post("txtAddr"),
						"acc_website" => $this->input->post("txtWebsite"),						
						"acc_status" => $this->input->post("ddlStatus"),												
						"acc_desc" => $this->input->post("txtDesc"),												
						"user_updt" => $this->userCrea,
						"date_updt" => date('Y-m-d')
						 );
			}	
			$this->db->where("acc_id",$id);
			$query=$this->db->update("tbl_account",$data);
			if($query==TRUE){return TRUE;}
		}				
	}
	public function change_password($id="")
	{
		$row=$this->index($id);
		if($row->acc_pass==do_hash($this->input->post('txtOldAccPass')))
		{		
			$data= array(							
						"acc_pass" =>do_hash($this->input->post("txtAccPass")),
						"user_updt" => $this->userCrea,
						"date_updt" => date('Y-m-d')						
						 );
			$this->db->where("acc_id",$id);
			$query=$this->db->update("tbl_account",$data);
			if($query==TRUE){return TRUE;}
		}
		else{return FALSE;}		
	}	
	public function delete($id)
	{
		if($id==TRUE)
		{	
			$row=$this->index($id);			
			unlink("assets/uploads/".$row->acc_photo);					
			$this->db->where("acc_id",$id);
			$query=$this->db->delete("tbl_account");
			if($query==TRUE){return $query;}
		}
	}
	
}
?>