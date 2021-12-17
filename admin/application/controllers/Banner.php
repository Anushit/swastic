<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Banner extends MY_Controller {

	public function __construct(){

		parent::__construct(); 
		auth_check(); // check login auth
		check_premissions($this->router->fetch_class(), $this->router->fetch_method());
		check_user_premissions($this->session->userdata('admin_id'), $this->router->fetch_class(), $this->router->fetch_method());
		$this->load->model('banner_model', 'banner_model');
		$this->load->library('datatable'); // loaded my custom serverside datatable library
	}

	public function index(){
		$data['title'] = 'banners List';

		$this->load->view('includes/_header', $data);
		$this->load->view('banner/banner_list');
		$this->load->view('includes/_footer');
	}
	
	public function datatable_json(){				   					   
		$records = $this->banner_model->get_all_banner();
		$data = array();

		$i=0;
		foreach ($records['data']  as $row) 
		{  
			$status = ($row['is_active'] == 1)? 'checked': '';
			$data[]= array(
				++$i,
				$row['name'],
				'<img src="'.base_url($row['image']).'" class=" logominiimg" />', 
				$row['sort_order'],
				date_time($row['created_at']),	
				'<input class="tgl_checkbox tgl-ios" 
				data-id="'.$row['id'].'" 
				id="cb_'.$row['id'].'"
				type="checkbox" '.$status.'><label for="cb_'.$row['id'].'"></label>',		

				'<a title="Edit" class="update btn btn-sm btn-warning" href="'.base_url('banner/edit/'.$row['id']).'"> <i class="fa fa-pencil-square-o"></i></a>
				<a title="Delete" class="delete btn btn-sm btn-danger" href='.base_url("banner/delete/".$row['id']).' title="Delete" onclick="return confirm(\'Do you want to delete ?\')"> <i class="fa fa-trash-o"></i></a>'

				 
			);
		}
		$records['data']=$data;
		echo json_encode($records);						   
	}

	//-----------------------------------------------------------
	public function change_status(){   

		$this->banner_model->change_status();
	}

	//-----------------------------------------------------------
	public function add(){

		if($this->input->post('submit')){
			$this->form_validation->set_rules('name', 'Name', 'trim|required');
			$this->form_validation->set_rules('sort_order', 'Sort Order', 'trim|numeric|required');
			  
			$this->form_validation->set_rules('status', 'Status', 'trim|required');

			if ($this->form_validation->run() == FALSE) {
				$data = array(
					'errors' => validation_errors()
				);
				$data['banner'] = array(
					'name' => $this->input->post('name'), 
					'title_first' => $this->input->post('title_first'),
					'title_second' => $this->input->post('title_second'), 
					'url_link' => $this->input->post('url_link'),
					'sort_order' => $this->input->post('sort_order'),
					'is_active' => $this->input->post('status') 
				); 
				$this->session->set_flashdata('errors', $data['errors']); 
				$this->load->view('includes/_header');
				$this->load->view('banner/banner_add', $data);
				$this->load->view('includes/_footer');
			}
			else{
				$data = array(
					'name' => $this->input->post('name'), 
					'title_first' => $this->input->post('title_first'),
					'title_second' => $this->input->post('title_second'), 
					'url_link' => $this->input->post('url_link'),
					'sort_order' => $this->input->post('sort_order'),
					'is_active' => $this->input->post('status'),
					'created_by' => $this->session->userdata('admin_id'),
					'updated_by' => $this->session->userdata('admin_id'),
					'created_at' => date('Y-m-d : h:m:s'),
					'updated_at' => date('Y-m-d : h:m:s'),
				); 
				$old_image = $this->input->post('old_image');
				$path="assets/img/banner/"; 				
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
						redirect(base_url('banner/add'), 'refresh');
					}
				}
				$old_image = $this->input->post('old_image');
				$path="assets/img/banner/"; 				
				if(!empty($_FILES['image1']['name']))
				{
					if(!empty($old_image)){
						$this->functions->delete_file($old_image);
					}
					$result = $this->functions->file_insert($path, 'image1', 'image', '9097152');
					if($result['status'] == 1){
						$data['image1'] = $path.$result['msg'];
					}
					else{
						$this->session->set_flashdata('error', $result['msg']);
						redirect(base_url('banner/add'), 'refresh');
					}
				}
				$old_image = $this->input->post('old_image');
				$path="assets/img/banner/"; 				
				if(!empty($_FILES['image2']['name']))
				{
					if(!empty($old_image)){
						$this->functions->delete_file($old_image);
					}
					$result = $this->functions->file_insert($path, 'image2', 'image', '9097152');
					if($result['status'] == 1){
						$data['image2'] = $path.$result['msg'];
					}
					else{
						$this->session->set_flashdata('error', $result['msg']);
						redirect(base_url('banner/add'), 'refresh');
					}
				}
				$old_image = $this->input->post('old_image');
				$path="assets/img/banner/"; 				
				if(!empty($_FILES['image3']['name']))
				{
					if(!empty($old_image)){
						$this->functions->delete_file($old_image);
					}
					$result = $this->functions->file_insert($path, 'image3', 'image', '9097152');
					if($result['status'] == 1){
						$data['image3'] = $path.$result['msg'];
					}
					else{
						$this->session->set_flashdata('error', $result['msg']);
						redirect(base_url('banner/add'), 'refresh');
					}
				}
				$data = $this->security->xss_clean($data);
				$result = $this->banner_model->add_banner($data);
				if($result){
					$this->session->set_flashdata('success', 'banner has been added successfully!');
					redirect(base_url('banner'));
				}
			}
		}
		else{
			$data['title'] = 'Add banner';
			$this->load->view('includes/_header', $data);
			$this->load->view('banner/banner_add');
			$this->load->view('includes/_footer');
		}
		
	}

	//-----------------------------------------------------------
	public function edit($id = 0){

		if($this->input->post('submit')){
			$this->form_validation->set_rules('name', 'Name', 'trim|required');
			$this->form_validation->set_rules('sort_order', 'Sort Order', 'trim|numeric|required');
			  
			$this->form_validation->set_rules('status', 'Status', 'trim|required');

			if ($this->form_validation->run() == FALSE) {
				$bannerData = $this->banner_model->get_banner_by_id($id);
				$data = array(
					'errors' => validation_errors()
				); 
				$data['banner'] = array(
					'id' => $id, 
					'name' => $this->input->post('name'),
					'image' => $bannerData['image'],
					'title_first' => $this->input->post('title_first'),
					'title_second' => $this->input->post('title_second'), 
					'url_link' => $this->input->post('url_link'),
					'sort_order' => $this->input->post('sort_order'),
					'is_active' => $this->input->post('status')
				);
				$this->session->set_flashdata('errors', $data['errors']);
				$this->load->view('includes/_header');
				$this->load->view('banner/banner_edit', $data);
				$this->load->view('includes/_footer');
			}
			else{
				$data = array(
					'name' => $this->input->post('name'), 
					'title_first' => $this->input->post('title_first'),
					'title_second' => $this->input->post('title_second'), 
					'url_link' => $this->input->post('url_link'),
					'sort_order' => $this->input->post('sort_order'),
					'is_active' => $this->input->post('status'),
					'updated_by' => $this->session->userdata('admin_id'),
					'updated_at' => date('Y-m-d : h:m:s'),
				); 
				$old_image = $this->input->post('old_image');
				$path="assets/img/banner/"; 
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
						redirect(base_url('banner/edit/'.$id), 'refresh');
					}
				}
				if(!empty($_FILES['image1']['name']))
				{
					if(!empty($old_image)){
						$this->functions->delete_file($old_image);
					}
					$result = $this->functions->file_insert($path, 'image1', 'image', '9097152');
					if($result['status'] == 1){
						$data['image1'] = $path.$result['msg'];
					}
					else{
						$this->session->set_flashdata('error', $result['msg']);
						redirect(base_url('banner/edit/'.$id), 'refresh');
					}
				}
				if(!empty($_FILES['image2']['name']))
				{
					if(!empty($old_image)){
						$this->functions->delete_file($old_image);
					}
					$result = $this->functions->file_insert($path, 'image2', 'image', '9097152');
					if($result['status'] == 1){
						$data['image2'] = $path.$result['msg'];
					}
					else{
						$this->session->set_flashdata('error', $result['msg']);
						redirect(base_url('banner/edit/'.$id), 'refresh');
					}
				}
				if(!empty($_FILES['image3']['name']))
				{
					if(!empty($old_image)){
						$this->functions->delete_file($old_image);
					}
					$result = $this->functions->file_insert($path, 'image3', 'image', '9097152');
					if($result['status'] == 1){
						$data['image3'] = $path.$result['msg'];
					}
					else{
						$this->session->set_flashdata('error', $result['msg']);
						redirect(base_url('banner/edit/'.$id), 'refresh');
					}
				}
				$data = $this->security->xss_clean($data);
				$result = $this->banner_model->edit_banner($data, $id);
				if($result){
					$this->session->set_flashdata('success', 'banner has been updated successfully!');
					redirect(base_url('banner'));
				}
			}
		}
		else{
			$data['title'] = 'Edit banner';
			$data['banner'] = $this->banner_model->get_banner_by_id($id);
			
			$this->load->view('includes/_header', $data);
			$this->load->view('banner/banner_edit', $data);
			$this->load->view('includes/_footer');
		}
	}

	//-----------------------------------------------------------
	public function delete($id = 0)
	{		
		$this->db->delete('ci_banners', array('id' => $id));
		$this->session->set_flashdata('success', 'banner has been deleted successfully!');
		redirect(base_url('banner'));
	}
 
	 
}

?>