<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Career extends MY_Controller {

	public function __construct(){

		parent::__construct();
		auth_check(); // check login auth
		check_premissions($this->router->fetch_class(), $this->router->fetch_method());
		check_user_premissions($this->session->userdata('admin_id'), $this->router->fetch_class(), $this->router->fetch_method());
		$this->load->model('career_model', 'career_model');
		$this->load->library('datatable'); // loaded my custom serverside datatable library
	}

	public function index(){

		$data['title'] = 'Career List';

		$this->load->view('includes/_header', $data);
		$this->load->view('career/career_list');
		$this->load->view('includes/_footer');
	}
	
	public function datatable_json(){				   					   
		$records = $this->career_model->get_all_career();
		$data = array();

		$i=0;
		foreach ($records['data']  as $row) 
		{  
			$status = ($row['is_active'] == 1)? 'checked': '';
			$data[]= array(
				++$i,
				$row['name'],
				date('d-m-Y',strtotime($row['opening_date'])),
				date('d-m-Y',strtotime($row['created_at'])), 
				'<input class="tgl_checkbox tgl-ios" 
				data-id="'.$row['id'].'" 
				id="cb_'.$row['id'].'"
				type="checkbox" '.$status.'><label for="cb_'.$row['id'].'"></label>',		

				'<a title="View" class="view btn btn-sm btn-info" href="'.base_url('career/edit/'.$row['id']).'"> <i class="fa fa-pencil"></i></a>
				<a title="Delete" class="delete btn btn-sm btn-danger" href='.base_url("career/delete/".$row['id']).' title="Delete" onclick="return confirm(\'Do you want to delete ?\')"> <i class="fa fa-trash-o"></i></a>'

				 
			);
		}
		$records['data']=$data;
		echo json_encode($records);						   
	}

	public function apply_job(){

		$data['title'] = 'Apply Job';
		
		$this->load->view('includes/_header', $data);
		$this->load->view('career/apply_job',$data);
		$this->load->view('includes/_footer');
	}
	
	public function datatable_jsonapply_job(){				   					   
		$records = $this->career_model->get_all_job_appliction();
		$data = array();

		$i=0;
		foreach ($records['data']  as $row) 
		{  
			$schedule = ($row['is_schudule_Interview'] == 1)? '<span class="badge badge-primary">Scheduled</span>': '<span class="badge badge-danger">Not Scheduled</span>';

			$data[]= array(
				++$i,
				$row['jobname'],
				$row['first_name'].' '.$row['last_name'],
				$row['mobile'],
				$row['email'],
				$schedule,

				date('d-m-Y',strtotime($row['created_at'])),

				'<a title="View Job Details" class="view btn btn-sm btn-info" href="'.base_url('career/view_jobdetail/'.$row['id']).'"> <i class="fa fa-eye"></i></a>'
				 
			);
		}
		$records['data']=$data;
		echo json_encode($records);						   
	}

	public function view_jobdetail($id=NULL){
		$data['job_data'] = $this->career_model->get_jobdetails($id);
		$data['schedule_data'] = $this->career_model->get_scheduleData($id);
		if($id==NULL or empty($data['job_data']) ){
			$this->session->set_flashdata('error', 'Unauthenticated Access');
			redirect(base_url('Career/apply_job'));
			
		}

		if($this->input->post('submit')){

			$this->form_validation->set_rules('hr_perform', 'Hr Perform', 'trim|required');
			$this->form_validation->set_rules('hr_schedule_date', 'Final Schedule Date', 'trim|required');
			$this->form_validation->set_rules('technical_perform', 'Technical Perform', 'trim|required');
			$this->form_validation->set_rules('technical_schedule_date', 'Technical Schedule Date', 'trim|required');
			$this->form_validation->set_rules('final_perform', 'Final Perform', 'trim|required');
			$this->form_validation->set_rules('final_schedule_date', 'Final Schedule Date', 'trim|required');
			if ($this->form_validation->run() == FALSE) {
				$error = array(
					'errors' => validation_errors()
				);
				$data['schedule'] = array( 
					'hr_schedule_perform' => $this->input->post('hr_perform'),
					'hr_schedule_date' => $this->input->post('hr_schedule_date'),
					'technical_schedule_perform' => $this->input->post('technical_perform'),
					'technical_schedule_date' => $this->input->post('technical_schedule_date'),
					'final_schedule_perform' => $this->input->post('final_perform'),
					'final_schedule_date' => $this->input->post('final_schedule_date'),
					
				);
				$this->session->set_flashdata('errors', $error['errors']);
				$this->load->view('includes/_header');
				$this->load->view('career/view_jobdetail', $data);
				$this->load->view('includes/_footer');
			}
			else{
				if($this->input->post('hr_schedule_date')>=$this->input->post('technical_schedule_date')){
					$this->session->set_flashdata('error', 'Please Selcet Technical Schedule After Hr Round');
					  	redirect(base_url('career/view_jobdetail/'.$id), 'refresh');
				}
				if($this->input->post('technical_schedule_date')>=$this->input->post('final_schedule_date')){
					$this->session->set_flashdata('error', 'Please Selcet Technical Schedule After Hr Round');
					  	redirect(base_url('career/view_jobdetail/'.$id), 'refresh');
				}

				$data = array(
					'hr_schudule_perform' => $this->input->post('hr_perform'),
					'hr_schudule_date' => $this->input->post('hr_schedule_date'),
					'technical_schudule_perform' => $this->input->post('technical_perform'),
					'technical_schudule_date' => $this->input->post('technical_schedule_date'),
					'final_schudule_perform' => $this->input->post('final_perform'),
					'final_schudule_date' => $this->input->post('final_schedule_date'),
					'created_at' => date('Y-m-d,h:m:s'),
					'updated_at' => date('Y-m-d,h:m:s'),
					'is_schudule_Interview'=>1
					
				);

				$data = $this->security->xss_clean($data);
				$result = $this->career_model->update_schedule($id,$data);

				if($result){
					$this->session->set_flashdata('success', 'Schedule has been Set successfully!');
						redirect(base_url('career/view_jobdetail/'.$id));
										
				}else{
					$this->session->set_flashdata('error', 'Somthing Want to wrong ');
					  	redirect(base_url('career/view_jobdetail/'.$id), 'refresh');
					}
			}
		}
		else{

			$data['title'] = 'view Job Details';
		
			$this->load->view('includes/_header', $data);
			$this->load->view('career/view_jobdetail');
			$this->load->view('includes/_footer');
		}
		
	}
	public function jobresult($id=NULL){   
		if($this->input->post('submit')){
			$this->form_validation->set_rules('job_result', 'Job Result', 'trim|required');
			$this->form_validation->set_rules('message', 'Message', 'trim|required');
			if ($this->form_validation->run() == FALSE) {
				$error = array(
					'errors' => validation_errors()
				);
				$data['schedule'] = array( 
					'is_job_result' => $this->input->post('job_result'),
					'comments' => $this->input->post('message'),
				);
				$this->session->set_flashdata('errors', $error['errors']);
				$this->load->view('includes/_header');
				$this->load->view('career/view_jobdetail', $data);
				$this->load->view('includes/_footer');
			}else{

				$attachment= "";
				$path="assets/img/selected_job_resutl/"; 				
				if(!empty($_FILES['attachment']['name']))
				{
					$type = "image";
					if ($_FILES['attachment']['type'] == 'application/pdf') {
						$type = "pdf";
					}

					$result = $this->functions->file_insert($path, 'attachment', $type, '9097152');
					if($result['status'] == 1){
						$attachment= $path.$result['msg'];
					}
					else{
						$this->session->set_flashdata('error', $result['msg']);
						redirect(base_url('career/apply_job/'.$id), 'refresh');
					}
				}
				$data = array(
					'is_job_result' => $this->input->post('job_result'),
					'comments' => $this->input->post('message'),
					'image' => $attachment,
					'updated_at'=> date('Y-m-d,h:i:s')
				);

				$data = $this->security->xss_clean($data);
				$result = $this->career_model->update_schedule($id,$data);

				if($result){
					$this->session->set_flashdata('success', 'Result has been update successfully!');
						redirect(base_url('career/view_jobdetail/'.$id));
										
				}else{
					$this->session->set_flashdata('error', 'Somthing Want to wrong ');
					  	redirect(base_url('career/view_jobdetail/'.$id), 'refresh');
					}
			}
		}
		
	}
	
	//-----------------------------------------------------------
	public function change_status(){   

		$this->career_model->change_status();
	}

	//-----------------------------------------------------------
	public function add(){

		if($this->input->post('submit')){
			$this->form_validation->set_rules('name', 'Career Name', 'trim|required');
			$this->form_validation->set_rules('type', 'Career Type', 'trim|required');
			$this->form_validation->set_rules('opening_date', 'Opening date', 'trim|required');
			$this->form_validation->set_rules('qualification', 'Qualification', 'trim|required');
			$this->form_validation->set_rules('experince', 'Experince', 'trim|required'); 
			$this->form_validation->set_rules('description', 'Description', 'trim|required'); 
			$this->form_validation->set_rules('status', 'Status', 'trim|required');
			$this->form_validation->set_rules('slug', 'Seo URL', 'trim|required');
			
			if ($this->form_validation->run() == FALSE) {
				$data = array(
					'errors' => validation_errors()
				);
				$data['career'] = array(
					'name' => $this->input->post('name'),
					'slug' => $this->input->post('slug'),
					'type' => $this->input->post('type'),
					'opening_date' => $this->input->post('opening_date'),
					'qualification' => $this->input->post('qualification'),
					'experince' => $this->input->post('experince'),
					'description' => $this->input->post('description'),
					'sort_order' => $this->input->post('sort_order'),
					'is_active' => $this->input->post('status') 
				); 
				$this->session->set_flashdata('errors', $data['errors']);
				$this->load->view('includes/_header');
				$this->load->view('career/career_add', $data);
				$this->load->view('includes/_footer');
			}
			else{
				$data = array(
					'name' => $this->input->post('name'),
					'slug' => $this->input->post('slug'),
					'type' => $this->input->post('type'),
					'opening_date' => $this->input->post('opening_date'),
					'qualification' => $this->input->post('qualification'),
					'experince' => $this->input->post('experince'),
					'description' => $this->input->post('description'),
					'is_active' => $this->input->post('status'),
					'sort_order' => $this->input->post('sort_order'),
					'created_at' => date('Y-m-d : h:m:s'),
					'updated_at' => date('Y-m-d : h:m:s'),
				);
				$data = $this->security->xss_clean($data);
				$result = $this->career_model->add_career($data);
				if($result){
					$this->session->set_flashdata('success', 'Career has been added successfully!');
					redirect(base_url('career'));
				}
			}
		}
		else{

			$data['title'] = 'Add Career';

			$this->load->view('includes/_header', $data);
			$this->load->view('career/career_add');
			$this->load->view('includes/_footer');
		}
		
	}

	//-----------------------------------------------------------
	public function edit($id = 0){

		if($this->input->post('submit')){
			$this->form_validation->set_rules('name', 'Career Name', 'trim|required');
			$this->form_validation->set_rules('type', 'Career Type', 'trim|required');
			$this->form_validation->set_rules('opening_date', 'Opening date', 'trim|required');
			$this->form_validation->set_rules('qualification', 'Qualification', 'trim|required');
			$this->form_validation->set_rules('experince', 'Experince', 'trim|required'); 
			$this->form_validation->set_rules('description', 'Description', 'trim|required'); 
			$this->form_validation->set_rules('status', 'Status', 'trim|required');
			$this->form_validation->set_rules('slug', 'Seo URL', 'trim|required');

			if ($this->form_validation->run() == FALSE) {
				///$data['career'] = $this->career_model->get_career_by_id($id);
				$data = array(
					'errors' => validation_errors()
				);
				$data['career'] = array(
					'id' => $id,
					'name' => $this->input->post('name'),
					'slug' => $this->input->post('slug'),
					'type' => $this->input->post('type'),
					'opening_date' => $this->input->post('opening_date'),
					'qualification' => $this->input->post('qualification'),
					'experince' => $this->input->post('experince'),
					'description' => $this->input->post('description'),
					'sort_order' => $this->input->post('sort_order'),
					'is_active' => $this->input->post('status') 
				); 
				$this->session->set_flashdata('errors', $data['errors']);
				$this->load->view('includes/_header');
				$this->load->view('career/career_edit', $data);
				$this->load->view('includes/_footer');
			}
			else{
				$data = array(
					'name' => $this->input->post('name'),
					'slug' => $this->input->post('slug'),
					'type' => $this->input->post('type'),
					'opening_date' => $this->input->post('opening_date'),
					'qualification' => $this->input->post('qualification'),
					'experince' => $this->input->post('experince'),
					'description' => $this->input->post('description'),
					'is_active' => $this->input->post('status'),
					'sort_order' => $this->input->post('sort_order'),
					'created_at' => date('Y-m-d : h:m:s'),
					'updated_at' => date('Y-m-d : h:m:s'),
				);
				$data = $this->security->xss_clean($data);
				$result = $this->career_model->edit_career($data, $id);
				if($result){
					$this->session->set_flashdata('success', 'Career has been updated successfully!');
					redirect(base_url('career'));
				}
			}
		}
		else{
			$data['title'] = 'Edit Career';
			$data['career'] = $this->career_model->get_career_by_id($id);
			
			$this->load->view('includes/_header', $data);
			$this->load->view('career/career_edit', $data);
			$this->load->view('includes/_footer');
		}
	}

	//-----------------------------------------------------------
	public function delete($id = 0)
	{		
		///$this->db->delete('ci_career', array('id' => $id));
		$result = $this->career_model->deleted($id);
		$this->session->set_flashdata('success', 'Career Page has been deleted successfully!');
		redirect(base_url('career'));
	}
}

?>