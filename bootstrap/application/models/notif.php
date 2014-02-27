<?php 
	
class Notif extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		//load monica database
	}
	
	function addnotif($data)
	{
		$this->db->insert('notifications', $data);
	}
	function getnotifs($userid)
	{
		$this->db->from('notifications')
					->join('users','notifications.notif_user = users.user_username')
					->where('notif_user', $userid)
					->where('notif_viewed', 'N')
					->order_by('notif_createdOn','desc');
		
		$query = $this->db->get()->result_array();
		
		return $query;
		$query->free_result();
	}
	
	function set_viewed($id)
	{
		$data = array(
				'notif_viewed' => 'Y'
		);
		
		$this->db->where('notif_id', $id);
		$this->db->update('notifications', $data);
	}
	
	function check_on_hospitalized_cases()
	{
		//$this->db->from();
	}
}

	
/* End of notif.php */
/* Location: ./application/models/notif.php */
