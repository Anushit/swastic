<?php
	class Inquiry_model extends CI_Model{

		public function add_inquiry($data){
			$this->db->insert('ci_inquiry', $data);
			return $this->db->insert_id();
		}

		public function add_assign_inquiry($data){
			$this->db->insert('ci_inquiry_assign', $data);
			return true;
		}
		public function add_inquiry_followup($data){
			$this->db->insert('ci_inquiry_followup', $data);
			return true;
		}
		public function add_inquiry_followupdetail($data){
			$this->db->insert('ci_inquiry_followdetail', $data);
			return true;
		}
		

		public function get_created_by_id($id){
			$query = $this->db->get_where('ci_admin', array('admin_id' => $id));
			return $result = $query->row_array();
		}
		
		
		//---------------------------------------------------
		// get all inquiry for server-side datatable processing (ajax based)
		public function get_all_inquiry(){
			$wh =array();
			$SQL ='SELECT ci_inquiry.*,ci_admin.firstname as firstname, ci_admin.lastname as lastname,
			case WHEN ci_inquiry.inquiry_type = 2 THEN ci_products.name  ELSE
			case WHEN ci_inquiry.inquiry_type = 3 THEN ci_services.name  END END as itm_name FROM ci_inquiry
			LEFT JOIN ci_products ON (ci_products.id = ci_inquiry.link_id)
			LEFT JOIN ci_inquiry_assign ON (ci_inquiry_assign.inquiry_id = ci_inquiry.id AND ci_inquiry_assign.status = 1)
			LEFT JOIN ci_services ON (ci_services.id = ci_inquiry.link_id)
			LEFT JOIN ci_admin ON (ci_admin.admin_id = ci_inquiry_assign.user_id  )';
			if($this->session->userdata('admin_id')==1){
				$wh[] = " deleted = 0";
			}else{
				$wh[] = " deleted = 0 AND ci_inquiry_assign.user_id =".$this->session->userdata('admin_id');
			}
			
			if(count($wh)>0)
			{
				$WHERE = implode(' and ',$wh);
				return $this->datatable->LoadJson($SQL,$WHERE);
			}
			else
			{
				return $this->datatable->LoadJson($SQL);
			}
		}

		public function get_all_reply_mail($id){
			$wh =array();
			$SQL ='SELECT ci_inquiry_followup.*,ci_inquiry.email as inquirymail FROM ci_inquiry_followup
			LEFT JOIN ci_inquiry ON (ci_inquiry.id = ci_inquiry_followup.inquiry_id)';
			$wh[] = " type = 1 AND inquiry_id =".$id;
			if(count($wh)>0)
			{
				$WHERE = implode(' and ',$wh);
				return $this->datatable->LoadJson($SQL,$WHERE);
			}
			else
			{
				return $this->datatable->LoadJson($SQL);
			}
		}
		public function get_all_reply_msg($id){
			$wh =array();
			$SQL ='SELECT ci_inquiry_followup.*,ci_inquiry.mobile as mob_number FROM ci_inquiry_followup
			LEFT JOIN ci_inquiry ON (ci_inquiry.id = ci_inquiry_followup.inquiry_id)';
			$wh[] = " type = 2 AND inquiry_id =".$id;
			if(count($wh)>0)
			{
				$WHERE = implode(' and ',$wh);
				return $this->datatable->LoadJson($SQL,$WHERE);
			}
			else
			{
				return $this->datatable->LoadJson($SQL);
			}
		}

		public function get_all_followup_details($id){

			$wh = array(); 
			$SQL ='(SELECT  `inquiry_id`, `type`, `subject`, `message`, `attachment`, "" as comments, `followup_date`, "" as next_followup_date FROM ci_inquiry_followup where inquiry_id ='.$id.') 
				Union 
				(SELECT  `inquiry_id`, 4 as type , "" as subject, "" as message, "" as attachment, `comments`, `followup_date`, `next_followup_date` FROM `ci_inquiry_followdetail`  where inquiry_id ='.$id.') ';

			if(count($wh)>0)
			{
				$WHERE = implode(' and ',$wh);
				return $this->datatable->LoadJson($SQL,$WHERE);
			}
			else
			{
				return $this->datatable->LoadJson($SQL);
			}
		}

		public function get_all_reply_whatsapp($id){
			$wh =array();
			$SQL ='SELECT ci_inquiry_followup.*,ci_inquiry.mobile as mob_number FROM ci_inquiry_followup
			LEFT JOIN ci_inquiry ON (ci_inquiry.id = ci_inquiry_followup.inquiry_id)';
			$wh[] = " type = 3 AND inquiry_id =".$id;
			if(count($wh)>0)
			{
				$WHERE = implode(' and ',$wh);
				return $this->datatable->LoadJson($SQL,$WHERE);
			}
			else
			{
				return $this->datatable->LoadJson($SQL);
			}
		}
		public function update_inquiry($data, $id,$userid=Null){
			$this->db->where('inquiry_id', $id);
			$this->db->where('user_id !=', $userid);
			$this->db->update('ci_inquiry_assign', $data);
			return true;
		}
		//---------------------------------------------------
		// Get inquiry detial by ID
		public function get_inquiry_by_id($id){
			$this->db->select('ci_inquiry.*,ci_admin.firstname as first_name,ci_admin.lastname as last_name,ci_products.name as productName,ci_services.name as serviceName');
			$this->db->from('ci_inquiry');
			$this->db->join('ci_inquiry_assign', 'ci_inquiry_assign.inquiry_id=ci_inquiry.id', 'left','ci_inquiry_assign.status = 1');
			$this->db->join('ci_admin', 'ci_admin.admin_id=ci_inquiry_assign.user_id', 'left');
			$this->db->join('ci_products', 'ci_products.id=ci_inquiry.link_id', 'left','ci_inquiry.inquiry_type = 2');
			$this->db->join('ci_services', 'ci_services.id=ci_inquiry.link_id', 'left','ci_inquiry.inquiry_type = 3');
			$this->db->where('ci_inquiry.id', $id);
			$query = $this->db->get();
			return $query->row_array();

			//$query = $this->db->get_where('ci_inquiry', array('id' => $id));
			//return $result = $query->row_array();
		}



		public function get_assing_inquiry_by_id($id){
			$query = $this->db->get_where('ci_inquiry_assign', array('inquiry_id' => $id));
			return $result = $query->row_array();
		}
		public function assign_inquirys($data){
			$query = $this->db->get_where('ci_inquiry_assign', $data);
			return $result = $query->row_array();
		}
		 
		 public function get_allassing_inquiry_by_id($id){
		 	$this->db->select('ci_inquiry_assign.*,ci_admin.firstname as name,ci_inquiry.email,ci_inquiry.subject,ci_inquiry.mobile,ci_inquiry.inquiry_type');
			$this->db->from('ci_inquiry_assign');
			$this->db->join('ci_admin', 'ci_admin.admin_id=ci_inquiry_assign.user_id', 'left');
			$this->db->join('ci_inquiry', 'ci_inquiry.id=ci_inquiry_assign.inquiry_id', 'left');
			$this->db->where('ci_inquiry_assign.inquiry_id', $id);
			$this->db->order_by('id','desc');
			$query = $this->db->get();
			return $query->result_array();
			
		}
		 
 
 
		//---------------------------------------------------
		// get inquirys for csv export
		public function get_inquirys_for_export(){
			///$this->db->where('is_admin', 0);
			$this->db->select('id, name, email, mobile, inquiry_type, subject, message, ip_address, created_at');
			$this->db->from('ci_inquiry');
			$query = $this->db->get();
			return $result = $query->result_array();
		}
		
		
		public function addgernalinquery($data){
			$this->db->insert('ci_inquiry', $data);
			return true;
			
		}
		public function addserviceinquery($data){
			$this->db->insert('ci_inquiry', $data);
			return true;
			
		}



	}

?>