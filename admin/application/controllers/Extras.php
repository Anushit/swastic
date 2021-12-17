<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Extras extends MY_Controller {

	
	public function __construct(){

		parent::__construct();
		auth_check(); // check login auth
	}

	//---------------------------------------------------------------
	public function error404(){

		$data['title'] = '';

		$this->load->view('includes/_header');
		$this->load->view('pages/404', $data);
		$this->load->view('includes/_footer');
	}

	//---------------------------------------------------------------
	public function errro500(){

		$data['title'] = '';

		$this->load->view('includes/_header');
		$this->load->view('pages/500', $data);
		$this->load->view('includes/_footer');
	}

	//---------------------------------------------------------------
	public function blank(){

		$data['title'] = '';

		$this->load->view('includes/_header');
		$this->load->view('pages/blank', $data);
		$this->load->view('includes/_footer');
	}

	//---------------------------------------------------------------
	public function starter(){

		$data['title'] = '';

		$this->load->view('includes/_header');
		$this->load->view('pages/starter', $data);
		$this->load->view('includes/_footer');
	}

}

?>
