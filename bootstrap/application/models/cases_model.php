<?php 
class Cases_model extends CI_Model
{
	function __construct()
	{
		// Call the Model constructor
		parent::__construct();
	}
	
	function get_cases($type, $offset, $limit)
	{
		$this->db->from('immediate_cases')
					->join('master_list','immediate_cases.person_id = master_list.person_id')
					->where('status',$type)
					->limit($offset,$limit);
		
		$query = $this->db->get();
		return $query->result_array();
		$query->free_result();
	}
	
	#TODO
	function get_case($person_id)
	{
		$this->db->from('immediate_cases')
				->join('master_list', 'immediate_cases.person_id = master_list.person_id')
				->where('person_id');
		
		$query = $this->db->get();
		$brgy_cases = $query->row_array();
			$query->free_result();
	}
	
	function check_case_resident($hosp_cases)
	{
		$this->db->from('immediate_cases')
				->join('master_list', 'immediate_cases.person_id = master_list.person_id');
		
		$query = $this->db->get();
		$brgy_cases = $query->result_array();
		
		$matching_cases = array();
		
		for ($ctr = 0; $ctr < count($hosp_cases); $ctr++)
		{
			for ($brgy_ctr = 0; $brgy_ctr < count($brgy_cases); $brgy_ctr++)
			{
				if(strcasecmp($hosp_cases[$ctr]['cr_first_name'], $brgy_cases[$brgy_ctr]['person_first_name']) == 0)
					if(strcasecmp($hosp_cases[$ctr]['cr_last_name'], $brgy_cases[$brgy_ctr]['person_last_name']) == 0)
						if(strcasecmp($hosp_cases[$ctr]['cr_sex'], $brgy_cases[$brgy_ctr]['person_sex']) == 0)
							if(strcasecmp( date('Y-m-d', strtotime($hosp_cases[$ctr]['cr_dob'])), $brgy_cases[$brgy_ctr]['person_dob']) == 0)
								$matching_cases[$ctr] = $brgy_cases[$brgy_ctr];
			}
		}
		return $matching_cases;
	}
	
	function check_gender_distribution($hosp_cases)
	{
		$male = 0;
		$female = 0;
		
		for($ctr = 0; $ctr < count($hosp_cases); $ctr++)
		{
			if (strcasecmp($hosp_cases[$ctr]['cr_sex'],'M') == 0)
				$male += 1;
			if (strcasecmp($hosp_cases[$ctr]['cr_sex'],'F') == 0)
				$female += 1;
		}
		$distribution = array(
							'male'=> $male, 
							'female' => $female
						);
		
		return $distribution;
	}
	
	#TODO for upload
	function check_barangay_count($hosp_cases)
	{
		$barangay_ctr = array();
		for($ctr = 0; $ctr < count($hosp_cases); $ctr++)
		{
			if ($hosp_cases[$ctr]['cr_barangay']);
		}
		
	}
	
	function check_if_hospitalized()
	{
		
	}
	
	function add_case($header,$cases)
	{
		$this->db->insert('case_report_header',$header);
		
		for ($ctr = 0; $ctr < count($cases); $ctr++)
		{
			$this->db->insert('case_report_main',$cases[$ctr]);
		}
	}
}


/* End of cases_model.php */
/* Location: ./application/models/cases_model.php */