<?php
class Aj_users_model extends CI_Model 
{
	function authenticate($data)
	{
		$query = "SELECT * FROM aj_users WHERE user_login='".$data->username."' AND user_pass='".$data->password."'";
		$res_raw = $this->db->query($query);
		if($res_raw->num_rows)
		{
			return $res_raw->row_array();
		}
		return false;
	}

	function this_user($id)
	{
		$query = "SELECT * FROM aj_users WHERE ID=".$id."";
		$res_raw = $this->db->query($query);
		if($res_raw->num_rows)
		{
			return $res_raw->row_array();
		}
		return false;
	}
}
?>
