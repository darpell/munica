<?php 
class Hh_model extends CI_Model
{
	function __construct()
	{
		// Call the Model constructor
		parent::__construct();
	}
	
	function add_to_visit($hh_id)
	{
		$input_data = array(
					'bhw_id'		=> $this->session->userdata('TPusername'),
					'household_id'	=> $hh_id,
					'created_on'	=> date('Y-m-d H:i:s')
				);
		
		$this->db->insert('to_visit',$input_data);
	}
	
	function get_to_visit_list($bhw)
	{
		$this->db->from('to_visit')
				->join('household_address','to_visit.household_id = household_address.household_id')
				->group_by('household_address.household_id')
				->order_by('created_on');
		
		$query = $this->db->get();
		
		return $query->result_array();
			$query->free_result();
	}
	
	function mark_visit($hh_id)
	{
		$this->check_if_in_to_visit($hh_id);
		$visit_data = array(
				'household_id'	=> $hh_id,
				'visit_date'	=> date('Y-m-d H:i:s')
			);
		
		$this->db->insert('house_visits', $visit_data);
		
		$query = $this->db->get_where('household_address',array('household_id' => $hh_id));
		
		return $query->row_array();
			$query->free_result();
	}
	
	function check_if_in_to_visit($hh_id)
	{
		$query = $this->db->get_where('to_visit', array('household_id' => $hh_id));
		
		if ($query->num_rows() > 0)
		{
			$this->db->delete('to_visit', array('household_id' => $hh_id));
		}
	}
	
	function get_visits($hh_id, $last = FALSE)
	{
		$this->db->from('house_visits')
				->join('household_address','household_address.household_id = house_visits.household_id')
				->where('house_visits.household_id', $hh_id)
				->order_by('visit_date', 'desc');
		
		if ($last == TRUE)
			$this->db->limit(1);
		
		$query = $this->db->get();
		return $query->row_array();
			$query->free_result();
	}
	
	function check_if_has_fever($person_id)
	{
		$query = $this->db->get_where('active_cases',array('person_id' => $person_id));
	
		return $query->row_array();
		$query->free_result();
	}
	
	function add_ca($hh_id, $person_id)
	{
		$input_data = array(
				'household_id'	=> $hh_id,
				'person_id'		=> $person_id,
				'bhw_id'		=> $this->session->userdata('TPusername'),
		);
	
		$this->db->insert('catchment_area',$input_data);
	}
	
	function add_household()
	{
		$input_data = array(
				'household_name'=>	$this->input->post('hh_name'),
				'household_lat'	=>	$this->input->post('lat'),
				'household_lng'	=>	$this->input->post('lng'),
				'house_no'		=>	$this->input->post('hh_no'),
				'street'		=>	$this->input->post('hh_street')
				//'last_visited'	=>	date("Y-m-d H:i:s")
		);
		$this->db->insert('household_address',$input_data);
	
		$hh_id = $this->db->insert_id();
		
		$visits_input = array(
					'household_id'	=> $hh_id,
					'visit_date'	=> date("Y-m-d H:i:s")
				);
		$this->db->insert('house_visits',$visits_input);
		
		$this->add_hh_member($hh_id);
	}
	
	function add_hh_member($hh_id)
	{
		$input_data = array(
				'person_first_name'	=>	$this->input->post('hh_fname'),
				'person_last_name'	=>	$this->input->post('hh_lname'),
				'person_dob'		=>	$this->input->post('hh_dob'),
				'person_sex'		=>	$this->input->post('hh_gender'),
				'person_marital'	=>	$this->input->post('hh_marital'),
				'person_nationality'=>	$this->input->post('hh_nationality'),
				'person_blood_type'	=>	$this->input->post('hh_blood'),
				'person_guardian'	=>	$this->input->post('hh_guardian'),
				'person_adu'		=>	'Alive',
				'person_contactno'	=>	$this->input->post('hh_contact'),
				'person_landline'	=> 	$this->input->post('hh_landline'),
				'person_email'		=> 	$this->input->post('hh_email'),
				'person_fb'			=> 	$this->input->post('hh_fb'),
				'person_tw'			=> 	$this->input->post('hh_tw'),
				'person_ym'			=> 	$this->input->post('hh_ym'),
		);
		$this->db->insert('master_list',$input_data);
		
		$person_id = $this->db->insert_id();
		
		$this->add_ca($hh_id,$person_id);
	}
	
