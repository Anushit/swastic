<?php
	class Role_model extends CI_Model{

		public function add_role($data){
			$this->db->insert('ci_role', $data);
			return true;
		}
		public function insert_rol_permission($data){
			$this->db->insert('ci_role_permission', $data);
			return true;
		}

		public function insert_adminrol_permission($data){
			$this->db->insert('ci_admin_role_permission', $data);
			return $this->db->insert_id();
		}

		//---------------------------------------------------
		// get all users for server-side datatable processing (ajax based)
		public function get_all_role(){
			$wh =array();
			$SQL ='SELECT * FROM ci_role';
			$wh[] = " id > 1";
			if(count($wh)>0)
			{
				$WHERE = implode(' and ',$wh);
				return $this->datatable->LoadJson($SQL,$WHERE);
			}
			else
			{
				return $this->datatable->LoadJson($SQL);
			}
		}


		//---------------------------------------------------
		// Get user detial by ID
		public function get_role_by_id($id){
			$query = $this->db->get_where('ci_role', array('id' => $id));
			return $result = $query->row_array();
		}

		public function get_allrole_by_where($id){
			  $this->db->select("*");
			  $this->db->from('ci_role');
			  $this->db->where_not_in('id', $id);
			  $query = $this->db->get();
			  return   $query->result_array();
		}

		public function get_role_permission($data){
			$query = $this->db->get_where('ci_role_permission',$data);
			return $result = $query->row_array();
		}

		public function get_allrole_permission($data){
			$query = $this->db->get_where('ci_role_permission',$data);
			return $result = $query->result_array();
		}
		public function get_diff_module($ids){
			  $this->db->select("*");
			  $this->db->from('ci_modules');
			  $this->db->where('is_allow',1);
			  if(!empty($ids)){
			  	$this->db->where_not_in('id', $ids);
			  }
			  $query = $this->db->get();
			  return   $query->result();
		}
 			  
		public function get_allmodel(){
			$this->db->select("*");
			$this->db->from('ci_modules');
			$this->db->where('is_allow',1);
			$query = $this->db->get();
			return $result = $query->result_array();
		}

		// //---------------------------------------------------
		// Edit user Record
		public function update_permissions($where,$data){
			$this->db->where($where);

			$this->db->update('ci_role_permission', $data) or die($this->db->_error_message()); 
			return ($this->db->affected_rows() != 1) ? 0 : 1;
			 //return $where;
		}

		//---------------------------------------------------
		// Change user status
		//-----------------------------------------------------
		function change_status()
		{		
			$this->db->set('is_active', $this->input->post('status'));
			$this->db->where('id', $this->input->post('id'));
			$this->db->update('ci_role');
		} 

		function get_permission($id)
		{		

			$this->db->select('ci_role_permission.*,ci_modules.name as menu_name');
			$this->db->from('ci_role_permission');
			$this->db->join('ci_modules', 'ci_modules.id=ci_role_permission.module_id', 'left');
			$this->db->where('ci_role_permission.role_id', $id);
			$query = $this->db->get();
			return $query->result();
		} 

		function get_spermission($id)
		{		
			$this->db->select('ci_modules.name as menu_name,ci_modules.id as id,ci_role_permission.id as permission_id,ci_role_permission.role_id,ci_role_permission.module_id,ci_role_permission.is_allow,ci_role_permission.is_view,ci_role_permission.is_add,ci_role_permission.is_edit,ci_role_permission.is_delete');
			$this->db->from('ci_modules');
			$this->db->where('ci_modules.is_allow',1);
			$this->db->join('ci_role_permission', 'ci_role_permission.module_id=ci_modules.id AND ci_role_permission.role_id ='. $id, 'left');
            $this->db->order_by('ci_modules.id','ASC');
			$query = $this->db->get();
			return $query->result();
			
		} 

		//---------------------------------------------------
		// get users for csv export
		public function get_role_for_export(){
			
			$this->db->where('is_admin', 0);
			$this->db->select('id, username, firstname, lastname, email, mobile_no, created_at');
			$this->db->from('ci_role');
			$query = $this->db->get();
			return $result = $query->result_array();
		}

	}

?>
