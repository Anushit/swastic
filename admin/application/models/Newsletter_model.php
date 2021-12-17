<?php
	class Newsletter_model extends CI_Model{

	
		//---------------------------------------------------
		// get all users for server-side datatable processing (ajax based)
		public function get_all_newsletter(){
			$wh =array();
			$SQL ='SELECT * FROM ci_newsletter';
			$wh[] = " deleted = 0";
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
		public function add_newsletter_mail($data){
			$this->db->insert('ci_message', $data);
			return $this->db->insert_id();
		}
		public function add_newsletter_member($data){
			$this->db->insert('ci_message_member', $data);
			return true;
		}
		
		
		public function add_newsletter($data){
			$this->db->insert('ci_newsletter', $data);
			return $this->db->insert_id();
		}

		public function get_newsletter_list(){
			$query = $this->db->get_where('ci_newsletter', array('deleted' => 0));
			return $result = $query->result_array();
		}
		public function get_newsletter_list_byid($id){
			$query = $this->db->get_where('ci_newsletter', array('deleted' => 0,'id'=>$id));
			return $result = $query->row_array();
		}
		
		public function get_mail_list(){
			$wh =array();
			$SQL ='SELECT ci_message.*,ci_admin.firstname as name FROM ci_message
			LEFT JOIN ci_admin ON (ci_admin.admin_id = ci_message.created_by)';
			$wh[] = " mode = 2";
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
	}

?>
