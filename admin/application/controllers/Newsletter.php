<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Newsletter extends MY_Controller {

	public function __construct(){

		parent::__construct();
		auth_check(); // check login auth
		check_premissions($this->router->fetch_class(), $this->router->fetch_method());
		check_user_premissions($this->session->userdata('admin_id'), $this->router->fetch_class(), $this->router->fetch_method());
		$this->load->model('Newsletter_model', 'newsletter_model');
			$this->load->model('message_model', 'message_model');
		$this->load->library('datatable'); // loaded my custom serverside datatable library
		$this->load->library('mailer');
	}

	public function index(){

		$data['title'] = 'Newsletter List';
		$this->load->view('includes/_header', $data);
		$this->load->view('newsletter/newsletter_list');
		$this->load->view('includes/_footer');
	}
	public function view_mail(){

		$data['title'] = 'Newsletter Mail List';
		$this->load->view('includes/_header', $data);
		$this->load->view('newsletter/view_mail');
		$this->load->view('includes/_footer');
	}
	
	
	public function datatable_json(){				   					   
		$records = $this->newsletter_model->get_all_newsletter();
		$data = array();

		$i=0;
		foreach ($records['data']  as $row) 
		{  
			$status = ($row['status'] == 1)? 'Active': 'Deactiv';
			$data[]= array(
				++$i,
				$row['email'],
				date_time($row['created_at']),	
				'<span class="badge badge-success">'.$status.'</span>',		

				'<a title="Delete" class="delete btn btn-sm btn-danger" href='.base_url("newsletter/delete/".$row['id']).' title="Delete" onclick="return confirm(\'Do you want to delete ?\')"> <i class="fa fa-trash-o"></i></a>'
			);
		}
		$records['data']=$data;
		echo json_encode($records);						   
	}

	public function datatable_json_viewmail(){				   					   
		$records = $this->newsletter_model->get_mail_list();
		$data = array();

		$i=0;
		foreach ($records['data']  as $row) 
		{  
			$countmail = $this->db->where('message_id',$row['id'])->count_all_results('ci_message_member');
			if(!empty($row['attachment'])){
				$attachment = '<a href="'.base_url().$row['attachment'].'" download><i class="fa fa-download "></i></a>';
			}else{
				$attachment = 'no attachment ';
			}
			$data[]= array(
				++$i,
				$row['subject'],
				$row['message'],
				$attachment,
				$row['name'],
				date_time($row['created_at']),
				'<button title="Member List"class=" btn btn-outline-info" id="'.$row["id"].'"  onclick = "member(this.id)" data-toggle="modal" data-target="#myModal">'.$countmail.'</button>'
				
			);
		}
		$records['data']=$data;
		echo json_encode($records);						   
	}


	public function delete($id = 0)
	{
		$data = array('deleted'=>1,'deleted_at'=>date('Y-m-d,H:s:i'));
		$this->db->where(array('id' => $id));
		$this->db->update('ci_newsletter', $data);
		$this->session->set_flashdata('success', 'Newsletter has been deleted successfully!');
		redirect(base_url('Newsletter'));
	}

	public function send_mail(){

		if($this->input->post('submit')){

			$this->form_validation->set_rules('users', 'User', 'trim|required');
			$this->form_validation->set_rules('subject', 'Subject', 'trim|required');
			$this->form_validation->set_rules('message', 'Message', 'trim|required');

			if ($this->form_validation->run() == FALSE) {
				$error = array(
					'errors' => validation_errors()
				);
				$data['errors'] = array( 
					'subject' => $this->input->post('subject'),
					'email' => $this->input->post('users'),
					'message' => $this->input->post('message'),
				);
				$this->session->set_flashdata('errors', $error['errors']);
				
				$this->load->view('includes/_header', $data);
				$this->load->view('newsletter/send_mail');
				$this->load->view('includes/_footer');
			}
			else{
				$attachment= "";
				$path="assets/img/mail_doc/"; 				
				if(!empty($_FILES['attachment']['name']))
				{
					$type = "image";
					if ($_FILES['attachment']['type'] == 'application/pdf') {
						$type = "pdf";
					}

					$result = $this->functions->file_insert($path, 'attachment', $type, '9097152');
					if($result['status'] == 1){
						$attachment= $path.$result['msg'];
					}
					else{
						$this->session->set_flashdata('error', $result['msg']);
						redirect(base_url('newsletter/send_mail'), 'refresh');
					}
				}
				
				$data = array(
					'subject' => $this->input->post('subject'),
					'message' => $this->input->post('message'),
					'attachment' => $attachment,
					'type' => 1,
					'mode' => 2,
					'created_by' => $this->session->userdata('admin_id'),
					'created_at' => date('Y-m-d,h:m:s'),
					'updated_at' => date('Y-m-d,h:m:s'),
				);
				
				$data = $this->security->xss_clean($data);
				$result = $this->newsletter_model->add_newsletter_mail($data);

					if($result){
						if($this->input->post('users')==1){
							$records = $this->newsletter_model->get_newsletter_list();
						}else{
							$resultdata = $this->input->post('selectedemail'); 
							for ($i=0; $i <count($resultdata) ; $i++) { 
								$records[] = $this->newsletter_model->get_newsletter_list_byid($resultdata[$i]);
							}
							
						}
						//print_r($records); exit;
							if($records){
								$this->load->helper('email_helper');										
								foreach ($records as $value) {					
									$data = array(
									'message_id' =>$result ,
									'reciver' => $value['email'],
									'created_at' => date('Y-m-d,h:m:s'),
									);
								$insert = $this->newsletter_model->add_newsletter_member($data);

								$to = $value['email'];
								$subject = $this->input->post('subject');
								$msg = $this->input->post('message');
								$body = $this->mailer->global_template($msg);
								$message = $body;

								$senddata = send_email($to, $subject, $message, $attachment , $cc = '');
								
								}
								if($senddata){
									$this->session->set_flashdata('success', 'Mail has been Send successfully!');
									redirect(base_url('newsletter'));
								}else{
									$this->session->set_flashdata('error', 'Uanable To send mail somthing Want to wrong');
							  		redirect(base_url('newsletter/send_mail'), 'refresh');
								}

							}

						

					$this->session->set_flashdata('success', 'Newsletter mail has been send successfully!');
					redirect(base_url('newsletter'));
				}
			}
		}
		else{

			$data['title'] = 'Newsletter Mail Send';

			$this->load->view('includes/_header', $data);
			$this->load->view('newsletter/send_mail');
			$this->load->view('includes/_footer');
		}
		
	}

	public function get_allnewletter()
	{
		$id = $this->input->post('id'); 
		$data = "";
		if($id==2){

		$records = $this->newsletter_model->get_newsletter_list();


		foreach ($records as  $value) {
			$data.=  '<div class="col-md-4"><input type="checkbox" name="selectedemail[]" id="vehicle1" name="vehicle1" value="'.$value["id"].'">&nbsp' .$value["email"].'</div>';
		}
		
		 $res = array('status' => true, 'data' => $data );
			 echo json_encode($res); exit;
		}else{
		$res = array('status' => false, 'data' => '' );
			 echo json_encode($res); exit;
		}
		
	}

	public function getmemberid(){

		$id = $this->input->post('id'); 
		$data = "";
		$records = $this->message_model->get_member_list_by_msgId($id);
		$sub = $this->message_model->get_maildataby_Id($id);
		foreach ($records as  $value) {
			$data.=  '<div class="col-md-12"><i class="fa fa-envelope"></i>&nbsp' .$value["reciver"].'</div>';
		}
		
		 $res = array('status' => true, 'data' => $data ,'sub' =>$sub['subject']);
			 echo json_encode($res); exit;
	}
	

}

	?>
