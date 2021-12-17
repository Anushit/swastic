<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Subadmin extends MY_Controller {

	public function __construct(){

		parent::__construct();
		auth_check(); // check login auth
		check_premissions($this->router->fetch_class(), $this->router->fetch_method());
		check_user_premissions($this->session->userdata('admin_id'), $this->router->fetch_class(), $this->router->fetch_method());
		$this->load->model('subadmin_model', 'subadmin_model');
		$this->load->model('role_model', 'role_model');
		$this->load->library('datatable'); // loaded my custom serverside datatable library
	}

	public function index(){
		//echo $this->router->fetch_method(); exit;
		
		
		$data['title'] = 'User List';

		$this->load->view('includes/_header', $data);
		$this->load->view('subadmin/user_list');
		$this->load->view('includes/_footer');
	}
	
	public function datatable_json(){				   					   
		$records = $this->subadmin_model->get_all_subadmin();
		$data = array();

		$i=0;
		foreach ($records['data']  as $row) 
		{  
			$status = ($row['is_active'] == 1)? 'checked': '';
			$data[]= array(
				++$i,
				$row['username'],
				$row['email'],
				$row['mobile_no'],
				date_time($row['created_at']),	
				'<input class="tgl_checkbox tgl-ios" 
				data-id="'.$row['admin_id'].'" 
				id="cb_'.$row['admin_id'].'"
				type="checkbox"  
				'.$status.'><label for="cb_'.$row['admin_id'].'"></label>',		

				'<a title="Edit" class="update btn btn-sm btn-warning" href="'.base_url('subadmin/edit/'.$row['admin_id']).'"> <i class="fa fa-pencil-square-o"></i></a>
				<a title="Delete" class="delete btn btn-sm btn-danger" href='.base_url("subadmin/delete/".$row['admin_id']).' title="Delete" onclick="return confirm(\'Do you want to delete ?\')"> <i class="fa fa-trash-o"></i></a>
				<a title="Manage Permission" class="update btn btn-sm btn-warning" href="'.base_url('subadmin/manage_permission/'.$row['admin_id']).'"> <i class="fa fa-lock"></i></a>'
			);
		}
		$records['data']=$data;
		echo json_encode($records);						   
	}

	//-----------------------------------------------------------
	public function change_status(){   

		$this->subadmin_model->change_status();
	}

	//-----------------------------------------------------------
	public function add(){
		$data['role'] = $this->role_model->get_allrole_by_where(1);
			

		if($this->input->post('submit')){
			$this->form_validation->set_rules('username', 'Username', 'trim|required|is_unique[ci_admin.username]');
			$this->form_validation->set_rules('firstname', 'Firstname', 'trim|required');
			$this->form_validation->set_rules('lastname', 'Lastname', 'trim|required');
			$this->form_validation->set_rules('email', 'Email', 'trim|valid_email|required|is_unique[ci_admin.email]');
			$this->form_validation->set_rules('mobile_no', 'Number', 'trim|required');
			$this->form_validation->set_rules('password', 'Password', 'trim|required');
			$this->form_validation->set_rules('role', 'Role', 'trim|required');
			$this->form_validation->set_rules('conf_password', 'Confirm Password', 'trim|required|matches[password]');
			

			if ($this->form_validation->run() == FALSE) {
				$error = array(
					'errors' => validation_errors()
				);
				$data['user'] = array( 					
					'username' => $this->input->post('username'),
					'firstname' => $this->input->post('firstname'),
					'lastname' => $this->input->post('lastname'), 
					'email' => $this->input->post('email'),
					'mobile_no' => $this->input->post('mobile_no'),
					'password' =>  $this->input->post('password'),
					'is_active' => $this->input->post('status'),
				);
				$this->session->set_flashdata('errors', $error['errors']);
				$this->load->view('includes/_header');
				$this->load->view('subadmin/user_add', $data);
				$this->load->view('includes/_footer'); 
			}
			else{
				
				$data = array(
					'username' => $this->input->post('username'),
					'firstname' => $this->input->post('firstname'),
					'lastname' => $this->input->post('lastname'),
					'email' => $this->input->post('email'), 
					'mobile_no' => $this->input->post('mobile_no'),
					'admin_role_id' => $this->input->post('role'),
					'status'=> '1',
					'password' =>  password_hash($this->input->post('password'), PASSWORD_BCRYPT),
					'created_at' => date('Y-m-d,h:m:s'),
					'updated_at' => date('Y-m-d,h:m:s'),
				);
				$data = $this->security->xss_clean($data);
				$result = $this->subadmin_model->add_user($data);
				if($result){

					$role_perm = $this->role_model->get_allrole_permission(array('role_id'=>$this->input->post('role')));
					$i = 0;
					foreach ($role_perm as $value) {
						$insertData = array('admin_id'=>$result,'module_id'=>$value['module_id'],'is_allow'=>$value['is_allow'],'is_add'=>$value['is_add'],'is_view'=>$value['is_view'],'is_edit'=>$value['is_edit'],'is_delete'=>$value['is_delete']);
						$this->role_model->insert_adminrol_permission($insertData);
						$i++;
					}

					$this->session->set_flashdata('success', 'User has been added successfully!');
					redirect(base_url('subadmin'));
				}
			}
		}
		else{
			$data['title'] = 'Add User';

			$this->load->view('includes/_header', $data);
			$this->load->view('subadmin/user_add',$data);
			$this->load->view('includes/_footer');
		}
		
	}

	//-----------------------------------------------------------
	public function edit($id = 0){

		if($this->input->post('submit')){
			$original_value = $this->subadmin_model->get_user_by_id($id);
			if($this->input->post('username') != $original_value['username']) {
			   $uis_unique =  '|is_unique[ci_admin.username]';
			} else {
			   $uis_unique =  '';
			}
			if($this->input->post('email') != $original_value['email']) {
			   $eis_unique =  '|is_unique[ci_admin.email]';
			} else {
			   $eis_unique =  '';
			}
			$this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean'.$uis_unique);
			$this->form_validation->set_rules('firstname', 'Username', 'trim|required');
			$this->form_validation->set_rules('lastname', 'Lastname', 'trim|required');
			$this->form_validation->set_rules('email', 'Email', 'trim|valid_email|required'.$eis_unique);
			$this->form_validation->set_rules('mobile_no', 'Number', 'trim|required');
			$this->form_validation->set_rules('status', 'Status', 'trim|required');

			if ($this->form_validation->run() == FALSE) { 
				$data = array(
					'errors' => validation_errors()
				);
				$data['user'] = array(
					'admin_id' => $id,
					'username' => $this->input->post('username'),
					'firstname' => $this->input->post('firstname'),
					'lastname' => $this->input->post('lastname'), 
					'email' => $this->input->post('email'),
					'mobile_no' => $this->input->post('mobile_no'),
					'password' =>  $this->input->post('password'),
					'is_active' => $this->input->post('status'),
				); 
				$this->session->set_flashdata('errors', $data['errors']);
				$this->load->view('includes/_header');
				$this->load->view('subadmin/user_edit', $data);
				$this->load->view('includes/_footer');  
			}
			else{
				$data = array(
					'username' => $this->input->post('username'),
					'firstname' => $this->input->post('firstname'),
					'lastname' => $this->input->post('lastname'),
					'email' => $this->input->post('email'), 
					'mobile_no' => $this->input->post('mobile_no'),
					'password' =>  password_hash($this->input->post('password'), PASSWORD_BCRYPT),
					'is_active' => $this->input->post('status'),
					'updated_at' => date('Y-m-d : h:m:s'),
				);
				$data = $this->security->xss_clean($data);
				$result = $this->subadmin_model->edit_user($data, $id);
				if($result){
					$this->session->set_flashdata('success', 'User has been updated successfully!');
					redirect(base_url('subadmin'));
				}
			}
		}
		else{
			$data['title'] = 'Edit User';
			$data['user'] = $this->subadmin_model->get_user_by_id($id);
			
			$this->load->view('includes/_header', $data);
			$this->load->view('subadmin/user_edit', $data);
			$this->load->view('includes/_footer');
		}
	}

	//-----------------------------------------------------------
	public function delete($id = 0)
	{		
		$this->db->delete('ci_admin', array('admin_id' => $id));
		$this->session->set_flashdata('success', 'Subadmin has been deleted successfully!');
		redirect(base_url('subadmin'));
	}

	//---------------------------------------------------------------
	//  Export subadmin PDF 
	public function create_subadmin_pdf(){

		$this->load->helper('pdf_helper'); // loaded pdf helper
		$data['all_subadmin'] = $this->subadmin_model->get_subadmin_for_export();
		$this->load->view('subadmin/subadmin_pdf', $data);
	}

	//---------------------------------------------------------------	
	// Export data in CSV format 
	public function export_csv(){ 

	   // file name 
		$filename = 'subadmin_'.date('Y-m-d').'.csv'; 
		header("Content-Description: File Transfer"); 
		header("Content-Disposition: attachment; filename=$filename"); 
		header("Content-Type: application/csv; ");

	   // get data 
		$user_data = $this->subadmin_model->get_subadmin_for_export();
		
	   // file creation 
		$file = fopen('php://output', 'w');

		$header = array("ID", "Username", "First Name", "Last Name", "Email", "Mobile_no", "Created Date"); 

		fputcsv($file, $header);
		foreach ($user_data as $key=>$line){ 
			fputcsv($file,$line); 
		}
		fclose($file); 
		exit; 
	}


	public function manage_permission($id){  
		if($id == 1){
			$this->session->set_flashdata('errors', "invalid access");
			redirect('subadmin');
		}
		$data['subadmin'] = $this->subadmin_model->get_user_by_id($id);

		if(empty($data['subadmin'])){
			$this->session->set_flashdata('errors', "invalid access");
			redirect('subadmin');
		}

		$user_perm = $this->subadmin_model->get_alluser_permission(array('admin_id'=>$id));

		$ids = array();
		foreach ($user_perm as  $value) {
			 $ids[] = $value['module_id'];
		}


		$diff_module = $this->role_model->get_diff_module($ids);

		if($diff_module){
			for ($i=0; $i <count($diff_module); $i++)
			 { 
				$insertData = array('admin_id'=>$id,'module_id'=>$diff_module[$i]->id,'is_allow'=>0,'is_add'=>0,'is_view'=>0,'is_edit'=>0,'is_delete'=>0);
				$this->subadmin_model->insert_user_permission($insertData);
	 			# code...
			}			
		}

		$data['title'] = 'Assing Usere Permission';
		$data['module'] = $this->role_model->get_allmodel();
		$data['permission'] = $this->subadmin_model->get_subadmin_permission($id);

		$this->load->view('includes/_header', $data);
		$this->load->view('subadmin/user_permission');
		$this->load->view('includes/_footer');
		
	}

	function updatedata($id){
		$permission = $this->subadmin_model->get_subadmin_permission($id);
		$data ='';
        $i = 1;             
            foreach ($permission as $rs) {
                $data .=' <tr id= "'.$rs->id .'row">
                        <td class="text-center">'. $i.'</td>
                        <td class="text-center">'. $rs->menu_name.'</td>
                        <td class="text-center"><input type="checkbox" class="form-check-input mt-0 pt-0" id="is_allow' . $rs->module_id.$rs->id.'" data-modelid="'. $rs->id.'"data-userid="'. $rs->permission_id.'" data-type="is_allow" onChange="actions(this.id)"';
                          if($rs->is_allow == 1){
                        $data.=  'checked' ;}
                        $data.=' ></td>';

                $data.=' <td class="text-center"><input type="checkbox" class="form-check-input mt-0 pt-0" id="is_add' . $rs->module_id.$rs->id.'" data-modelid="'. $rs->id.'"data-userid="'. $rs->permission_id.'" data-type="is_add" onChange="actions(this.id)" ';if($rs->is_allow == 0){ $data.=  'disabled' ;} if($rs->is_add == 1){  $data.=  'checked' ; }
                        $data.=' ></td>';

                $data.=' <td class="text-center"><input type="checkbox" class="form-check-input mt-0 pt-0" id="is_view' . $rs->module_id.$rs->id.'" data-modelid="'. $rs->id.'"data-userid="'. $rs->permission_id.'" data-type="is_view" onChange="actions(this.id)" ';if($rs->is_allow == 0){ $data.=  'disabled'; } if($rs->is_view == 1){   $data.=  'checked' ;}
                    $data.=' ></td>';

					$data.=' <td class="text-center"><input type="checkbox" class="form-check-input mt-0 pt-0" id="is_edit' . $rs->module_id.$rs->id.'" data-modelid="'. $rs->id.'"data-userid="'. $rs->permission_id.'" data-type="is_edit" onChange="actions(this.id)" ';if($rs->is_allow == 0){ $data.=  'disabled'; } if($rs->is_edit == 1){  $data.=  'checked' ; }
                    $data.=' ></td>';

                $data.=' <td class="text-center"><input type="checkbox" class="form-check-input mt-0 pt-0" id="is_delete' . $rs->module_id.$rs->id.'" data-modelid="'. $rs->id.'"data-userid="'. $rs->permission_id.'" data-type="is_delete"onChange="actions(this.id)" ';if($rs->is_allow == 0){ $data.=  'disabled'; } if($rs->is_delete == 1){  $data.=  'checked' ;}
                    $data.=' ></td>';

                $data.=' </tr>';
                                               
                    $i++;
                }
             return $data;           			 
	}

	
	public function update_permission(){      
        $id = trim($this->input->post('id'));
        $menu = trim($this->input->post('menu'));
        $action = trim($this->input->post('action'));
        $value = trim($this->input->post('value'));
        $admin_id = trim($this->input->post('admin_id'));
       
   		$data = array('id' => $id,'module_id' => $menu);
   		$checkdata = $this->subadmin_model->get_user_permission(array('admin_id'=>$admin_id,'module_id'=>$menu));
   

   		if(empty($checkdata) && $action == 'is_allow' ){

   			$insertData = array('admin_id'=>$admin_id,'module_id'=>$menu,'is_allow'=>1,'is_add'=>0,'is_view'=>0,'is_edit'=>0,'is_delete'=>0);
   			
   			 $this->subadmin_model->insert_user_permission($insertData);
   			  
   			 $res = array('status' => true, 'data' => $this->updatedata($admin_id));
			 echo json_encode($res); exit;
        			
   		}

        if($action == 'is_allow' &&  $value == 0){
        	
        	$disallow = array('is_allow'=>0,'is_add'=>0,'is_view'=>0,'is_edit'=>0,'is_delete'=>0);

			$update = $this->subadmin_model->update_permissions($data,$disallow);
			   
   			 $res = array('status' => true, 'data' => $this->updatedata($admin_id));
			 echo json_encode($res); exit;
        } 
        $where = array('id' => $id,'module_id' => $menu,'is_allow'=>1);

        $checkallow = $this->subadmin_model->get_user_permission($where);

        if(empty($checkallow) &&  $action != 'is_allow'){

   			 $res = array('status' => false, 'data' => $this->updatedata($admin_id));
			 echo json_encode($res); exit;
        	
        }


     	$where = array($action => $value);
     //	print_r($where); exit;

        $update = $this->subadmin_model->update_permissions($data,$where);
           
   			 $res = array('status' => true, 'data' => $this->updatedata($admin_id));
			 echo json_encode($res); exit;
       
    }
	//-------

}


	?>