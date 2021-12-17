<?php
	class Blogs_model extends CI_Model{

		public function add_blogs($data){
			$this->db->insert('ci_blogs', $data);
			return true;
		}

        public function get_all_blogs(){
			$wh = [];
			$SQL ='SELECT * FROM ci_blogs';
			///wh[] = " is_admin = 0";
			// print_r(count($wh));die;
			if(count($wh) > 0) {
				$WHERE = implode(' and ',$wh);
				return $this->datatable->LoadJson($SQL,$WHERE);
			}
			else
			{
				return $this->datatable->LoadJson($SQL);
			}
		}

			// Get user detial by ID
		public function get_blog_by_id($id){
			$query = $this->db->get_where('ci_blogs', array('id' => $id));
			return $result = $query->row_array();
		}

		//---------------------------------------------------
		// Edit user Record
		public function edit_blog($data, $id){
			$this->db->where('id', $id);
			$this->db->update('ci_blogs', $data);
			return true;
		}

		//---------------------------------------------------
		// Change user status
		//-----------------------------------------------------
		function change_status()
		{		
			$this->db->set('is_active', $this->input->post('status'));
			$this->db->where('id', $this->input->post('id'));
			$this->db->update('ci_blogs');
		}

		// get users for csv export
		public function get_blogs_for_export(){ 
			//$this->db->where('is_admin', 0);
			$this->db->select('id, name, sort_description, blog_date, created_at');
			$this->db->from('ci_blogs');
			$query = $this->db->get();
			return $result = $query->result_array();
		} 
		public function all_blog($select){
			$this->db->select($select);
			$this->db->from('ci_blogs');
			$this->db->where('is_active=1');
			$query = $this->db->get();
			return $result = $query->result_array();
		}
}

?>