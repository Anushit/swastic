<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Events extends MY_Controller {

	public function __construct(){

		parent::__construct();
		auth_check(); // check login auth
		check_premissions($this->router->fetch_class(), $this->router->fetch_method());
		check_user_premissions($this->session->userdata('admin_id'), $this->router->fetch_class(), $this->router->fetch_method());
		$this->load->model('events_model', 'events_model');
		$this->load->library('datatable'); // loaded my custom serverside datatable library
	}

	public function index(){

		$data['title'] = 'Events List';

		$this->load->view('includes/_header', $data);
		$this->load->view('events/event_list');
		$this->load->view('includes/_footer');
	}
	
	public function datatable_json(){				   					   
		$records = $this->events_model->get_all_events();
		$data = array();

		$i=0;
		foreach ($records['data']  as $row) 
		{  
			$status = ($row['is_active'] == 1)? 'checked': '';
			$data[]= array(
				++$i,
				$row['name'], 
				$row['event_date'],
				$row['event_location'],
				''.$row['event_start_time'].' - '.$row['event_end_time'].'',
				'<img src="'.base_url($row['image']).'" width="50" height="50">',
				date_time($row['created_at']),	
				'<input class="tgl_checkbox tgl-ios" 
				data-id="'.$row['id'].'" 
				id="cb_'.$row['id'].'"
				type="checkbox"  
				'.$status.'><label for="cb_'.$row['id'].'"></label>',		

				'<a title="Edit" class="update btn btn-sm btn-warning" href="'.base_url('events/edit/'.$row['id']).'"> <i class="fa fa-pencil-square-o"></i></a>
				<a title="Delete" class="delete btn btn-sm btn-danger" href='.base_url("events/delete/".$row['id']).' title="Delete" onclick="return confirm(\'Do you want to delete ?\')"> <i class="fa fa-trash-o"></i></a>'
			);
		}
		$records['data']=$data;
		echo json_encode($records);						   
	}

	//-----------------------------------------------------------
	public function change_status(){   

		$this->events_model->change_status();
	}

//-----------------------------------------------------------
	public function add(){

		if($this->input->post('submit')){
			$this->form_validation->set_rules('name', 'Name', 'trim|required|xss_clean|is_unique[ci_events.name]');
			$this->form_validation->set_rules('sort_description', 'Sort Description', 'trim|required');
			$this->form_validation->set_rules('description', 'Description', 'trim|required');
			$this->form_validation->set_rules('event_date', 'Event_Date', 'trim|required');
			$this->form_validation->set_rules('event_location', 'Event Location', 'trim|required');
			$this->form_validation->set_rules('event_start_time', 'Event Start Time', 'trim|required');
			$this->form_validation->set_rules('event_end_time', 'Event End Time', 'trim|required');
			$this->form_validation->set_rules('status', 'Status', 'trim|required');
			$this->form_validation->set_rules('slug', 'Seo URL', 'trim|required');
			
			if ($this->form_validation->run() == FALSE) {
				$data = array(
					'errors' => validation_errors()
				);
				$data['event'] = array( 
					'name' => $this->input->post('name'),
					'slug' => $this->input->post('slug'),
					'sort_description' => $this->input->post('sort_description'),
					'description' => $this->input->post('description'),
					'event_date' => $this->input->post('event_date'),
					'event_location' => $this->input->post('event_location'),
					'event_start_time' => $this->input->post('event_start_time'),
					'event_end_time' => $this->input->post('event_end_time'),
					'sort_order' => $this->input->post('sort_order'),
					'is_active' => $this->input->post('status'),
				);
				$this->session->set_flashdata('errors', $data['errors']);
				$this->load->view('includes/_header');
				$this->load->view('events/event_add', $data);
				$this->load->view('includes/_footer');
			}
			else{
				$data = array(
					'name' => $this->input->post('name'),
					'slug' => $this->input->post('slug'),
					'sort_description' => $this->input->post('sort_description'),
					'description' => $this->input->post('description'),
					'event_date' => $this->input->post('event_date'),
					'event_location' => $this->input->post('event_location'),
					'event_start_time' => $this->input->post('event_start_time'),
					'event_end_time' => $this->input->post('event_end_time'),
					'sort_order' => $this->input->post('sort_order'),
					'is_active' => $this->input->post('status'),
					'created_at' => date('Y-m-d : h:m:s'),
					'updated_at' => date('Y-m-d : h:m:s'),
				);
				$old_image = $this->input->post('old_image');
				$path="assets/img/events/";
				if(!empty($_FILES['image']['name']))
				{
					$this->functions->delete_file($old_image);
					$result = $this->functions->file_insert($path, 'image', 'image', '9097152');
					if($result['status'] == 1){
						$data['image'] = $path.$result['msg'];
					}
					else{
						$this->session->set_flashdata('error', $result['msg']);
						redirect(base_url('events/add'), 'refresh');
					}
				}
				$data = $this->security->xss_clean($data);
				$result = $this->events_model->add_events($data);
				if($result){
					$this->session->set_flashdata('success', 'Events has been added successfully!');
					redirect(base_url('events'));
				}
			}
		}
		else{

			$data['title'] = 'Add Events';

			$this->load->view('includes/_header', $data);
			$this->load->view('events/event_add');
			$this->load->view('includes/_footer');
		}
	}	


		//-----------------------------------------------------------
public function edit($id = 0){

		if($this->input->post('submit')){
			$original_value = $this->events_model->get_event_by_id($id);
			if($this->input->post('name') != $original_value['name']) {
			   $uis_unique =  '|is_unique[ci_events.name]';
			} else {
			   $uis_unique =  '';
			}
			
			$this->form_validation->set_rules('name', 'Name', 'trim|required|xss_clean'.$uis_unique); 
			$this->form_validation->set_rules('sort_description', 'Sort Description', 'trim|required');
			$this->form_validation->set_rules('description', 'Description', 'trim|required');
			$this->form_validation->set_rules('event_date', 'Event_Date', 'trim|required');
			$this->form_validation->set_rules('event_location', 'Event Location', 'trim|required');
			$this->form_validation->set_rules('event_start_time', 'Event Start Time', 'trim|required');
			$this->form_validation->set_rules('event_end_time', 'Event End Time', 'trim|required');
			$this->form_validation->set_rules('status', 'Status', 'trim|required');
			$this->form_validation->set_rules('slug', 'Seo URL', 'trim|required');

			if ($this->form_validation->run() == FALSE) { 
				$eventData = $this->event_model->get_event_by_id($id);
				$data = array(
					'errors' => validation_errors()
				); 
				$data['event'] = array(
					'id' => $id,
					'name' => $this->input->post('name'),
					'slug' => $this->input->post('slug'),
					'sort_description' => $this->input->post('sort_description'),
					'description' => $this->input->post('description'),
					'image' => $eventData['image'],
					'event_date' => $this->input->post('event_date'),
					'event_location' => $this->input->post('event_location'),
					'event_start_time' => $this->input->post('event_start_time'),
					'event_end_time' => $this->input->post('event_end_time'),
					'sort_order' => $this->input->post('sort_order'),
					'is_active' => $this->input->post('status'),
				); 
				$this->session->set_flashdata('errors', $data['errors']);
				$this->load->view('includes/_header');
				$this->load->view('events/event_edit', $data);
				$this->load->view('includes/_footer');
			}
			else{
				$data = array(
					'name' => $this->input->post('name'),
					'slug' => $this->input->post('slug'),
					'sort_description' => $this->input->post('sort_description'),
					'description' => $this->input->post('description'),
					'event_date' => $this->input->post('event_date'),
					'event_location' => $this->input->post('event_location'),
					'event_start_time' => $this->input->post('event_start_time'),
					'event_end_time' => $this->input->post('event_end_time'),
					'sort_order' => $this->input->post('sort_order'),
					'is_active' => $this->input->post('status'),
					'updated_at' => date('Y-m-d : h:m:s'),
				);

				$old_image = $this->input->post('old_image');
				$path="assets/img/events/";
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
						redirect(base_url('events/edit/'.$id), 'refresh');
					}
				}

				$data = $this->security->xss_clean($data);
				$result = $this->events_model->edit_event($data, $id);
				if($result){
					$this->session->set_flashdata('success', 'Event has been updated successfully!');
					redirect(base_url('events'));
				}
			}
		}
		else{
			$data['title'] = 'Edit Events';
			$data['event'] = $this->events_model->get_event_by_id($id);
			
			$this->load->view('includes/_header', $data);
			$this->load->view('events/event_edit', $data);
			$this->load->view('includes/_footer');
		}
	}

	//-----------------------------------------------------------
	public function delete($id = 0)
	{
		
		$this->db->delete('ci_events', array('id' => $id));
		$this->session->set_flashdata('success', 'Event has been deleted successfully!');
		redirect(base_url('events'));
	}

	public function create_events_pdf(){

		$this->load->helper('pdf_helper'); // loaded pdf helper
		$data['all_events'] = $this->events_model->get_events_for_export();
		
		$this->load->view('events/events_pdf', $data);
	}

	public function export_csv(){ 
// $user_data = $this->events_model->get_events_for_export();
// print_r($user_data); exit;
	   // file name 
		$filename = 'event_'.date('Y-m-d').'.csv'; 
		header("Content-Description: File Transfer"); 
		header("Content-Disposition: attachment; filename=$filename"); 
		header("Content-Type: application/csv; ");

	   // get data 
		$event_data = $this->events_model->get_events_for_export();
// print_r($user_data); exit;
	   // file creation 
		$file = fopen('php://output', 'w');

		$header = array("id", "name", "sort_description", "event_date", "event_location", "event_start_time", "event_end_time", "created_at"); 

		fputcsv($file, $header);
		foreach ($event_data as $key=>$line){ 
			fputcsv($file,$line); 
		}
		fclose($file); 
		exit; 
	}
	
}
?>