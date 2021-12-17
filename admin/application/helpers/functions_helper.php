<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
    
    // -----------------------------------------------------------------------------
    //check auth
    if (!function_exists('auth_check')) {
        function auth_check()
        {
            // Get a reference to the controller object
            $ci =& get_instance();
            if(!$ci->session->has_userdata('is_admin_login'))
            {
                redirect('login', 'refresh');
            }
            
        }
    }
    
    if (!function_exists('check_premissions')) {
        function check_premissions($page, $mode)
        {   
            $curd = array('add','edit','delete','view'); 
            $ci =& get_instance();
            $ci->load->model('setting_model');
            $pageVal  = $ci->setting_model->get_permission_settings($page);

            if(isset($pageVal[0]['is_allow']) && $pageVal[0]['is_allow']==0)
            {
                $ci->session->set_flashdata('errors', "You don't have permission to access page.");
                redirect('error', 'refresh');
            }elseif(in_array($mode, $curd)){ 
                //print_r($pageVal);
                if($pageVal[0]['is_allow']==1 && $pageVal[0]['is_'.$mode]==0){
                   $ci->session->set_flashdata('errors', "You don't have permission to access page.");
                    redirect('error', 'refresh'); 
                } 
            }
        }
    }


 if (!function_exists('check_user_premissions')) {
        function check_user_premissions($admin_id, $page, $mode)
        {              
            $curd = array('add','edit','delete','view'); 
            $ci =& get_instance();
            $ci->load->model('setting_model');  
            $freepage = array('profile') ;        
            if($admin_id!=1 && !in_array($page, $freepage)){ 
                $pageVal  = $ci->setting_model->get_user_permission_settings($admin_id,$page);
                if(isset($pageVal[0]['is_allow']) && $pageVal[0]['is_allow']==0)
                {
                    $ci->session->set_flashdata('errors', "You don't have permission to access page.");
                    redirect('error', 'refresh');
                }elseif(in_array($mode, $curd)){  
                    if($pageVal[0]['is_allow']==1 && $pageVal[0]['is_'.$mode]==0){
                       $ci->session->set_flashdata('errors', "You don't have permission to access page.");
                        redirect('error', 'refresh'); 
                    } 
                }
            }
        }
    }

    // -----------------------------------------------------------------------------
    // Get General Setting
    if (!function_exists('get_general_settings')) {
        function get_general_settings($type=NULL)
        {
            $ci =& get_instance();
            $ci->load->model('setting_model');
            return $ci->setting_model->get_general_settings($type);
        }
    }

   

    // -----------------------------------------------------------------------------
    //get recaptcha
    if (!function_exists('generate_recaptcha')) {
        function generate_recaptcha()
        {
            $ci =& get_instance();
            if ($ci->recaptcha_status) {
                $ci->load->library('recaptcha');
                echo '<div class="form-group mt-2">';
                echo $ci->recaptcha->getWidget();
                echo $ci->recaptcha->getScriptTag();
                echo ' </div>';
            }
        }
    }

    // ----------------------------------------------------------------------------
    //print old form data
    if (!function_exists('old')) {
        function old($field)
        {
            $ci =& get_instance();
            return html_escape($ci->session->flashdata('form_data')[$field]);
        }
    }

    // --------------------------------------------------------------------------------
    if (!function_exists('date_time')) {
        function date_time($datetime) 
        {
           return date('F j, Y',strtotime($datetime));
        }
    }

    // --------------------------------------------------------------------------------
    // limit the no of characters
    if (!function_exists('text_limit')) {
        function text_limit($x, $length)
        {
          if(strlen($x)<=$length)
          {
            echo $x;
          }
          else
          {
            $y=substr($x,0,$length) . '...';
            echo $y;
          }
        }
    }

?>