<?php
class Setting_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	//-----------------------------------------------------
	/*public function update_general_setting($data){
		$this->db->where('id', 1);
		$this->db->update('ci_general_settings', $data);
		return true;

	}*/

	//-----------------------------------------------------
	public function get_general_settings($type=NULL){
		if($type!=NULL){
			$this->db->where('setting_type', $type);
		}
        $query = $this->db->get('ci_general_settings'); 
        return $query->result_array();
	}



	public function get_permission_settings($type=NULL){
		if($type!=NULL){
			$this->db->where('name', $type);
		}
        $query = $this->db->get('ci_modules'); 
        return $query->result_array();
	}
	public function get_user_permission_settings($admin_id,$type=NULL){
		//$admin_id = $this->session->userdata('admin_id');
		$pageid = 0;  
		if($type!=NULL){
			$this->db->where('name', $type);
	        $query = $this->db->get('ci_modules'); 
	        $page  =  $query->row_array(); 
	        $pageid = $page['id'];
		}
		if($admin_id!=NULL){
			$this->db->where('admin_id', $admin_id );
			$this->db->where('module_id',$pageid);
		}
        $query = $this->db->get('ci_admin_role_permission'); 
        return $query->result_array();
	}

	public function getgenraluser_permission_settings($type=NULL){
		$admin_id = $this->session->userdata('admin_id');
		$pageid = 0;
		if($type!=NULL){
			$this->db->where('name', $type);
	        $query = $this->db->get('ci_modules'); 
	        $page  =  $query->row_array();        
	        $pageid = $page['id'];
		}
		
		$this->db->select('ci_admin_role_permission.*,ci_modules.name as name');
		$this->db->from('ci_admin_role_permission');
		$this->db->join('ci_modules', 'ci_modules.id=ci_admin_role_permission.module_id', 'left');
		$this->db->where('ci_admin_role_permission.admin_id', $admin_id);
		$query = $this->db->get();
		return $query->result_array();
       
	}


	public function get_general_parent_settings(){
		return array(
		'type'=>array(
			'1'=>"basic", 
			'2'=>"email", 
			'3'=>"social", 
			'4'=>"recaptcha",
			'5'=>"smsData" 
		),
		'name'=>array(
			'1'=>"General Setting", 
			'2'=>"Email Setting", 
			'3'=>"Social Setting", 
			'4'=>"Google reCAPTCHA", 
			'5'=>"SMS Setting"
		) );
	}

	
}
?>