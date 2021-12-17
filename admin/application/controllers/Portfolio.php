<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Portfolio extends MY_Controller {

	public function __construct(){
		parent::__construct();
		auth_check(); // check login auth
		check_premissions($this->router->fetch_class(), $this->router->fetch_method());
		check_user_premissions($this->session->userdata('admin_id'), $this->router->fetch_class(), $this->router->fetch_method());
		$this->load->model('Portfolio_model', 'portfolio_model');
		$this->load->model('category_model', 'category_model');
		$this->load->library('datatable'); // loaded my custom serverside datatable library
	}

	public function index(){
		$data['title'] = 'Portfolio List';

		$this->load->view('includes/_header', $data);
		$this->load->view('portfolio/portfolio_list');
		$this->load->view('includes/_footer');
	}
	
	public function datatable_json(){				   					   
		$records = $this->portfolio_model->get_all_portfolio();
		$data = array();
		$i = 0;
		foreach ($records['data']  as $row) 
		{  
			$status = ($row['is_active'] == 1)? 'checked': '';
			$data[]= array(
				++$i,
				$row['name'],
				$row['sort_description'],
				$row['feature'],
				$row['sort_order'],
				date_time($row['created_at']),	
				'<input class="tgl_checkbox tgl-ios" 
				data-id="'.$row['id'].'" 
				id="cb_'.$row['id'].'"
				type="checkbox"  
				'.$status.'><label for="cb_'.$row['id'].'"></label>',		

				'<a title="Edit" class="update btn btn-sm btn-warning" href="'.base_url('portfolio/edit/'.$row['id']).'"> <i class="fa fa-pencil-square-o"></i></a>
				<a title="Delete" class="delete btn btn-sm btn-danger" href='.base_url("portfolio/delete/".$row['id']).' title="Delete" onclick="return confirm(\'Do you want to delete ?\')"> <i class="fa fa-trash-o"></i></a>'
			);
		}
		$records['data']=$data;
		echo json_encode($records);						   
	}

	//-----------------------------------------------------------
	public function change_status(){   

		$this->portfolio_model->change_status();
	}

	//-----------------------------------------------------------
	public function add(){

		if($this->input->post('submit')){
			$this->form_validation->set_rules('name', 'Name', 'trim|required');
			$this->form_validation->set_rules('sort_description', 'Sort Description', 'trim|required');
			$this->form_validation->set_rules('sort_order', 'Sort Order', 'trim|required'); 
			$this->form_validation->set_rules('description', 'Description', 'trim|required');
			$this->form_validation->set_rules('meta_title', 'Meta Title', 'trim|required');
			$this->form_validation->set_rules('meta_keyword', 'Meta Keyword', 'trim|required');
			$this->form_validation->set_rules('meta_description', 'Meta Description', 'trim|required');		
			$this->form_validation->set_rules('feature', 'Featured', 'trim|required');
			$this->form_validation->set_rules('status', 'Status', 'trim|required');
 
			if ($this->form_validation->run() == FALSE) {

				$data = array(
					'errors' => validation_errors()
				);
				$data['pro'] = array(					
					'name' => $this->input->post('name'),
					'sort_description' => $this->input->post('sort_description'),		
					'sort_order' => $this->input->post('sort_order'),
					'description' => $this->input->post('description'),
					'meta_title' =>  $this->input->post('meta_title'),
					'meta_keyword' =>  $this->input->post('meta_keyword'),
					'meta_description' =>  $this->input->post('meta_description'),
					'feature' =>  $this->input->post('feature'),
					'is_active' => $this->input->post('status'),
				); 
				$this->session->set_flashdata('errors', $data['errors']);
				$this->load->view('includes/_header');
				$this->load->view('portfolio/portfolio_add',$data);
				$this->load->view('includes/_footer'); 
			}
			else{   
				$filedold= @$_POST['old_image'];
				$filedfile=$_FILES['image'];
				$data = array( 
					'slug' => $this->input->post('slug'),
					'name' => $this->input->post('name'),
					'sort_description' => $this->input->post('sort_description'),		
					'sort_order' => $this->input->post('sort_order'),
					'description' => $this->input->post('description'),
					'meta_title' =>  $this->input->post('meta_title'),
					'meta_keyword' =>  $this->input->post('meta_keyword'),
					'meta_description' =>  $this->input->post('meta_description'),
					'feature' =>  $this->input->post('feature'),
					'is_active' => $this->input->post('status'),
					'img_order' => $this->input->post('img_order'),
					'updated_by' => $this->session->userdata('admin_id'), 
					'created_at' => date('Y-m-d : h:m:s'),
					'updated_at' => date('Y-m-d : h:m:s'),
				);   
				foreach ($filedold as $key => $value) {
					$oldfile[$key]= $value;
				}  				 
				$path="assets/img/portfolio/";				
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
						}else{ 
							$this->session->set_flashdata('error', $result['msg']);
							redirect(base_url('portfolio/add'), 'refresh');
						} 	
					}
				}  
				$data = $this->security->xss_clean($data);
				$result = $this->portfolio_model->add_portfolio($data,$image);
				 
				if($result){
					$this->session->set_flashdata('success', 'Portfolio has been added successfully!');
					redirect(base_url('portfolio'));
				}
			}
		}
		else{

			$data['title'] = 'Add Portfolio';
			$data['parcat']=$this->category_model->getallCategory();

			$this->load->view('includes/_header', $data);
			$this->load->view('portfolio/portfolio_add');
			$this->load->view('includes/_footer');
		}
		
	}

	//-----------------------------------------------------------
	public function edit($id = 0){
		$checkid = $this->portfolio_model->get_portfolio_by_id($id);
		if (empty($checkid)) {
			$this->session->set_flashdata('error', 'Unauthenticated Access ');
			redirect(base_url('portfolio'), 'refresh');
		}

		if($this->input->post('submit')){
			$this->form_validation->set_rules('name', 'Name', 'trim|required');
			$this->form_validation->set_rules('sort_description', 'Sort Description', 'trim|required');
			$this->form_validation->set_rules('sort_order', 'Sort Order', 'trim|required'); 
			$this->form_validation->set_rules('description', 'Description', 'trim|required');
			$this->form_validation->set_rules('meta_title', 'Meta Title', 'trim|required');
			$this->form_validation->set_rules('meta_keyword', 'Meta Keyword', 'trim|required');
			$this->form_validation->set_rules('meta_description', 'Meta Description', 'trim|required');
			$this->form_validation->set_rules('feature', 'Featured', 'trim|required');
			$this->form_validation->set_rules('status', 'Status', 'trim|required'); 

			if ($this->form_validation->run() == FALSE) { 
				$data = array(
					'errors' => validation_errors()
				);
				$data['pro'] = array( 
					'id'=>$id,
					'slug' => $this->input->post('slug'),
					'name' => $this->input->post('name'),
					'sort_description' => $this->input->post('sort_description'),		
					'sort_order' => $this->input->post('sort_order'),
					'description' => $this->input->post('description'),
					'meta_title' =>  $this->input->post('meta_title'),
					'meta_keyword' =>  $this->input->post('meta_keyword'),
					'meta_description' =>  $this->input->post('meta_description'),
					'feature' =>  $this->input->post('feature'),
					'is_active' => $this->input->post('status'),
				);
		
				$data['proimage'] = $this->portfolio_model->get_portfolio_image($id);
			
				$this->session->set_flashdata('errors', $data['errors']);
				$this->load->view('includes/_header');
				$this->load->view('portfolio/portfolio_edit',$data);
				$this->load->view('includes/_footer');  
			}
			else{
				$filedold=$_POST['old_image'];
				$filedfile=$_FILES['image'];
				$data = array(
					'name' => $this->input->post('name'),
					'slug' => $this->input->post('slug'),
					'sort_description' => $this->input->post('sort_description'),		
					'sort_order' => $this->input->post('sort_order'),
					'description' => $this->input->post('description'),
					'meta_title' =>  $this->input->post('meta_title'),
					'meta_keyword' =>  $this->input->post('meta_keyword'),
					'meta_description' =>  $this->input->post('meta_description'),
					'feature' =>  $this->input->post('feature'),
					'is_active' => $this->input->post('status'),
					'updated_by' => $this->session->userdata('admin_id'),
					'img_order' => $this->input->post('img_order'),
					'updated_at' => date('Y-m-d : h:m:s'),
				);  
				foreach ($filedold as $key => $value) {
					$oldfile[$key]= $value;
				}  
				$path="assets/img/portfolio/";
				
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
							redirect(base_url('portfolio/edit/'.$id), 'refresh');
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
				$result = $this->portfolio_model->edit_portfolio($data, $image, $id);
				if($result){
					$this->session->set_flashdata('success', 'portfolio has been updated successfully!');
					redirect(base_url('portfolio'));
				}
			}
		}
		else{
			$data['title'] = 'Edit portfolio';
			$data['pro'] = $this->portfolio_model->get_portfolio_by_id($id);
			$data['proimage'] = $this->portfolio_model->get_portfolio_image($id);

			$this->load->view('includes/_header', $data);
			$this->load->view('portfolio/portfolio_edit', $data);
			$this->load->view('includes/_footer');
		}
	} 

	//-----------------------------------------------------------
	public function delete($id = 0)
	{	
		$this->db->delete('ci_portfolio_image', array('portfolio_id' => $id));
		$this->db->delete('ci_portfolio', array('id' => $id));
		$this->session->set_flashdata('success', 'portfolio has been deleted successfully!');
		redirect(base_url('portfolio'));
	}

	//---------------------------------------------------------------
	//  Export portfolio PDF 
	public function create_portfolio_pdf(){
		$this->load->helper('pdf_helper'); // loaded pdf helper
		$data['all_portfolio'] = $this->portfolio_model->get_portfolio_for_export();
		$this->load->view('portfolio/portfolio_pdf', $data);
	}

	//---------------------------------------------------------------	
	// Export data in CSV format 
	public function export_csv(){ 
	   // file name 
		$filename = 'portfolio_'.date('Y-m-d').'.csv'; 
		header("Content-Description: File Transfer"); 
		header("Content-Disposition: attachment; filename=$filename"); 
		header("Content-Type: application/csv; ");

	   // get data 
		$pro_data = $this->portfolio_model->get_portfolio_for_export();

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