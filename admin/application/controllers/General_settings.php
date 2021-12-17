<?php defined('BASEPATH') OR exit('No direct script access allowed');

class General_settings extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		auth_check(); // check login auth
		check_premissions($this->router->fetch_class(), $this->router->fetch_method());
		check_user_premissions($this->session->userdata('admin_id'), $this->router->fetch_class(), $this->router->fetch_method());
		$this->load->model('setting_model', 'setting_model');
		$this->load->library('functions');
	}

	//-------------------------------------------------------------------------
	// General Setting View
	public function index()
	{
		$data['parent_setting'] = $this->setting_model->get_general_parent_settings();
		$general_settings_data = $this->setting_model->get_general_settings();
		foreach ($general_settings_data as $skey => $svalue) {
           $data['general_settings'][$svalue['setting_type']][]= $svalue;
        } 

		$data['title'] = 'General Setting';

		$this->load->view('includes/_header', $data);
		$this->load->view('general_settings/setting', $data);
		$this->load->view('includes/_footer');
	}

	//-------------------------------------------------------------------------
	public function add()
	{

		$filedold=$_POST['SettingOld']['filedval'];
		$filedval=$_POST['Setting']['filedval'];
		$filedfile=$_FILES; 
 
 		foreach ($filedval as $key => $value) {  
		 	$data['filed_value'] = $value;
		 	$this->db->where('id', $key);
			$this->db->update('ci_general_settings', $data);
		} 
		/// Manage Old file and New
		foreach ($filedold as $key => $value) {
			$oldfile[$key]= $value;
		}  
		 
		$path="assets/img/"; 
		$i=1;

		foreach ($filedfile as $key => $value) { 
			if(!empty($_FILES[$key]['name']))
			{  
				$akey = explode('_',$key);
				$pagId = array_pop($akey);
				if(!empty($oldfile[$i])){ 
					$this->functions->delete_file($oldfile[$i]);
				}
				$result = $this->functions->file_insert($path, $key, 'image', '9097152');
				if($result['status'] == 1){
					$logo = $path.$result['msg'];
					$data['filed_value'] = $logo;
					$this->db->where('id', $pagId);
					$this->db->update('ci_general_settings', $data);
				}
				else{
					$this->session->set_flashdata('error', $result['msg']);
					redirect(base_url('general_settings'), 'refresh');
				}
			$i++;	
			}
		} 
		$this->session->set_flashdata('success', 'Setting has been changed Successfully!');
		redirect(base_url('general_settings'), 'refresh');
		 
	}

}

?>	