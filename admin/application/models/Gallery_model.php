<?php
	class Gallery_model extends CI_Model{

		public function add_gallery($data){
			$this->db->insert('ci_gallery', $data);
			return true;
		}

		//---------------------------------------------------
		// get all gallery for server-side datatable processing (ajax based)
		public function get_all_gallery($type=1){
			$wh =array();
			$SQL ='SELECT * FROM ci_gallery';
			if($type==1){
				$wh[] = " type = 1";
			}else{
				$wh[] = " type = 2";
			}
			
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
		// Get gallery detial by ID
		public function get_gallery_by_id($id){
			$query = $this->db->get_where('ci_gallery', array('id' => $id));
			return $result = $query->row_array();
		}

		//---------------------------------------------------
		// Get gallery detial by ID
		public function get_gallerydetail_by_id($id){
			$query = $this->db->get_where('ci_gallery_details', array('gallery_id' => $id));
			return $result = $query->result_array();
		}

		//---------------------------------------------------
		// Edit gallery Record
		public function edit_gallery($data, $id){
			$this->db->where('id', $id);
			$this->db->update('ci_gallery', $data);
			return true;
		}

		//---------------------------------------------------
		// Change gallery status
		//-----------------------------------------------------
		function change_status()
		{		
			$this->db->set('is_active', $this->input->post('status'));
			$this->db->where('id', $this->input->post('id'));
			$this->db->update('ci_gallery');
		}   


		function update_photogallery($data, $image, $id){
		/// Insert image Data 
			if(!empty($image)){
				$this->db->delete('ci_gallery_details', array('gallery_id' => $id));
				foreach ($image as $ikey => $ivalue) {
					$imgData['gallery_id'] = $id;
					$imgData['value'] = $ivalue;
					$imgData['type'] = 1;
					$imgData['is_active'] = 1;
					$imgData['sort_order'] = $data['img_order'][$ikey];
					$imgData['created_by'] = $data['created_by'];
					$imgData['created_at'] = $data['created_at'];
					$this->db->insert('ci_gallery_details', $imgData);
				}
			}
			return true;
		}

		function update_videogallery($data, $id){
		/// Insert image Data 
			if(!empty($data['video_url'])){
				$this->db->delete('ci_gallery_details', array('gallery_id' => $id));
				foreach ($data['video_url'] as $ikey => $ivalue) {
					$imgData['gallery_id'] = $id;
					$imgData['value'] = $ivalue;
					$imgData['type'] = 2;
					$imgData['is_active'] = 1;
					$imgData['sort_order'] = $data['img_order'][$ikey];
					$imgData['created_by'] = $data['created_by'];
					$imgData['created_at'] = $data['created_at'];
					$this->db->insert('ci_gallery_details', $imgData);
				}
			}
			return true;
		}
		

	}

?>