<?php
	class Category_model extends CI_Model{

		public function add_category($data){
			$this->db->insert('ci_categories', $data);
			return true;
		}

		//---------------------------------------------------
		// get all categories for server-side datatable processing (ajax based)
		public function get_all_categories(){
			$wh =array();
			$SQL ='SELECT c1.id, 
					case WHEN c1.parent_id!=0 THEN c3.name ELSE "" END as main_id, 
					case WHEN c2.parent_id=0 THEN c2.name ELSE 
					case WHEN c1.parent_id!=0 THEN c2.name ELSE "" END END as parent_id,
					c1.name, c1.sort_order, c1.created_at, c1.is_active FROM ci_categories c1  
					LEFT JOIN ci_categories c2 ON (c1.parent_id = c2.id)
					LEFT JOIN ci_categories c3 ON (c2.parent_id = c3.id)';
			if(!empty($_GET['search']['value'])){
				$wh[] = " (c2.name like '%".$_GET['search']['value']."%') or (c3.name like '%".$_GET['search']['value']."%')";	
			}			
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

		public function getallCategory(){
			$query = $this->db->query('SELECT c1.id, 
					case WHEN c1.parent_id!=0 THEN c3.name ELSE "" END as main_id, 
					case WHEN c2.parent_id=0 THEN c2.name ELSE 
					case WHEN c1.parent_id!=0 THEN c2.name ELSE "" END END as parent_id,
					c1.name FROM ci_categories c1  
					LEFT JOIN ci_categories c2 ON (c1.parent_id = c2.id)
					LEFT JOIN ci_categories c3 ON (c2.parent_id = c3.id)
					where c1.is_active=1 order by c3.name, c2.name, c1.name');
			$records = $query->result_array();	
			$newRecord = [];	
			foreach ($records as $key =>  $row) 
			{ 
				$catName = '';	
				if($row['main_id']){ $catName = $row['main_id'].' >> '; }
				if($row['parent_id']){ $catName.= $row['parent_id'].' >> '; }
				if($row['name']){ $catName.= $row['name'];}
				$newRecord[$key]['id'] = $row['id'];
				$newRecord[$key]['name'] = $catName; 
			}
			return $newRecord;
		}

		public function getparentCat(){  
			$query = $this->db->query('SELECT c1.id, 
					case WHEN c1.parent_id!=0 THEN c3.name ELSE "" END as main_id, 
					case WHEN c2.parent_id=0 THEN c2.name ELSE 
					case WHEN c1.parent_id!=0 THEN c2.name ELSE "" END END as parent_id,
					c1.name FROM ci_categories c1  
					LEFT JOIN ci_categories c2 ON (c1.parent_id = c2.id)
					LEFT JOIN ci_categories c3 ON (c2.parent_id = c3.id)
					where c1.is_active=1 order by c3.name, c2.name, c1.name');
			$records = $query->result_array();	
			$newRecord = [];	
			foreach ($records as $key =>  $row) 
			{ 
				if(empty($row['main_id'])){
				$catName = '';	
				if($row['main_id']){ $catName = $row['main_id'].' >> '; }
				if($row['parent_id']){ $catName.= $row['parent_id'].' >> '; }
				if($row['name']){ $catName.= $row['name'];}
				$newRecord[$key]['id'] = $row['id'];
				$newRecord[$key]['name'] = $catName; 
				}
			}
			return $newRecord;
		}

		//---------------------------------------------------
		// Get user detial by ID
		public function get_category_by_id($id){
			$query = $this->db->get_where('ci_categories', array('id' => $id));
			return $result = $query->row_array();
		}

		//---------------------------------------------------
		// Edit user Record
		public function edit_category($data, $id){
			$this->db->where('id', $id);
			$this->db->update('ci_categories', $data);
			return true;
		}

		//---------------------------------------------------
		// Change user status
		//-----------------------------------------------------
		function change_status()
		{		
			$this->db->set('is_active', $this->input->post('status'));
			$this->db->where('id', $this->input->post('id'));
			$this->db->update('ci_categories');
		} 

		//---------------------------------------------------
		// get categories for csv export
		public function get_categories_for_export(){
			$query = $this->db->query('SELECT c1.id, 
					case WHEN c1.parent_id!=0 THEN c3.name ELSE "" END as main_id, 
					case WHEN c2.parent_id=0 THEN c2.name ELSE 
					case WHEN c1.parent_id!=0 THEN c2.name ELSE "" END END as parent_id,
					c1.name, c1.sort_order, c1.created_at, c1.is_active FROM ci_categories c1  
					LEFT JOIN ci_categories c2 ON (c1.parent_id = c2.id)
					LEFT JOIN ci_categories c3 ON (c2.parent_id = c3.id)'); 
			return $result = $query->result_array();
		}

		public function get_sub_category($id){
			if($id!=0){
				$query = $this->db->query('SELECT c1.id, c1.name FROM ci_categories c1 where c1.parent_id='.$id.''); 
				$result = $query->result_array(); 
				$optData = '<option value="0">Parent</option>';
				foreach ($result as $key => $value) {
					$optData.='<option value="'.$value['id'].'">'.$value['name'].'</option>'; 
				}
			}else{
				$optData = '<option value="0">Parent</option>';
			}
			return $optData;
		}
	}

?>