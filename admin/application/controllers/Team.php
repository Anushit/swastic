<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Team extends MY_Controller {

	public function __construct(){

		parent::__construct();
		auth_check(); // check login auth
		check_premissions($this->router->fetch_class(), $this->router->fetch_method());
		check_user_premissions($this->session->userdata('admin_id'), $this->router->fetch_class(), $this->router->fetch_method());
		$this->load->model('team_model', 'team_model');
		$this->load->library('datatable'); // loaded my custom serverside datatable library
	}

	public function index(){
		$data['title'] = 'Teams List';

		$this->load->view('includes/_header', $data);
		$this->load->view('team/team_list');
		$this->load->view('includes/_footer');
	}
	
	public function datatable_json(){				   					   
		$records = $this->team_model->get_all_team();
		$data = array();

		$i=0;
		foreach ($records['data']  as $row) 
		{  
			$status = ($row['is_active'] == 1)? 'checked': '';
			$data[]= array(
				++$i,
				$row['name'], 
				$row['designation'],
				$row['department'],
				date_time($row['created_at']),	
				'<input class="tgl_checkbox tgl-ios" 
				data-id="'.$row['id'].'" 
				id="cb_'.$row['id'].'"
				type="checkbox" '.$status.'><label for="cb_'.$row['id'].'"></label>',		

				'<a title="Edit" class="update btn btn-sm btn-warning" href="'.base_url('team/edit/'.$row['id']).'"> <i class="fa fa-pencil-square-o"></i></a>
				<a title="Delete" class="delete btn btn-sm btn-danger" href='.base_url("team/delete/".$row['id']).' title="Delete" onclick="return confirm(\'Do you want to delete ?\')"> <i class="fa fa-trash-o"></i></a>'

				 
			);
		}
		$records['data']=$data;
		echo json_encode($records);						   
	}

	//-----------------------------------------------------------
	public function change_status(){   

		$this->team_model->change_status();
	}

	//-----------------------------------------------------------
	public function add(){

		if($this->input->post('submit')){
			$this->form_validation->set_rules('name', 'Name', 'trim|required');
			$this->form_validation->set_rules('department', 'Department', 'trim|required');
			$this->form_validation->set_rules('sort_order', 'Sort Order', 'trim|required');
			$this->form_validation->set_rules('designation', 'Designation', 'trim|required');  
			$this->form_validation->set_rules('status', 'Status', 'trim|required');

			if ($this->form_validation->run() == FALSE) {
				$data = array(
					'errors' => validation_errors()
				);
				$data['team'] = array(
					'name' => $this->input->post('name'), 
					'department' => $this->input->post('department'),
					'designation' => $this->input->post('designation'),
					'twitter' => $this->input->post('twitter'),
					'facebook' => $this->input->post('facebook'),
					'instagram' => $this->input->post('instagram'),
					'linkedin' => $this->input->post('linkedin'),
					'google' => $this->input->post('google'),
					'sort_order'=> $this->input->post('sort_order'),
					'is_active' => $this->input->post('status') 
				); 
				$this->session->set_flashdata('errors', $data['errors']);
				$this->load->view('includes/_header');
				$this->load->view('team/team_add', $data);
				$this->load->view('includes/_footer');
			}
			else{
				$data = array(
					'name' => $this->input->post('name'), 
					'department' => $this->input->post('department'),
					'designation' => $this->input->post('designation'),
					'twitter' => $this->input->post('twitter'),
					'facebook' => $this->input->post('facebook'),
					'instagram' => $this->input->post('instagram'),
					'linkedin' => $this->input->post('linkedin'),
					'google' => $this->input->post('google'),
					'sort_order'=> $this->input->post('sort_order'),
					'is_active' => $this->input->post('status'), 
					'created_by' => $this->session->userdata('admin_id'),
					'updated_by' => $this->session->userdata('admin_id'),
					'created_at' => date('Y-m-d : h:m:s'),
					'updated_at' => date('Y-m-d : h:m:s'),
				);
				$old_image = $this->input->post('old_image');
				$path="assets/img/team/"; 				
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
						redirect(base_url('team/add'), 'refresh');
					}
				}
				$data = $this->security->xss_clean($data);
				$result = $this->team_model->add_team($data);
				if($result){
					$this->session->set_flashdata('success', 'Team has been added successfully!');
					redirect(base_url('team'));
				}
			}
		}
		else{

			$data['title'] = 'Add Team';

			$this->load->view('includes/_header', $data);
			$this->load->view('team/team_add');
			$this->load->view('includes/_footer');
		}
		
	}

	//-----------------------------------------------------------
	public function edit($id = 0){

		if($this->input->post('submit')){
			$this->form_validation->set_rules('name', 'Name', 'trim|required');
			$this->form_validation->set_rules('department', 'Department', 'trim|required');
			$this->form_validation->set_rules('sort_order', 'Sort Order', 'trim|required');
			$this->form_validation->set_rules('designation', 'Designation', 'trim|required');  
			$this->form_validation->set_rules('status', 'Status', 'trim|required');

			if ($this->form_validation->run() == FALSE) {
				$teamData = $this->team_model->get_team_by_id($id);
				$data = array(
					'errors' => validation_errors()
				); 
				$data['team'] = array(
					'id' => $id, 
					'name' => $this->input->post('name'), 
					'image' => $teamData['image'],
					'department' => $this->input->post('department'),
					'designation' => $this->input->post('designation'),
					'twitter' => $this->input->post('twitter'),
					'facebook' => $this->input->post('facebook'),
					'instagram' => $this->input->post('instagram'),
					'linkedin' => $this->input->post('linkedin'),
					'google' => $this->input->post('google'),
					'sort_order'=> $this->input->post('sort_order'),
					'is_active' => $this->input->post('status') 
				);
				$this->session->set_flashdata('errors', $data['errors']);
				$this->load->view('includes/_header');
				$this->load->view('team/team_edit', $data);
				$this->load->view('includes/_footer');
			}
			else{
				$data = array(
					'name' => $this->input->post('name'), 
					'department' => $this->input->post('department'),
					'designation' => $this->input->post('designation'),
					'twitter' => $this->input->post('twitter'),
					'facebook' => $this->input->post('facebook'),
					'instagram' => $this->input->post('instagram'),
					'linkedin' => $this->input->post('linkedin'),
					'google' => $this->input->post('google'),
					'sort_order'=> $this->input->post('sort_order'),
					'is_active' => $this->input->post('status'), 
					'updated_by' => $this->session->userdata('admin_id'),
					'updated_at' => date('Y-m-d : h:m:s'),
				); 
				$old_image = $this->input->post('old_image');
				$path="assets/img/team/"; 		
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
						redirect(base_url('team/edit/'.$id), 'refresh');
					}
				}
				$data = $this->security->xss_clean($data);
				$result = $this->team_model->edit_team($data, $id);
				if($result){
					$this->session->set_flashdata('success', 'Team has been updated successfully!');
					redirect(base_url('team'));
				}
			}
		}
		else{
			$data['title'] = 'Edit Team';
			$data['team'] = $this->team_model->get_team_by_id($id);
			
			$this->load->view('includes/_header', $data);
			$this->load->view('team/team_edit', $data);
			$this->load->view('includes/_footer');
		}
	}

	//-----------------------------------------------------------
	public function delete($id = 0)
	{		
		$this->db->delete('ci_teams', array('id' => $id));
		$this->session->set_flashdata('success', 'Team has been deleted successfully!');
		redirect(base_url('team'));
	}
 
	
	//---------------------------------------------------------------
	//  Export Categories PDF 
	public function create_team_pdf(){
		$this->load->helper('pdf_helper'); // loaded pdf helper
		$data['all_teams'] = $this->team_model->get_teams_for_export();		 
		$this->load->view('team/team_pdf', $data);
	}

	//---------------------------------------------------------------	
	// Export data in CSV format 
	public function export_csv(){ 

	   // file name 
		$filename = 'teams_'.date('Y-m-d').'.csv'; 
		header("Content-Description: File Transfer"); 
		header("Content-Disposition: attachment; filename=$filename"); 
		header("Content-Type: application/csv; ");

	   // get data 
		$all_teams = $this->team_model->get_teams_for_export();		 

	   // file creation 
		$file = fopen('php://output', 'w');

		$header = array("ID", "Name", "Department" ,"Designation", "Created Date"); 

		fputcsv($file, $header);
		foreach ($all_teams as $key=>$line){ 
			fputcsv($file,$line); 
		}
		fclose($file); 
		exit; 
	} 


}

?>