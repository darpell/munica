<?php 

class Im_case_model extends CI_Model
{
	function __construct()
	{
		// Call the Model constructor
		parent::__construct();
	}
	
	function add_im_case()
	{
		/*if ($this->input->post('duration') == '1')
			$remark = '1st day: ';
		else if ($this->input->post('duration') == '2')
			$remark = '2nd day: ';
		else if ($this->input->post('duration') == '3')
			$remark = '3rd day: ';
		else
			$remark = $this->input->post('duration') . 'th day: ';*/
			
		$data = array(
				'person_id'			=> $this->input->post('person_id'),
				'has_muscle_pain'	=> $hmp = ($this->input->post('has_muscle_pain') == 'Y') ? 'Y' : 'N',
				'has_joint_pain'	=> $hjp = ($this->input->post('has_joint_pain') == 'Y') ? 'Y' : 'N',
				'has_headache'		=> $hh = ($this->input->post('has_headache') == 'Y') ? 'Y' : 'N',
				'has_bleeding'		=> $hb = ($this->input->post('has_bleeding') == 'Y') ? 'Y' : 'N',
				'has_rashes'		=> $hr = ($this->input->post('has_rashes') == 'Y') ? 'Y' : 'N',
				'days_fever'		=> $this->input->post('duration'),
				'suspected_source'	=> $this->input->post('source')
				//'remarks'			=> $remark . $this->input->post('remarks'),
				//'imcase_lat'		=> $this->input->post('lat'),
				//'imcase_lng'		=> $this->input->post('lng')
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
			
		$this->db->insert('immediate_cases', $data);
			
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
	function update_im()
	{
	if ($this->input->post('duration') == '1')
		$remark = '1st day: ';
		else if ($this->input->post('duration') == '2')
		$remark = '2nd day: ';
		else if ($this->input->post('duration') == '3')
		$remark = '3rd day: ';
		else
		$remark = $this->input->post('duration') . 'th day: ';
			
		$this->db->from('immediate_cases');
	$this->db->where('imcase_no',$this->input->post('imcase_no'));
		
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
			
													'created_on'		=> $this->input->post('created_on'),
											'imcase_lat'		=> $this->input->post('lat'),
									'imcase_lng'		=> $this->input->post('lng')
							);
								
							$this->db->delete('immediate_cases', array('imcase_no' => $this->input->post('imcase_no')));
								
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
										
									$this->db->insert('immediate_cases', $data);
										
									//$this->db->where('imcase_no',$this->input->post('imcase_no'));
									//$this->db->update('immediate_cases, $data','imcase_no = ' . $this->input->post('imcase_no'));
	
									// updates last_visited_on at `household_address`
									$hh = array(
											'last_visited' => date('Y-m-d')
									);
	
									$this->db->where('household_id',$this->input->post('household_id'));
									$this->db->update('household_address', $hh);
										
									$returning_data = array($level, $symptoms);
										
									return $returning_data;
	}
	
	# TODO within 7 days
	function get_fever_count($household_id)
	{
		/*$this->db->select('count(household_id) as fever_house');
		 $this->db->from('immediate_cases');
		$this->db->join('catchment_area','immediate_cases.person_id = catchment_area.person_id');
		$this->db->where('catchment_area.household_id',$household_id);
		//$this->db->where("last_updated_on BETWEEN '$start_date' AND '$end_date'");
	
		$this->db->group_by('catchment_area.household_id');*/
			
		$query = $this->db->query("SELECT COUNT(household_id) as fever_house
						FROM
							(SELECT MAX(imcase_no), person_id, imcase_no, created_on
							FROM immediate_cases
	
							WHERE status != 'finished'
			
							GROUP BY person_id
							)ic
	
						JOIN catchment_area ca ON ic.person_id = ca.person_id"
				. " WHERE DATEDIFF(NOW(), ic.created_on) <= '7' AND ca.household_id = '" .
				$household_id
				.
				"' GROUP BY ca.household_id");
	
		//$query = $this->db->get();
	
	
		if ($query->num_rows() > 0)
		{
			$row = $query->row_array();
	
			return $row['fever_house'];
		}
		else
			return NULL;
	
		$query->free_result();
	}
	
	function check_person_fever($person_id)
	{
		$this->db->from('immediate_cases');
		$where = "imcase_no = (SELECT MAX(imcase_no) FROM immediate_cases WHERE person_id = '" . $person_id . "' AND DATEDIFF(NOW(), created_on) <= '7'
							AND status != 'finished')";
		$this->db->where($where);
	
		$query = $this->db->get();
		if ($query->num_rows() > 0)
		{
			return TRUE;
		}
		else
			return FALSE;
	}
	
