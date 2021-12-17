<?php 
 ini_set('display_errors', 1); ini_set('log_errors', 1); error_reporting(E_ALL);
// API auth credentials 
define("ApiUser", "aytadmin");
define("ApiPass", "12345");
// API key 
define("APIKEY", "AYTWEB@12345");
// Site Path
define("SITE_URL", "http://localhost/swastic_business/admin/api/");
define("ADMIN_PATH", "http://localhost/swastic_business/admin/"); 
define("BASE_PATH", "http://localhost/swastic_business/");
define("DOC_PATH", __DIR__."/admin/");


function getData($url,$id = NULL)
{   
	// API URL
	if(empty($id)){
		$url = SITE_URL.$url; 
	}else{
		$url = SITE_URL.$url.'/'.$id; 
	}  

	// Create a new cURL resource
	$ch = curl_init($url);
	$apiUser  = ApiUser;
	$apiPass = ApiPass;
	curl_setopt($ch, CURLOPT_TIMEOUT, 30);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
	curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array("X-API-KEY: " . APIKEY));
	curl_setopt($ch, CURLOPT_USERPWD, "$apiUser:$apiPass");

	$result = curl_exec($ch);
/*echo "<pre>";print_r($result);die; 
*/	// Close cURL resource
	curl_close($ch);
	$mydata=json_decode($result, true); 
    return $mydata;
}
	

function postData($url, $data)
{
	// User account login
/*	print_r($data); die; 
*/	$apiData = $data;
	// API URL
	$url = SITE_URL.$url; 

	// Create a new cURL resource
	$ch = curl_init($url);
	$apiUser  = ApiUser;
	$apiPass = ApiPass;
	curl_setopt($ch, CURLOPT_TIMEOUT, 30);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
	curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array("X-API-KEY: " . APIKEY));
	curl_setopt($ch, CURLOPT_USERPWD, "$apiUser:$apiPass");
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $apiData);
/*	curl_setopt($ch, CURLOPT_URL,$url);
*/


	$result = curl_exec($ch); 
/*echo "<pre>";print_r($result);die; 
*///////////// Close cURL resource
	curl_close($ch);
	$mydata=json_decode($result, true); 
    return $mydata;
}


function putData($url, $data)
{
	// User account login info
	$apiData = $data;
	// API URL
	$url = SITE_URL.$url; 

	// Create a new cURL resource 
	$ch = curl_init($url);
	$apiUser  = ApiUser;
	$apiPass = ApiPass;
	curl_setopt($ch, CURLOPT_TIMEOUT, 30);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
	curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-API-KEY: '.APIKEY, 'Content-Type: application/x-www-form-urlencoded'));
	curl_setopt($ch, CURLOPT_USERPWD, "$apiUser:$apiPass");
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
	curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($apiData));

	$result = curl_exec($ch);
	// Close cURL resource
	curl_close($ch);
	$mydata=json_decode($result, true); 
    return $mydata;

}

function redirect($url){
	header("Location: ".BASE_PATH.$url."");
	die();
}
 
/*Othere Bacis functions for site*/
function getimage($image,$defaultImg=NULL){
	$defaultImgPath = 'assets/img/'; 
	if(isset($image) && !empty($image) && file_exists(DOC_PATH.$image)){
        $img = ADMIN_PATH.$image;
    }elseif(isset($defaultImg) && !empty($defaultImg) && file_exists(DOC_PATH.$defaultImgPath.$defaultImg)){
        $img = ADMIN_PATH.$defaultImgPath.$defaultImg;
    }else{
        $img = ADMIN_PATH.'assets/img/profileicon.png';
    }
    return $img;
}

function checkdata($data){
  
	$response = 1;

	if(empty($data))
	{
		$response = 0;
	}
	elseif(!isset($data['status']) || !$data['status'])
	{
		$response = 0;
	}
	elseif(!isset($data['data']) || empty($data['data']))
	{
		$response = 0;
	}

	return $response;	

}




?>