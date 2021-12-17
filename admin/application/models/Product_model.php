<?php
	class Product_model extends CI_Model{

		public function add_product($data,$image){
			$pro=[]; 
			$catData = [];
			$imgData = [];
			foreach ($data as $key => $value) {
				if($key!='category_id' && $key!='img_order'){
					$pro[$key]=$value;
				}
			}
			$procat= explode(',', $data['category_id']);
			/// Insert Product Data
			$this->db->insert('ci_products', $pro); 
			$insert_id = $this->db->insert_id();
			/// Insert Category Data
			foreach ($procat as $ckey => $cvalue) {
				$catData['product_id'] = $insert_id;
				$catData['category_id'] = $cvalue;
				$this->db->insert('ci_product_to_category', $catData); 
			}
			/// Insert image Data
			foreach ($image as $ikey => $ivalue) {
				$imgData['product_id'] = $insert_id;
				$imgData['image'] = $ivalue;
				$imgData['sort_order'] = $data['img_order'][$ikey];
				$this->db->insert('ci_product_image', $imgData);
			}
			return true;
		}

		//---------------------------------------------------
		// get all categories for server-side datatable processing (ajax based)
		public function get_all_products(){
			$wh =array();
			$SQL ='SELECT * FROM ci_products ';
			 		
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
		public function get_product_by_slug($slug){
			$this->db->select('p.*,pi.image');
			$this->db->from('ci_products as p');
			$this->db->where('p.id',$slug);
			$this->db->join('ci_product_image as pi', 'pi.product_id = p.id','left'); 
			return $this->db->get()->row_array();			
		}

		public function get_products(){
			$query = $this->db->get_where('ci_products', array('is_active' => 1));
			return $result = $query->result_array();
		}

		//---------------------------------------------------
		// Get user detial by ID
		

		//---------------------------------------------------
		// Get product category detial by ID
		public function get_product_category($id){
			$this->db->select('ci_categories.id, ci_categories.name');
			$this->db->from('ci_product_to_category');
			$this->db->where('product_id', $id);
			$this->db->join('ci_categories', 'ci_categories.id = ci_product_to_category.category_id');
			$query = $this->db->get(); 
			return $result = $query->result_array();
		}
		
		//---------------------------------------------------
		// Get product image detial by ID
		public function get_product_image($id){
			$this->db->select('id, product_id, image, sort_order');
			$this->db->from('ci_product_image');
			$this->db->where('product_id', $id);
			$this->db->order_by('sort_order', 'asc');
			$query = $this->db->get(); 
			return $result = $query->result_array();
		}

		//---------------------------------------------------
		// Edit user Record
		public function edit_product($data, $image, $id){
			$pro=[]; 
			$catData = [];
			$imgData = [];
			foreach ($data as $key => $value) {
				if($key!='category_id' && $key!='img_order'){
					$pro[$key]=$value;
				}
			}
			$procat= explode(',', $data['category_id']);
			/// Update Product Data
			$this->db->where('id', $id);
			$this->db->update('ci_products', $pro);  
			/// Insert Category Data
			$this->db->delete('ci_product_to_category', array('product_id' => $id));
			foreach ($procat as $ckey => $cvalue) {
				$catData['product_id'] = $id;
				$catData['category_id'] = $cvalue;
				$this->db->insert('ci_product_to_category', $catData); 
			}
			/// Insert image Data
			if(!empty($image)){
				$this->db->delete('ci_product_image', array('product_id' => $id));
				foreach ($image as $ikey => $ivalue) {
					$imgData['product_id'] = $id;
					$imgData['image'] = $ivalue;
					$imgData['sort_order'] = $data['img_order'][$ikey];
					$this->db->insert('ci_product_image', $imgData);
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
			$this->db->update('ci_products');
		} 

		//---------------------------------------------------
		// get categories for csv export
		public function get_products_for_export(){
			///$this->db->where('is_admin', 0);
			$this->db->select('id, name, model, price, special_price, sort_order, created_at');
			$this->db->from('ci_products');
			$query = $this->db->get();
			return $result = $query->result_array();
		}

		public function getTotalProducts($data = array()) {
			$sql = "SELECT COUNT(p.id) AS total";
 			$sql .= " FROM ci_products p"; 
			$sql .= " left join ci_product_to_category p2c on p2c.product_id=p.id";  
			$sql .= " where is_active=1 ";
			if (!empty($data['category_id'])) {
				$sql .= " AND p2c.category_id = '" . (int)$data['category_id'] . "'"; 
			}  
			$query = $this->db->query($sql);
			$result = $query->row_array(); 
			
			return $result['total'];
		}
		
		public function getProducts($data = array(),$category_id) {
			$sql = "SELECT p.*,(select image from ci_product_image pi where pi.product_id=p.id order by sort_order ASC LIMIT 1 ) as image, c.name as category_name";
 			$sql .= " FROM ci_products p"; 
			$sql .= " left join ci_product_to_category p2c on p2c.product_id=p.id";
			$sql .= " left join ci_categories c on p2c.category_id=c.id";  
			$sql .= " where p.is_active=1 ";
			if (!empty($data['category_id'])) {
				$sql .= " AND p2c.category_id = '" . (int)$data['category_id'] . "'"; 
			}  
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

		public function allproducts($cat_id,$search,$start,$limit){
	    	$this->db->select('p.*,pi.image');
			$this->db->from('ci_products as p');
			if($search != ""){
			$this->db->like('name',$search);
		     }
			if($cat_id){
			$this->db->where('pc.category_id',$cat_id);
			$this->db->join('ci_product_to_category as pc', 'pc.product_id = p.id','inner'); 				
			}
			$this->db->where('is_active=1');
			$this->db->limit($limit,$start);
			$this->db->join('ci_product_image as pi', 'pi.product_id = p.id','left'); 
			return $this->db->get()->result();
			// print_r($this->db->last_query()); die;

			 
		}
		public function count_product(){
         	$this->db->select("*");
            $this->db->from('ci_products');
			$query = $this->db->get();
			return $query->num_rows();
		}
		
		public function getProductdetail($id) {
			$sql = "SELECT p.*,(select image from ci_product_image pi where pi.product_id=p.id order by sort_order ASC LIMIT 1 ) as image";
 			$sql .= " FROM ci_products p";   
			$sql .= " where is_active=1 ";
			if (!empty($id)) {
				$sql .= " AND p.slug = '" . $id . "'"; 
			}   
			$query = $this->db->query($sql);
			return $result = $query->row_array(); 			 
		}


		public function getProductimages($id) {
			$sql = "SELECT * ";
 			$sql .= " FROM ci_product_image pi";  
			if (!empty($id)) {
				$sql .= " where pi.product_id = '" . (int)$id . "'"; 
			}   
			$sql .= " order by sort_order asc "; 

			$query = $this->db->query($sql);
			return $result = $query->result_array(); 			 
		} 

		public function getProductcategory($id) {
			$sql = "SELECT c.* ";
 			$sql .= " FROM ci_product_to_category p2c";  
 			$sql .= " left join ci_categories c on p2c.category_id=c.id";  
			if (!empty($id)) {
				$sql .= " where p2c.product_id = '" . (int)$id . "'"; 
			}   
			$sql .= " order by c.sort_order asc "; 

			$query = $this->db->query($sql);
			return $result = $query->result_array(); 			 
		}



	}

?>