<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Cms extends MY_Controller {

	public function __construct(){

		parent::__construct(); 
		auth_check(); // check login auth 
		check_premissions($this->router->fetch_class(), $this->router->fetch_method());
		check_user_premissions($this->session->userdata('admin_id'), $this->router->fetch_class(), $this->router->fetch_method());
		$this->load->model('cms_model', 'cms_model');
		$this->load->library('datatable'); // loaded my custom serverside datatable library
	}

	public function index(){
		$data['title'] = 'Cms List';
		$this->load->view('includes/_header', $data);
		$this->load->view('cms/cms_list');
		$this->load->view('includes/_footer');
	}
	
	public function datatable_json(){				   					   
		$records = $this->cms_model->get_all_cms();
		$data = array();

		$i=0;
		foreach ($records['data']  as $row) 
		{  
			$status = ($row['is_active'] == 1)? 'checked': '';
			$data[]= array(
				++$i,
				$row['cms_name'],
				$row['cms_title'],
				$row['meta_title'],
				date_time($row['created_at']),	
				'<input class="tgl_checkbox tgl-ios" 
				data-id="'.$row['id'].'" 
				id="cb_'.$row['id'].'"
				type="checkbox" '.$status.'><label for="cb_'.$row['id'].'"></label>',		

				'<a title="Edit" class="update btn btn-sm btn-warning" href="'.base_url('cms/edit/'.$row['id']).'"> <i class="fa fa-pencil-square-o"></i></a>
				<a title="Delete" class="delete btn btn-sm btn-danger" href='.base_url("cms/delete/".$row['id']).' title="Delete" onclick="return confirm(\'Do you want to delete ?\')"> <i class="fa fa-trash-o"></i></a>'

				 
			);
		}
		$records['data']=$data;
		echo json_encode($records);						   
	}

	//-----------------------------------------------------------
	public function change_status(){   

		$this->cms_model->change_status();
	}

	//-----------------------------------------------------------
	public function add(){

		if($this->input->post('submit')){
			$this->form_validation->set_rules('cms_name', 'Cms Name', 'trim|required');
			$this->form_validation->set_rules('cms_title', 'Cms Title', 'trim|required');
			$this->form_validation->set_rules('meta_title', 'Meta Title', 'trim|required');
			$this->form_validation->set_rules('meta_keyword', 'Meta Keyword', 'trim|required');
			$this->form_validation->set_rules('meta_description', 'Meta Description', 'trim|required'); 
			$this->form_validation->set_rules('status', 'Status', 'trim|required');
			$this->form_validation->set_rules('slug', 'Seo URL', 'trim|required');

			if ($this->form_validation->run() == FALSE) {
				$data = array(
					'errors' => validation_errors()
				);
				$data['cms'] = array(
					'cms_name' => $this->input->post('cms_name'),
					'cms_title' => $this->input->post('cms_title'),
					'slug' => $this->input->post('slug'),
					'cms_contant' => $this->input->post('cms_contant'),
					'meta_title' => $this->input->post('meta_title'),
					'meta_keyword' => $this->input->post('meta_keyword'),
					'meta_description' => $this->input->post('meta_description'),
					'is_active' => $this->input->post('status') 
				); 
				$this->session->set_flashdata('errors', $data['errors']);
				$this->load->view('includes/_header');
				$this->load->view('cms/cms_add', $data);
				$this->load->view('includes/_footer');
			}
			else{
				$data = array(
					'cms_name' => $this->input->post('cms_name'),
					'slug' => $this->input->post('slug'),
					'cms_title' => $this->input->post('cms_title'),
					'cms_contant' => $this->input->post('cms_contant'),
					'meta_title' => $this->input->post('meta_title'),
					'meta_keyword' => $this->input->post('meta_keyword'),
					'meta_description' => $this->input->post('meta_description'),
					'created_by' => $this->session->userdata('admin_id'),
					'updated_by' => $this->session->userdata('admin_id'),
					'is_active' => $this->input->post('status'),
					'created_at' => date('Y-m-d : h:m:s'),
					'updated_at' => date('Y-m-d : h:m:s'),
				);
				$path="assets/img/cms/";
				if(!empty($_FILES['cms_banner']['name']))
				{
					if(!empty($old_icon2)){
						$this->functions->delete_file($old_icon2);
					}
					$result = $this->functions->file_insert($path, 'cms_banner', 'image', '9097152');
					if($result['status'] == 1){
						$data['cms_banner'] = $path.$result['msg'];
					}
					else{
						$this->session->set_flashdata('error', $result['msg']);
						redirect(base_url('cms/add'), 'refresh');
					}
				}
				$data = $this->security->xss_clean($data);
				$result = $this->cms_model->add_cms($data);
				if($result){
					$this->session->set_flashdata('success', 'Cms has been added successfully!');
					redirect(base_url('cms'));
				}
			}
		}else{

			$data['title'] = 'Add Cms';

			$this->load->view('includes/_header', $data);
			$this->load->view('cms/cms_add');
			$this->load->view('includes/_footer');
		}
		
	}

	//-----------------------------------------------------------
	public function edit($id = 0){

		if($this->input->post('submit')){
			//$this->form_validation->set_rules('cms_name', 'Cmsname', 'trim|required');
			$this->form_validation->set_rules('cms_name', 'Cms Name', 'trim|required');
			$this->form_validation->set_rules('cms_title', 'Cms Title', 'trim|required');
			$this->form_validation->set_rules('meta_title', 'Meta Title', 'trim|required');
			$this->form_validation->set_rules('meta_keyword', 'Meta Keyword', 'trim|required');
			$this->form_validation->set_rules('meta_description', 'Meta Description', 'trim|required'); 
			$this->form_validation->set_rules('status', 'Status', 'trim|required');
			$this->form_validation->set_rules('slug', 'Seo URL', 'trim|required');
			
			if ($this->form_validation->run() == FALSE) {
				///$data['cms'] = $this->cms_model->get_cms_by_id($id);
				$data = array(
					'errors' => validation_errors()
				);
				$data['cms'] = array(
					'id' => $id,
					'cms_name' => $this->input->post('cms_name'),
					'slug' => $this->input->post('slug'),
					'cms_title' => $this->input->post('cms_title'),
					'cms_contant' => $this->input->post('cms_contant'),
					'meta_title' => $this->input->post('meta_title'),
					'meta_keyword' => $this->input->post('meta_keyword'),
					'meta_description' => $this->input->post('meta_description'),
					'is_active' => $this->input->post('status')
				); 
				$this->session->set_flashdata('errors', $data['errors']);
				$this->load->view('includes/_header');
				$this->load->view('cms/cms_edit', $data);
				$this->load->view('includes/_footer');
			}
			else{
				$data = array(
					//'cms_name' => $this->input->post('cms_name'),
					'cms_title' => $this->input->post('cms_title'),
					'slug' => $this->input->post('slug'),
					'cms_contant' => $this->input->post('cms_contant'),
					'meta_title' => $this->input->post('meta_title'),
					'meta_keyword' => $this->input->post('meta_keyword'),
					'meta_description' => $this->input->post('meta_description'),
					'is_active' => $this->input->post('status'),
					'updated_by' => $this->session->userdata('admin_id'),
					'updated_at' => date('Y-m-d : h:m:s'),
				);
				$path="assets/img/cms/";
				$old_banner = $this->input->post('old_banner');
				if(!empty($_FILES['cms_banner']['name']))
				{
					if(!empty($old_banner)){
						$this->functions->delete_file($old_banner);
					}
					$result = $this->functions->file_insert($path, 'cms_banner', 'image', '9097152'); 
					if($result['status'] == 1){
						$data['cms_banner'] = $path.$result['msg'];
					}
					else{
						$this->session->set_flashdata('error', $result['msg']);
						redirect(base_url('cms/edit/'.$id), 'refresh');
					}
				}
				$data = $this->security->xss_clean($data);
				$result = $this->cms_model->edit_cms($data, $id);
				if($result){
					$this->session->set_flashdata('success', 'Cms has been updated successfully!');
					redirect(base_url('cms'));
				}
			}
		}
		else{
			$data['title'] = 'Edit Cms';
			$data['cms'] = $this->cms_model->get_cms_by_id($id);
			
			$this->load->view('includes/_header', $data);
			$this->load->view('cms/cms_edit', $data);
			$this->load->view('includes/_footer');
		}
	}

	//-----------------------------------------------------------
	public function delete($id = 0)
	{		
		$this->db->delete('ci_cms', array('id' => $id));
		$this->session->set_flashdata('success', 'Cms Page has been deleted successfully!');
		redirect(base_url('cms'));
	}  


}

?>