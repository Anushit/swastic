<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Service extends MY_Controller {

	public function __construct(){

		parent::__construct();
		auth_check(); // check login auth
		check_premissions($this->router->fetch_class(), $this->router->fetch_method());
		check_user_premissions($this->session->userdata('admin_id'), $this->router->fetch_class(), $this->router->fetch_method());
		$this->load->model('service_model', 'service_model');
		$this->load->library('datatable'); // loaded my custom serverside datatable library
	}

	public function index(){
		$data['title'] = 'Services List';

		$this->load->view('includes/_header', $data);
		$this->load->view('service/service_list');
		$this->load->view('includes/_footer');
	}
	
	public function datatable_json(){				   					   
		$records = $this->service_model->get_all_service();
		$data = array();

		$i=0;
		foreach ($records['data']  as $row) 
		{  
			$status = ($row['is_active'] == 1)? 'checked': '';
			$data[]= array(
				++$i,
				$row['name'],
				'<img src="'.base_url($row['icon']).'" class=" logominiimg" />', 
				$row['sort_description'],
				date_time($row['created_at']),	
				'<input class="tgl_checkbox tgl-ios" 
				data-id="'.$row['id'].'" 
				id="cb_'.$row['id'].'"
				type="checkbox" '.$status.'><label for="cb_'.$row['id'].'"></label>',		

				'<a title="Edit" class="update btn btn-sm btn-warning" href="'.base_url('service/edit/'.$row['id']).'"> <i class="fa fa-pencil-square-o"></i></a>
				<a title="Delete" class="delete btn btn-sm btn-danger" href='.base_url("service/delete/".$row['id']).' title="Delete" onclick="return confirm(\'Do you want to delete ?\')"> <i class="fa fa-trash-o"></i></a>'

				 
			);
		}
		$records['data']=$data;
		echo json_encode($records);						   
	}

	//-----------------------------------------------------------
	public function change_status(){   

		$this->service_model->change_status();
	}

	//-----------------------------------------------------------
	public function add(){

		if($this->input->post('submit')){
			$this->form_validation->set_rules('name', 'Name', 'trim|required');
			$this->form_validation->set_rules('sort_order', 'Sort Order', 'trim|numeric|required');
			$this->form_validation->set_rules('sort_description', 'Sort Description', 'trim|required');  
			$this->form_validation->set_rules('status', 'Status', 'trim|required');
			$this->form_validation->set_rules('slug', 'Seo URL', 'trim|required');

			if ($this->form_validation->run() == FALSE) {
				$data = array(
					'errors' => validation_errors()
				);
				$data['service'] = array(
					'name' => $this->input->post('name'), 
					'slug' => $this->input->post('slug'),
					'sort_description' => $this->input->post('sort_description'),
					'description' => $this->input->post('description'),
					'meta_title' => $this->input->post('meta_title'),
					'meta_keyword' => $this->input->post('meta_keyword'),
					'meta_description' => $this->input->post('meta_description'),
					'sort_order' => $this->input->post('sort_order'),
					'is_active' => $this->input->post('status') 
				); 
				$this->session->set_flashdata('errors', $data['errors']); 
				$this->load->view('includes/_header');
				$this->load->view('service/service_add', $data);
				$this->load->view('includes/_footer');
			}
			else{
				$data = array(
					'name' => $this->input->post('name'), 
					'slug' => $this->input->post('slug'),
					'sort_description' => $this->input->post('sort_description'),
					'description' => $this->input->post('description'),
					'meta_title' => $this->input->post('meta_title'),
					'meta_keyword' => $this->input->post('meta_keyword'),
					'meta_description' => $this->input->post('meta_description'),
					'sort_order' => $this->input->post('sort_order'),
					'is_active' => $this->input->post('status'),
					'created_by' => $this->session->userdata('admin_id'),
					'updated_by' => $this->session->userdata('admin_id'),
					'created_at' => date('Y-m-d : h:m:s'),
					'updated_at' => date('Y-m-d : h:m:s'),
				);
				$old_icon = $this->input->post('old_icon');
				$old_icon2 = $this->input->post('old_icon2');
				$old_image = $this->input->post('old_image');
				$old_brochure = $this->input->post('old_brochure');
				$path="assets/img/service/";
				if(!empty($_FILES['icon']['name']))
				{
					if(!empty($old_icon)){
						$this->functions->delete_file($old_icon);
					}
					$result = $this->functions->file_insert($path, 'icon', 'image', '9097152');
					if($result['status'] == 1){
						$data['icon'] = $path.$result['msg'];
					}
					else{
						$this->session->set_flashdata('error', $result['msg']);
						redirect(base_url('service/add'), 'refresh');
					}
				}
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
						redirect(base_url('service/add'), 'refresh');
					}
				}	
				if(!empty($_FILES['icon2']['name']))
				{
					if(!empty($old_icon2)){
						$this->functions->delete_file($old_icon2);
					}
					$result = $this->functions->file_insert($path, 'icon2', 'image', '9097152');
					if($result['status'] == 1){
						$data['icon2'] = $path.$result['msg'];
					}
					else{
						$this->session->set_flashdata('error', $result['msg']);
						redirect(base_url('service/add'), 'refresh');
					}
				}			
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
						redirect(base_url('service/add'), 'refresh');
					}
				}
				$data = $this->security->xss_clean($data);
				$result = $this->service_model->add_service($data);
				if($result){
					$this->session->set_flashdata('success', 'Service has been added successfully!');
					redirect(base_url('service'));
				}
			}
		}
		else{
			$data['title'] = 'Add Service';
			$this->load->view('includes/_header', $data);
			$this->load->view('service/service_add');
			$this->load->view('includes/_footer');
		}
		
	}

	//-----------------------------------------------------------
	public function edit($id = 0){

		if($this->input->post('submit')){
			$this->form_validation->set_rules('name', 'Name', 'trim|required');
			$this->form_validation->set_rules('sort_order', 'Sort Order', 'trim|numeric|required');
			$this->form_validation->set_rules('sort_description', 'Sort Description', 'trim|required');  
			$this->form_validation->set_rules('status', 'Status', 'trim|required');
			$this->form_validation->set_rules('slug', 'Seo URL', 'trim|required');
			
			if ($this->form_validation->run() == FALSE) {
				$serviceData = $this->service_model->get_service_by_id($id);
				$data = array(
					'errors' => validation_errors()
				); 
				$data['service'] = array(
					'id' => $id, 
					'slug' => $this->input->post('slug'),
					'name' => $this->input->post('name'),
					'icon' => $serviceData['icon'],
					'image' => $serviceData['image'],
					'sort_description' => $this->input->post('sort_description'),
					'description' => $this->input->post('description'),
					'meta_title' => $this->input->post('meta_title'),
					'meta_keyword' => $this->input->post('meta_keyword'),
					'meta_description' => $this->input->post('meta_description'),
					'sort_order' => $this->input->post('sort_order'),
					'is_active' => $this->input->post('status') 
				);
				$this->session->set_flashdata('errors', $data['errors']);
				$this->load->view('includes/_header');
				$this->load->view('service/service_edit', $data);
				$this->load->view('includes/_footer');
			}
			else{
				$data = array(
					'name' => $this->input->post('name'), 
					'slug' => $this->input->post('slug'),
					'sort_description' => $this->input->post('sort_description'),
					'description' => $this->input->post('description'),
					'meta_title' => $this->input->post('meta_title'),
					'meta_keyword' => $this->input->post('meta_keyword'),
					'meta_description' => $this->input->post('meta_description'),
					'sort_order' => $this->input->post('sort_order'),
					'is_active' => $this->input->post('status'),
					'updated_by' => $this->session->userdata('admin_id'),
					'updated_at' => date('Y-m-d : h:m:s'),
				);
				$old_icon = $this->input->post('old_icon');
				$old_icon2 = $this->input->post('old_icon2');
				$old_image = $this->input->post('old_image');
				$old_brochure = $this->input->post('old_brochure');
				$path="assets/img/service/";
				if(!empty($_FILES['icon']['name']))
				{
					if(!empty($old_icon)){
						$this->functions->delete_file($old_icon);
					}
					$result = $this->functions->file_insert($path, 'icon', 'image', '9097152');
					if($result['status'] == 1){
						$data['icon'] = $path.$result['msg'];
					}
					else{
						$this->session->set_flashdata('error', $result['msg']);
						redirect(base_url('service/edit'.$id), 'refresh');
					}
				}	
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
						redirect(base_url('service/edit'.$id), 'refresh');
					}
				}
				if(!empty($_FILES['icon2']['name']))
				{
					if(!empty($old_icon2)){
						$this->functions->delete_file($old_icon2);
					}
					$result = $this->functions->file_insert($path, 'icon2', 'image', '9097152');
					if($result['status'] == 1){
						$data['icon2'] = $path.$result['msg'];
					}
					else{
						$this->session->set_flashdata('error', $result['msg']);
						redirect(base_url('service/edit'.$id), 'refresh');
					}
				}			
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
						redirect(base_url('service/edit'.$id), 'refresh');
					}
				}
				$data = $this->security->xss_clean($data);
				$result = $this->service_model->edit_service($data, $id);
				if($result){
					$this->session->set_flashdata('success', 'Service has been updated successfully!');
					redirect(base_url('service'));
				}
			}
		}
		else{
			$data['title'] = 'Edit Service';
			$data['service'] = $this->service_model->get_service_by_id($id);
			
			$this->load->view('includes/_header', $data);
			$this->load->view('service/service_edit', $data);
			$this->load->view('includes/_footer');
		}
	}

	//-----------------------------------------------------------
	public function delete($id = 0)
	{		
		$this->db->delete('ci_services', array('id' => $id));
		$this->session->set_flashdata('success', 'Service has been deleted successfully!');
		redirect(base_url('service'));
	}
 
	
	//---------------------------------------------------------------
	//  Export Categories PDF 
	public function create_service_pdf(){
		$this->load->helper('pdf_helper'); // loaded pdf helper
		$data['all_services'] = $this->service_model->get_services_for_export();		 
		$this->load->view('service/service_pdf', $data);
	}

	//---------------------------------------------------------------	
	// Export data in CSV format 
	public function export_csv(){ 

	   // file name 
		$filename = 'services_'.date('Y-m-d').'.csv'; 
		header("Content-Description: File Transfer"); 
		header("Content-Disposition: attachment; filename=$filename"); 
		header("Content-Type: application/csv; ");

	   // get data 
		$all_services = $this->service_model->get_services_for_export();		 

	   // file creation 
		$file = fopen('php://output', 'w');

		$header = array("ID", "Name", "Icon" ,"Sort Description", "Created Date"); 

		fputcsv($file, $header);
		foreach ($all_services as $key=>$line){ 
			fputcsv($file,$line); 
		}
		fclose($file); 
		exit; 
	} 


}

?>