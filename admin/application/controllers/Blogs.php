<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Blogs extends MY_Controller {

	public function __construct(){

		parent::__construct();
		auth_check(); // check login auth
		check_premissions($this->router->fetch_class(), $this->router->fetch_method());
		check_user_premissions($this->session->userdata('admin_id'), $this->router->fetch_class(), $this->router->fetch_method());
		$this->load->model('blogs_model', 'blogs_model');
		$this->load->library('datatable'); // loaded my custom serverside datatable library
	}

	public function index(){

		$data['title'] = 'Blogs List';

		$this->load->view('includes/_header', $data);
		$this->load->view('blogs/blog_list');
		$this->load->view('includes/_footer');
	}
	
	public function datatable_json(){				   					   
		$records = $this->blogs_model->get_all_blogs();
		$data = array();

		$i=0;
		foreach ($records['data']  as $row) 
		{  
			$status = ($row['is_active'] == 1)? 'checked': '';
			$data[]= array(
				++$i,
				$row['name'], 
				$row['blog_date'],
				$row['posted_by'], 
				'<img src="'.base_url($row['image']).'" width="50" height="50">',
				date_time($row['created_at']),	
				'<input class="tgl_checkbox tgl-ios" 
				data-id="'.$row['id'].'" 
				id="cb_'.$row['id'].'"
				type="checkbox"  
				'.$status.'><label for="cb_'.$row['id'].'"></label>',		

				'<a title="Edit" class="update btn btn-sm btn-warning" href="'.base_url('blogs/edit/'.$row['id']).'"> <i class="fa fa-pencil-square-o"></i></a>
				<a title="Delete" class="delete btn btn-sm btn-danger" href='.base_url("blogs/delete/".$row['id']).' title="Delete" onclick="return confirm(\'Do you want to delete ?\')"> <i class="fa fa-trash-o"></i></a>'
			);
		}
		$records['data']=$data;
		echo json_encode($records);						   
	}

	//-----------------------------------------------------------
	public function change_status(){   

		$this->blogs_model->change_status();
	}

//-----------------------------------------------------------
	public function add(){

		if($this->input->post('submit')){
			$this->form_validation->set_rules('name', 'Name', 'trim|required|xss_clean|is_unique[ci_blogs.name]');
			$this->form_validation->set_rules('sort_description', 'Sort Description', 'trim|required');
			$this->form_validation->set_rules('description', 'Description', 'trim|required');
			$this->form_validation->set_rules('blog_date', 'Blog Date', 'trim|required');
			$this->form_validation->set_rules('posted_by', 'Posted By', 'trim|required'); 
			$this->form_validation->set_rules('status', 'Status', 'trim|required');
			$this->form_validation->set_rules('slug', 'Seo URL', 'trim|required');

			if ($this->form_validation->run() == FALSE) {
				$data = array(
					'errors' => validation_errors()
				);
				$data['blog'] = array( 
					'name' => $this->input->post('name'),
					'slug' => $this->input->post('slug'),
					'sort_description' => $this->input->post('sort_description'),
					'description' => $this->input->post('description'),
					'blog_date' => $this->input->post('blog_date'),
					'posted_by' => $this->input->post('posted_by'), 
					'sort_order' => $this->input->post('sort_order'),
					'is_active' => $this->input->post('status'),
				);
				$this->session->set_flashdata('errors', $data['errors']);
				$this->load->view('includes/_header');
				$this->load->view('blogs/blog_add', $data);
				$this->load->view('includes/_footer');
			}
			else{
				$data = array(
					'name' => $this->input->post('name'),
					'slug' => $this->input->post('slug'),
					'sort_description' => $this->input->post('sort_description'),
					'description' => $this->input->post('description'),
					'blog_date' => $this->input->post('blog_date'),
					'posted_by' => $this->input->post('posted_by'), 
					'sort_order' => $this->input->post('sort_order'),
					'is_active' => $this->input->post('status'),
					'created_at' => date('Y-m-d : h:m:s'),
					'updated_at' => date('Y-m-d : h:m:s'),
				);
				$old_image = $this->input->post('old_image');
				$path="assets/img/blogs/";
				if(!empty($_FILES['image']['name']))
				{
					$this->functions->delete_file($old_image);
					$result = $this->functions->file_insert($path, 'image', 'image', '9097152');
					if($result['status'] == 1){
						$data['image'] = $path.$result['msg'];
					}
					else{
						$this->session->set_flashdata('error', $result['msg']);
						redirect(base_url('blogs/add'), 'refresh');
					}
				}
				$data = $this->security->xss_clean($data);
				$result = $this->blogs_model->add_blogs($data);
				if($result){
					$this->session->set_flashdata('success', 'Blogs has been added successfully!');
					redirect(base_url('blogs'));
				}
			}
		}
		else{

			$data['title'] = 'Add Blogs';

			$this->load->view('includes/_header', $data);
			$this->load->view('blogs/blog_add');
			$this->load->view('includes/_footer');
		}
	}	


		//-----------------------------------------------------------
public function edit($id = 0){

		if($this->input->post('submit')){
			$original_value = $this->blogs_model->get_blog_by_id($id);
			if($this->input->post('name') != $original_value['name']) {
			   $uis_unique =  '|is_unique[ci_blogs.name]';
			} else {
			   $uis_unique =  '';
			}
			
			$this->form_validation->set_rules('name', 'Name', 'trim|required|xss_clean'.$uis_unique); 
			$this->form_validation->set_rules('sort_description', 'Sort Description', 'trim|required');
			$this->form_validation->set_rules('description', 'Description', 'trim|required');
			$this->form_validation->set_rules('blog_date', 'Blog_Date', 'trim|required');
			$this->form_validation->set_rules('posted_by', 'Posted By', 'trim|required'); 
			$this->form_validation->set_rules('status', 'Status', 'trim|required');
			$this->form_validation->set_rules('slug', 'Seo URL', 'trim|required');

			if ($this->form_validation->run() == FALSE) { 
				$blogData = $this->blogs_model->get_blog_by_id($id);
				$data = array(
					'errors' => validation_errors()
				); 
				$data['blog'] = array(
					'id' => $id,
					'name' => $this->input->post('name'),
					'slug' => $this->input->post('slug'),
					'sort_description' => $this->input->post('sort_description'),
					'description' => $this->input->post('description'),
					'image' => $blogData['image'],
					'blog_date' => $this->input->post('blog_date'),
					'posted_by' => $this->input->post('posted_by'), 
					'sort_order' => $this->input->post('sort_order'),
					'is_active' => $this->input->post('status'),
				); 
				$this->session->set_flashdata('errors', $data['errors']);
				$this->load->view('includes/_header');
				$this->load->view('blogs/blog_edit', $data);
				$this->load->view('includes/_footer');
			}
			else{
				$data = array(
					'name' => $this->input->post('name'),
					'slug' => $this->input->post('slug'),
					'sort_description' => $this->input->post('sort_description'),
					'description' => $this->input->post('description'),
					'blog_date' => $this->input->post('blog_date'),
					'posted_by' => $this->input->post('posted_by'), 
					'sort_order' => $this->input->post('sort_order'),
					'is_active' => $this->input->post('status'),
					'updated_at' => date('Y-m-d : h:m:s'),
				);

				$old_image = $this->input->post('old_image');
				$path="assets/img/blogs/";
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
						redirect(base_url('blogs/edit/'.$id), 'refresh');
					}
				}

				$data = $this->security->xss_clean($data);
				$result = $this->blogs_model->edit_blog($data, $id);
				if($result){
					$this->session->set_flashdata('success', 'Blog has been updated successfully!');
					redirect(base_url('blogs'));
				}
			}
		}
		else{
			$data['title'] = 'Edit Blogs';
			$data['blog'] = $this->blogs_model->get_blog_by_id($id);
			
			$this->load->view('includes/_header', $data);
			$this->load->view('blogs/blog_edit', $data);
			$this->load->view('includes/_footer');
		}
	}

	//-----------------------------------------------------------
	public function delete($id = 0)
	{
		
		$this->db->delete('ci_blogs', array('id' => $id));
		$this->session->set_flashdata('success', 'Blog has been deleted successfully!');
		redirect(base_url('blogs'));
	}

	public function create_blogs_pdf(){

		$this->load->helper('pdf_helper'); // loaded pdf helper
		$data['all_blogs'] = $this->blogs_model->get_blogs_for_export();
		$this->load->view('blogs/blog_pdf', $data);
	}

	public function export_csv(){ 

	   // file name 
		$filename = 'blog_'.date('Y-m-d').'.csv'; 
		header("Content-Description: File Transfer"); 
		header("Content-Disposition: attachment; filename=$filename"); 
		header("Content-Type: application/csv; ");

	   // get data 
		$blogs_data = $this->blogs_model->get_blogs_for_export();

	   // file creation 
		$file = fopen('php://output', 'w');

		$header = array("ID", "name", "sort_description", "blog_date", "posted_by", "created_at"); 

		fputcsv($file, $header);
		foreach ($blogs_data as $key=>$line){ 
			fputcsv($file,$line); 
		}
		fclose($file); 
		exit; 
	}
	
}
?>