<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends MY_Controller {
	
	public function __construct(){
		
		parent::__construct();
		auth_check(); // check login auth
		$this->load->model('profile_model', 'profile_model');
		check_user_premissions($this->session->userdata('admin_id'), $this->router->fetch_class(), $this->router->fetch_method());
	}

	//-------------------------------------------------------------------------
	public function index(){

		if($this->input->post('submit')){
			$data = array(
				'username' => $this->input->post('username'),
				'firstname' => $this->input->post('firstname'),
				'lastname' => $this->input->post('lastname'),
				'email' => $this->input->post('email'),
				'mobile_no' => $this->input->post('mobile_no'),
				'updated_at' => date('Y-m-d : h:m:s'),
			);
			$data = $this->security->xss_clean($data);
			$result = $this->profile_model->update_user($data);
			if($result){
				$this->session->set_flashdata('success', 'Profile has been Updated Successfully!');
				redirect(base_url('profile'), 'refresh');
			}
		}
		else{

			$data['title'] = 'Admin Profile';
			$data['admin'] = $this->profile_model->get_user_detail();
			
			$this->load->view('includes/_header');
			$this->load->view('profile/index', $data);
			$this->load->view('includes/_footer');
		}
	}

	//-------------------------------------------------------------------------
	public function change_pwd(){

		$id = $this->session->userdata('admin_id');

		if($this->input->post('submit')){

			$this->form_validation->set_rules('password', 'Password', 'trim|required');
			$this->form_validation->set_rules('oldpassword', 'Old Password', 'trim|required');
			$this->form_validation->set_rules('confirm_pwd', 'Confirm Password', 'trim|required|matches[password]');

			if ($this->form_validation->run() == FALSE) {
				$data = array(
					'errors' => validation_errors()
				);
				
				$this->session->set_flashdata('errors', $data['errors']);
				redirect(base_url('profile/change_pwd'),'refresh');
			}
			else{
				$admin = $this->profile_model->get_user_detail();
				$data = ""; 
				if (password_verify($this->input->post('oldpassword'), $admin['password'])) {
					$data = array(
						'password' => password_hash($this->input->post('password'), PASSWORD_BCRYPT)
					);
				}else {
						$this->session->set_flashdata('error', 'Old password is incorrect');
						redirect(base_url('profile/change_pwd'));
					}

				$data = $this->security->xss_clean($data);
				$result = $this->profile_model->change_pwd($data, $id);
				if($result){
					$this->session->set_flashdata('success', 'Password has been changed successfully!');
					redirect(base_url('profile/change_pwd'));
				}else {
						$this->session->set_flashdata('error', 'Someting is wrong ,unable to change password');
						redirect(base_url('profile/change_pwd'));
					}
			}
		}
		else{
			
			$data['title'] = 'Change Password';
			$data['user'] = $this->profile_model->get_user_detail();
			
			$this->load->view('includes/_header');
			$this->load->view('profile/change_pwd', $data);
			$this->load->view('includes/_footer');
		}
	}
}

?>	