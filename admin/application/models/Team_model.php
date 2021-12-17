<?php
	class Team_model extends CI_Model{

		public function add_team($data){
			$this->db->insert('ci_teams', $data);
			return true;
		}

		//---------------------------------------------------
		// get all team for server-side datatable processing (ajax based)
		public function get_all_team(){
			$wh =array();
			$SQL ='SELECT * FROM ci_teams';
			
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
		// Get team detial by ID
		public function get_team_by_id($id){
			$query = $this->db->get_where('ci_teams', array('id' => $id));
			return $result = $query->row_array();
		}

		//---------------------------------------------------
		// Edit team Record
		public function edit_team($data, $id){
			$this->db->where('id', $id);
			$this->db->update('ci_teams', $data);
			return true;
		}

		//---------------------------------------------------
		// Change team status
		//-----------------------------------------------------
		function change_status()
		{		
			$this->db->set('is_active', $this->input->post('status'));
			$this->db->where('id', $this->input->post('id'));
			$this->db->update('ci_teams');
		}  
 
		//---------------------------------------------------
		// get teams for csv export
		public function get_teams_for_export(){
			
			$this->db->select('id, name, department, designation, created_at');
			$this->db->from('ci_teams');
			$query = $this->db->get();
			return $result = $query->result_array();
		}


	}

?>