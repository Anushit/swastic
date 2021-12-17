<?php
	class Banner_model extends CI_Model{

		public function add_banner($data){
			$this->db->insert('ci_banners', $data);
			return true;
		}

		//---------------------------------------------------
		// get all banner for server-side datatable processing (ajax based)
		public function get_all_banner(){
			$wh =array();
			$SQL ='SELECT * FROM ci_banners';
			
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
		// Get banner detial by ID
		public function get_banner_by_id($id){
			$query = $this->db->get_where('ci_banners', array('id' => $id));
			return $result = $query->row_array();
		}

		//---------------------------------------------------
		// Edit banner Record
		public function edit_banner($data, $id){
			$this->db->where('id', $id);
			$this->db->update('ci_banners', $data);
			return true;
		}

		//---------------------------------------------------
		// Change banner status
		//-----------------------------------------------------
		function change_status()
		{		
			$this->db->set('is_active', $this->input->post('status'));
			$this->db->where('id', $this->input->post('id'));
			$this->db->update('ci_banners');
		}   

	}

?>