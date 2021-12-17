<?php
	class Events_model extends CI_Model{

		public function add_events($data){
			$this->db->insert('ci_events', $data);
			return true;
		}

        public function get_all_events(){
			$wh = [];
			$SQL ='SELECT * FROM ci_events';
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
		public function get_event_by_id($id){
			$query = $this->db->get_where('ci_events', array('id' => $id));
			return $result = $query->row_array();
		}

		//---------------------------------------------------
		// Edit user Record
		public function edit_event($data, $id){
			$this->db->where('id', $id);
			$this->db->update('ci_events', $data);
			return true;
		}

		//---------------------------------------------------
		// Change user status
		//-----------------------------------------------------
		function change_status()
		{		
			$this->db->set('is_active', $this->input->post('status'));
			$this->db->where('id', $this->input->post('id'));
			$this->db->update('ci_events');
		}

				// get users for csv export
		public function get_events_for_export(){
			
			//$this->db->where('is_admin', 0);
			$this->db->select('id, name, sort_description, event_date, event_location, event_start_time, event_end_time, created_at');
			$this->db->from('ci_events');
			$query = $this->db->get();
			return $result = $query->result_array();
		} 
}

?>