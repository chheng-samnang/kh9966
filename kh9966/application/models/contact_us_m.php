<?php
class Contact_us_m extends CI_Model
{			
	var $userCrea;		
	public function __construct()
	{
		parent::__construct();
		$this->userCrea = isset($this->session->userLogin)?$this->session->userLogin:"N/A";				
	}
	public function index($id="")
	{
		if($id=="")
		{
			$this->db->order_by('cnt_us_id', 'DESC');
			$query=$this->db->get("tbl_contact_us");
			if($query->num_rows()>0){return $query->result();}			
		}
		else
		{
			$this->db->where("cnt_us_id",$id);
			$query=$this->db->get("tbl_contact_us");
			if($query->num_rows()>0){return $query->row();}
		}
	}
	public function add()
	{
		$data= array(						
						"addr" => $this->input->post("txtAddr"),
						"phone1" => $this->input->post("txtPhone1"),
						"phone2" => $this->input->post("txtPhone2"),
						"phone3" => $this->input->post("txtPhone3"),
						"email" => $this->input->post("txtEmail"),
						"fb_messager" => $this->input->post("txtFbMessager"),
						"whatApp" => $this->input->post("txtWatApp"),
						"line" => $this->input->post("txtLine"),
						"viber" => $this->input->post("txtViber"),						
						"user_crea" => $this->userCrea,
						"date_crea" => date('Y-m-d')
						 );
		$query=$this->db->insert("tbl_contact_us",$data);		
		if($query){return $query;}
	}
	public function edit($id)
	{
		if($id==TRUE)
		{			
			
			$data= array(					
					"addr" => $this->input->post("txtAddr"),
					"phone1" => $this->input->post("txtPhone1"),
					"phone2" => $this->input->post("txtPhone2"),
					"phone3" => $this->input->post("txtPhone3"),
					"email" => $this->input->post("txtEmail"),
					"fb_messager" => $this->input->post("txtFbMessager"),
					"whatApp" => $this->input->post("txtWatApp"),
					"line" => $this->input->post("txtLine"),
					"viber" => $this->input->post("txtViber"),						
					"user_updt" => $this->userCrea,
					"date_updt" => date('Y-m-d')
					 );				
			$this->db->where("cnt_us_id",$id);
			$query=$this->db->update("tbl_contact_us",$data);
			if($query==TRUE){return $query;}
		}				
	}
	public function delete($id)
	{
		if($id==TRUE)
		{						
			$this->db->where("cnt_us_id",$id);
			$query=$this->db->delete("tbl_contact_us");
			if($query==TRUE){return $query;}
		}
	}
	
}
?>