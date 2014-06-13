<?php


class Index extends MY_Controller {

	function __construct() {
		parent::__construct();
		$this->load->helper('url');
		$this->load->helper('form');
	}

	public function index() {
	
		$this->load->view('index');		
	}

	public function validate()
	{
		$postdata = file_get_contents("php://input");
		$uname = json_decode($postdata);	
		$invalid = preg_match('/[^A-Za-z0-9.#\\-$]/', $uname->username);
		if($invalid)
		{
			$res['invalidChars'] = 1;
			$res['invalidChars'];
		}
		else
		{
			$res['success'] = 'valid';
		}
		echo json_encode($res);
	}

	public function formsubmit()
	{
		$postdata = file_get_contents("php://input");
		$data = json_decode($postdata);
		$this->load->model('aj_users_model');
		$this->load->library('session');
		$user = $this->aj_users_model->authenticate($data);
		if($user)
		{
			$us_data = array (
						'user_type' => '1',
						//'user_id' => $user->u_id,
						'user_id' => $user['ID'],
						'username' => $user['user_login'],
						'password' => $user['user_pass'],		
						'logged_in' => TRUE
					);
			$this->session->set_userdata($us_data);
			$result = 2;
		}
		else
		{
			$result =1;
		}
		echo json_encode($result);		
	}

}
	?>
