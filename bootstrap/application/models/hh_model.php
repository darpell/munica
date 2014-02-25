<?php 
class Hh_model extends CI_Model
{
	function __construct()
	{
		// Call the Model constructor
		parent::__construct();
	}
	
	function get_hh_count()
	{
		$this->db->select('count(*) as total');
		$this->db->from('household_address');
	
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
	
	function get_catchment_area($brgy = FALSE, $offset = FALSE, $limit = FALSE)
	{
		$this->db->from('catchment_area')
					->join('bhw','catchment_area.bhw_id = bhw.user_username');
		if ($brgy != FALSE)
			$this->db->where('bhw.barangay', $brgy);
		
		$this->db->group_by('catchment_area.bhw_id');
		
		if ($offset != FALSE && $limit != FALSE)
			$this->db->limit($offset, $limit);
		
		$query = $this->db->get();
		return $query->result_array();
			$query->free_result();
	}
	
	function get_households($bhw = FALSE, $offset = FALSE, $limit = FALSE)
	{
		$this->db->from('catchment_area')
					->join('bhw','catchment_area.bhw_id = bhw.user_username')
					->join('household_address', 'household_address.household_id = catchment_area.household_id');
		/*
		if ($brgy != FALSE)
			$this->db->where('bhw.barangay', $brgy);
		*/
		if ($bhw != FALSE)
			$this->db->where('catchment_area.bhw_id', $bhw);
		
		$this->db->group_by('catchment_area.household_id');
		
		if ($offset != FALSE && $limit != FALSE)
			$this->db->limit($offset, $limit);
		
		$query = $this->db->get();
		return $query->result_array();
			$query->free_result();
	}
	
	function get_people($hh = FALSE, $offset = FALSE, $limit = FALSE)
	{
		$this->db->from('catchment_area')
					->join('bhw','catchment_area.bhw_id = bhw.user_username')
					->join('master_list', 'master_list.person_id = catchment_area.person_id');
		/*
			if ($bhw != FALSE)
				$this->db->where('catchment_area.bhw_id', $bhw);
		*/
		if ($hh != FALSE)
			$this->db->where('catchment_area.household_id', $hh);
		
		if ($offset != FALSE && $limit != FALSE)
			$this->db->limit($offset, $limit);
		
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
	
	function check_if_has_fever($person_id)
	{
		$query = $this->db->get_where('active_cases',array('person_id' => $person_id));
		
		return $query->row_array();
		$query->free_result();
	}
}


/* End of hh_model.php */
/* Location: ./application/models/hh_model.php */