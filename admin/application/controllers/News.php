<?php defined('BASEPATH') OR exit('No direct script access allowed');

class News extends MY_Controller {

	public function __construct(){

		parent::__construct();
		auth_check(); // check login auth
		check_premissions($this->router->fetch_class(), $this->router->fetch_method());
		check_user_premissions($this->session->userdata('admin_id'), $this->router->fetch_class(), $this->router->fetch_method());
		$this->load->model('news_model', 'news_model');
		$this->load->library('datatable'); // loaded my custom serverside datatable library
	}

	public function index(){

		$data['title'] = 'News & Updates List';

		$this->load->view('includes/_header', $data);
		$this->load->view('news/news_list');
		$this->load->view('includes/_footer');
	}
	
	public function datatable_json(){				   					   
		$records = $this->news_model->get_all_news();
		$data = array();

		$i=0;
		foreach ($records['data']  as $row) 
		{  
			$status = ($row['is_active'] == 1)? 'checked': '';
			$data[]= array(
				++$i,
				$row['name'],  
				$row['news_location'],
				$row['news_date'],
				$row['news_time'],
				'<img src="'.base_url($row['image']).'" width="50" height="50">',
				date_time($row['created_at']),	
				'<input class="tgl_checkbox tgl-ios" 
				data-id="'.$row['id'].'" 
				id="cb_'.$row['id'].'"
				type="checkbox"  
				'.$status.'><label for="cb_'.$row['id'].'"></label>',		

				'<a title="Edit" class="update btn btn-sm btn-warning" href="'.base_url('news/edit/'.$row['id']).'"> <i class="fa fa-pencil-square-o"></i></a>
				<a title="Delete" class="delete btn btn-sm btn-danger" href='.base_url("news/delete/".$row['id']).' title="Delete" onclick="return confirm(\'Do you want to delete ?\')"> <i class="fa fa-trash-o"></i></a>'
			);
		}
		$records['data']=$data;
		echo json_encode($records);						   
	}

	//-----------------------------------------------------------
	public function change_status(){   

		$this->news_model->change_status();
	}

//-----------------------------------------------------------
	public function add(){

		if($this->input->post('submit')){
			$this->form_validation->set_rules('name', 'Name', 'trim|required|xss_clean|is_unique[ci_newsupdates.name]');
			$this->form_validation->set_rules('sort_description', 'Sort Description', 'trim|required');
			$this->form_validation->set_rules('description', 'Description', 'trim|required');
			$this->form_validation->set_rules('news_date', 'News_Date', 'trim|required');
			$this->form_validation->set_rules('news_location', 'News Location', 'trim|required');
			$this->form_validation->set_rules('news_time', 'News Time', 'trim|required'); 
			$this->form_validation->set_rules('status', 'Status', 'trim|required');
			$this->form_validation->set_rules('slug', 'Seo URL', 'trim|required');
			
			if ($this->form_validation->run() == FALSE) {
				$data = array(
					'errors' => validation_errors()
				);
				$data['news'] = array( 
					'name' => $this->input->post('name'),
					'slug' => $this->input->post('slug'),
					'sort_description' => $this->input->post('sort_description'),
					'description' => $this->input->post('description'),
					'news_date' => $this->input->post('news_date'),
					'news_location' => $this->input->post('news_location'),
					'news_time' => $this->input->post('news_time'), 
					'sort_order' => $this->input->post('sort_order'),
					'is_active' => $this->input->post('status'),
				);
				$this->session->set_flashdata('errors', $data['errors']);
				$this->load->view('includes/_header');
				$this->load->view('news/news_add', $data);
				$this->load->view('includes/_footer');
			}
			else{
				$data = array(
					'name' => $this->input->post('name'),
					'slug' => $this->input->post('slug'),
					'sort_description' => $this->input->post('sort_description'),
					'description' => $this->input->post('description'),
					'news_date' => $this->input->post('news_date'),
					'news_location' => $this->input->post('news_location'),
					'news_time' => $this->input->post('news_time'), 
					'sort_order' => $this->input->post('sort_order'),
					'is_active' => $this->input->post('status'),
					'created_at' => date('Y-m-d : h:m:s'),
					'updated_at' => date('Y-m-d : h:m:s'),
				);
				$old_image = $this->input->post('old_image');
				$path="assets/img/news/";
				if(!empty($_FILES['image']['name']))
				{
					$this->functions->delete_file($old_image);
					$result = $this->functions->file_insert($path, 'image', 'image', '9097152');
					if($result['status'] == 1){
						$data['image'] = $path.$result['msg'];
					}
					else{
						$this->session->set_flashdata('error', $result['msg']);
						redirect(base_url('news/add'), 'refresh');
					}
				}
				$data = $this->security->xss_clean($data);
				$result = $this->news_model->add_news($data);
				if($result){
					$this->session->set_flashdata('success', 'News has been added successfully!');
					redirect(base_url('news'));
				}
			}
		}
		else{

			$data['title'] = 'Add News';

			$this->load->view('includes/_header', $data);
			$this->load->view('news/news_add');
			$this->load->view('includes/_footer');
		}
	}	


