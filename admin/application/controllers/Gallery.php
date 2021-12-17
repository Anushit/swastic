<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Gallery extends MY_Controller {

	public function __construct(){

		parent::__construct(); 
		auth_check(); // check login auth
		check_user_premissions($this->session->userdata('admin_id'), $this->router->fetch_class(), $this->router->fetch_method());
		if(!empty($this->uri->segment(2))){
		   $cur_tab = $this->uri->segment(2)==''?'dashboard': $this->uri->segment(2); 
		   switch($cur_tab){
		   	case 'photo':
		   	 check_premissions('photo_gallery', $this->router->fetch_method());
		   	 break;
		   	case 'video':
			 check_premissions('video_gallery', $this->router->fetch_method());
			 break;
			case 'addphoto':
		   	 check_premissions('photo_gallery', 'add');
		   	 break;
		   	case 'addvideo':
			 check_premissions('video_gallery', 'add');
			 break;
			case 'editphoto':
		   	 check_premissions('photo_gallery', 'edit');
		   	 break;
		   	case 'editvideo':
			 check_premissions('video_gallery', 'edit');
			 break;
			case 'deletephoto':
		   	 check_premissions('photo_gallery', 'delete');
		   	 break;
		   	case 'editvideo':
			 check_premissions('video_gallery', 'delete');
			 break;  
		   } 
		}  
		$this->load->model('gallery_model', 'gallery_model');
		$this->load->library('datatable'); // loaded my custom serverside datatable library
	}

	public function index($id=1){
		$data['title'] = 'gallery List'; 
		if($id=='1'){
			$data['type'] = 1;
			$module ='photo_gallery';
		}elseif($id=='2'){
			$data['type'] = 2;
			$module ='video_gallery';
		} 
		$this->load->view('includes/_header', $data);
		$this->load->view($module.'/gallery_list');
		$this->load->view('includes/_footer');
	}
	
	public function photo_datatable_json(){				   					   
		$records = $this->gallery_model->get_all_gallery('1');
		$data = array();

		$i=0;
		foreach ($records['data']  as $row) 
		{  
			$status = ($row['is_active'] == 1)? 'checked': '';
			$data[]= array(
				++$i,
				$row['album'],
				'<img src="'.base_url($row['cover_photo']).'" class=" logominiimg" />', 
				$row['sort_order'],
				date_time($row['created_at']),	
				'<input class="tgl_checkbox tgl-ios" 
				data-id="'.$row['id'].'" 
				id="cb_'.$row['id'].'"
				type="checkbox" '.$status.'><label for="cb_'.$row['id'].'"></label>',		

				'<a title="Add More Photos" style="margin-bottom:5px;" class="update btn btn-sm btn-info" href="'.base_url('gallery/updatephoto/'.$row['id']).'"> <i class="fa fa-plus">&nbsp;</i> Add Photos</a> <br>
				<a title="Edit" class="update btn btn-sm btn-warning" href="'.base_url('gallery/editphoto/'.$row['id']).'"> <i class="fa fa-pencil-square-o"></i></a> &nbsp;
				<a title="Delete" class="delete btn btn-sm btn-danger" href='.base_url("gallery/deletephoto/".$row['id']).' title="Delete" onclick="return confirm(\'Do you want to delete ?\')"> <i class="fa fa-trash-o"></i></a>'				 
			);
		}
		$records['data']=$data;
		echo json_encode($records);						   
	}

	
	public function video_datatable_json(){				   					   
		$records = $this->gallery_model->get_all_gallery('2');
		$data = array();

		$i=0;
		foreach ($records['data']  as $row) 
		{  
			$status = ($row['is_active'] == 1)? 'checked': '';
			$data[]= array(
				++$i,
				$row['album'],
				'<img src="'.base_url($row['cover_photo']).'" class=" logominiimg" />', 
				$row['sort_order'],
				date_time($row['created_at']),	
				'<input class="tgl_checkbox tgl-ios" 
				data-id="'.$row['id'].'" 
				id="cb_'.$row['id'].'"
				type="checkbox" '.$status.'><label for="cb_'.$row['id'].'"></label>',		

				'<a title="Add More Video" style="margin-bottom:5px;" class="update btn btn-sm btn-info" href="'.base_url('gallery/updatevideo/'.$row['id']).'"> <i class="fa fa-plus">&nbsp;</i> Add Video</a> <br>
				<a title="Edit" class="update btn btn-sm btn-warning" href="'.base_url('gallery/editvideo/'.$row['id']).'"> <i class="fa fa-pencil-square-o"></i></a> &nbsp;
				<a title="Delete" class="delete btn btn-sm btn-danger" href='.base_url("gallery/deletevideo/".$row['id']).' title="Delete" onclick="return confirm(\'Do you want to delete ?\')"> <i class="fa fa-trash-o"></i></a>'

				 
			);
		}
		$records['data']=$data;
		echo json_encode($records);						   
	}

	//-----------------------------------------------------------
	public function change_status(){   

		$this->gallery_model->change_status();
	}

	//-----------------------------------------------------------
	public function addphoto(){

		if($this->input->post('submit')){
			$this->form_validation->set_rules('album', 'Album', 'trim|required');
			$this->form_validation->set_rules('sort_order', 'Sort Order', 'trim|numeric|required');
			  
			$this->form_validation->set_rules('status', 'Status', 'trim|required');
			$this->form_validation->set_rules('slug', 'Seo URL', 'trim|required');

			if ($this->form_validation->run() == FALSE) {
				$data = array(
					'errors' => validation_errors()
				);
				$data['gallery'] = array(
					'album' => $this->input->post('album'),  
					'slug' => $this->input->post('slug'),
					'description' => $this->input->post('description'),
					'sort_order' => $this->input->post('sort_order'),
					'is_active' => $this->input->post('status') 
				); 
				$this->session->set_flashdata('errors', $data['errors']); 
				$this->load->view('includes/_header');
				$this->load->view('photo_gallery/gallery_add', $data);
				$this->load->view('includes/_footer');
			}
			else{
				$data = array(
					'album' => $this->input->post('album'), 
					'slug' => $this->input->post('slug'), 
					'description' => $this->input->post('description'),
					'type' => '1',
					'sort_order' => $this->input->post('sort_order'),
					'is_active' => $this->input->post('status'),
					'created_by' => $this->session->userdata('admin_id'),
					'updated_by' => $this->session->userdata('admin_id'),
					'created_at' => date('Y-m-d : h:m:s'),
					'updated_at' => date('Y-m-d : h:m:s'),
				); 
				$old_cover_photo = $this->input->post('old_cover_photo');
				$path="assets/img/gallery/"; 				
				if(!empty($_FILES['cover_photo']['name']))
				{
					if(!empty($old_cover_photo)){
						$this->functions->delete_file($old_cover_photo);
					}
					$result = $this->functions->file_insert($path, 'cover_photo', 'image', '9097152');
					if($result['status'] == 1){
						$data['cover_photo'] = $path.$result['msg'];
					}
					else{
						$this->session->set_flashdata('error', $result['msg']);
						redirect(base_url('gallery/addphoto'), 'refresh');
					}
				}
				$data = $this->security->xss_clean($data);
				$result = $this->gallery_model->add_gallery($data);
				if($result){
					$this->session->set_flashdata('success', 'gallery has been added successfully!');
					redirect(base_url('gallery/photo'));
				}
			}
		}
		else{
			$data['title'] = 'Add photo gallery';
			$this->load->view('includes/_header', $data);
			$this->load->view('photo_gallery/gallery_add');
			$this->load->view('includes/_footer');
		}
		
	}

	//-----------------------------------------------------------
	public function editphoto($id = 0){
		if($this->input->post('submit')){
			$this->form_validation->set_rules('album', 'Album', 'trim|required');
			$this->form_validation->set_rules('sort_order', 'Sort Order', 'trim|numeric|required');
			  
			$this->form_validation->set_rules('status', 'Status', 'trim|required');
			$this->form_validation->set_rules('slug', 'Seo URL', 'trim|required');

			if ($this->form_validation->run() == FALSE) {
				$galleryData = $this->gallery_model->get_gallery_by_id($id);
				$data = array(
					'errors' => validation_errors()
				); 
				$data['gallery'] = array(
					'id' => $id, 
					'album' => $this->input->post('album'),
					'slug' => $this->input->post('slug'),
					'description' => $this->input->post('description'),
					'cover_photo' => $galleryData['cover_photo'], 
					'sort_order' => $this->input->post('sort_order'),
					'is_active' => $this->input->post('status')
				);
				$this->session->set_flashdata('errors', $data['errors']);
				$this->load->view('includes/_header');
				$this->load->view('photo_gallery/gallery_edit', $data);
				$this->load->view('includes/_footer');
			}
			else{
				$data = array(
					'album' => $this->input->post('album'),  
					'slug' => $this->input->post('slug'),
					'description' => $this->input->post('description'),
					'sort_order' => $this->input->post('sort_order'),
					'is_active' => $this->input->post('status'),
					'updated_by' => $this->session->userdata('admin_id'),
					'updated_at' => date('Y-m-d : h:m:s'),
				); 
				$old_cover_photo = $this->input->post('old_cover_photo');
				$path="assets/img/gallery/"; 
				if(!empty($_FILES['cover_photo']['name']))
				{
					if(!empty($old_cover_photo)){
						$this->functions->delete_file($old_cover_photo);
					}
					$result = $this->functions->file_insert($path, 'cover_photo', 'image', '9097152');
					if($result['status'] == 1){
						$data['cover_photo'] = $path.$result['msg'];
					}
					else{
						$this->session->set_flashdata('error', $result['msg']);
						redirect(base_url('gallery/editphoto/'.$id), 'refresh');
					}
				}
				$data = $this->security->xss_clean($data);
				$result = $this->gallery_model->edit_gallery($data, $id);
				if($result){
					$this->session->set_flashdata('success', 'gallery has been updated successfully!');
					redirect(base_url('gallery/photo'));
				}
			}
		}
		else{
			$data['title'] = 'Edit photo gallery';
			$data['gallery'] = $this->gallery_model->get_gallery_by_id($id);
			
			$this->load->view('includes/_header', $data);
			$this->load->view('photo_gallery/gallery_edit', $data);
			$this->load->view('includes/_footer');
		}
	}

	//-----------------------------------------------------------
	public function deletephoto($id = 0)
	{		
		$galleryData = $this->gallery_model->get_gallery_by_id($id);
		$this->functions->delete_file($galleryData['cover_photo']);
		$this->db->delete('ci_gallery', array('id' => $id,'type'=>'1'));
		$galleryDetails = $this->gallery_model->get_gallerydetail_by_id($id);
		foreach ($galleryDetails as $key => $value) {
			if(!empty($value)){
				$this->functions->delete_file($value['value']);
			}
		}
		$this->db->delete('ci_gallery_details', array('gallery_id' => $id));
		$this->session->set_flashdata('success', 'gallery has been deleted successfully!');
		redirect(base_url('gallery/photo'));
	}


	//-----------------------------------------------------------
	public function addvideo(){

		if($this->input->post('submit')){
			$this->form_validation->set_rules('album', 'Album', 'trim|required');
			$this->form_validation->set_rules('sort_order', 'Sort Order', 'trim|numeric|required');
			  
			$this->form_validation->set_rules('status', 'Status', 'trim|required');
			$this->form_validation->set_rules('slug', 'Seo URL', 'trim|required');

			if ($this->form_validation->run() == FALSE) {
				$data = array(
					'errors' => validation_errors()
				);
				$data['gallery'] = array(
					'album' => $this->input->post('album'),  
					'slug' => $this->input->post('slug'),
					'description' => $this->input->post('description'),
					'sort_order' => $this->input->post('sort_order'),
					'is_active' => $this->input->post('status') 
				); 
				$this->session->set_flashdata('errors', $data['errors']); 
				$this->load->view('includes/_header');
				$this->load->view('video_gallery/gallery_add', $data);
				$this->load->view('includes/_footer');
			}
			else{
				$data = array(
					'album' => $this->input->post('album'), 
					'slug' => $this->input->post('slug'), 
					'description' => $this->input->post('description'),
					'type' => '2',
					'sort_order' => $this->input->post('sort_order'),
					'is_active' => $this->input->post('status'),
					'created_by' => $this->session->userdata('admin_id'),
					'updated_by' => $this->session->userdata('admin_id'),
					'created_at' => date('Y-m-d : h:m:s'),
					'updated_at' => date('Y-m-d : h:m:s'),
				); 
				$old_cover_photo = $this->input->post('old_cover_photo');
				$path="assets/img/gallery/"; 				
				if(!empty($_FILES['cover_photo']['name']))
				{
					if(!empty($old_cover_photo)){
						$this->functions->delete_file($old_cover_photo);
					}
					$result = $this->functions->file_insert($path, 'cover_photo', 'image', '9097152');
					if($result['status'] == 1){
						$data['cover_photo'] = $path.$result['msg'];
					}
					else{
						$this->session->set_flashdata('error', $result['msg']);
						redirect(base_url('gallery/addvideo'), 'refresh');
					}
				}
				$data = $this->security->xss_clean($data);
				$result = $this->gallery_model->add_gallery($data);
				if($result){
					$this->session->set_flashdata('success', 'gallery has been added successfully!');
					redirect(base_url('gallery/video'));
				}
			}
		}
		else{
			$data['title'] = 'Add photo gallery';
			$this->load->view('includes/_header', $data);
			$this->load->view('video_gallery/gallery_add');
			$this->load->view('includes/_footer');
		}
		
	}

	//-----------------------------------------------------------
	public function editvideo($id = 0){

		if($this->input->post('submit')){
			$this->form_validation->set_rules('album', 'Album', 'trim|required');
			$this->form_validation->set_rules('sort_order', 'Sort Order', 'trim|numeric|required');
			  
			$this->form_validation->set_rules('status', 'Status', 'trim|required');
			$this->form_validation->set_rules('slug', 'Seo URL', 'trim|required');
			
			if ($this->form_validation->run() == FALSE) {
				$galleryData = $this->gallery_model->get_gallery_by_id($id);
				$data = array(
					'errors' => validation_errors()
				); 
				$data['gallery'] = array(
					'id' => $id, 
					'album' => $this->input->post('album'),
					'slug' => $this->input->post('slug'),
					'description' => $this->input->post('description'),
					'cover_photo' => $galleryData['cover_photo'], 
					'sort_order' => $this->input->post('sort_order'),
					'is_active' => $this->input->post('status')
				);
				$this->session->set_flashdata('errors', $data['errors']);
				$this->load->view('includes/_header');
				$this->load->view('video_gallery/gallery_edit', $data);
				$this->load->view('includes/_footer');
			}
			else{
				$data = array(
					'album' => $this->input->post('album'),  
					'slug' => $this->input->post('slug'),
					'description' => $this->input->post('description'),
					'sort_order' => $this->input->post('sort_order'),
					'is_active' => $this->input->post('status'),
					'updated_by' => $this->session->userdata('admin_id'),
					'updated_at' => date('Y-m-d : h:m:s'),
				); 
				$old_cover_photo = $this->input->post('old_cover_photo');
				$path="assets/img/gallery/"; 
				if(!empty($_FILES['cover_photo']['name']))
				{
					if(!empty($old_cover_photo)){
						$this->functions->delete_file($old_cover_photo);
					}
					$result = $this->functions->file_insert($path, 'cover_photo', 'image', '9097152');
					if($result['status'] == 1){
						$data['cover_photo'] = $path.$result['msg'];
					}
					else{
						$this->session->set_flashdata('error', $result['msg']);
						redirect(base_url('gallery/editvideo/'.$id), 'refresh');
					}
				}
				$data = $this->security->xss_clean($data);
				$result = $this->gallery_model->edit_gallery($data, $id);
				if($result){
					$this->session->set_flashdata('success', 'Video Album has been updated successfully!');
					redirect(base_url('gallery/video'));
				}
			}
		}
		else{
			$data['title'] = 'Edit photo gallery';
			$data['gallery'] = $this->gallery_model->get_gallery_by_id($id);
			
			$this->load->view('includes/_header', $data);
			$this->load->view('video_gallery/gallery_edit', $data);
			$this->load->view('includes/_footer');
		}
	}

	//-----------------------------------------------------------
	public function deletevideo($id = 0)
	{		
		$galleryData = $this->gallery_model->get_gallery_by_id($id);
		$this->functions->delete_file($galleryData['cover_photo']);
		$this->db->delete('ci_gallery', array('id' => $id,'type'=>'2'));
		$galleryDetails = $this->gallery_model->get_gallerydetail_by_id($id);
		foreach ($galleryDetails as $key => $value) {
			if(!empty($value)){
				$this->functions->delete_file($value['value']);
			}
		}
		$this->db->delete('ci_gallery_details', array('gallery_id' => $id));
		$this->session->set_flashdata('success', 'Video Album has been deleted successfully!');
		redirect(base_url('gallery/video'));
	}
 
 	//-----------------------------------------------------------
	public function updatephoto($id = 0){

		if($this->input->post('submit')){  
				$filedold = @$_POST['old_image'];
				$filedfile=@$_FILES['image'];
				$oldfile = [];
				$data = array(
					'gallery_id' => $this->input->post('gallery_id'), 
					'img_order' => $this->input->post('img_order'),
					'created_at' => date('Y-m-d : h:m:s'),
					'created_by' => $this->session->userdata('admin_id') 
				);  
				if(!empty($filedold)){
					foreach ($filedold as $key => $value) {
						$oldfile[$key]= $value;
					}  
				}
				$path="assets/img/gallery/";
				$image = []; 
				if(!empty($filedfile)){
					foreach ($filedfile['name'] as $key => $value) { 
						if(!empty($value['image']))
						{   
							$size =  '9097152';
							$filename = $filedfile['name'][$key]['image'];
							$filetempname = $filedfile['tmp_name'][$key]['image'];
							$file_extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
							$filesize = $filedfile['size'][$key]['image'];  
							$result = $this->functions->file_insert_bulk($path, $filename, $filetempname, $file_extension, $filesize, $size); 
							if($result['status'] == 1){
								$logo = $path.$result['msg'];
								$image[$key] = $logo; 
							}
							else{
								$this->session->set_flashdata('error', $result['msg']);
								redirect(base_url('gallery/updatephoto/'.$id), 'refresh');
							} 	
						}
					}  
				}
				foreach ($oldfile as $key => $value) {
					if(isset($image[$key])){ 
						$this->functions->delete_file($value['value']); 
					}else{
						$image[$key] = $value['value']; 
					}
				} 
				$data = $this->security->xss_clean($data);
				$result = $this->gallery_model->update_photogallery($data, $image, $id);
				if($result){
					$this->session->set_flashdata('success', 'Photos has been updated successfully!');
					redirect(base_url('gallery/updatephoto/'.$id));
				} 

		}else{
			$data['gallery'] = $this->gallery_model->get_gallery_by_id($id); 
			$data['title'] = 'Update Photos'; 
			$data['id'] = $id;
			$data['proimage'] = $this->gallery_model->get_gallerydetail_by_id($id); 

			$this->load->view('includes/_header', $data);
			$this->load->view('photo_gallery/updatephoto', $data);
			$this->load->view('includes/_footer');
		}
	} 

	//-----------------------------------------------------------
	public function updatevideo($id = 0){

		if($this->input->post('submit')){   
				$oldfile = [];
				$data = array(
					'gallery_id' => $this->input->post('gallery_id'), 
					'video_url' => $this->input->post('video_url'),
					'img_order' => $this->input->post('img_order'),
					'created_at' => date('Y-m-d : h:m:s'),
					'created_by' => $this->session->userdata('admin_id') 
				);  
				 
				$data = $this->security->xss_clean($data);
				$result = $this->gallery_model->update_videogallery($data, $id);
				if($result){
					$this->session->set_flashdata('success', 'Video has been updated successfully!');
					redirect(base_url('gallery/updatevideo/'.$id));
				} 

		}else{
			$data['gallery'] = $this->gallery_model->get_gallery_by_id($id); 
			$data['title'] = 'Update Video'; 
			$data['id'] = $id;
			$data['proimage'] = $this->gallery_model->get_gallerydetail_by_id($id); 

			$this->load->view('includes/_header', $data);
			$this->load->view('video_gallery/updatevideo', $data);
			$this->load->view('includes/_footer');
		}
	} 
	 
}

?>