	# TODO
	function check_person_hospitalized($person_id)//($f_name,$l_name,$sex,$dob)
	{
		$this->db->from('immediate_cases');
				$where = "imcase_no = (SELECT MAX(imcase_no) FROM immediate_cases WHERE person_id = '" . $person_id . "' AND DATEDIFF(NOW(), created_on) <= '7'
								AND status = 'hospitalized')";
				$this->db->where($where);
						
					$query = $this->db->get();
					if ($query->num_rows() > 0)
					{
					return TRUE;
		}
		else
			return FALSE;
			/*$this->db->from('immediate_cases');
		$this->db->join('master_list','master_list.person_id = immediate_cases.person_id');
		$this->db->join('catchment_area','master_list.person_id = catchment_area.person_id');
		$this->db->join('bhw','catchment_area.bhw_id = bhw.user_username');
		
		$this->db->where('master_list.person_first_name', $f_name);
		$this->db->where('master_list.person_last_name', $l_name);
		$this->db->where('master_list.person_sex', $sex);
		$this->db->where('master_list.person_dob', $dob);
		// + max cr_patient_no
		
		$query = $this->db->get();
		if ($query->num_rows() > 0)
		{
		$person_info = $query->row_array();
		$query->free_result();
			
		$this->db->from('case_report_main');
		$this->db->where('cr_first_name',$person_info['person_first_name']);
		$this->db->where('cr_last_name',$person_info['person_last_name']);
		$this->db->where('cr_sex',$person_info['person_sex']);
		$this->db->where('cr_dob',$person_info['person_dob']);
		
		$query = $this->db->get();
		if ($query->num_rows() > 0)
		{
		return TRUE;
		}
		else
			return FALSE;
		}
		else
			return FALSE;
		$query->free_result();*/
	}
	
	function count_fever_day($person_id)
	{
		$this->db->from('immediate_cases');
		$where = "imcase_no = (SELECT MAX(imcase_no) FROM immediate_cases WHERE person_id = '" . $person_id . "' AND DATEDIFF(NOW(), created_on) <= '7'
		AND status != 'finished')";
		$this->db->where($where);
		$query = $this->db->get();
			
			if ($query->num_rows() > 0)
			{
				$row = $query->row_array();
						
				return $row['days_fever'];
			}
		}
	
		function get_imcase_no($person_id)
			{
			$this->db->from('immediate_cases');
			$where = "imcase_no = (SELECT MAX(imcase_no) FROM immediate_cases WHERE person_id = '" . $person_id . "' AND DATEDIFF(NOW(), created_on) <= '7'
			AND status != 'finished' )";
		$this->db->where($where);
			$query = $this->db->get();
	
			if ($query->num_rows() > 0)
			{
				$row = $query->row_array();
						
					return $row['imcase_no'];
			}
		}
	
		function check_symptom_if_checked($person_id,$symptom)
			{
		$this->db->from('immediate_cases');
		$where = "imcase_no = (SELECT MAX(imcase_no) FROM immediate_cases WHERE person_id = '" . $person_id . "' AND DATEDIFF(NOW(), created_on) <= '7'
		AND status != 'finished')";
		$this->db->where($where);
	
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
	
		function get_suspected($person_id)
		{
		$this->db->from('immediate_cases');
		$where = "imcase_no = (SELECT MAX(imcase_no) FROM immediate_cases WHERE person_id = '" . $person_id . "' AND DATEDIFF(NOW(), created_on) <= '7'
		AND status != 'finished')";
		$this->db->where($where);
			
		$query = $this->db->get();
		if ($query->num_rows() > 0)
		{
			$row = $query->row_array();
		
				return $row['suspected_source'];
			}
		}
	
			function get_remarks($person_id)
		{
			$this->db->from('immediate_cases');
			$where = "imcase_no = (SELECT MAX(imcase_no) FROM immediate_cases WHERE person_id = '" . $person_id . "' AND DATEDIFF(NOW(), created_on) <= '7'
			AND status != 'finished')";
			$this->db->where($where);
	
			$query = $this->db->get();
			if ($query->num_rows() > 0)
			{
				$row = $query->row_array();
			
				return $row['remarks'];
			}
		}
	
		function get_created_on($person_id)
		{
			$this->db->from('immediate_cases');
			$where = "imcase_no = (SELECT MAX(imcase_no) FROM immediate_cases WHERE person_id = '" . $person_id . "' AND DATEDIFF(NOW(), created_on) <= '7'
				AND status != 'finished')";
				$this->db->where($where);
				
			$query = $this->db->get();
			if ($query->num_rows() > 0)
			{
				$row = $query->row_array();
			
				return $row['created_on'];
			}
		}
	
		function get_imcase_lat($person_id)
				{
			$this->db->from('immediate_cases');
			$where = "imcase_no = (SELECT MAX(imcase_no) FROM immediate_cases WHERE person_id = '" . $person_id . "' AND DATEDIFF(NOW(), created_on) <= '7'
				AND status != 'finished')";
			$this->db->where($where);
				
			$query = $this->db->get();
			if ($query->num_rows() > 0)
			{
			$row = $query->row_array();
				
			return $row['imcase_lat'];
			}
		}
	
		function get_imcase_lng($person_id)
			{
			$this->db->from('immediate_cases');
			$where = "imcase_no = (SELECT MAX(imcase_no) FROM immediate_cases WHERE person_id = '" . $person_id . "' AND DATEDIFF(NOW(), created_on) <= '7'
				AND status != 'finished')";
				$this->db->where($where);
		
			$query = $this->db->get();
				if ($query->num_rows() > 0)
				{
					$row = $query->row_array();
			
					return $row['imcase_lng'];
			}
		}
	
		function update_hospitalized()
		{
			$this->db->from('immediate_cases');
			$this->db->where('imcase_no',$this->input->post('imcase_no'));
					
				$query = $this->db->get();
				$row = $query->row_array();
	
				$data = array(
				'imcase_no'			=> $this->input->post('imcase_no'),
					'person_id'			=> $this->input->post('person_id'),
					'has_muscle_pain'	=> $row['has_muscle_pain'],
						'has_joint_pain'	=> $row['has_joint_pain'],
							'has_headache'		=> $row['has_headache'],
							'has_bleeding'		=> $row['has_bleeding'],
							'has_rashes'		=> $row['has_rashes'],
							'days_fever'		=> $row['days_fever'],
						'suspected_source'	=> $row['suspected_source'],
							'remarks'			=> $row['remarks'],
									'status'			=> 'finished',
									'created_on'		=> $this->input->post('created_on'),
						'imcase_lat'		=> $this->input->post('lat'),
						'imcase_lng'		=> $this->input->post('lng')
							);
								
			$this->db->delete('immediate_cases', array('imcase_no' => $this->input->post('imcase_no')));
		
						$this->db->set('last_updated_on', 'NOW()', FALSE);
	
						//$this->db->set('status','finished');
			// end status
		
			$this->db->insert('immediate_cases', $data);
		
			//$this->db->where('imcase_no',$this->input->post('imcase_no'));
				//$this->db->update('immediate_cases, $data','imcase_no = ' . $this->input->post('imcase_no'));
		}
}

/* End of im_case_model.php */
/* Location: ./application/models/im_case_model.php */