<?php
class Aj_comments_model extends CI_Model 
{	
	function this_post_cmnts($id)
	{
		$query = "SELECT * FROM aj_comments WHERE comment_post_ID=".$id."";
		$res_raw = $this->db->query($query);
		if($res_raw->num_rows)
		{
			return $res_raw->result_array();
		}
		return false;
	}

	function insert_cmnt($input)
	{
		$this->db->insert('aj_comments',$input);
		return $this->db->insert_id();
	}

	function this_cmnt($data)
	{
		$query = "SELECT * FROM aj_comments WHERE comment_ID=".$data->comment_ID."";
		$res_raw = $this->db->query($query);
		if($res_raw->num_rows)
		{
			return $res_raw->row_array();
		}
		return false;
	}

	
}
?>
