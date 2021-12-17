<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Profile_model extends CI_Model{

	public function get_user_detail(){

		$id = $this->session->userdata('admin_id');
		$query = $this->db->get_where('ci_admin', array('admin_id' => $id));
		return $result = $query->row_array();
	}

	//--------------------------------------------------------------------
	public function update_user($data){

		$id = $this->session->userdata('admin_id');
		$this->db->where('admin_id', $id);
		$this->db->update('ci_admin', $data);
		return true;
	}
	
	//--------------------------------------------------------------------
	public function change_pwd($data, $id){

		$this->db->where('admin_id', $id);
		$this->db->update('ci_admin', $data);
		return true;
	}

}

?>