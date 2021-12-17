<?php
	class Subadmin_model extends CI_Model{

		public function add_user($data){
			$this->db->insert('ci_admin', $data);
			return $this->db->insert_id();
		}

		//---------------------------------------------------
		// get all users for server-side datatable processing (ajax based)
		public function get_all_subadmin(){
			$wh =array();
			$SQL ='SELECT * FROM ci_admin';
			$wh[] = " admin_role_id != 1";
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

		public function get_subadmin_list(){
			$this->db->where('admin_id !=',1);
			$this->db->where('is_active ',1);
			$query = $this->db->get('ci_admin');
			return $result = $query->result_array();
		}

		//---------------------------------------------------
		// Get user detial by ID
		public function get_user_by_id($id){
			$query = $this->db->get_where('ci_admin', array('admin_id' => $id));
			return $result = $query->row_array();
		}
		public function insert_user_permission($data){
			$this->db->insert('ci_admin_role_permission', $data);
			return $this->db->insert_id();
		}
		
		public function update_permissions($where,$data){
			$this->db->where($where);

			$this->db->update('ci_admin_role_permission', $data) or die($this->db->_error_message()); 
			return ($this->db->affected_rows() != 1) ? 0 : 1;
			 //return $where;
		}

		//---------------------------------------------------
		// Edit user Record
		public function edit_user($data, $id){
			$this->db->where('admin_id', $id);
			$this->db->update('ci_admin', $data);
			return true;
		}
		public function get_alluser_permission($data){
			$query = $this->db->get_where('ci_admin_role_permission',$data);
			return $result = $query->result_array();
		}
		public function get_user_permission($data){
			$query = $this->db->get_where('ci_admin_role_permission',$data);
			return $result = $query->row_array();
		}


		//---------------------------------------------------
		// Change user status
		//-----------------------------------------------------
		function change_status()
		{		
			$this->db->set('is_active', $this->input->post('status'));
			$this->db->where('admin_id', $this->input->post('id'));
			$this->db->update('ci_admin');
		} 
		function get_subadmin_permission($id)
		{		

			$this->db->select('ci_modules.name as menu_name,ci_modules.id as id,ci_admin_role_permission.id as permission_id,ci_admin_role_permission.admin_id,ci_admin_role_permission.module_id,ci_admin_role_permission.is_allow,ci_admin_role_permission.is_view,ci_admin_role_permission.is_add,ci_admin_role_permission.is_edit,ci_admin_role_permission.is_delete');
			$this->db->from('ci_modules');
			$this->db->where('ci_modules.is_allow',1);
			$this->db->join('ci_admin_role_permission', 'ci_admin_role_permission.module_id=ci_modules.id AND ci_admin_role_permission.admin_id ='. $id, 'left');
            $this->db->order_by('ci_modules.id','ASC');
			$query = $this->db->get();
			return $query->result();
			
		} 
		//---------------------------------------------------
		// get users for csv export
		public function get_subadmin_for_export(){
			
			$this->db->where_not_in('admin_role_id', 1);
			$this->db->select('admin_id, username, firstname, lastname, email, mobile_no, created_at');
			$this->db->from('ci_admin');
			$query = $this->db->get();
			return $result = $query->result_array();
		}

	}

?>