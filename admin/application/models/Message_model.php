<?php
	class Message_model extends CI_Model{

		public function add_message($data){
			$this->db->insert('ci_message', $data);
			return $this->db->insert_id();
		}
		public function add_message_member($data){
			$this->db->insert('ci_message_member', $data);
			return true;
		}
	
		//---------------------------------------------------
		// get all users for server-side datatable processing (ajax based)
		public function get_mail_list(){
			$wh =array();
			$SQL ='SELECT ci_message.*,ci_admin.firstname as name FROM ci_message
			LEFT JOIN ci_admin ON (ci_admin.admin_id = ci_message.created_by)';
			if($this->session->userdata('admin_id')==1){
				$wh[] = " mode = 1";
			}else{
				$wh[] = " mode = 1 AND ci_message.created_by =".$this->session->userdata('admin_id');
			}
			
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

		public function get_sms_list(){
			$wh =array();
			$SQL ='SELECT ci_message.*,ci_admin.firstname as name FROM ci_message
			LEFT JOIN ci_admin ON (ci_admin.admin_id = ci_message.created_by)';
			if($this->session->userdata('admin_id')==1){
				$wh[] = " type = 2";
			}else{
				$wh[] = " type = 2 AND ci_message.created_by =".$this->session->userdata('admin_id');
			}
			
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
		public function get_whatsapp_list(){
			$wh =array();
			$SQL ='SELECT ci_message.*,ci_admin.firstname as name FROM ci_message
			LEFT JOIN ci_admin ON (ci_admin.admin_id = ci_message.created_by)';
			if($this->session->userdata('admin_id')==1){
				$wh[] = " type = 3";
			}else{
				$wh[] = " type = 2 AND ci_message.created_by =".$this->session->userdata('admin_id');
			}
			
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

		public function get_member_list_by_msgId($id){
			$query = $this->db->get_where('ci_message_member', array('message_id' => $id));
			return $result = $query->result_array();
		}
		public function get_maildataby_Id($id){
			$query = $this->db->get_where('ci_message', array('id' => $id));
			return $result = $query->row_array();
		}



		// //---------------------------------------------------
		// Edit user Record

		//---------------------------------------------------
		// Change user status
		//-----------------------------------------------------
		function change_status()
		{		
			$this->db->set('is_active', $this->input->post('status'));
			$this->db->where('id', $this->input->post('id'));
			$this->db->update('ci_role');
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

		public function get_mails_for_export(){
			///$this->db->where('is_admin', 0);
			$this->db->select('id, mode, subject, message, type, created_by, attachment, created_at');
			$this->db->from('ci_message');
			$query = $this->db->get();
			return $result = $query->result_array();
		}
		public function get_mail_for_export(){
			$this->db->select('ci_message.*,');
			$this->db->from('ci_message');
			$this->db->where('ci_message.type',1);
			$this->db->where('ci_message.mode',1);
			$query = $this->db->get();
			return $query->result_array();
		}



	}

?>
