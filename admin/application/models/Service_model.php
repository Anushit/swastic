<?php
	class Service_model extends CI_Model{

		public function add_service($data){
			$this->db->insert('ci_services', $data);
			return true;
		}

		//---------------------------------------------------
		// get all service for server-side datatable processing (ajax based)
		public function get_all_service(){
			$wh =array();
			$SQL ='SELECT * FROM ci_services';
			
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
		// Get service detial by ID
		public function get_service_by_id($id){
			$query = $this->db->get_where('ci_services', array('id' => $id));
			return $result = $query->row_array();
		}

		public function get_service(){
			$query = $this->db->get_where('ci_services', array('is_active' => 1));
			return $result = $query->result_array();
		}
		//---------------------------------------------------
		// Get service detial by Slug
		public function get_service_by_slug($slug){
			$query = $this->db->get_where('ci_services', array('slug' => $slug));
			return $result = $query->row_array();
		}

		//---------------------------------------------------
		// Edit service Record
		public function edit_service($data, $id){
			$this->db->where('id', $id);
			$this->db->update('ci_services', $data);
			return true;
		}

		//---------------------------------------------------
		// Change service status
		//-----------------------------------------------------
		function change_status()
		{		
			$this->db->set('is_active', $this->input->post('status'));
			$this->db->where('id', $this->input->post('id'));
			$this->db->update('ci_services');
		}  
 
		//---------------------------------------------------
		// get services for csv export
		public function get_services_for_export(){
			///$this->db->where('is_admin', 0);
			$this->db->select('id, name, icon, sort_description, created_at');
			$this->db->from('ci_services');
			$query = $this->db->get();
			return $result = $query->result_array();
		}


		public function getTotalService($data = array()) {
			$sql = "SELECT COUNT(p.id) AS total";
 			$sql .= " FROM ci_services p";   
			$sql .= " where is_active=1 "; 
			$query = $this->db->query($sql);
			$result = $query->row_array(); 
			
			return $result['total'];
		}
		
		public function getService($data = array()) {
			$sql = "SELECT p.* ";
 			$sql .= " FROM ci_services p";  
			$sql .= " where p.is_active=1 "; 
			if (($data['sort'] != '')) { 
				$sql .= " ORDER BY " . $data['sort'] . " " . $data['order'];
			}
        	if (($data['start']!=0) || ($data['limit']!=0)) { 
				$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
			}  
			 
			//echo $sql; exit;
			$query = $this->db->query($sql);
			return $result = $query->result_array(); 			 
		}

		public function all_service($select/*,$search,$start,$limit*/){
        	$this->db->select($select);
			$this->db->from('ci_services');
			/*if($search != ''){
            	 $this->db->like('name', $search);
             }
             $this->db->limit($limit, $start);*/
			$this->db->where('is_active=1');
		   return $this->db->get()->result();
/*	    print_r($this->db->last_query()); die;
*/	}

         public function count_service(){
         	$this->db->select("*");
            $this->db->from('ci_services');
			$query = $this->db->get();
			return $query->num_rows();
		}


	}

?>