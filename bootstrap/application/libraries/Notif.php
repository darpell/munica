<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
class Notif
{
	function __construct()
	{
		parent::__construct();
		// Do something with $params
		$this->load->model('notif','model');
	}
	
	function add_notif($type, $data, $url, $user)
	{
		$data = array(
					'notif_type'		=> $type,
					'notification'		=> $data,
					'unique_id'			=> ,
					'notif_viewed'		=> ,
					'notif_createdOn'	=> ,
					'notif_user'		=> $user
				);
	}
	
	//came from controllers/siteupload
	function add_case_notif($type,$id,$barangay)
	{
		if ($type == 'imcase')
		{//chance to person_id
			$msg = 'New Immediate Case:';
		}
		else if($type == 'invcase')
		{//change to patient_no'
			$msg = 'Plotted Uninvestigated Case:';
		}
		else if($type == 'newcase')
		{//change to patient_no'
			$msg = 'New Dengue Case Reported:';
		}
	
		$midwife = $this->notif->get_midwife_by_barangay($barangay);
		$personid = $id;
		$data2 = array(
				'notif_type' => 1,
				'notification' => $msg,
				'unique_id' => $type.'-'.$personid,
				'notif_viewed' => 'N',
				'notif_createdOn' => Date('Y-m-d'),
				'notif_user' => $midwife,
		);
		$this->notif->addnotif($data2);
	}
	function check_prev_case_notif($bgy)
	{
		$barangay =  $bgy;
		$data = $this->masterlist->get_cases($barangay);
		$midwife = $this->notif->get_midwife_by_barangay($barangay);
		if(($data[date('Y')] > $data[date('Y')-1]))
		{
			$id='highcase-'.date('Y-m');
			if ($this->notif->checknotifexist($id,$midwife))
			{
				$data2 = array(
						'notif_type' => 2,
						'notification' => 'current number of dengue cases exceeded the previous cases from last year',
						'unique_id' => $id,
						'notif_viewed' => 'N',
						'notif_createdOn' => Date('Y-m-d'),
						'notif_user' => $midwife,
	
				);
				$this->notif->addnotif($data2);
			}
		}
	}
	
	/*
	 * end
	 */
}

/* End of file Notif.php */