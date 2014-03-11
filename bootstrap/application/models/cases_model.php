<?php 
class Cases_model extends CI_Model
{
	function __construct()
	{
		// Call the Model constructor
		parent::__construct();
	}
	
	function add_case($header,$cases)
	{
		$this->db->insert('case_report_header',$header);
	
		for ($ctr = 0; $ctr < count($cases); $ctr++)
		{
		$this->db->insert('case_report_main',$cases[$ctr]);
		}
		}
	
	function get_cases($type = FALSE, $bhw = FALSE ,$offset = FALSE, $limit = FALSE)
	{
		$this->db->from('active_cases')
					->join('master_list','active_cases.person_id = master_list.person_id')
					->join('catchment_area','master_list.person_id = catchment_area.person_id');
		
		if ($bhw != FALSE)
			$this->db->where('bhw_id', $bhw);
		
		if ($type != FALSE)
			$this->db->where('status',$type);
		if ($offset != FALSE && $limit != FALSE)
			$this->db->limit($offset,$limit);
		
		$query = $this->db->get();
		return $query->result_array();
		$query->free_result();
	}
	
	#TODO subject for deletion due to duplicate entr in active_case_model
	function get_case($imcase)
	{
		$this->db->from('active_cases')
				->join('master_list', 'active_cases.person_id = master_list.person_id')
				->where('active_cases.imcase_no',$imcase)
				->order_by('imcase_no','desc')
				->limit('1');
		
		$query = $this->db->get();
		return $query->row_array();
			$query->free_result();
	}
	
	/*
	 * Combo
	 */
	
	function get_case_resident($hosp_cases)
	{
		$query = $this->db->get('master_list');
		$brgy_cases = $query->result_array();
		
		$match_ctr = 0;
		$match = array();
		
		for ($ctr = 0; $ctr < count($hosp_cases); $ctr++)
		{
			for ($brgy_ctr = 0; $brgy_ctr < count($brgy_cases); $brgy_ctr++)
			{
				if(strcasecmp($hosp_cases[$ctr]['cr_first_name'], $brgy_cases[$brgy_ctr]['person_first_name']) == 0)
					if(strcasecmp($hosp_cases[$ctr]['cr_last_name'], $brgy_cases[$brgy_ctr]['person_last_name']) == 0)
						if(strcasecmp($hosp_cases[$ctr]['cr_sex'], $brgy_cases[$brgy_ctr]['person_sex']) == 0)
							if(strcasecmp( date('Y-m-d', strtotime($hosp_cases[$ctr]['cr_dob'])), $brgy_cases[$brgy_ctr]['person_dob']) == 0)
							{
								$match[$match_ctr] = $brgy_cases[$brgy_ctr];
								$match_ctr++;
							}
			}
		}
		return $match;
	}
	
	function check_if_active($hosp_cases)
	{
		$query = $this->db->get('active_cases');
		$active_cases = $query->result_array();
		$residents = $this->get_case_resident($hosp_cases);
		
		$match_ctr = 0;
		$match = array();
		
		for ($ctr = 0; $ctr < count($residents); $ctr++)
		{
			for ($active_ctr = 0; $active_ctr < count($active_cases); $active_ctr++)
			{
				if($residents[$ctr]['person_id'] == $active_cases[$active_ctr]['person_id'])
				{
					$match[$match_ctr] = $active_cases[$active_ctr];
					$match_ctr++;
				}
					
			}
		}
		
		return $match;
	}
	
	function add_unrecorded_case($hosp_cases)
	{
		$residents = $this->get_case_resident($hosp_cases);
		
		$STATUS = 'hospitalized';
		
		for ($ctr = 0; $ctr < count($residents); $ctr++)
		{
			$unrecorded_case = $this->check_case_if_active(
											$residents[$ctr]['person_first_name'],
											$residents[$ctr]['person_last_name'],
											$residents[$ctr]['person_sex'],
											$residents[$ctr]['person_dob']
										);
			
			if ($unrecorded_case == NULL || $unrecorded_case == 0)
			{
				$data = array(
						'person_id'			=> $residents[$ctr]['person_id'],
						'has_muscle_pain'	=> 'N',
						'has_joint_pain'	=> 'N',
						'has_headache'		=> 'N',
						'has_bleeding'		=> 'N',
						'has_rashes'		=> 'N',
						'days_fever'		=> '0', // to be edited
						'remarks'			=> 'Unrecorded case in the barangay',
						'status'			=> $STATUS,
						'created_on'		=> date('Y-m-d H:i:s'), // to be edited
						'last_updated_on'	=> date('Y-m-d H:i:s') // to be edited
					);
				
				$this->db->insert('active_cases', $data);
			}
			
		}
	}
	
	function check_case_if_active($fname,$lname,$gender,$dob)
	{
		//$residents = $this->get_case_resident($hosp_cases);
		
		$this->db->from('active_cases')
				->join('master_list','active_cases.person_id = master_list.person_id')
				->where_in('person_first_name',array($fname))
				->where_in('person_last_name',array($lname))
				->where_in('person_sex',array($gender))
				->where_in('person_dob',array($dob));
		
		$query = $this->db->get();
		return $query->row_array();
			$query->free_result();
	}
	
	function update_to_hospitalized($hosp_cases)
	{
		$active_cases = $this->check_if_active($hosp_cases);
	
		for ($ctr = 0; $ctr < count($active_cases); $ctr++)
		{
			$updated_cases = array(
								'status'		 	=> 'hospitalized',
								'last_updated_on'	=> date('Y-m-d H:i:s')
							);
			
			$this->db->where('person_id',$active_cases[$ctr]['person_id']);
			$this->db->update('active_cases', $updated_cases);
		}
	}
	
	/**
	 * end Combo
	 */
	
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
}


/* End of cases_model.php */
/* Location: ./application/models/cases_model.php */