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
		$date_comp = date('Y-m-d H:i:s',strtotime('-7 days',strtotime(date('Y-m-d H:i:s'))));
		
		$this->db->from('active_cases')
				->join('master_list','active_cases.person_id = master_list.person_id')
				->join('catchment_area','active_cases.person_id = catchment_area.person_id')
				->where('status','hospitalized')
				->where('active_cases.created_on <', $date_comp);
		
		$query = $this->db->get()->result_array();
		
		for ($ctr = 0; $ctr < count($query); $ctr++)
		{
			$notif_input = array(
					'notif_type'		=> 'update',
					'notification'		=> 'Please update on' . $query[$ctr]['person_first_name'] . ' ' . $query[$ctr]['person_last_name'] . ' status',
					'unique_id'			=> 'test',
					'notif_viewed'		=> 'N',
					'notif_createdOn'	=> date('Y-m-d H:i:s'),
					'notif_user'		=> $query[$ctr]['bhw_id']
					);
			
			$this->addnotif($notif_input);
		}
	}
}

	
/* End of notif.php */
/* Location: ./application/models/notif.php */
