<?php 
class Active_case_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		//load monica database
	}
	
	function get_cases($bhw = FALSE, $status = FALSE)
	{
		$this->db->from('active_cases')
				->join('catchment_area','active_cases.person_id = catchment_area.person_id')
				->join('master_list','catchment_area.person_id = master_list.person_id')
				->join('household_address', 'household_address.household_id = catchment_area.household_id');
		
		if ($bhw != FALSE)
			$this->db->where('bhw_id',$bhw);
		if ($status != FALSE)
			$this->db->where('status',$status);
		
		$this->db->order_by('imcase_no','desc');
		
		$query = $this->db->get();
		return $query->result_array();
			$query->free_result();
		
	}
	
	function get_cases_per_brgy($brgy = FALSE, $status = FALSE)
	{
		$this->db->from('active_cases')
		->join('catchment_area','active_cases.person_id = catchment_area.person_id')
		->join('bhw', 'catchment_area.bhw_id = bhw.user_username')
		->join('master_list','catchment_area.person_id = master_list.person_id')
		->join('household_address', 'household_address.household_id = catchment_area.household_id');
	
		if ($brgy != FALSE)
			$this->db->where('barangay',$brgy);
		if ($status != FALSE)
			$this->db->where('status',$status);
	
		$this->db->order_by('imcase_no','desc');
	
		$query = $this->db->get();
		return $query->result_array();
		$query->free_result();
	
	}
	
	function get_case($imcase)
	{
		$this->db->from('active_cases')
				->join('master_list', 'active_cases.person_id = master_list.person_id')
				->join('catchment_area','active_cases.person_id = catchment_area.person_id')
				->join('household_address', 'household_address.household_id = catchment_area.household_id')
				->where('active_cases.imcase_no',$imcase)
				->order_by('imcase_no','desc')
				->limit('1');
		
		$query = $this->db->get();
		return $query->row_array();
			$query->free_result();
	}
	
	function get_symptom($symptom, $status = FALSE)
	{
		$this->db->from('active_cases')
				->where($symptom,'Y');
		
		if ($status != FALSE)
			$this->db->where('status',$status);
		
		$query = $this->db->get();
		return $query->result_array();
			$query->free_result();
	}
	
	function check_symptom($person_id, $symptom)
	{
		$this->db->from('active_cases')
					->where('person_id',$person_id);
		
		
		$query = $this->db->get();
		if ($query->num_rows() > 0)
		{
			$row = $query->row_array();
		
			if ($row[$symptom] == 'Y')
				return TRUE;
			else
				return FALSE;
		}
		else
			return FALSE;
	}
	
	function check_gender_distribution($cases)
	{
		$male = 0;
		$female = 0;
	
		for($ctr = 0; $ctr < count($cases); $ctr++)
		{
		if (strcasecmp($cases[$ctr]['person_sex'],'M') == 0)
		$male += 1;
		if (strcasecmp($cases[$ctr]['person_sex'],'F') == 0)
				$female += 1;
		}
		$distribution = array(
				'male'=> $male,
				'female' => $female
						);
	
		return $distribution;
	}
	
	function add_case()
	{
		if ($this->input->post('duration') == '1')
			$remark = '1st day: ';
		else if ($this->input->post('duration') == '2')
			$remark = '2nd day: ';
		else if ($this->input->post('duration') == '3')
			$remark = '3rd day: ';
		else
			$remark = $this->input->post('duration') . 'th day: ';
			
		$data = array(
				'person_id'			=> $this->input->post('person_id'),
				'has_muscle_pain'	=> $hmp = ($this->input->post('has_muscle_pain') == 'Y') ? 'Y' : 'N',
				'has_joint_pain'	=> $hjp = ($this->input->post('has_joint_pain') == 'Y') ? 'Y' : 'N',
				'has_headache'		=> $hh = ($this->input->post('has_headache') == 'Y') ? 'Y' : 'N',
				'has_bleeding'		=> $hb = ($this->input->post('has_bleeding') == 'Y') ? 'Y' : 'N',
				'has_rashes'		=> $hr = ($this->input->post('has_rashes') == 'Y') ? 'Y' : 'N',
				'days_fever'		=> $this->input->post('duration'),
				'suspected_source'	=> $this->input->post('source'),
				'remarks'			=> $remark . $this->input->post('remarks')
		);
		$this->db->set('created_on', 'NOW()', FALSE);
		$this->db->set('last_updated_on', 'NOW()', FALSE);
	
		/*
		 * Status
		*/
		$symptoms = array();
		if ($data['has_muscle_pain'] == 'Y')
			array_push($symptoms,"Muscle Pain");
		if ($data['has_joint_pain'] == 'Y')
			array_push($symptoms,"Joint Pain");
		if ($data['has_headache'] == 'Y')
			array_push($symptoms,"Headache");
		if ($data['has_bleeding'] == 'Y')
			array_push($symptoms,"Bleeding");
		if ($data['has_rashes'] == 'Y')
			array_push($symptoms,"Rashes");
	
		if ($data['days_fever'] < 3 && count($symptoms) >= 2)
		{
			$level = 'suspected';
		}
		else if ($data['days_fever'] == 3 && count($symptoms) >= 2)
		{
			$level = 'threatening';
		}
		else if ($data['days_fever'] >= 3 || count($symptoms) >= 2 || in_array('Rashes',$symptoms) || in_array('Bleeding',$symptoms))
		{
			$level = 'serious';
		}
		else
			$level = 'suspected';
	
		$this->db->set('status',$level);
		// end status
			
		$this->db->insert('active_cases', $data);
			
		# trigger notif
			
		// updates last_visited_on at `household_address`
		$hh = array(
		'last_visited' => date('Y-m-d')
			);
			
		$this->db->where('household_id',$this->input->post('household_id'));
			$this->db->update('household_address', $hh);
		
						$returning_data = array($level, $symptoms);
							
						return $returning_data;
	}
	
	
	# TODO
	function update_im($imcase)
	{
		if ($this->input->post('duration') == '1')
			$remark = '1st day: ';
		else if ($this->input->post('duration') == '2')
			$remark = '2nd day: ';
		else if ($this->input->post('duration') == '3')
			$remark = '3rd day: ';
		else
			$remark = $this->input->post('duration') . 'th day: ';
			
		$this->db->from('active_cases');
		$this->db->where('imcase_no',$imcase);
		
			$query = $this->db->get();
					$row = $query->row_array();
	
					$old_remark = $row['remarks'];
						
						
					$data = array(
							'imcase_no'			=> $this->input->post('imcase_no'),
							'person_id'			=> $this->input->post('person_id'),
							'has_muscle_pain'	=> $hmp = ($this->input->post('has_muscle_pain') == 'Y') ? 'Y' : 'N',
							'has_joint_pain'	=> $hjp = ($this->input->post('has_joint_pain') == 'Y') ? 'Y' : 'N',
							'has_headache'		=> $hh = ($this->input->post('has_headache') == 'Y') ? 'Y' : 'N',
							'has_bleeding'		=> $hb = ($this->input->post('has_bleeding') == 'Y') ? 'Y' : 'N',
							'has_rashes'		=> $hr = ($this->input->post('has_rashes') == 'Y') ? 'Y' : 'N',
							'days_fever'		=> $this->input->post('duration'),
							'suspected_source'	=> $this->input->post('source'),
							'remarks'			=> $remark . $this->input->post('remarks') . " " . $old_remark,
							'created_on'		=> $this->input->post('created_on')
					);
						
					$this->db->delete('active_cases', array('imcase_no' => $this->input->post('imcase_no')));
						
			$this->db->set('last_updated_on', 'NOW()', FALSE);
		
				/*
				* Status
				*/
				$symptoms = array();
				if ($data['has_muscle_pain'] == 'Y')
				array_push($symptoms,"Muscle Pain");
					if ($data['has_joint_pain'] == 'Y')
				array_push($symptoms,"Joint Pain");
					if ($data['has_headache'] == 'Y')
				array_push($symptoms,"Headache");
					if ($data['has_bleeding'] == 'Y')
							array_push($symptoms,"Bleeding");
			if ($data['has_rashes'] == 'Y')
						array_push($symptoms,"Rashes");
							
						if ($data['days_fever'] < 3 && count($symptoms) >= 2)
						{
						$level = 'suspected';
			}
						else if ($data['days_fever'] == 3 && count($symptoms) >= 2)
						{
						$level = 'threatening';
						}
						else if ($data['days_fever'] >= 3 || count($symptoms) >= 2 || in_array('Rashes',$symptoms) || in_array('Bleeding',$symptoms))
						{
							$level = 'serious';
						}
						else
							$level = 'suspected';
							
						$this->db->set('status',$level);
							
						$this->db->insert('active_cases', $data);
						$hh = array(
								'last_visited' => date('Y-m-d')
						);
	
						$this->db->where('household_id',$this->input->post('household_id'));
						$this->db->update('household_address', $hh);
							
						$returning_data = array($level, $symptoms);
							
						return $returning_data;
	}
}

	
/* End of active_case_model.php */
/* Location: ./application/models/active_case_model.php */