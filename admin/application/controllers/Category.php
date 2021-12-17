<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Category extends MY_Controller {

	public function __construct(){
		parent::__construct();
		auth_check(); // check login auth
		check_premissions($this->router->fetch_class(), $this->router->fetch_method());
		check_user_premissions($this->session->userdata('admin_id'), $this->router->fetch_class(), $this->router->fetch_method());
		$this->load->model('category_model', 'category_model');
		$this->load->library('datatable'); // loaded my custom serverside datatable library
	}

	public function index(){
		$data['title'] = 'Categories List';

		$this->load->view('includes/_header', $data);
		$this->load->view('categories/category_list');
		$this->load->view('includes/_footer');
	}
	
	public function datatable_json(){				   					   
		$records = $this->category_model->get_all_categories();
		$data = array();
		$newRecord = [];
		foreach ($records['data']  as $key =>  $row) 
		{ 
			$catName = '';	
			if($row['main_id']){ $catName = $row['main_id'].' >> '; }
			if($row['parent_id']){ $catName.= $row['parent_id'].' >> '; }
			if($row['name']){ $catName.= $row['name'];}
			$newRecord[$key]['id'] = $row['id'];
			$newRecord[$key]['name'] = $catName;
			$newRecord[$key]['sort_order'] = $row['sort_order'];
			$newRecord[$key]['created_at'] = $row['created_at'];
			$newRecord[$key]['is_active'] = $row['is_active'];
		}

		$i=0;
		foreach ($newRecord  as $row) 
		{  
			$status = ($row['is_active'] == 1)? 'checked': '';
			$data[]= array(
				++$i, 
				$row['name'],
				$row['sort_order'],
				date_time($row['created_at']),	
				'<input class="tgl_checkbox tgl-ios" 
				data-id="'.$row['id'].'" 
				id="cb_'.$row['id'].'"
				type="checkbox"  
				'.$status.'><label for="cb_'.$row['id'].'"></label>',		

				'<a title="Edit" class="update btn btn-sm btn-warning" href="'.base_url('category/edit/'.$row['id']).'"> <i class="fa fa-pencil-square-o"></i></a>
				<a title="Delete" class="delete btn btn-sm btn-danger" href='.base_url("category/delete/".$row['id']).' title="Delete" onclick="return confirm(\'Do you want to delete ?\')"> <i class="fa fa-trash-o"></i></a>'
			);
		}
		$records['data']=$data;
		echo json_encode($records);						   
	}

	//-----------------------------------------------------------
	public function change_status(){   

		$this->category_model->change_status();
	}

	//-----------------------------------------------------------
	public function add(){

		if($this->input->post('submit')){
			$this->form_validation->set_rules('parent_id', 'Parent Category', 'trim|required');
			$this->form_validation->set_rules('name', 'Name', 'trim|required');
			$this->form_validation->set_rules('sort_order', 'Sort Order', 'trim|required'); 
			$this->form_validation->set_rules('description', 'Description', 'trim|required');
			$this->form_validation->set_rules('meta_title', 'Meta Title', 'trim|required');
			$this->form_validation->set_rules('meta_keyword', 'Meta Keyword', 'trim|required');
			$this->form_validation->set_rules('meta_description', 'Meta Description', 'trim|required');			 
			$this->form_validation->set_rules('is_feature', 'Is Featured', 'trim|required');
			$this->form_validation->set_rules('status', 'Status', 'trim|required');
			$this->form_validation->set_rules('slug', 'Seo URL', 'trim|required');

			if ($this->form_validation->run() == FALSE) {
				$data = array(
					'errors' => validation_errors()
				);
				$data['cat'] = array( 
					'name' => $this->input->post('name'),
					'slug' => $this->input->post('slug'),
					'parent_id' => $this->input->post('parent_id'),
					'lastname' => $this->input->post('lastname'),
					'sort_order' => $this->input->post('sort_order'),
					'description' => $this->input->post('description'),
					'meta_title' =>  $this->input->post('meta_title'),
					'meta_keyword' =>  $this->input->post('meta_keyword'),
					'meta_description' =>  $this->input->post('meta_description'),
					'is_feature' =>  $this->input->post('is_feature'),
					'is_active' => $this->input->post('status'),
				); 
				$data['parcat']=$this->category_model->getparentCat();
				$this->session->set_flashdata('errors', $data['errors']);
				$this->load->view('includes/_header');
				$this->load->view('categories/category_add', $data);
				$this->load->view('includes/_footer');
			}
			else{  
				$data = array(
					'name' => $this->input->post('name'),
					'slug' => $this->input->post('slug'),
					'parent_id' => $this->input->post('parent_id'), 
					'sort_order' => $this->input->post('sort_order'),
					'description' => $this->input->post('description'),
					'meta_title' =>  $this->input->post('meta_title'),
					'meta_keyword' =>  $this->input->post('meta_keyword'),
					'meta_description' =>  $this->input->post('meta_description'),
					'is_feature' =>  $this->input->post('is_feature'),
					'created_by' => $this->session->userdata('admin_id'),
					'updated_by' => $this->session->userdata('admin_id'),
					'is_active' => $this->input->post('status'),
					'created_at' => date('Y-m-d : h:m:s'),
					'updated_at' => date('Y-m-d : h:m:s'),
				);  
				$old_image = $this->input->post('old_image');
				$path="assets/img/category/";
				if(!empty($_FILES['image']['name']))
				{
					$this->functions->delete_file($old_image);
					$result = $this->functions->file_insert($path, 'image', 'image', '9097152');
					if($result['status'] == 1){
						$data['image'] = $path.$result['msg'];
					}
					else{
						$this->session->set_flashdata('error', $result['msg']);
						redirect(base_url('categories/add'), 'refresh');
					}
				}
				$data = $this->security->xss_clean($data);
				$result = $this->category_model->add_category($data);
				if($result){
					$this->session->set_flashdata('success', 'Categories has been added successfully!');
					redirect(base_url('category'));
				}
			}
		}
		else{

			$data['title'] = 'Add Categories';
			$data['parcat']=$this->category_model->getparentCat();

			$this->load->view('includes/_header', $data);
			$this->load->view('categories/category_add');
			$this->load->view('includes/_footer');
		}
		
	}

	//-----------------------------------------------------------
	public function edit($id = 0){

		if($this->input->post('submit')){
			$this->form_validation->set_rules('parent_id', 'Parent Category', 'trim|required');
			$this->form_validation->set_rules('name', 'Name', 'trim|required');
			$this->form_validation->set_rules('sort_order', 'Sort Order', 'trim|required'); 
			$this->form_validation->set_rules('description', 'Description', 'trim|required');
			$this->form_validation->set_rules('meta_title', 'Meta Title', 'trim|required');
			$this->form_validation->set_rules('meta_keyword', 'Meta Keyword', 'trim|required');
			$this->form_validation->set_rules('meta_description', 'Meta Description', 'trim|required');		
			$this->form_validation->set_rules('is_feature', 'Is Featured', 'trim|required');
			$this->form_validation->set_rules('status', 'Status', 'trim|required');
			$this->form_validation->set_rules('slug', 'Seo URL', 'trim|required');
			
			if ($this->form_validation->run() == FALSE) { 
				$data = array(
					'errors' => validation_errors()
				);
				$catData = $this->category_model->get_category_by_id($id);
				$data['cat'] = array(
					'id' => $id,
					'name' => $this->input->post('name'),
					'slug' => $this->input->post('slug'),
					'image' => $catData['image'],
					'parent_id' => $this->input->post('parent_id'), 
					'sort_order' => $this->input->post('sort_order'),
					'description' => $this->input->post('description'),
					'meta_title' =>  $this->input->post('meta_title'),
					'meta_keyword' =>  $this->input->post('meta_keyword'),
					'meta_description' =>  $this->input->post('meta_description'),
					'is_feature' =>  $this->input->post('is_feature'),
					'is_active' => $this->input->post('status'),
				); 
				$data['parcat']=$this->category_model->getparentCat();
				$this->session->set_flashdata('errors', $data['errors']);
				$this->load->view('includes/_header');
				$this->load->view('categories/category_edit', $data);
				$this->load->view('includes/_footer'); 
			}
			else{ 
				$data = array(
					'name' => $this->input->post('name'),
					'slug' => $this->input->post('slug'),
					'parent_id' => $this->input->post('parent_id'), 
					'sort_order' => $this->input->post('sort_order'),
					'description' => $this->input->post('description'),
					'meta_title' =>  $this->input->post('meta_title'),
					'meta_keyword' =>  $this->input->post('meta_keyword'),
					'meta_description' =>  $this->input->post('meta_description'),
					'is_feature' =>  $this->input->post('is_feature'),
					'is_active' => $this->input->post('status'),
					'updated_by' => $this->session->userdata('admin_id'),
					'updated_at' => date('Y-m-d : h:m:s'),
				);
				$old_image = $this->input->post('old_image');
				$path="assets/img/category/";
				if(!empty($_FILES['image']['name']))
				{
					if(!empty($old_image)){ 
						$this->functions->delete_file($old_image);
					}
					$result = $this->functions->file_insert($path, 'image', 'image', '9097152');
					if($result['status'] == 1){
						$data['image'] = $path.$result['msg'];
					}
					else{
						$this->session->set_flashdata('error', $result['msg']);
						redirect(base_url('categories/edit/'.$id), 'refresh');
					}
				}
				$data = $this->security->xss_clean($data);
				$result = $this->category_model->edit_category($data, $id);
				if($result){
					$this->session->set_flashdata('success', 'Categories has been updated successfully!');
					redirect(base_url('category'));
				}
			}
		}
		else{
			$data['title'] = 'Edit Categories';
			$data['cat'] = $this->category_model->get_category_by_id($id);
			$data['parcat']=$this->category_model->getparentCat();

			$this->load->view('includes/_header', $data);
			$this->load->view('categories/category_edit', $data);
			$this->load->view('includes/_footer');
		}
	}

	public function get_subcategroy(){ 
		$id = $this->input->post('id');
		$cat = $this->category_model->get_sub_category($id);
		echo $cat;
	}

	//-----------------------------------------------------------
	public function delete($id = 0)
	{		
		$query = $this->db->get_where('ci_product_to_category', array('category_id' => $id));
		$resultcat = $query->row_array();
		$this->db->delete('ci_categories', array('id' => $id));
		$this->db->delete('ci_categories', array('parent_id' => $id));	
		if(!empty($resultcat)){	
			/// Delete product image / category	
			$this->db->join("ci_product_to_category", "ci_product_to_category.product_id = ci_products.id")
			  ->where("ci_product_to_category.category_id", $id)
			  ->delete("ci_products");
			$this->db->join("ci_product_to_category", "ci_product_to_category.product_id = ci_product_image.product_id")
			  ->where("ci_product_to_category.category_id", $id)
			  ->delete("ci_product_image");  			
			$this->db->delete('ci_product_to_category', array('category_id' => $id));  
		} 
		$this->session->set_flashdata('success', 'Categories has been deleted successfully!');
		redirect(base_url('category'));
	}

	//---------------------------------------------------------------
	//  Export Categories PDF 
	public function create_category_pdf(){
		$this->load->helper('pdf_helper'); // loaded pdf helper
		$all_categories = $this->category_model->get_categories_for_export();
		$newRecord = [];
		foreach ($all_categories  as $key =>  $row) 
		{ 
			$catName = '';	
			if($row['main_id']){ $catName = $row['main_id'].' >> '; }
			if($row['parent_id']){ $catName.= $row['parent_id'].' >> '; }
			if($row['name']){ $catName.= $row['name'];}
			$newRecord[$key]['id'] = $row['id'];
			$newRecord[$key]['name'] = $catName;
			$newRecord[$key]['sort_order'] = $row['sort_order'];
			$newRecord[$key]['created_at'] = $row['created_at'];
			$newRecord[$key]['is_active'] = $row['is_active'];
		}
		$data['all_categories'] = $newRecord;
		$this->load->view('categories/category_pdf', $data);
	}

	//---------------------------------------------------------------	
	// Export data in CSV format 
	public function export_csv(){ 

	   // file name 
		$filename = 'categories_'.date('Y-m-d').'.csv'; 
		header("Content-Description: File Transfer"); 
		header("Content-Disposition: attachment; filename=$filename"); 
		header("Content-Type: application/csv; ");

	   // get data 
		$all_categories = $this->category_model->get_categories_for_export();
		$newRecord = [];
		foreach ($all_categories  as $key =>  $row) 
		{ 
			$catName = '';	
			if($row['main_id']){ $catName = $row['main_id'].' >> '; }
			if($row['parent_id']){ $catName.= $row['parent_id'].' >> '; }
			if($row['name']){ $catName.= $row['name'];}
			$newRecord[$key]['id'] = $row['id'];
			$newRecord[$key]['name'] = $catName;
			$newRecord[$key]['sort_order'] = $row['sort_order'];
			$newRecord[$key]['created_at'] = $row['created_at']; 
		} 

	   // file creation 
		$file = fopen('php://output', 'w');

		$header = array("ID", "Name", "Sort Order", "Created Date"); 

		fputcsv($file, $header);
		foreach ($newRecord as $key=>$line){ 
			fputcsv($file,$line); 
		}
		fclose($file); 
		exit; 
	}


}


	?>