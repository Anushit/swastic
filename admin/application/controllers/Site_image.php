<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Site_image extends MY_Controller {

	public function __construct(){

		parent::__construct(); 
		auth_check(); // check login auth 
		check_premissions($this->router->fetch_class(), $this->router->fetch_method());
		check_user_premissions($this->session->userdata('admin_id'), $this->router->fetch_class(), $this->router->fetch_method());
		$this->load->model('Site_image_model', 'site_image_model');
		$this->load->library('datatable'); // loaded my custom serverside datatable library
	}

	public function index(){

		$data['title'] = 'Site Image List';

		$this->load->view('includes/_header', $data);
		$this->load->view('siteimage/site_image_list');
		$this->load->view('includes/_footer');
	}
	
	public function datatable_json(){				   					   
		$records = $this->site_image_model->get_all_siteImage();
		$data = array();

		$i=0;
		foreach ($records['data']  as $row) 
		{  
			$status = ($row['is_active'] == 1)? 'checked': '';
			$data[]= array(
				++$i,
				$row['section_name'],
				$row['title'],
				$row['url'],
				'<img src="'.base_url($row["image"]).'" class="image" height="50">',
				$row['size_suggestion'],
				date_time($row['created_at']),	
				'<input class="tgl_checkbox tgl-ios" 
				data-id="'.$row['id'].'" 
				id="cb_'.$row['id'].'"
				type="checkbox" '.$status.'><label for="cb_'.$row['id'].'"></label>',		

				'<a title="Edit" class="update btn btn-sm btn-warning" href="'.base_url('site_image/edit/'.$row['id']).'"> <i class="fa fa-pencil-square-o"></i></a>
				<a title="Delete" class="delete btn btn-sm btn-danger" href='.base_url("site_image/delete/".$row['id']).' title="Delete" onclick="return confirm(\'Do you want to delete ?\')"> <i class="fa fa-trash-o"></i></a>'

				 
			);
		}
		$records['data']=$data;
		echo json_encode($records);						   
	}

	//-----------------------------------------------------------
	public function change_status(){   

		$this->site_image_model->change_status();
	}


	//-----------------------------------------------------------
	public function edit($id = 0){
	$data['site_image'] = $this->site_image_model->get_siteimage_by_id($id);
		if($this->input->post('submit')){
			$this->form_validation->set_rules('section_name', 'section name', 'trim|required');
			$this->form_validation->set_rules('title', ' Title', 'trim|required');
			///$this->form_validation->set_rules('url', 'url ', 'trim|required');
			///$this->form_validation->set_rules('size_suggestion', 'size suggestion ', 'trim|required');
			$this->form_validation->set_rules('status', 'Status', 'trim|required');

			if ($this->form_validation->run() == FALSE) {
				///$data['cms'] = $this->cms_model->get_cms_by_id($id);
				$error = array(
					'errors' => validation_errors()
				);
				$data['site_images'] = array(
					'id' => $id,
					'title' => $this->input->post('title'), 
					'url' => $this->input->post('url'),
					'is_active' => $this->input->post('status')
				); 
				$this->session->set_flashdata('errors', $error['errors']);
				$this->load->view('includes/_header');
				$this->load->view('siteimage/site_image_edit', $data);
				$this->load->view('includes/_footer');
			}
			else{
				$data = array( 
					'title' => $this->input->post('title'), 
					'url' => $this->input->post('url'),
					'is_active' => $this->input->post('status'),
					'updated_by' => $this->session->userdata('admin_id'),
					'updated_at' => date('Y-m-d,H:m:s'),
				);
				$old_image = $this->input->post('old_image');
				$path="assets/img/site_image/"; 				
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
						redirect(base_url('site_image/edit'), 'refresh');
					}
				}
				$data = $this->security->xss_clean($data);
				$result = $this->site_image_model->edit_siteimage($data, $id);
				if($result){
					$this->session->set_flashdata('success', 'Site image has been updated successfully!');
					redirect(base_url('site_image'));
				}
			}
		}
		else{
			$data['title'] = 'Edit Site Image'; 
			
			$this->load->view('includes/_header', $data);
			$this->load->view('siteimage/site_image_edit', $data);
			$this->load->view('includes/_footer');
		}
	}

	//-----------------------------------------------------------
	public function delete($id = 0)
	{		
		$this->db->delete('site_images', array('id' => $id));
		$this->session->set_flashdata('success', 'Site image Page has been deleted successfully!');
		redirect(base_url('site_image'));
	}  


}

?>