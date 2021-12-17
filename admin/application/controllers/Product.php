<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Product extends MY_Controller {

	public function __construct(){
		parent::__construct();
		auth_check(); // check login auth
		check_premissions($this->router->fetch_class(), $this->router->fetch_method());
		check_user_premissions($this->session->userdata('admin_id'), $this->router->fetch_class(), $this->router->fetch_method());
		$this->load->model('product_model', 'product_model');
		$this->load->model('category_model', 'category_model');
		$this->load->library('datatable'); // loaded my custom serverside datatable library
	}

	public function index(){
		$data['title'] = 'products List';

		$this->load->view('includes/_header', $data);
		$this->load->view('products/product_list');
		$this->load->view('includes/_footer');
	}
	
	public function datatable_json(){				   					   
		$records = $this->product_model->get_all_products();
		$data = array();
		$newRecord = [];
		foreach ($records['data']  as $key =>  $row) 
		{ 
			$proPrice = '';	
			if(!empty($row['special_price'])){ $proPrice = '<span style="text-decoration:line-through">'.$this->general_settings['currency'].' '.$row['price'].'</span><br>'.$this->general_settings['currency'].' '.$row['special_price']; }else{ $proPrice = $row['price']; } 
			$newRecord[$key]['id'] = $row['id'];
			$newRecord[$key]['model'] = $row['model'];
			$newRecord[$key]['name'] = $row['name'];
			$newRecord[$key]['price'] = $proPrice;
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
				$row['model'],
				$row['name'],
				$row['price'],
				$row['sort_order'],
				date_time($row['created_at']),	
				'<input class="tgl_checkbox tgl-ios" 
				data-id="'.$row['id'].'" 
				id="cb_'.$row['id'].'"
				type="checkbox"  
				'.$status.'><label for="cb_'.$row['id'].'"></label>',		

				'<a title="Edit" class="update btn btn-sm btn-warning" href="'.base_url('product/edit/'.$row['id']).'"> <i class="fa fa-pencil-square-o"></i></a>
				<a title="Delete" class="delete btn btn-sm btn-danger" href='.base_url("product/delete/".$row['id']).' title="Delete" onclick="return confirm(\'Do you want to delete ?\')"> <i class="fa fa-trash-o"></i></a>'
			);
		}
		$records['data']=$data;
		echo json_encode($records);						   
	}

	//-----------------------------------------------------------
	public function change_status(){   

		$this->product_model->change_status();
	}

	//-----------------------------------------------------------
	public function add(){

		if($this->input->post('submit')){
			$this->form_validation->set_rules('category_id', 'Category', 'trim|required');
			$this->form_validation->set_rules('model', 'Model', 'trim|required');
			//$this->form_validation->set_rules('sku', 'SKU', 'trim|required');
			$this->form_validation->set_rules('name', 'Name', 'trim|required');
			$this->form_validation->set_rules('sort_description', 'Sort Description', 'trim|required');
			$this->form_validation->set_rules('price', 'Price', 'trim|required');
			///$this->form_validation->set_rules('special_price', 'Special Price', 'trim|required');
			$this->form_validation->set_rules('sort_order', 'Sort Order', 'trim|required'); 
			$this->form_validation->set_rules('description', 'Description', 'trim|required');
			$this->form_validation->set_rules('meta_title', 'Meta Title', 'trim|required');
			$this->form_validation->set_rules('meta_keyword', 'Meta Keyword', 'trim|required');
			$this->form_validation->set_rules('meta_description', 'Meta Description', 'trim|required');		
			$this->form_validation->set_rules('is_topsell', 'Is Top Selling', 'trim|required');		 
			$this->form_validation->set_rules('is_feature', 'Is Featured', 'trim|required');
			$this->form_validation->set_rules('status', 'Status', 'trim|required');
			$this->form_validation->set_rules('slug', 'Seo URL', 'trim|required');

			if ($this->form_validation->run() == FALSE) {
				$data = array(
					'errors' => validation_errors()
				);
				$data['pro'] = array( 
					'category_id' => $this->input->post('category_id'),
					'model' => $this->input->post('model'),
					'slug' => $this->input->post('slug'),
					'sku' => $this->input->post('sku'),
					'name' => $this->input->post('name'),
					'sort_description' => $this->input->post('sort_description'),
					'price' => $this->input->post('price'),
					'special_price' => $this->input->post('special_price'),
					'sort_order' => $this->input->post('sort_order'),
					'description' => $this->input->post('description'),
					'meta_title' =>  $this->input->post('meta_title'),
					'meta_keyword' =>  $this->input->post('meta_keyword'),
					'meta_description' =>  $this->input->post('meta_description'),
					'is_topsell' =>  $this->input->post('is_topsell'),
					'is_feature' =>  $this->input->post('is_feature'),
					'status' => $this->input->post('status'),
				);
				$data['parcat']=$this->category_model->getallCategory();
				$this->session->set_flashdata('errors', $data['errors']);
				$this->load->view('includes/_header');
				$this->load->view('products/product_add',$data);
				$this->load->view('includes/_footer'); 
			}
			else{   
				$filedold= @$_POST['old_image'];
				$filedfile=$_FILES['image'];
				$old_brochure = $this->input->post('old_brochure');
				$data = array(
					'category_id' => $this->input->post('category_id'),
					'model' => $this->input->post('model'),
					'slug' => $this->input->post('slug'),
					'sku' => $this->input->post('sku'),
					'name' => $this->input->post('name'),
					'sort_description' => $this->input->post('sort_description'),
					'price' => $this->input->post('price'),
					'sort_order' => $this->input->post('sort_order'),
					'special_price' => $this->input->post('special_price'),
					'description' => $this->input->post('description'),
					'meta_title' =>  $this->input->post('meta_title'),
					'meta_keyword' =>  $this->input->post('meta_keyword'),
					'meta_description' =>  $this->input->post('meta_description'),
					'is_topsell' =>  $this->input->post('is_topsell'),
					'is_feature' =>  $this->input->post('is_feature'),
					'is_active' => $this->input->post('status'),
					'created_by' => $this->session->userdata('admin_id'),
					'updated_by' => $this->session->userdata('admin_id'),
					'img_order' => $this->input->post('img_order'),
					'created_at' => date('Y-m-d : h:m:s'),
					'updated_at' => date('Y-m-d : h:m:s'),
				);  
				foreach ($filedold as $key => $value) {
					$oldfile[$key]= $value;
				}  
				 
				$path="assets/img/product/";
				if(!empty($_FILES['brochure']['name']))
				{
					if(!empty($old_brochure)){
						$this->functions->delete_file($old_brochure);
					}
					$result = $this->functions->file_insert($path, 'brochure', 'pdf', '9097152');
					if($result['status'] == 1){
						$data['brochure'] = $path.$result['msg'];
					}
					else{
						$this->session->set_flashdata('error', $result['msg']);
						redirect(base_url('product/add'), 'refresh');
					}
				}
				$image = []; 
				foreach ($filedfile['name'] as $key => $value) { 
					if(!empty($value['image']))
					{    
						$size =  '9097152';
						$filename = $filedfile['name'][$key]['image'];
						$filetempname = $filedfile['tmp_name'][$key]['image'];
						$file_extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
						$filesize = $filedfile['size'][$key]['image'];  
						$result = $this->functions->file_insert_bulk($path, $filename, $filetempname, $file_extension, $filesize, $size); 
						if($result['status'] == 1){
							$logo = $path.$result['msg'];
							$image[$key] = $logo; 
						}
						else{
							$this->session->set_flashdata('error', $result['msg']);
							redirect(base_url('product/add'), 'refresh');
						} 	
					}
				}  
				$data = $this->security->xss_clean($data);
				$result = $this->product_model->add_product($data,$image);
				if($result){
					$this->session->set_flashdata('success', 'products has been added successfully!');
					redirect(base_url('product'));
				}
			}
		}
		else{

			$data['title'] = 'Add products';
			$data['parcat']=$this->category_model->getallCategory();

			$this->load->view('includes/_header', $data);
			$this->load->view('products/product_add');
			$this->load->view('includes/_footer');
		}
		
	}

	//-----------------------------------------------------------
	public function edit($id = 0){

		if($this->input->post('submit')){
			$this->form_validation->set_rules('category_id', 'Category', 'trim|required');
			$this->form_validation->set_rules('model', 'Model', 'trim|required');
			//$this->form_validation->set_rules('sku', 'SKU', 'trim|required');
			$this->form_validation->set_rules('name', 'Name', 'trim|required');
			$this->form_validation->set_rules('sort_description', 'Sort Description', 'trim|required');
			$this->form_validation->set_rules('price', 'Price', 'trim|required');
			///$this->form_validation->set_rules('special_price', 'Special Price', 'trim|required');
			$this->form_validation->set_rules('sort_order', 'Sort Order', 'trim|required'); 
			$this->form_validation->set_rules('description', 'Description', 'trim|required');
			$this->form_validation->set_rules('meta_title', 'Meta Title', 'trim|required');
			$this->form_validation->set_rules('meta_keyword', 'Meta Keyword', 'trim|required');
			$this->form_validation->set_rules('meta_description', 'Meta Description', 'trim|required');		
			$this->form_validation->set_rules('is_topsell', 'Is Top Selling', 'trim|required');	 
			$this->form_validation->set_rules('is_feature', 'Is Featured', 'trim|required');
			$this->form_validation->set_rules('status', 'Status', 'trim|required');
			$this->form_validation->set_rules('slug', 'Seo URL', 'trim|required');
			
			if ($this->form_validation->run() == FALSE) { 
				$data = array(
					'errors' => validation_errors()
				);
				$data['pro'] = array( 
					'id'=>$id,
					'category_id' => $this->input->post('category_id'),
					'slug' => $this->input->post('slug'),
					'model' => $this->input->post('model'),
					'sku' => $this->input->post('sku'),
					'name' => $this->input->post('name'),
					'sort_description' => $this->input->post('sort_description'),
					'price' => $this->input->post('price'),
					'special_price' => $this->input->post('special_price'),
					'sort_order' => $this->input->post('sort_order'),
					'description' => $this->input->post('description'),
					'meta_title' =>  $this->input->post('meta_title'),
					'meta_keyword' =>  $this->input->post('meta_keyword'),
					'meta_description' =>  $this->input->post('meta_description'),
					'is_topsell' =>  $this->input->post('is_topsell'),
					'is_feature' =>  $this->input->post('is_feature'),
					'is_active' => $this->input->post('status'),
				);
				////print_r($data); exit;
				$data['procategory'] = $this->product_model->get_product_category($id);
				$data['proimage'] = $this->product_model->get_product_image($id);
				$data['parcat']=$this->category_model->getallCategory();
				$this->session->set_flashdata('errors', $data['errors']);
				$this->load->view('includes/_header');
				$this->load->view('products/product_edit',$data);
				$this->load->view('includes/_footer');  
			}
			else{
				$filedold=$_POST['old_image'];
				$filedfile=$_FILES['image'];
				$old_brochure = $this->input->post('old_brochure');
				$data = array(
					'category_id' => $this->input->post('category_id'),
					'slug' => $this->input->post('slug'),
					'model' => $this->input->post('model'),
					'sku' => $this->input->post('sku'),
					'name' => $this->input->post('name'),
					'sort_description' => $this->input->post('sort_description'),
					'price' => $this->input->post('price'),
					'sort_order' => $this->input->post('sort_order'),
					'special_price' => $this->input->post('special_price'),
					'description' => $this->input->post('description'),
					'meta_title' =>  $this->input->post('meta_title'),
					'meta_keyword' =>  $this->input->post('meta_keyword'),
					'meta_description' =>  $this->input->post('meta_description'),
					'is_topsell' =>  $this->input->post('is_topsell'),
					'is_feature' =>  $this->input->post('is_feature'),
					'is_active' => $this->input->post('status'),
					'updated_by' => $this->session->userdata('admin_id'),
					'img_order' => $this->input->post('img_order'),
					'updated_at' => date('Y-m-d : h:m:s'),
				);  
				foreach ($filedold as $key => $value) {
					$oldfile[$key]= $value;
				}  
				$path="assets/img/product/";
				if(!empty($_FILES['brochure']['name']))
				{
					if(!empty($old_brochure)){
						$this->functions->delete_file($old_brochure);
					}
					$result = $this->functions->file_insert($path, 'brochure', 'pdf', '9097152');
					if($result['status'] == 1){
						$data['brochure'] = $path.$result['msg'];
					}
					else{
						$this->session->set_flashdata('error', $result['msg']);
						redirect(base_url('product/edit/'.$id), 'refresh');
					}
				}
				$image = []; 
				foreach ($filedfile['name'] as $key => $value) { 
					if(!empty($value['image']))
					{   
						$size =  '9097152';
						$filename = $filedfile['name'][$key]['image'];
						$filetempname = $filedfile['tmp_name'][$key]['image'];
						$file_extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
						$filesize = $filedfile['size'][$key]['image'];  
						$result = $this->functions->file_insert_bulk($path, $filename, $filetempname, $file_extension, $filesize, $size); 
						if($result['status'] == 1){
							$logo = $path.$result['msg'];
							$image[$key] = $logo; 
						}
						else{
							$this->session->set_flashdata('error', $result['msg']);
							redirect(base_url('product/edit/'.$id), 'refresh');
						} 	
					}
				}  
				foreach ($oldfile as $key => $value) {
					if(isset($image[$key])){ 
						$this->functions->delete_file($value['image']); 
					}else{
						$image[$key] = $value['image']; 
					}
				} 
				$data = $this->security->xss_clean($data);
				$result = $this->product_model->edit_product($data, $image, $id);
				if($result){
					$this->session->set_flashdata('success', 'products has been updated successfully!');
					redirect(base_url('product'));
				}
			}
		}
		else{
			$data['title'] = 'Edit products';
			$data['pro'] = $this->product_model->get_product_by_slug($id);
			$data['procategory'] = $this->product_model->get_product_category($id);
			$data['proimage'] = $this->product_model->get_product_image($id);
			$data['parcat']=$this->category_model->getallCategory();

			$this->load->view('includes/_header', $data);
			$this->load->view('products/product_edit', $data);
			$this->load->view('includes/_footer');
		}
	} 

	//-----------------------------------------------------------
	public function delete($id = 0)
	{	
		$this->db->delete('ci_product_image', array('product_id' => $id));
		$this->db->delete('ci_product_to_category', array('product_id' => $id));
		$this->db->delete('ci_product_image', array('id' => $id));
		$this->session->set_flashdata('success', 'products has been deleted successfully!');
		redirect(base_url('product'));
	}

	//---------------------------------------------------------------
	//  Export products PDF 
	public function create_product_pdf(){
		$this->load->helper('pdf_helper'); // loaded pdf helper
		$data['all_products'] = $this->product_model->get_products_for_export();
		$this->load->view('products/product_pdf', $data);
	}

	//---------------------------------------------------------------	
	// Export data in CSV format 
	public function export_csv(){ 
	   // file name 
		$filename = 'products_'.date('Y-m-d').'.csv'; 
		header("Content-Description: File Transfer"); 
		header("Content-Disposition: attachment; filename=$filename"); 
		header("Content-Type: application/csv; ");

	   // get data 
		$pro_data = $this->product_model->get_products_for_export();

	   // file creation 
		$file = fopen('php://output', 'w');

		$header = array("ID", "Model", "Name", "Price", "Special Price", "Sort Order", "Created Date"); 

		fputcsv($file, $header);
		foreach ($pro_data as $key=>$line){ 
			fputcsv($file,$line); 
		}
		fclose($file); 
		exit; 
	}


}


	?>