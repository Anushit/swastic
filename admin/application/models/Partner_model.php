<?php
	class Partner_model extends CI_Model{

		public function add_partner($data){
			$this->db->insert('ci_partners', $data);
			return true;
		}

		//---------------------------------------------------
		// get all partner for server-side datatable processing (ajax based)
		public function get_all_partner(){
			$wh =array();
			$SQL ='SELECT * FROM ci_partners';
			
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
		// Get partner detial by ID
		public function get_partner_by_id($id){
			$query = $this->db->get_where('ci_partners', array('id' => $id));
			return $result = $query->row_array();
		}

		//---------------------------------------------------
		// Edit partner Record
		public function edit_partner($data, $id){
			$this->db->where('id', $id);
			$this->db->update('ci_partners', $data);
			return true;
		}

		//---------------------------------------------------
		// Change partner status
		//-----------------------------------------------------
		function change_status()
		{		
			$this->db->set('is_active', $this->input->post('status'));
			$this->db->where('id', $this->input->post('id'));
			$this->db->update('ci_partners');
		}  
 
		//---------------------------------------------------
		// get partners for csv export
		public function get_partners_for_export(){
			///$this->db->where('is_admin', 0);
			$this->db->select('id, name, email, mobile, created_at');
			$this->db->from('ci_partners');
			$query = $this->db->get();
			return $result = $query->result_array();
		}
		public function get_partner($select){
	    	$this->db->select($select);
			$this->db->from('ci_partners');
			$this->db->where('is_active=1');
			return $this->db->get()->result();
		}



	}

?>