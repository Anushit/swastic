<?php
	class Faq_model extends CI_Model{

		public function add_faq($data){
			$this->db->insert('ci_faq', $data);
			return true;
		}

		//---------------------------------------------------
		// get all cms for server-side datatable processing (ajax based)
		public function get_all_faq(){
			$wh =array();
			$SQL ='SELECT ci_faq.*, ci_faq_type.name as faq_name, ci_faq_type.id as faq_id  FROM ci_faq
			LEFT JOIN ci_faq_type ON (ci_faq.faq_type_id = ci_faq_type.id)';
			
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
		// Get cms detial by ID
		public function get_faq_by_id($id){
			$query = $this->db->get_where('ci_faq', array('id' => $id));
			return $result = $query->row_array();
		}

		public function get_Allfaqtype(){
			$query = $this->db->get('ci_faq_type');
			return $result = $query->result_array();
		}


		//---------------------------------------------------
		// Edit cms Record
		public function edit_faq($data, $id){
			$this->db->where('id', $id);
			$this->db->update('ci_faq', $data);
			return true;
		}

		//---------------------------------------------------
		// Change cms status
		//-----------------------------------------------------
		function change_status()
		{		
			$this->db->set('is_active', $this->input->post('status'));
			$this->db->where('id', $this->input->post('id'));
			$this->db->update('ci_faq');
		}  

		public function get_faq($faq_id){

	    	$this->db->select('*');
			$this->db->from('ci_faq as q');
			if($faq_id){
			$this->db->where('faq_type_id',$faq_id);
/*			$this->db->join('ci_faq_type as ft', 'ft.faq_type_id = q.id','inner'); 				
*/		    }
            
			return $this->db->get()->result();
			// print_r($this->db->last_query()); die;



			 
		
		} 
 
 

	}

?>