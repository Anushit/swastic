<?php
	class Portfolio_model extends CI_Model{

		public function add_portfolio($data,$image){
			$pro=[]; 
			
			$imgData = [];
			foreach ($data as $key => $value) {
				if($key!='id' && $key!='img_order'){
					$pro[$key]=$value;
				}
			} 
			$this->db->insert('ci_portfolio', $pro); 
			$insert_id = $this->db->insert_id(); 
			foreach ($image as $ikey => $ivalue) {
				$imgData['portfolio_id'] = $insert_id;
				$imgData['image'] = $ivalue;
				$imgData['sort_order'] = $data['img_order'][$ikey];
				$this->db->insert('ci_portfolio_image', $imgData);
			}
			return true;
		}

		//---------------------------------------------------
		// get all categories for server-side datatable processing (ajax based)
		public function get_all_portfolio(){
			$wh =array();
			$SQL ='SELECT * FROM ci_portfolio ';
			 		
			if(count($wh)>0)
			{
				$WHERE = implode(' and ',$wh);
				return $this->datatable->LoadJson($SQL,$WHERE,'','OR');
			}
			else
			{
				return $this->datatable->LoadJson($SQL);
			}
		}
 
		//---------------------------------------------------
		// Get user detial by ID
		public function get_portfolio_by_id($id){
			$query = $this->db->get_where('ci_portfolio', array('id' => $id));
			return $result = $query->row_array();
		}

		public function get_portfolios(){
			$query = $this->db->get_where('ci_portfolio', array('is_active' => 1));
			return $result = $query->result_array();
		}

		//---------------------------------------------------
		// Get user detial by ID
		public function get_portfolio_by_slug($slug){
			$query = $this->db->get_where('ci_portfolio', array('slug' => $slug));
			return $result = $query->row_array();
		}

		 
		
		//---------------------------------------------------
		// Get portfolio image detial by ID
		public function get_portfolio_image($id){
			$this->db->select('id, portfolio_id, image, sort_order');
			$this->db->from('ci_portfolio_image');
			$this->db->where('portfolio_id', $id);
			$this->db->order_by('sort_order', 'asc');
			$query = $this->db->get(); 
			return $result = $query->result_array();
		}

		//---------------------------------------------------
		// Edit user Record
		public function edit_portfolio($data, $image, $id){
			$pro=[]; 			
			$imgData = [];
			foreach ($data as $key => $value) {
				if($key!='img_order'){
					$pro[$key]=$value;
				}
			} 
			$this->db->where('id', $id);
			$this->db->update('ci_portfolio', $pro);  
	
			/// Insert image Data
			if(!empty($image)){
				$this->db->delete('ci_portfolio_image', array('portfolio_id' => $id));
				foreach ($image as $ikey => $ivalue) {
					$imgData['portfolio_id'] = $id;
					$imgData['image'] = $ivalue;
					$imgData['sort_order'] = $data['img_order'][$ikey];
					$this->db->insert('ci_portfolio_image', $imgData);
				}
			}
			return true;
		}

		//---------------------------------------------------
		// Change user status
		//-----------------------------------------------------
		function change_status()
		{		
			$this->db->set('is_active', $this->input->post('status'));
			$this->db->where('id', $this->input->post('id'));
			$this->db->update('ci_portfolio');
		} 

		//---------------------------------------------------
		// get categories for csv export
		public function get_portfolio_for_export(){
			///$this->db->where('is_admin', 0);
			$this->db->select('id, name, model, price, special_price, sort_order, created_at');
			$this->db->from('ci_portfolio');
			$query = $this->db->get();
			return $result = $query->result_array();
		}

		public function getTotalportfolio($data = array()) {
			$sql = "SELECT COUNT(p.id) AS total";
 			$sql .= " FROM ci_portfolio p";  
			$sql .= " where is_active=1 "; 
			$query = $this->db->query($sql);
			$result = $query->row_array(); 
			
			return $result['total'];
		}
		
		public function getportfolio($data = array()) {
			$sql = "SELECT p.*,(select image from ci_portfolio_image pi where pi.portfolio_id=p.id order by sort_order ASC LIMIT 1 ) as image";
 			$sql .= " FROM ci_portfolio p";  
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

		public function getportfoliodetail($id) {
			$sql = "SELECT p.*,(select image from ci_portfolio_image pi where pi.portfolio_id=p.id order by sort_order ASC LIMIT 1 ) as image";
 			$sql .= " FROM ci_portfolio p";   
			$sql .= " where is_active=1 ";
			if (!empty($id)) {
				$sql .= " AND p.slug = '" . $id . "'"; 
			}   
			$query = $this->db->query($sql);
			return $result = $query->row_array(); 			 
		}

		public function getportfolioimages($id) {
			$sql = "SELECT * ";
 			$sql .= " FROM ci_portfolio_image pi";  
			if (!empty($id)) {
				$sql .= " where pi.portfolio_id = '" . (int)$id . "'"; 
			}   
			$sql .= " order by sort_order asc "; 

			$query = $this->db->query($sql);
			return $result = $query->result_array(); 			 
		} 
 



	}

?>