		//-----------------------------------------------------------
public function edit($id = 0){

		if($this->input->post('submit')){
			$original_value = $this->news_model->get_news_by_id($id);
			if($this->input->post('name') != $original_value['name']) {
			   $uis_unique =  '|is_unique[ci_newsupdates.name]';
			} else {
			   $uis_unique =  '';
			}
			
			$this->form_validation->set_rules('name', 'Name', 'trim|required|xss_clean'.$uis_unique); 
			$this->form_validation->set_rules('sort_description', 'Sort Description', 'trim|required');
			$this->form_validation->set_rules('description', 'Description', 'trim|required');
			$this->form_validation->set_rules('news_date', 'News_Date', 'trim|required');
			$this->form_validation->set_rules('news_location', 'News Location', 'trim|required');
			$this->form_validation->set_rules('news_time', 'News Time', 'trim|required'); 
			$this->form_validation->set_rules('status', 'Status', 'trim|required');
			$this->form_validation->set_rules('slug', 'Seo URL', 'trim|required');

			if ($this->form_validation->run() == FALSE) { 
				$newsData = $this->news_model->get_news_by_id($id);
				$data = array(
					'errors' => validation_errors()
				); 
				$data['news'] = array(
					'id' => $id,
					'name' => $this->input->post('name'),
					'slug' => $this->input->post('slug'),
					'sort_description' => $this->input->post('sort_description'),
					'description' => $this->input->post('description'),
					'image' => $newsData['image'],
					'news_date' => $this->input->post('news_date'),
					'news_location' => $this->input->post('news_location'),
					'news_time' => $this->input->post('news_time'), 
					'sort_order' => $this->input->post('sort_order'),
					'is_active' => $this->input->post('status'),
				); 
				$this->session->set_flashdata('errors', $data['errors']);
				$this->load->view('includes/_header');
				$this->load->view('news/news_edit', $data);
				$this->load->view('includes/_footer');
			}
			else{
				$data = array(
					'name' => $this->input->post('name'),
					'slug' => $this->input->post('slug'),
					'sort_description' => $this->input->post('sort_description'),
					'description' => $this->input->post('description'),
					'news_date' => $this->input->post('news_date'),
					'news_location' => $this->input->post('news_location'),
					'news_time' => $this->input->post('news_time'), 
					'sort_order' => $this->input->post('sort_order'),
					'is_active' => $this->input->post('status'),
					'updated_at' => date('Y-m-d : h:m:s'),
				);

				$old_image = $this->input->post('old_image');
				$path="assets/img/news/";
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
						redirect(base_url('news/add'), 'refresh');
					}
				}

				$data = $this->security->xss_clean($data);
				$result = $this->news_model->edit_news($data, $id);
				if($result){
					$this->session->set_flashdata('success', 'News has been updated successfully!');
					redirect(base_url('news'));
				}
			}
		}
		else{
			$data['title'] = 'Edit News';
			$data['news'] = $this->news_model->get_news_by_id($id);
			
			$this->load->view('includes/_header', $data);
			$this->load->view('news/news_edit', $data);
			$this->load->view('includes/_footer');
		}
	}

	//-----------------------------------------------------------
	public function delete($id = 0)
	{
		
		$this->db->delete('ci_newsupdates', array('id' => $id));
		$this->session->set_flashdata('success', 'News has been deleted successfully!');
		redirect(base_url('news'));
	}

	public function create_news_pdf(){

		$this->load->helper('pdf_helper'); // loaded pdf helper
		$data['all_news'] = $this->news_model->get_news_for_export();
		
		$this->load->view('news/news_pdf', $data);
	}

	public function export_csv(){ 

	   // file name 
		$filename = 'news_'.date('Y-m-d').'.csv'; 
		header("Content-Description: File Transfer"); 
		header("Content-Disposition: attachment; filename=$filename"); 
		header("Content-Type: application/csv; ");

	   // get data 
		$news_data = $this->news_model->get_news_for_export();

	   // file creation 
		$file = fopen('php://output', 'w');

		$header = array("ID", "name", "sort_description", "news_date", "news_location", "news_start_time", "news_end_time", "created_at"); 

		fputcsv($file, $header);
		foreach ($news_data as $key=>$line){ 
			fputcsv($file,$line); 
		}
		fclose($file); 
		exit; 
	}
	
}
?>