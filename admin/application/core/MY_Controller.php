<?php

	class MY_Controller extends CI_Controller
	{

		function __construct()
		{
			parent::__construct();
			$this->load->model('admin/setting_model', 'setting_model');  
			//general settings
	        $global_data = [];
	        $general_settings_data = $this->setting_model->get_general_settings();
	        foreach ($general_settings_data as $skey => $svalue) {
	           $global_data['general_settings'][$svalue['setting_name']]= $svalue['filed_value'];
	        } 
	        $this->general_settings = $global_data['general_settings']; 

	        //modules settings
	        $global_premission = [];
	        $premission_data = $this->setting_model->get_permission_settings(); 
	        foreach ($premission_data as $skey => $svalue) {
	           $global_premission['premission'][$svalue['name']]['is_allow'] = $svalue['is_allow'];
	           $global_premission['premission'][$svalue['name']]['is_add'] = $svalue['is_add'];
	           $global_premission['premission'][$svalue['name']]['is_edit'] = $svalue['is_edit'];
	           $global_premission['premission'][$svalue['name']]['is_delete'] = $svalue['is_delete'];
	           $global_premission['premission'][$svalue['name']]['is_view'] = $svalue['is_view'];
	        } 
	        $this->general_premissions = $global_premission['premission']; 
	        if($this->session->userdata('admin_id') >1){
		        $global_user_premission = [];
		        $user_premission_data = $this->setting_model->getgenraluser_permission_settings(); 
		        foreach ($user_premission_data as $skey => $svalue) {
		           $global_user_premission['premission'][$svalue['name']]['is_allow'] = $svalue['is_allow'];
		           $global_user_premission['premission'][$svalue['name']]['is_add'] = $svalue['is_add'];
		           $global_user_premission['premission'][$svalue['name']]['is_edit'] = $svalue['is_edit'];
		           $global_user_premission['premission'][$svalue['name']]['is_delete'] = $svalue['is_delete'];
		           $global_user_premission['premission'][$svalue['name']]['is_view'] = $svalue['is_view'];
		        } 
		        $this->general_user_premissions = $global_user_premission['premission']; 
	        }else{
	        	$this->general_user_premissions = $global_premission['premission'];         
	        }

  	        //set timezone
	        date_default_timezone_set($this->general_settings['timezone']);
	        //recaptcha status
	        $global_data['recaptcha_status'] = true;
	        if (empty($this->general_settings['recaptcha_site_key']) || empty($this->general_settings['recaptcha_secret_key'])) {
	            $global_data['recaptcha_status'] = false;
	        }
	        $this->recaptcha_status = $global_data['recaptcha_status'];
		}

		//verify recaptcha
	    public function recaptcha_verify_request()
	    {
	        if (!$this->recaptcha_status) {
	            return true;
	        }
	        $this->load->library('recaptcha');
	        $recaptcha = $this->input->post('g-recaptcha-response');
	        if (!empty($recaptcha)) {
	            $response = $this->recaptcha->verifyResponse($recaptcha);
	            if (isset($response['success']) && $response['success'] === true) {
	                return true;
	            }
	        }
	        return false;
	    }

	}



?>



    