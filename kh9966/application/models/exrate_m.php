<?php
	/**
	* 
	*/
	class Exrate_m extends CI_Model
	{
		var $userCrea;
		function __construct()
		{
			parent::__construct();	
			$this->userCrea = isset($this->session->userLogin)?$this->session->userLogin:"N/A";		
		}

		public function index()
		{
			$query = $this->db->query("SELECT key_id, key_data, user_crea, date_crea, user_updt, date_updt FROM tbl_sysdata WHERE key_type='exrate'");
				
				return $query->result();
		}
		public function getExrate($id="")
		{
			if ($id!="") 
			{
				$query = $this->db->query("SELECT key_id, key_data, user_crea, date_crea, user_updt, date_updt FROM tbl_sysdata WHERE key_type={$id} ");
				
				return $query->result();
			}else
			{
				$query = $this->db->get('tbl_sysdata');
				return $query;
			}
		}
		#============= this function getExrate=====================

		public function insertExrate()
		{
			$data = array(

						'key_type'=>'exrate',
						'key_code'=>date('YmdHis'),
						'key_data'=>$this->input->post('txtExRate'),
						"user_crea"	=>	$this->userCrea,
						'date_crea'=>date('Y-m-d')							
				);
			$this->db->insert('tbl_sysdata',$data);
		}
		#============ this function insertExrate================

		public function remove($id)
		{
			$this->db->delete('tbl_sysdata',array('key_id'=>$id));
		}
		#============== this function remove =================

	}// Class