<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Sms extends MY_Controller {

	public function __construct(){

		parent::__construct();
		auth_check(); // check login auth
		check_premissions($this->router->fetch_class(), $this->router->fetch_method());
		check_user_premissions($this->session->userdata('admin_id'), $this->router->fetch_class(), $this->router->fetch_method());
		$this->load->model('message_model', 'message_model');
		$this->load->library('datatable'); // loaded my custom serverside datatable library
	}

	public function index(){

		$data['title'] = 'Sms List';
		
		$this->load->view('includes/_header', $data);
		$this->load->view('sms/sms_list');
		$this->load->view('includes/_footer');
	}
	
	public function datatable_json(){				   					   
		$records = $this->message_model->get_sms_list();
		$data = array();

		$i=0;
		foreach ($records['data']  as $row) 
		{  
			$countmember = $this->db->where('message_id',$row['id'])->count_all_results('ci_message_member');
			
			$data[]= array(
				++$i,
				$row['message'],
				$row['name'],
				date_time($row['created_at']),
				'<button title="Member List"class=" btn btn-outline-info" id="'.$row["id"].'"  onclick = "member(this.id)" data-toggle="modal" data-target="#myModal">'.$countmember.'</button>'
				
			);
		}
		$records['data']=$data;
		echo json_encode($records);						   
	}


	//-----------------------------------------------------------
	public function add(){
		if($this->input->post('submit')){
			$this->form_validation->set_rules('message', 'Message', 'trim|required');
			
			if ($this->form_validation->run() == FALSE) {
				$data = array(
					'errors' => validation_errors()
				);
				$data['user'] = array( 
					'message' => $this->input->post('message'),
					
				);
				$this->session->set_flashdata('errors', $data['errors']);
				$this->load->view('includes/_header');
				$this->load->view('sms/send_sms', $data);
				$this->load->view('includes/_footer');
			}
			else{
				
				$data = array(
					'message' => $this->input->post('message'),
					'type' => 2,
					'created_by' => $this->session->userdata('admin_id'),
					'created_at' => date('Y-m-d,h:m:s'),
					'updated_at' => date('Y-m-d,h:m:s'),
				);
				
				$data = $this->security->xss_clean($data);
				$result = $this->message_model->add_message($data);

					if($result){
						$mobilearray = explode(" ", $this->input->post('allemailids'));
						$mobilefilter = array_filter($mobilearray); 
						$number = implode(' ,', $mobilefilter) ;
						$mobiles = explode(',', $number) ;
																
						for ($i=0; $i < count($mobiles); $i++) { 
							
								$data = array(
								'message_id' =>$result ,
								'reciver' => $mobiles[$i],
								'created_at' => date('Y-m-d,h:m:s'),
								);
							$insert = $this->message_model->add_message_member($data);
							
						}
						$this->session->set_flashdata('success', 'SMS has been Send successfully!');
						redirect(base_url('sms'));
					}else{
						$this->session->set_flashdata('error', 'Uanable To send SMS somthing Want to wrong');
				  		redirect(base_url('sms/send_sms'), 'refresh');
					}

				}

			}

		else{

			$data['title'] = 'Send SMS';

			$this->load->view('includes/_header', $data);
			$this->load->view('sms/send_sms');
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
		//$sub = $this->message_model->get_maildataby_Id($id);
		foreach ($records as  $value) {
			$data.=  '<div class="col-md-12"><i class="fa fa-commenting"></i>&nbsp' .$value["reciver"].'</div>';
		}
		
		 $res = array('status' => true, 'data' => $data);
			 echo json_encode($res); exit;
	}
	
}
	


	?>