	function get_hh_count($user = FALSE)
	{
		$this->db->select('count(*) as total');
		$this->db->from('household_address');
		
		if ($user != NULL)
		{
			$this->db->join('catchment_area','household_address.household_id = catchment_area.household_id');
			$this->db->where('bhw_id',$user);
		}
	
		$query = $this->db->get();
		if ($query->num_rows() > 0)
		{
			$row = $query->row_array();
				
			return $row['total'];
		}
	}
	
	function get_cases($bhw = FALSE, $hh_id = FALSE)
	{
		$this->db->from('active_cases')
					->join('catchment_area','active_cases.person_id = catchment_area.person_id');
		
		if ($bhw != FALSE)
			$this->db->where('bhw_id',$bhw);
		if ($hh_id != FALSE)
			$this->db->where('household_id',$hh_id);
		
		$query = $this->db->get();
		return $query->result_array();
		$query->free_result();
	}
	
	function get_catchment_area_limitless($brgy)
	{
		$this->db->from('catchment_area')
			->join('bhw','catchment_area.bhw_id = bhw.user_username')
			->where('bhw.barangay', $brgy)
			->group_by('catchment_area.bhw_id');
	
		$query = $this->db->get();
		return $query->result_array();
		$query->free_result();
	}
	
	function get_catchment_area($brgy, $offset, $limit)
	{
		$this->db->from('catchment_area')
					->join('bhw','catchment_area.bhw_id = bhw.user_username')
					->where('bhw.barangay', $brgy)
					->group_by('catchment_area.bhw_id')
					->limit($offset, $limit);
		
		$query = $this->db->get();
		return $query->result_array();
			$query->free_result();
	}
	
	function get_hh_midwife($mw)
	{
		$query = $this->db->get_where('bhw', array('user_username' => $mw));
		
		$brgy = $query->row_array();
		
		return $this->get_catchment_area($brgy['barangay']);
	}
	
	function get_households_limitless($bhw)
	{
		$this->db->from('catchment_area')
		->join('bhw','catchment_area.bhw_id = bhw.user_username')
		->join('household_address', 'household_address.household_id = catchment_area.household_id')
		->join('house_visits','catchment_area.household_id = house_visits.household_id')
		->where('catchment_area.bhw_id', $bhw);
	
		$this->db->order_by('household_address.household_name');
		$this->db->group_by('catchment_area.household_id');
	
		$query = $this->db->get();
		return $query->result_array();
	}		
	
	function get_households($bhw, $offset, $limit)
	{
		$this->db->from('catchment_area')
					->join('bhw','catchment_area.bhw_id = bhw.user_username')
					->join('household_address', 'household_address.household_id = catchment_area.household_id')
					->join('house_visits','catchment_area.household_id = house_visits.household_id')
					->where('catchment_area.bhw_id', $bhw)
					->order_by('household_address.household_name')
					->group_by('catchment_area.household_id')
					->limit($offset, $limit);
		
		$query = $this->db->get();
		return $query->result_array();
			$query->free_result();
	}
	
	function get_people_limitless($hh)
	{
		$this->db->from('catchment_area')
		->join('bhw','catchment_area.bhw_id = bhw.user_username')
		->join('master_list', 'master_list.person_id = catchment_area.person_id')
		->join('household_address','catchment_area.household_id = household_address.household_id')
		->where('catchment_area.household_id', $hh);
	
		$query = $this->db->get();
		return $query->result_array();
		$query->free_result();
	}
	
	function get_people($hh, $offset, $limit)
	{
		$this->db->from('catchment_area')
					->join('bhw','catchment_area.bhw_id = bhw.user_username')
					->join('master_list', 'master_list.person_id = catchment_area.person_id')
					->join('household_address','catchment_area.household_id = household_address.household_id')
					->where('catchment_area.household_id', $hh)
					->limit($offset, $limit);
		
		$query = $this->db->get();
		return $query->result_array();
		$query->free_result();
	}
	
	function get_person($id)
	{
		$query = $this->db->get_where('master_list', array('person_id' => $id));
		
		return $query->row_array();
		$query->free_result();
	}
	
	function get_household($id)
	{
		$query = $this->db->get_where('household_address', array('household_id' => $id));
		
		return $query->row_array();
		$query->free_result();
	}
	
	function update_person($id, $data)
	{
		$this->db->where('person_id', $id);
		$this->db->update('master_list', $data);
	}
}


/* End of hh_model.php */
/* Location: ./application/models/hh_model.php */