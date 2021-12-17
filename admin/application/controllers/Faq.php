<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Faq extends MY_Controller {

	public function __construct(){

		parent::__construct(); 
		auth_check(); // check login auth 
		check_premissions($this->router->fetch_class(), $this->router->fetch_method());
		check_user_premissions($this->session->userdata('admin_id'), $this->router->fetch_class(), $this->router->fetch_method());
		$this->load->model('Faq_model', 'Faq_model');
		$this->load->library('datatable'); // loaded my custom serverside datatable library
	}

	public function index(){
		$data['title'] = 'FAQ List';

		$this->load->view('includes/_header', $data);
		$this->load->view('faq/faq_list');
		$this->load->view('includes/_footer');
	}
	
	public function datatable_json(){				   					   
		$records = $this->Faq_model->get_all_faq();
		$data = array();

		$i=0;
		foreach ($records['data']  as $row) 
		{  
			$status = ($row['is_active'] == 1)? 'checked': '';
			$data[]= array(
				++$i,
				$row['faq_name'],
				$row['question'],
				$row['answer'],
				date_time($row['created_at']),	
				'<input class="tgl_checkbox tgl-ios" 
				data-id="'.$row['id'].'" 
				id="cb_'.$row['id'].'"
				type="checkbox" '.$status.'><label for="cb_'.$row['id'].'"></label>',		

				'<a title="Edit" class="update btn btn-sm btn-warning" href="'.base_url('Faq/edit/'.$row['id']).'"> <i class="fa fa-pencil-square-o"></i></a>
				<a title="Delete" class="delete btn btn-sm btn-danger" href='.base_url("Faq/delete/".$row['id']).' title="Delete" onclick="return confirm(\'Do you want to delete ?\')"> <i class="fa fa-trash-o"></i></a>'
				 
			);
		}
		$records['data']=$data;
		echo json_encode($records);						   
	}

	//-----------------------------------------------------------
	public function change_status(){   

		$this->faq_model->change_status();
	}

	//-----------------------------------------------------------
	public function add(){
		$data['Faqtype'] = $this->Faq_model->get_Allfaqtype();
			
		if($this->input->post('submit')){
			$this->form_validation->set_rules('faqtype', 'FAQ Type', 'trim|required');
			$this->form_validation->set_rules('answer', 'Answer ', 'trim|required');
			$this->form_validation->set_rules('faq_question', 'Question', 'trim|required');
			$this->form_validation->set_rules('status', 'Status', 'trim|required');

			if ($this->form_validation->run() == FALSE) {
				$data = array(
					'errors' => validation_errors()
				);
				$data['faq'] = array(
					'faq_type_id' => $this->input->post('faqtype'),
					'answer' => $this->input->post('answer'),
					'question' => $this->input->post('faq_question'),
					'sort_order' => $this->input->post('sort_order'),
					'is_active' => $this->input->post('status') 
				); 
				$data['Faqtype'] = $this->Faq_model->get_Allfaqtype();
				$this->session->set_flashdata('errors', $data['errors']);
				$this->load->view('includes/_header');
				$this->load->view('faq/faq_add', $data);
				$this->load->view('includes/_footer');
			}
			else{
				$data = array(
					'faq_type_id' => $this->input->post('faqtype'),
					'answer' => $this->input->post('answer'),
					'question' => $this->input->post('faq_question'),
					'created_by' => $this->session->userdata('admin_id'),
					'updated_by' => $this->session->userdata('admin_id'),
					'sort_order' => $this->input->post('sort_order'),
					'is_active' => $this->input->post('status'),
					'created_at' => date('Y-m-d,H:m:s'),
					'updated_at' => date('Y-m-d,H:m:s'),
				);
				$data = $this->security->xss_clean($data);
				$result = $this->Faq_model->add_faq($data);
				if($result){
					$this->session->set_flashdata('success', 'FAQ has been added successfully!');
					redirect(base_url('faq'));
				}
			}
		}else{ 
			$data['title'] = 'Add FAQ'; 
			$this->load->view('includes/_header', $data);
			$this->load->view('faq/faq_add',$data);
			$this->load->view('includes/_footer');
		}
		
	}

	//-----------------------------------------------------------
	public function edit($id = 0){
		$data['Faqtype'] = $this->Faq_model->get_Allfaqtype();
		if($this->input->post('submit')){ 
			$this->form_validation->set_rules('faqtype', 'FAQ Type', 'trim|required');
			$this->form_validation->set_rules('answer', 'Answer ', 'trim|required');
			$this->form_validation->set_rules('faq_question', 'Question ', 'trim|required');
			$this->form_validation->set_rules('status', 'Status', 'trim|required');

			if ($this->form_validation->run() == FALSE) {
				///$data['faq'] = $this->faq_model->get_faq_by_id($id);
				$data = array(
					'errors' => validation_errors()
				);
				$data['faq'] = array(
					'id' => $id,
					'faq_type_id' => $this->input->post('faqtype'),
					'answer' => $this->input->post('answer'),
					'question' => $this->input->post('faq_question'),
					'sort_order' => $this->input->post('sort_order'),
					'is_active' => $this->input->post('status') 
				); 
				$data['Faqtype'] = $this->Faq_model->get_Allfaqtype();
				$this->session->set_flashdata('errors', $data['errors']);
				$this->load->view('includes/_header');
				$this->load->view('faq/faq_edit', $data);
				$this->load->view('includes/_footer');
			}
			else{
				$data = array(
									
					'faq_type_id' => $this->input->post('faqtype'),
					'answer' => $this->input->post('answer'),
					'question' => $this->input->post('faq_question'),
					'created_by' => $this->session->userdata('admin_id'),
					'updated_by' => $this->session->userdata('admin_id'),
					'sort_order' => $this->input->post('sort_order'),
					'is_active' => $this->input->post('status'),				
					'updated_at' =>  date('Y-m-d,H:m:s'),
				);
				$data = $this->security->xss_clean($data);
				$result = $this->Faq_model->edit_faq($data, $id);
				if($result){
					$this->session->set_flashdata('success', 'FAQ has been updated successfully!');
					redirect(base_url('Faq'));
				}
			}
		}
		else{
			$data['title'] = 'Edit FAQ';
			$data['faq'] = $this->Faq_model->get_faq_by_id($id);
						
			$this->load->view('includes/_header', $data);
			$this->load->view('faq/faq_edit', $data);
			$this->load->view('includes/_footer');
		}
	}

	//-----------------------------------------------------------
	public function delete($id = 0)
	{		
		$this->db->delete('ci_faq', array('id' => $id));
		$this->session->set_flashdata('success', 'FAQ has been deleted successfully!');
		redirect(base_url('faq'));
	}  


}

?>