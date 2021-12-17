<?php
class Mailer 
{
	function __construct()
	{
		$this->CI =& get_instance(); 
	}

	//=============================================================
	function registration_email($username, $email_verification_link)
	{
    $login_link = base_url('login');  

		$tpl = '<table class="table" style="width:100%;border-collapse: collapse;border: solid 1px #999; ">
                <tr><th style="background-color:'.$this->CI->general_settings['mail_bgcolor'].'" ><img src="'.base_url($this->CI->general_settings['logo']).'" style="float: left;
line-height: .8; max-height: 34px; width: auto; margin-left: .8rem; margin-right: .5rem; margin-top: -3px;"> &nbsp;<h3 style="margin: 5px; float:left;">' .$this->CI->general_settings['application_name'].'</h3></th></tr>
                <tr><td>&nbsp;</td></tr>
                <tr><td style="font-size: 15px; padding:1px 10px;">  <h3>Hi ' .strtoupper($username).'</h3>
                <p>Welcome to AYT!</p>
                <p>Active your account with the link above and start your Career :</p>  
                <p>'.$email_verification_link.'</p>
                </td></tr>
                <tr><td>&nbsp;</td></tr>
                <tr><td><span style="font-size:12px; text-align:left; padding:1px 10px;">' .$this->CI->general_settings['copyright'].'</span></td></tr> 
                </table>
        ';
		return $tpl;		
	}

	//=============================================================
	function pwd_reset_email($username, $reset_link)
	{
		$tpl = '<table class="table" style="width:100%;border-collapse: collapse;border: solid 1px #999; ">
                <tr><th style="background-color:'.$this->CI->general_settings['mail_bgcolor'].'" ><img src="'.base_url($this->CI->general_settings['logo']).'" style="float: left;
line-height: .8; max-height: 34px; width: auto; margin-left: .8rem; margin-right: .5rem; margin-top: -3px;"> &nbsp;<h3 style="margin: 5px; float:left;">' .$this->CI->general_settings['application_name'].'</h3></th></tr>
                <tr><td>&nbsp;</td></tr>
                <tr><td style="font-size: 15px; padding:1px 10px;">  <h3>Hi ' .strtoupper($username).'</h3>
                <p>Welcome to AYT!</p>
                <p>We have received a request to reset your password. If you did not initiate this request, you can simply ignore this message and no action will be taken.</p> 
                <p>To reset your password, please click the link below:</p> 
                <p>'.$reset_link.'</p>
                </td></tr>
                <tr><td>&nbsp;</td></tr>
                <tr><td><span style="font-size:12px; text-align:left; padding:1px 10px;">' .$this->CI->general_settings['copyright'].'</span></td></tr> 
            </table>
        ';
		return $tpl;		
	}

function global_template($msg)
    {
    $login_link = base_url('login');  

        $tpl = '<table class="table" style="width:100%;border-collapse: collapse;border: solid 1px #999; ">
                <tr><th style="background-color:'.$this->CI->general_settings['mail_bgcolor'].'" ><img src="'.base_url($this->CI->general_settings['logo']).'" style="float: left;
line-height: .8; max-height: 34px; width: auto; margin-left: .8rem; margin-right: .5rem; margin-top: -3px;"> &nbsp;<h3 style="margin: 5px; float:left;">' .$this->CI->general_settings['application_name'].'</h3></th></tr>
                <tr><td>&nbsp;</td></tr>
                <tr><td style="font-size: 15px; padding:1px 10px;"> <p>'.$msg.'</p> </td></tr>
                <tr><td>&nbsp;</td></tr>
                <tr><td><span style="font-size:12px; text-align:left; padding:1px 10px;">' .$this->CI->general_settings['copyright'].'</span></td></tr> 
            </table>
        ';
        return $tpl;        
    }

	

}
?>