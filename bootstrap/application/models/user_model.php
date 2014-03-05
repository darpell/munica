<?php

class User_model extends CI_Model
{
	function __construct()
	{
		// Call the Model constructor
		parent::__construct();
	}
	
	function login($data)
	{
			
		$qString = 'CALL ';
		$qString .= "login ('"; // name of stored procedure
		$qString .=
		//variables needed by the stored procedure
		$data['TPusername-txt'] . "','" .
		$data['TPpassword-txt'] . "')";
			
		$q= $this->db->query($qString);
			
		if($q->num_rows() > 0)
		{
			foreach ($q->result() as $row) {
	
				$data2[] = array(
						'TPusername'	=>	$row->user_username ,
						'TPtype'		=>	$row->user_type ,
						'TPfirstname'	=>	$row->user_firstname ,
						'TPmiddlename'	=>	$row->user_middlename ,
						'TPlastname'	=>	$row->user_lastname ,
				);
	
			}
			return $data2;
		}
		else
			return false;
	}
	
	function add()
	{
		$data = array(
				'user_username' 	=> $this->input->post('TPusername-txt'),
				'user_password' 	=> $this->input->post('TPpassword-txt'),
				'user_type' 		=> $this->input->post('TPusertype-rd'),
				'user_firstname'	=> $this->input->post('TPfirstname-txt'),
				'user_middlename'	=> $this->input->post('TPmiddlename-txt'),
				'user_lastname'		=> $this->input->post('TPlastname-txt'),
				'user_contact' 		=> $this->input->post('TPcontactno-txt'),
		);
	
		$this->db->insert('users', $data);
	
		$assoc = array(
				'user_username'	=> $this->input->post('TPusername-txt'),
				'barangay'		=> $this->input->post('TPbrgy-dd')
		);
		$this->db->insert('bhw', $assoc);
	}
	
	function update($username)
	{
		$data = array(
				'user_username' 	=> $this->input->post('TPusername-txt'),
				'user_password' 	=> $this->input->post('TPpassword-txt'),
				'user_type' 		=> $this->input->post('TPusertype-rd'),
				'user_firstname'	=> $this->input->post('TPfirstname-txt'),
				'user_middlename'	=> $this->input->post('TPmiddlename-txt'),
				'user_lastname'		=> $this->input->post('TPlastname-txt'),
				'user_contact' 		=> $this->input->post('TPcontactno-txt'),
		);
		
		$this->db->where('user_username', $username);
		$this->db->update('users', $data);
	}
	
	function get_users($offset, $limit)
	{
		$query = $this->db->get('users',$offset,$limit);
			return $query->result_array();
			$query->free_result();
	}
	
	function get_user($username)
	{
		$query = $this->db->get_where('users',array('user_username' => $username));
		return $query->row_array();
		$query->free_result();
	}
	
	function get_brgy($user)
	{
		$query = $this->db->get_where('bhw',array('user_username' => $user));
		
		return $query->row_array();
			$query->free_result();
	}
}

/* End of user_model.php */
/* Location: ./application/models/user_model.php */