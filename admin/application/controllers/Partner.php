<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Partner extends MY_Controller {

	public function __construct(){

		parent::__construct();
		auth_check(); // check login auth
		check_premissions($this->router->fetch_class(), $this->router->fetch_method());
		check_user_premissions($this->session->userdata('admin_id'), $this->router->fetch_class(), $this->router->fetch_method());
		$this->load->model('partner_model', 'partner_model');
		$this->load->library('datatable'); // loaded my custom serverside datatable library
	}

	public function index(){
		$data['title'] = 'Partners List';

		$this->load->view('includes/_header', $data);
		$this->load->view('partner/partner_list');
		$this->load->view('includes/_footer');
	}
	
	public function datatable_json(){				   					   
		$records = $this->partner_model->get_all_partner();
		$data = array();

		$i=0;
		foreach ($records['data']  as $row) 
		{  
			$status = ($row['is_active'] == 1)? 'checked': '';
			$data[]= array(
				++$i,
				$row['name'],  
				$row['email'],
				$row['mobile'],
				date_time($row['created_at']),	
				'<input class="tgl_checkbox tgl-ios" 
				data-id="'.$row['id'].'" 
				id="cb_'.$row['id'].'"
				type="checkbox" '.$status.'><label for="cb_'.$row['id'].'"></label>',		

				'<a title="Edit" class="update btn btn-sm btn-warning" href="'.base_url('partner/edit/'.$row['id']).'"> <i class="fa fa-pencil-square-o"></i></a>
				<a title="Delete" class="delete btn btn-sm btn-danger" href='.base_url("partner/delete/".$row['id']).' title="Delete" onclick="return confirm(\'Do you want to delete ?\')"> <i class="fa fa-trash-o"></i></a>'
				 
			);
		}
		$records['data']=$data;
		echo json_encode($records);						   
	}

	//-----------------------------------------------------------
	public function change_status(){   

		$this->partner_model->change_status();
	}

	//-----------------------------------------------------------
	public function add(){

		if($this->input->post('submit')){
			$this->form_validation->set_rules('name', 'Name', 'trim|required');
			$this->form_validation->set_rules('email', 'Email', 'trim|valid_email|required');
			$this->form_validation->set_rules('mobile', 'Mobile', 'trim|numeric|required'); 
			$this->form_validation->set_rules('sort_order', 'Sort Order', 'trim|numeric|required');
			$this->form_validation->set_rules('status', 'Status', 'trim|required');
			$this->form_validation->set_rules('slug', 'Seo URL', 'trim|required');

			if ($this->form_validation->run() == FALSE) {
				$data = array(
					'errors' => validation_errors()
				);
				$data['partner'] = array(
					'name' => $this->input->post('name'), 
					'slug' => $this->input->post('slug'),
					'mobile' => $this->input->post('mobile'),
					'email' => $this->input->post('email'),
					'description' => $this->input->post('description'), 
					'sort_order' => $this->input->post('sort_order'),
					'is_active' => $this->input->post('status') 
				); 
				$this->session->set_flashdata('errors', $data['errors']); 
				$this->load->view('includes/_header');
				$this->load->view('partner/partner_add', $data);
				$this->load->view('includes/_footer');
			}
			else{
				$data = array(
					'name' => $this->input->post('name'), 
					'slug' => $this->input->post('slug'),
					'mobile' => $this->input->post('mobile'),
					'email' => $this->input->post('email'),
					'description' => $this->input->post('description'), 
					'sort_order' => $this->input->post('sort_order'),
					'is_active' => $this->input->post('status'),
					'created_by' => $this->session->userdata('admin_id'),
					'updated_by' => $this->session->userdata('admin_id'),
					'created_at' => date('Y-m-d : h:m:s'),
					'updated_at' => date('Y-m-d : h:m:s'),
				); 
				$old_image = $this->input->post('old_image');
				$path="assets/img/partner/"; 			
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
						redirect(base_url('partner/add'), 'refresh');
					}
				}
				$data = $this->security->xss_clean($data);
				$result = $this->partner_model->add_partner($data);
				if($result){
					$this->session->set_flashdata('success', 'Partner has been added successfully!');
					redirect(base_url('partner'));
				}
			}
		}
		else{

			$data['title'] = 'Add Partner';

			$this->load->view('includes/_header', $data);
			$this->load->view('partner/partner_add');
			$this->load->view('includes/_footer');
		}
		
	}

	//-----------------------------------------------------------
	public function edit($id = 0){

		if($this->input->post('submit')){
			$this->form_validation->set_rules('name', 'Name', 'trim|required');
			$this->form_validation->set_rules('email', 'Email', 'trim|valid_email|required');
			$this->form_validation->set_rules('mobile', 'Mobile', 'trim|numeric|required'); 
			$this->form_validation->set_rules('sort_order', 'Sort Order', 'trim|numeric|required');
			$this->form_validation->set_rules('status', 'Status', 'trim|required');
			$this->form_validation->set_rules('slug', 'Seo URL', 'trim|required');
			
			if ($this->form_validation->run() == FALSE) {
				$partnerData = $this->partner_model->get_partner_by_id($id);
				$data = array(
					'errors' => validation_errors()
				); 
				$data['partner'] = array(
					'id'=> $id,
					'name' => $this->input->post('name'), 
					'slug' => $this->input->post('slug'),
					'image' => $partnerData['image'],
					'mobile' => $this->input->post('mobile'),
					'email' => $this->input->post('email'),
					'sort_order' => $this->input->post('sort_order'),
					'description' => $this->input->post('description'), 
					'is_active' => $this->input->post('status') 
				); 
				$this->session->set_flashdata('errors', $data['errors']);
				$this->load->view('includes/_header');
				$this->load->view('partner/partner_edit', $data);
				$this->load->view('includes/_footer');
			}
			else{
				$data = array(
					'name' => $this->input->post('name'), 
					'slug' => $this->input->post('slug'),
					'mobile' => $this->input->post('mobile'),
					'email' => $this->input->post('email'),
					'description' => $this->input->post('description'), 
					'sort_order' => $this->input->post('sort_order'),
					'updated_by' => $this->session->userdata('admin_id'),
					'is_active' => $this->input->post('status'),
					'updated_at' => date('Y-m-d : h:m:s'),
				); 
				$old_image = $this->input->post('old_image');
				$path="assets/img/partner/"; 			
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
						redirect(base_url('partner/edit/'.$id), 'refresh');
					}
				}
				$data = $this->security->xss_clean($data);
				$result = $this->partner_model->edit_partner($data, $id);
				if($result){
					$this->session->set_flashdata('success', 'Partner has been updated successfully!');
					redirect(base_url('partner'));
				}
			}
		}
		else{
			$data['title'] = 'Edit Partner';
			$data['partner'] = $this->partner_model->get_partner_by_id($id);
			
			$this->load->view('includes/_header', $data);
			$this->load->view('partner/partner_edit', $data);
			$this->load->view('includes/_footer');
		}
	}

	//-----------------------------------------------------------
	public function delete($id = 0)
	{		
		$this->db->delete('ci_partners', array('id' => $id));
		$this->session->set_flashdata('success', 'Partner has been deleted successfully!');
		redirect(base_url('partner'));
	}
 
	
	//---------------------------------------------------------------
	//  Export Categories PDF 
	public function create_partner_pdf(){
		$this->load->helper('pdf_helper'); // loaded pdf helper
		$data['all_partners'] = $this->partner_model->get_partners_for_export();		 
		$this->load->view('partner/partner_pdf', $data);
	}

	//---------------------------------------------------------------	
	// Export data in CSV format 
	public function export_csv(){ 

	   // file name 
		$filename = 'partners_'.date('Y-m-d').'.csv'; 
		header("Content-Description: File Transfer"); 
		header("Content-Disposition: attachment; filename=$filename"); 
		header("Content-Type: application/csv; ");

	   // get data 
		$all_partners = $this->partner_model->get_partners_for_export();		 

	   // file creation 
		$file = fopen('php://output', 'w');

		$header = array("ID", "Name", "Email" ,"Mobile", "Created Date"); 

		fputcsv($file, $header);
		foreach ($all_partners as $key=>$line){ 
			fputcsv($file,$line); 
		}
		fclose($file); 
		exit; 
	} 


}

?>