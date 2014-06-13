<?php

///////////////////////////////////////////////////////////////////
// Created by Jack Young 
// Date: 08/09/2013
// Copyright 2013.  All rights reserved.  
///////////////////////////////////////////////////////////////////

class Auth {

	var $CI;

	function __construct() {
		$this->CI = & get_instance();
	}

	function check_session() {
		 $uname = $this->CI->session->userdata('username');
		 $user_id = $this->CI->session->userdata('user_id');

		 if ( $uname == '' || $user_id == '' ) {
		 	redirect(base_url('login'));
		 }
	}
	
	
	
}

?>
