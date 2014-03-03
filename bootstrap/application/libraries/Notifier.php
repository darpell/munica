<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
class Notifier
{	
	public function __construct()
	{
		// Do something with $params
	}
	function add_notif($type, $data, $uri, $user)
	{
		$this->load->model('notif_model','model');
		$data = array(
					'notif_type'		=> $type,
					'notification'		=> $data,
					'unique_id'			=> $uri,
					'notif_viewed'		=> 'N',
					'notif_createdOn'	=> date('Y-m-d H:i:s'),
					'notif_user'		=> $user
				);
		
		$this->model->addnotif($data);
	}
}

/* End of file Notif.php */