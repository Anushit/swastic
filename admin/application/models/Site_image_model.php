<?php
	class Site_image_model extends CI_Model{

		//---------------------------------------------------
		// get all cms for server-side datatable processing (ajax based)
		public function get_all_siteImage(){
			$wh =array();
			$SQL ='SELECT * FROM ci_site_images';
			
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
		public function get_siteimage_by_id($id){
			$query = $this->db->get_where('ci_site_images', array('id' => $id));
			return $result = $query->row_array();
		}

		//---------------------------------------------------
		// Edit cms Record
		public function edit_siteimage($data, $id){
			$this->db->where('id', $id);
			$this->db->update('ci_site_images', $data);
			return true;
		}

		//---------------------------------------------------
		// Change cms status
		//-----------------------------------------------------
		function change_status()
		{		
			$this->db->set('is_active', $this->input->post('status'));
			$this->db->where('id', $this->input->post('id'));
			$this->db->update('ci_site_images');
		}  
 

	}

?>