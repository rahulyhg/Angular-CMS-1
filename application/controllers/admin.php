<?php

class Admin extends MY_Controller {

	function __construct() {
		parent::__construct();
		$this->load->helper('url');
		$this->load->helper('form');
	}

	public function index() {
		
		$this->load->view('admin/index');		
	}

	public function session_check()
	{
		$this->load->library('session');
		if($this->session->userdata("user_id"))
		{
			echo 1;
		}
		else
		{
			echo 0;
		}
		exit;
	}

	public function logout() {
		$this->load->library('session');
		$this->session->sess_destroy();
		if($this->session->userdata("user_id"))
		{
			echo 1;
		}
		else
		{
			echo 0;
		}
		exit;
	}
	public function saveDraft()
	{
		$postdata = file_get_contents("php://input");
		$data = json_decode($postdata);
		
		$this->load->model('aj_posts_model');
		$result = '';
		if(isset($data->ID))
		{
			$this->aj_posts_model->update_page($data);
			$result = $data->ID;
		}
		else
		{		
			$l_id = $this->aj_posts_model->insert_draft($data);
		
			if($l_id)
			{
				$this->aj_posts_model->insert_postmeta_last($l_id);
				$this->aj_posts_model->insert_postmeta_lock($l_id);
				$result = $this->aj_posts_model->update_draft_guid($l_id);
			}
		}
		echo (int)$result;exit;
	}
	
	public function add_draft_preview()
	{
		$postdata = file_get_contents("php://input");
		$data = json_decode($postdata);
		$this->load->model('aj_posts_model');
		$result = $this->aj_posts_model->update_org_row($data);
		echo json_encode($data);
	}

	public function add_inherit_preview()
	{
		$postdata = file_get_contents("php://input");
		$data = json_decode($postdata);
		$this->load->model('aj_posts_model');
		$res = $this->aj_posts_model->get_if_inherit($data->post_parent);
		$result = '';
		if(!$res)
		{
			$result = $this->aj_posts_model->insert_draft($data);
		}
		else
		{
			$result = $this->aj_posts_model->update_draft($data);
		}	
		echo json_encode($data);
	}

	public function fetch_page_one()
	{
		$postdata = file_get_contents("php://input");
		$data = json_decode($postdata);
		$this->load->model('aj_posts_model');
		$this->load->model('aj_comments_model');
		$result['page'] = $this->aj_posts_model->fetch_onepage($data);
		$result['cmnts'] = $this->aj_comments_model->this_post_cmnts((int)$result['page']['post_parent']);
		//$result['post_content'] = html_entity_decode(htmlentities($result['post_content']));
		echo json_encode($result);
		
	}

	public function addPage()
	{
		$postdata = file_get_contents("php://input");
		$data = json_decode($postdata);
		$this->load->model('aj_posts_model');
		$result = '';
		$result = $this->aj_posts_model->update_org_row($data);
		if($result)
		{
			$meta_data = array("post_id"=>$data->ID,"meta_key "=>"_aj_page_template","meta_value"=>"default");
			$result = $this->aj_posts_model->insert_metapost($meta_data);
		}		
		echo json_encode($result);
	}

	public function auto_save_preview()
	{
		$postdata = file_get_contents("php://input");
		$data = json_decode($postdata);
		$this->load->model('aj_posts_model');
		$res = $this->aj_posts_model->get_auto_save($data);
		if($res)
		{
		$this->aj_posts_model->update_auto_save($data);
		$result = (int)$res->ID;
		}
		else
		{
		$result = $this->aj_posts_model->insert_draft($data);
		}
		echo json_encode($result);
	}	

	public function editPage()
	{
		$postdata = file_get_contents("php://input");
		$data = json_decode($postdata);
		$this->load->model('aj_posts_model');
		$result = $this->aj_posts_model->update_page($data);
		if($result)
		{
			$this->aj_posts_model->del_auto_save($data);
		}
		echo json_encode($result);	
	}

	public function trashpage()
	{
		$postdata = file_get_contents("php://input");
		$data = json_decode($postdata);
		$this->load->model('aj_posts_model');
		$result = $this->aj_posts_model->get_row_bsd_id($data->ID);
		if($result)
		{
			$input = array('post_id'=>$data->ID,'meta_key'=>'_wp_trash_meta_status',
					'meta_value'=>$result['post_status']);
			$this->aj_posts_model->insert_metapost($input);
			$input = array('post_id'=>$data->ID,'meta_key'=>'_wp_trash_meta_time',
					'meta_value'=>round(microtime(true) * 1000));
			$this->aj_posts_model->insert_metapost($input);
			$this->aj_posts_model->update_page($data);
					
		}		
		echo json_encode($result);
	}

	public function getpagedetails()
	{
		$postdata = file_get_contents("php://input");
		$data = json_decode($postdata);		
		$this->load->model('aj_posts_model');		
		$result['num_rows'] = $this->aj_posts_model->fetch_sel_pages($data);		
		 $arr1 = $this->aj_posts_model->pages_count();
		$arr2 = array();$i=0;
		foreach($arr1 as $key => $val){
		   $arr2[$val['post_status']] = $val["count('post_status')"];
		   if($val['post_status'] != 'trash')
		   {
			$i = $i + $val["count('post_status')"];
		   }		   	
		}
		$arr2['all'] = $i;
		$result['counts'] = $arr2;
		echo json_encode($result);		
	}

	public function deletepage()
	{
		$postdata = file_get_contents("php://input");
		$data = json_decode($postdata);
		$this->load->model('aj_posts_model');
		$result = $this->aj_posts_model->delete_sel_page($data);	
	}

	public function restorepage()
	{
		$postdata = file_get_contents("php://input");
		$data = json_decode($postdata);
		$this->load->model('aj_posts_model');
		$result = $this->aj_posts_model->restore_sel_page($data);
	}

	public function updatepage_cmt()
	{
		$postdata = file_get_contents("php://input");
		$data = json_decode($postdata);
		$this->load->model('aj_posts_model');
		$result['cmnts'] = $this->aj_posts_model->updatepage_cmt($data);
		if($result)
		{
			$this->load->model('aj_users_model');
			$this->load->model('aj_comments_model');
			$row = $this->aj_users_model->this_user(1);

			$ip = getenv('HTTP_CLIENT_IP')?:getenv('HTTP_X_FORWARDED_FOR')?:getenv('HTTP_X_FORWARDED')?:getenv('HTTP_FORWARDED_FOR')?:
			  getenv('HTTP_FORWARDED')?:getenv('REMOTE_ADDR');
			
			$browser = $_SERVER['HTTP_USER_AGENT'];
			
			$input = array("comment_post_ID"=>$data->ID,"comment_author"=>$row["user_login"],
					"comment_author_email"=>$row["user_email"],
					"comment_author_IP"=>$ip,"comment_date"=>date('Y-m-d H:i:s'),
					"comment_date_gmt"=>date('Y-m-d H:i:s'),
					"comment_content"=>$data->comment,"comment_approved"=>1,
					"comment_agent"=>$browser,"user_id"=>$row["ID"]
					);
			$exe = $this->aj_comments_model->insert_cmnt($input);
			if($exe)
			{
				$result['cmnts'] = $this->aj_comments_model->this_post_cmnts($data->ID);
			}
			
		}
		echo json_encode($result);
	}
	
	public function cmnt_info()
	{
		$postdata = file_get_contents("php://input");
		$data = json_decode($postdata);
		$this->load->model('aj_comments_model');
		$result = $this->aj_comments_model->this_cmnt($data);
		echo json_encode($result);
	}
	
}
?>
