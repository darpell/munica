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
	
	function get_catchment_area($brgy = FALSE)
	{
		$this->db->from('catchment_area')
					->join('bhw','catchment_area.bhw_id = bhw.user_username');
		if ($brgy != FALSE)
			$this->db->where('bhw.barangay', $brgy);
		
		$this->db->group_by('catchment_area.bhw_id');
		
		$query = $this->db->get();
		return $query->result_array();
			$query->free_result();
	}
	
	function get_households($brgy = FALSE, $bhw = FALSE)
	{
		$this->db->from('catchment_area')
					->join('bhw','catchment_area.bhw_id = bhw.user_username');
		if ($brgy != FALSE)
			$this->db->where('bhw.barangay', $brgy);
		if ($bhw != FALSE)
			$this->db->where('catchment_area.bhw_id', $bhw);
		
		$this->db->group_by('catchment_area.household_id');
		
		$query = $this->db->get();
		return $query->result_array();
			$query->free_result();
	}
	
	function get_people($bhw = FALSE, $hh = FALSE)
	{
		$this->db->from('catchment_area')
					->join('bhw','catchment_area.bhw_id = bhw.user_username');
		if ($bhw != FALSE)
			$this->db->where('catchment_area.bhw_id', $bhw);
		if ($hh != FALSE)
			$this->db->where('catchment_area.household_id', $hh);
		
		$query = $this->db->get();
		return $query->result_array();
		$query->free_result();
	}
}


/* End of hh_model.php */
/* Location: ./application/models/hh_model.php */