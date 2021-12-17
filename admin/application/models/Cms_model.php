<?php
	class Cms_model extends CI_Model{

		public function add_cms($data){
			$this->db->insert('ci_cms', $data);
			return true;
		}

		//---------------------------------------------------
		// get all cms for server-side datatable processing (ajax based)
		public function get_all_cms(){
			$wh =array();
			$SQL ='SELECT * FROM ci_cms';
			
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
		// Get cms detial by slug
		public function get_cms_by_slug($id){
			$query = $this->db->get_where('ci_cms', array('slug' => $id,'is_active=1'));
			return $result = $query->row_array();
		}
		//---------------------------------------------------
		// Get cms detial by ID
		public function get_cms_by_id($id){
			$query = $this->db->get_where('ci_cms', array('id' => $id,'is_active' =>1));
			return $result = $query->row_array();
		}

		//---------------------------------------------------
		// Edit cms Record
		public function edit_cms($data, $id){
			$this->db->where('id', $id);
			$this->db->update('ci_cms', $data);
			return true;
		}

		//---------------------------------------------------
		// Change cms status
		//-----------------------------------------------------
		function change_status()
		{		
			$this->db->set('is_active', $this->input->post('status'));
			$this->db->where('id', $this->input->post('id'));
			$this->db->update('ci_cms');
		}  
 

	}

?>