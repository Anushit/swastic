<?php
	class Testimonial_model extends CI_Model{

		public function add_testimonial($data){
			$this->db->insert('ci_testimonials', $data);
			return true;
		}

		//---------------------------------------------------
		// get all testimonial for server-side datatable processing (ajax based)
		public function get_all_testimonial(){
			$wh =array();
			$SQL ='SELECT * FROM ci_testimonials';
			
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
		// Get testimonial detial by ID
		public function get_testimonial_by_id($id){
			$query = $this->db->get_where('ci_testimonials', array('id' => $id));
			return $result = $query->row_array();
		}

		//---------------------------------------------------
		// Edit testimonial Record
		public function edit_testimonial($data, $id){
			$this->db->where('id', $id);
			$this->db->update('ci_testimonials', $data);
			return true;
		}

		//---------------------------------------------------
		// Change testimonial status
		//-----------------------------------------------------
		function change_status()
		{		
			$this->db->set('is_active', $this->input->post('status'));
			$this->db->where('id', $this->input->post('id'));
			$this->db->update('ci_testimonials');
		}  
 
		//---------------------------------------------------
		// get testimonials for csv export
		public function get_testimonials_for_export(){
			
			$this->db->select('id, name, designation, message, created_at');
			$this->db->from('ci_testimonials');
			$query = $this->db->get();
			return $result = $query->result_array();
		}


	}

?>