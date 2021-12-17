<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Testimonial extends MY_Controller {

	public function __construct(){

		parent::__construct();
		auth_check(); // check login auth
		check_premissions($this->router->fetch_class(), $this->router->fetch_method());
		check_user_premissions($this->session->userdata('admin_id'), $this->router->fetch_class(), $this->router->fetch_method());
		$this->load->model('testimonial_model', 'testimonial_model');
		$this->load->library('datatable'); // loaded my custom serverside datatable library
	}

	public function index(){
		$data['title'] = 'Testimonials List';

		$this->load->view('includes/_header', $data);
		$this->load->view('testimonial/testimonial_list');
		$this->load->view('includes/_footer');
	}
	
	public function datatable_json(){				   					   
		$records = $this->testimonial_model->get_all_testimonial();
		$data = array();

		$i=0;
		foreach ($records['data']  as $row) 
		{  
			$status = ($row['is_active'] == 1)? 'checked': '';
			$data[]= array(
				++$i,
				$row['name'], 
				$row['designation'],
				$row['sort_order'],
				date_time($row['created_at']),	
				'<input class="tgl_checkbox tgl-ios" 
				data-id="'.$row['id'].'" 
				id="cb_'.$row['id'].'"
				type="checkbox" '.$status.'><label for="cb_'.$row['id'].'"></label>',		

				'<a title="Edit" class="update btn btn-sm btn-warning" href="'.base_url('testimonial/edit/'.$row['id']).'"> <i class="fa fa-pencil-square-o"></i></a>
				<a title="Delete" class="delete btn btn-sm btn-danger" href='.base_url("testimonial/delete/".$row['id']).' title="Delete" onclick="return confirm(\'Do you want to delete ?\')"> <i class="fa fa-trash-o"></i></a>'

			);
		}
		$records['data']=$data;
		echo json_encode($records);						   
	}

	//-----------------------------------------------------------
	public function change_status(){   

		$this->testimonial_model->change_status();
	}

	//-----------------------------------------------------------
	public function add(){

		if($this->input->post('submit')){
			$this->form_validation->set_rules('name', 'Name', 'trim|required');
			$this->form_validation->set_rules('designation', 'Designation', 'trim|required'); 
			$this->form_validation->set_rules('message', 'Message', 'trim|required');
			$this->form_validation->set_rules('sort_order', 'Sort Order', 'trim|required');  
			$this->form_validation->set_rules('status', 'Status', 'trim|required');

			if ($this->form_validation->run() == FALSE) {
				$data = array(
					'errors' => validation_errors()
				);
				$data['testimonial'] = array(
					'name' => $this->input->post('name'), 
					'message' => $this->input->post('message'),
					'designation' => $this->input->post('designation'),
					'sort_order'=> $this->input->post('sort_order'),
					'is_active' => $this->input->post('status') 
				); 
				$this->session->set_flashdata('errors', $data['errors']);
				$this->load->view('includes/_header');
				$this->load->view('testimonial/testimonial_add', $data);
				$this->load->view('includes/_footer');
			}
			else{
				$data = array(
					'name' => $this->input->post('name'), 
					'message' => $this->input->post('message'),
					'designation' => $this->input->post('designation'), 
					'sort_order'=> $this->input->post('sort_order'),
					'is_active' => $this->input->post('status'), 
					'created_by' => $this->session->userdata('admin_id'),
					'updated_by' => $this->session->userdata('admin_id'),
					'created_at' => date('Y-m-d : h:m:s'),
					'updated_at' => date('Y-m-d : h:m:s'),
				);
				$old_image = $this->input->post('old_image');
				$path="assets/img/testimonial/"; 				
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
						redirect(base_url('testimonial/add'), 'refresh');
					}
				}
				$data = $this->security->xss_clean($data);
				$result = $this->testimonial_model->add_testimonial($data);
				if($result){
					$this->session->set_flashdata('success', 'Testimonial has been added successfully!');
					redirect(base_url('testimonial'));
				}
			}
		}
		else{

			$data['title'] = 'Add Testimonial';

			$this->load->view('includes/_header', $data);
			$this->load->view('testimonial/testimonial_add');
			$this->load->view('includes/_footer');
		}
		
	}

	//-----------------------------------------------------------
	public function edit($id = 0){

		if($this->input->post('submit')){
			$this->form_validation->set_rules('name', 'Name', 'trim|required');
			$this->form_validation->set_rules('designation', 'Designation', 'trim|required'); 
			$this->form_validation->set_rules('message', 'Message', 'trim|required');  
			$this->form_validation->set_rules('sort_order', 'Sort Order', 'trim|required');  
			$this->form_validation->set_rules('status', 'Status', 'trim|required');

			if ($this->form_validation->run() == FALSE) {
				$testimonialData = $this->testimonial_model->get_testimonial_by_id($id);
				$data = array(
					'errors' => validation_errors()
				); 
				$data['testimonial'] = array(
					'id' => $id, 
					'name' => $this->input->post('name'), 
					'image' => $testimonialData['image'],
					'message' => $this->input->post('message'),
					'designation' => $this->input->post('designation'),
					'sort_order'=> $this->input->post('sort_order'),
					'is_active' => $this->input->post('status') 
				);
				$this->session->set_flashdata('errors', $data['errors']);
				$this->load->view('includes/_header');
				$this->load->view('testimonial/testimonial_edit', $data);
				$this->load->view('includes/_footer');
			}
			else{
				$data = array(
					'name' => $this->input->post('name'),  
					'message' => $this->input->post('message'),
					'designation' => $this->input->post('designation'),
					'sort_order'=> $this->input->post('sort_order'),
					'is_active' => $this->input->post('status'), 
					'updated_by' => $this->session->userdata('admin_id'),
					'updated_at' => date('Y-m-d : h:m:s'),
				); 
				$old_image = $this->input->post('old_image');
				$path="assets/img/testimonial/"; 		
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
						redirect(base_url('testimonial/edit/'.$id), 'refresh');
					}
				}
				$data = $this->security->xss_clean($data);
				$result = $this->testimonial_model->edit_testimonial($data, $id);
				if($result){
					$this->session->set_flashdata('success', 'Testimonial has been updated successfully!');
					redirect(base_url('testimonial'));
				}
			}
		}
		else{
			$data['title'] = 'Edit Testimonial';
			$data['testimonial'] = $this->testimonial_model->get_testimonial_by_id($id);
			
			$this->load->view('includes/_header', $data);
			$this->load->view('testimonial/testimonial_edit', $data);
			$this->load->view('includes/_footer');
		}
	}

	//-----------------------------------------------------------
	public function delete($id = 0)
	{		
		$this->db->delete('ci_testimonials', array('id' => $id));
		$this->session->set_flashdata('success', 'Testimonial has been deleted successfully!');
		redirect(base_url('testimonial'));
	}
 
	
	//---------------------------------------------------------------
	//  Export Categories PDF 
	public function create_testimonial_pdf(){
		$this->load->helper('pdf_helper'); // loaded pdf helper
		$data['all_testimonials'] = $this->testimonial_model->get_testimonials_for_export();		 
		$this->load->view('testimonial/testimonial_pdf', $data);
	}

	//---------------------------------------------------------------	
	// Export data in CSV format 
	public function export_csv(){ 

	   // file name 
		$filename = 'testimonials_'.date('Y-m-d').'.csv'; 
		header("Content-Description: File Transfer"); 
		header("Content-Disposition: attachment; filename=$filename"); 
		header("Content-Type: application/csv; ");

	   // get data 
		$all_testimonials = $this->testimonial_model->get_testimonials_for_export();		 

	   // file creation 
		$file = fopen('php://output', 'w');

		$header = array("ID", "Name", "Designation", "message", "Created Date"); 

		fputcsv($file, $header);
		foreach ($all_testimonials as $key=>$line){ 
			fputcsv($file,$line); 
		}
		fclose($file); 
		exit; 
	} 


}

?>