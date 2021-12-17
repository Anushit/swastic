<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Mail extends MY_Controller {

	public function __construct(){

		parent::__construct();
		auth_check(); // check login auth
		check_premissions($this->router->fetch_class(), $this->router->fetch_method());
		check_user_premissions($this->session->userdata('admin_id'), $this->router->fetch_class(), $this->router->fetch_method());
		$this->load->model('message_model', 'message_model');
		$this->load->library('datatable'); // loaded my custom serverside datatable library
		$this->load->library('mailer');

	}

	public function index(){

		$data['title'] = 'Mail List';
		
		$this->load->view('includes/_header', $data);
		$this->load->view('mail/mail_list');
		$this->load->view('includes/_footer');
	}
	
	public function datatable_json(){				   					   
		$records = $this->message_model->get_mail_list();
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


	//-----------------------------------------------------------
	public function add()
	{ 
		if($this->input->post('submit')){
			$this->form_validation->set_rules('subject', 'subject', 'trim|required');
			$this->form_validation->set_rules('message', 'Message', 'trim|required');
			$this->form_validation->set_rules('allemailids', 'email', 'required');

			if ($this->form_validation->run() == FALSE) {
				$data = array(
					'errors' => validation_errors()
				);
				$data['user'] = array( 
					
					'subject' => $this->input->post('subject'),
					'message' => $this->input->post('message'),
					
				);
				$this->session->set_flashdata('errors', $data['errors']);
				$this->load->view('includes/_header');
				$this->load->view('mail/add_mail', $data);
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
						redirect(base_url('mail/add'), 'refresh');
					}
				}
				
				
				$data = array(
					'subject' => $this->input->post('subject'),
					'message' => $this->input->post('message'),
					'attachment' => $attachment,
					'type' => 1,
					'mode' => 1,
					'created_by' => $this->session->userdata('admin_id'),
					'created_at' => date('Y-m-d,h:m:s'),
					'updated_at' => date('Y-m-d,h:m:s'),
					
				);

				
				$data = $this->security->xss_clean($data);
				$result = $this->message_model->add_message($data);

				if($result){
					$emailarray = explode(" ", $this->input->post('allemailids'));
					$emailfilter = array_filter($emailarray); 
					$mail = implode(',', $emailfilter) ;
					$emails = explode(',', $mail) ;
					
					$this->load->helper('email_helper');
										
					for ($i=0; $i < count($emails); $i++) { 
						
							$data = array(
							'message_id' =>$result ,
							'reciver' => $emails[$i],
							'created_at' => date('Y-m-d,h:m:s'),
							);
						$insert = $this->message_model->add_message_member($data);

						$to = $emails[$i];
						$subject = $this->input->post('subject');
						$msg = $this->input->post('message');
						$body = $this->mailer->global_template($msg); 
						$message =  $body ;
						$senddata = send_email($to, $subject, $message, $attachment , $cc = '');
						
					}
					if($senddata){
						$this->session->set_flashdata('success', 'Mail has been Send successfully!');
						redirect(base_url('mail'));
					}else{
						$this->session->set_flashdata('error', 'Uanable To send mail somthing Want to wrong');
				  		redirect(base_url('mail/add'), 'refresh');
					}

				}else{
					$this->session->set_flashdata('error', 'Somthing Want to wrong ');
					  		redirect(base_url('mail/add'), 'refresh');
					}

			}
		}
		else{

			$data['title'] = 'Add Mail';

			$this->load->view('includes/_header', $data);
			$this->load->view('mail/add_mail');
			$this->load->view('includes/_footer');
		}
		
	}

	//-----------------------------------------------------------
	public function delete($id = 0)
	{
		$this->db->where(array('id' => $id));
		$this->db->update('ci_role_permission', $data);
		$this->db->delete('ci_role', array('id' => $id));
		$this->session->set_flashdata('success', 'Role has been deleted successfully!');
		redirect(base_url('role'));
	}
	//---------------------------------------------------------------

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

	public function create_inquiry_pdf(){
		$this->load->helper('pdf_helper'); // loaded pdf helper
		$data['all_inquirys'] = $this->inquiry_model->get_inquirys_for_export();		 
		$this->load->view('inquiry/inquiry_pdf', $data);
	}

	public function create_mail_pdf(){
		$this->load->helper('pdf_helper'); // loaded pdf helper
		$all_mails = $this->message_model->get_mail_for_export();
		$newRecord = [];
		foreach ($all_mails  as $key =>  $row) 
		{ 
			
			$newRecord[$key]['id'] = $row['id'];
			$newRecord[$key]['subject'] = $row['subject'];
			$newRecord[$key]['message'] = $row['message'];
			$newRecord[$key]['attachment'] = $row['attachment'];
			$newRecord[$key]['created_by'] = $row['created_by'];
			$newRecord[$key]['created_at'] = $row['created_at'];
		}
		$data['all_mails'] = $newRecord;
		
		$this->load->view('mail/mail_pdf', $data);
	}
	//---------------------------------------------------------------	
	// Export data in CSV format 
	public function export_csv(){ 

	   // file name 
		$filename = 'mails_'.date('Y-m-d').'.csv'; 
		header("Content-Description: File Transfer"); 
		header("Content-Disposition: attachment; filename=$filename"); 
		header("Content-Type: application/csv; ");

	   // get data 
		$all_mails = $this->message_model->get_mails_for_export();		 

	   // file creation 
		$file = fopen('php://output', 'w');

		$header = array("ID", "Mode", "Subject" ,"Message", "Type", "Created By", "Attachment", "Created Date"); 

		fputcsv($file, $header);
		foreach ($all_mails as $key=>$line){ 

			fputcsv($file,$line); 
		}
		fclose($file); 
		exit; 
	} 
	
}
	


	?>
