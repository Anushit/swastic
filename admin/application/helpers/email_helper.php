<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function send_email($to = '', $subject  = '', $body = '', $attachment = '', $cc = '')

    {
	

    	$Emailsettings = get_general_settings();
    	$settings = [];
        foreach ($Emailsettings as $key => $value) {
           $settings[$value['setting_name']]= $value['filed_value'];
        } 
		$controller =& get_instance();

       	$controller->load->helper('path'); 
       	// Configure email library
		$config = array();

        // $config['useragent']            = "CodeIgniter";

        // $config['mailpath']             = "/usr/bin/sendmail"; // or "/usr/sbin/sendmail"

        $config['protocol']             = "smtp";

        $config['smtp_host']            = $settings['smtp_host'];

        $config['smtp_port']            = $settings['smtp_port'];

		$config['smtp_timeout'] 		= '30';

		$config['smtp_user']    		= $settings['smtp_user'];

		$config['smtp_pass']    		= $settings['smtp_pass'];

        $config['mailtype'] 			= 'html';

        $config['charset']  			= 'utf-8';

        $config['newline']  			= "\r\n";

		 $config['crlf']  			= "\r\n";
		 $config['smtp_crypto']  			= "ssl";
	
        $config['wordwrap'] 			= TRUE;
/*        echo "<pre>"; print_r($config); die;
*/		// ------------
	// $mail_config['smtp_host'] = 'smtp.gmail.com';
	// $mail_config['smtp_port'] = '587';
	// $mail_config['smtp_user'] = 'narendra.adiyogi@gmail.com';
	// $mail_config['_smtp_auth'] = TRUE;
	// $mail_config['smtp_pass'] = 'vikram123@#';
	// $mail_config['smtp_crypto'] = 'tls';
	// $mail_config['protocol'] = 'smtp';
	// $mail_config['mailtype'] = 'html';
	// $mail_config['send_multipart'] = FALSE;
	// $mail_config['charset'] = 'utf-8';
	// $mail_config['wordwrap'] = TRUE;

        $controller->load->library('email');

        $controller->email->initialize($config);   

		$controller->email->from( $settings['email_from'] , $settings['application_name'] );
		$controller->email->to($to);
		$controller->email->subject($subject);
		$controller->email->message($body);
/*		 echo '<pre>'; print_r($config); die;
*/

		if($cc != '') 
		{	
			$controller->email->cc($cc);
		}	

		if($attachment != '')
		{

			$controller->email->attach(base_url()."your_file_path/" .$attachment);

		}

		if($controller->email->send()){

			/*echo "success";*/
		return "success";

		}
		else
		{
			/*return "error";
*/
			echo $controller->email->print_debugger();
		}
    }

?>