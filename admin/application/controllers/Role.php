<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Role extends MY_Controller {

	public function __construct(){

		parent::__construct();
		auth_check(); // check login auth
		check_premissions($this->router->fetch_class(), $this->router->fetch_method());
		check_user_premissions($this->session->userdata('admin_id'), $this->router->fetch_class(), $this->router->fetch_method());
		$this->load->model('Role_model', 'role_model');
		$this->load->library('datatable'); // loaded my custom serverside datatable library
	}

	public function index(){

		$data['title'] = 'Role List';

		$this->load->view('includes/_header', $data);
		$this->load->view('role/role_list');
		$this->load->view('includes/_footer');
	}
	
	public function datatable_json(){				   					   
		$records = $this->role_model->get_all_role();
		$data = array();

		$i=0;
		foreach ($records['data']  as $row) 
		{  
			$status = ($row['is_active'] == 1)? 'checked': '';
			$data[]= array(
				++$i,
				$row['name'],
				date_time($row['created_at']),	
				'<input class="tgl_checkbox tgl-ios" 
				data-id="'.$row['id'].'" 
				id="cb_'.$row['id'].'"
				type="checkbox"  
				'.$status.'><label for="cb_'.$row['id'].'"></label>',		

				'<a title="Manage Permission" class="update btn btn-sm btn-warning" href="'.base_url('role/manage_parmission/'.$row['id']).'"> <i class="fa fa-lock"></i></a>
				<a title="Delete" class="delete btn btn-sm btn-danger" href='.base_url("role/delete/".$row['id']).' title="Delete" onclick="return confirm(\'Do you want to delete ?\')"> <i class="fa fa-trash-o"></i></a>'
			);
		}
		$records['data']=$data;
		echo json_encode($records);						   
	}

	//-----------------------------------------------------------
	public function change_status(){   

		$this->role_model->change_status();
	}

	public function manage_parmission($id){  
		if($id == 1){
			$this->session->set_flashdata('errors', "invalid access");
			redirect('role');
		}
		$data['role'] = $this->role_model->get_role_by_id($id);
		
		
		if(empty($data['role'])){
			$this->session->set_flashdata('errors', "invalid access");
			redirect('role');
		}

		$role_perm = $this->role_model->get_allrole_permission(array('role_id'=>$id));
		$ids = array();
		foreach ($role_perm as  $value) {
			 $ids[] = $value['module_id'];
		}

		$diff_module = $this->role_model->get_diff_module($ids);
		
		if($diff_module){
			for ($i=0; $i <count($diff_module); $i++)
			 { 
				$insertData = array('role_id'=>$id,'module_id'=>$diff_module[$i]->id,'is_allow'=>0,'is_add'=>0,'is_view'=>0,'is_edit'=>0,'is_delete'=>0);
				$this->role_model->insert_rol_permission($insertData);
	 				# code...
			}
			
		}

		$data['title'] = 'Assing Permission';
		$data['module'] = $this->role_model->get_allmodel();
		$data['permission'] = $this->role_model->get_spermission($id); 
		
		$this->load->view('includes/_header', $data);
		$this->load->view('role/role_permission');
		$this->load->view('includes/_footer');
		
	}
	function updatedata($id){

		$permission = $this->role_model->get_spermission($id);
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
        $role_id = trim($this->input->post('role_id'));
       
   		$data = array('id' => $id,'module_id' => $menu);
   		$checkdata = $this->role_model->get_role_permission(array('role_id'=>$role_id,'module_id'=>$menu));
   

   		if(empty($checkdata) && $action == 'is_allow' ){

   			$insertData = array('role_id'=>$role_id,'module_id'=>$menu,'is_allow'=>1,'is_add'=>0,'is_view'=>0,'is_edit'=>0,'is_delete'=>0);
   			
   			 $this->role_model->insert_rol_permission($insertData);
   			  
   			 $res = array('status' => true, 'data' => $this->updatedata($role_id));
			 echo json_encode($res); exit;
        			
   		}

        if($action == 'is_allow' &&  $value == 0){
        	
        	$disallow = array('is_allow'=>0,'is_add'=>0,'is_view'=>0,'is_edit'=>0,'is_delete'=>0);

			$update = $this->role_model->update_permissions($data,$disallow);
			   
   			 $res = array('status' => true, 'data' => $this->updatedata($role_id));
			 echo json_encode($res); exit;
        } 
        $where = array('id' => $id,'module_id' => $menu,'is_allow'=>1);

        $checkallow = $this->role_model->get_role_permission($where);

        if(empty($checkallow) &&  $action != 'is_allow'){

   			 $res = array('status' => false, 'data' => $this->updatedata($role_id));
			 echo json_encode($res); exit;
        	
        }


     	$where = array($action => $value);
     //	print_r($where); exit;

        $update = $this->role_model->update_permissions($data,$where);
           
   			 $res = array('status' => true, 'data' => $this->updatedata($role_id));
			 echo json_encode($res); exit;
       
    }
	//-----------------------------------------------------------
	public function add(){

		if($this->input->post('submit')){
			$this->form_validation->set_rules('name', 'role Name', 'trim|required|xss_clean|is_unique[ci_role.name]');

			if ($this->form_validation->run() == FALSE) {
				$data = array(
					'errors' => validation_errors()
				);
				$data['user'] = array( 
					'username' => $this->input->post('name'),
					'is_active' => $this->input->post('status'),
				);
				$this->session->set_flashdata('errors', $data['errors']);
				$this->load->view('includes/_header');
				$this->load->view('role/add_role', $data);
				$this->load->view('includes/_footer');
			}
			else{
				$data = array(
					'name' => $this->input->post('name'),
					'created_at' => date('Y-m-d : h:m:s'),
					'updated_at' => date('Y-m-d : h:m:s'),
					'is_active' => $this->input->post('status'),
				);
				
				$data = $this->security->xss_clean($data);
				$result = $this->role_model->add_role($data);

					if($result){
					$this->session->set_flashdata('success', 'Role has been added successfully!');
					redirect(base_url('role'));
				}
			}
		}
		else{

			$data['title'] = 'Add Role';

			$this->load->view('includes/_header', $data);
			$this->load->view('role/add_role');
			$this->load->view('includes/_footer');
		}
		
	}


	//-----------------------------------------------------------
	public function delete($id = 0)
	{
		$data = array('deleted'=>1);
		$this->db->where(array('id' => $id));
		$this->db->update('ci_role_permission', $data);
		$this->session->set_flashdata('success', 'Role has been deleted successfully!');
		redirect(base_url('role'));
	}

	//---------------------------------------------------------------


}


	?>
