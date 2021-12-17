<?php
	class News_model extends CI_Model{

		public function add_news($data){
			$this->db->insert('ci_newsupdates', $data);
			return true;
		}

        public function get_all_news(){
			$wh = [];
			$SQL ='SELECT * FROM ci_newsupdates';
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
		public function get_news_by_id($id){
			$query = $this->db->get_where('ci_newsupdates', array('id' => $id));
			return $result = $query->row_array();
		}

		//---------------------------------------------------
		// Edit user Record
		public function edit_news($data, $id){
			$this->db->where('id', $id);
			$this->db->update('ci_newsupdates', $data);
			return true;
		}

		//---------------------------------------------------
		// Change user status
		//-----------------------------------------------------
		function change_status()
		{		
			$this->db->set('is_active', $this->input->post('status'));
			$this->db->where('id', $this->input->post('id'));
			$this->db->update('ci_newsupdates');
		}

				// get users for csv export
		public function get_news_for_export(){
			
			//$this->db->where('is_admin', 0);
			$this->db->select('id, name, sort_description, news_date, news_location, news_time,  created_at');
			$this->db->from('ci_newsupdates');
			$query = $this->db->get();
			return $result = $query->result_array();
		} 
}

?>