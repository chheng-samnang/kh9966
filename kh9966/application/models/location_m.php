<?php
class Location_m extends CI_Model
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
			$this->db->order_by('loc_id', 'DESC');
			$query=$this->db->get("tbl_location");
			if($query->num_rows()>0){return $query->result();}			
		}
		else
		{
			$this->db->where("loc_id",$id);
			$query=$this->db->get("tbl_location");
			if($query->num_rows()>0){return $query->row();}
		}
	}
	public function add()
	{
		$data= array(						
						"loc_name" => $this->input->post("txtLocName"),										
						"user_crea" => $this->userCrea,
						"date_crea" => date('Y-m-d')
						 );
		$query=$this->db->insert("tbl_location",$data);		
		if($query){return $query;}
	}
	public function edit($id)
	{
		if($id==TRUE)
		{			
			
			$data= array(
					"loc_name" => $this->input->post("txtLocName"),								
					"user_updt" => $this->userCrea,
					"date_updt" => date('Y-m-d')
					 );				
			$this->db->where("loc_id",$id);
			$query=$this->db->update("tbl_location",$data);
			if($query==TRUE){return $query;}
		}				
	}
	public function delete($id)
	{
		if($id==TRUE)
		{						
			$this->db->where("loc_id",$id);
			$query=$this->db->delete("tbl_location");
			if($query==TRUE){return $query;}
		}
	}
	
}
?>