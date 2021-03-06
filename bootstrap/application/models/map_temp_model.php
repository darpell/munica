<?php 

class Map_temp_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		//load monica database
		$this->load->database('default');
	}
	
	function get_map_nodes($type = FALSE)
	{
		$this->db->from('map_nodes');
		
		if ($type != FALSE)
				$this->db->where('node_type',$type);
		
		$query = $this->db->get();
		return $query->result_array();
			$query->free_result();
	}
	
	function get_brgys($brgy = FALSE)
	{
		$this->db->from('map_polygons')
				->join('bhw','map_polygons.polygon_name = bhw.barangay');
		
		if ($brgy != FALSE)
			$this->db->where('bhw.barangay',$brgy);
		
		$this->db->order_by('point_no','asc');
		
		$query = $this->db->get();
		return $query->result_array();
			$query->free_result();
	}
	
	function get_households($bhw = FALSE)
	{
		$this->db->from('household_address')
				->join('catchment_area','household_address.household_id = catchment_area.household_id')
				->join('bhw', 'catchment_area.bhw_id = bhw.user_username')
				->group_by('household_address.household_id');
		
		if ($bhw != FALSE)
			$this->db->where('bhw_id',$bhw);
			
		$query = $this->db->get();
		return $query->result_array();
			$query->free_result();
	}
	
	function get_all_cases($start = FALSE, $end = FALSE)
	{
		$this->db->from('previous_cases')
				->join('catchment_area', 'catchment_area.person_id = previous_cases.person_id')
				->join('household_address', 'household_address.household_id = catchment_area.household_id');
		
		if ($start != FALSE && $end != FALSE)
			$this->db->where("created_on BETWEEN '$start' AND '$end'");

		$query = $this->db->get();
		
		$previous_cases = $query->result_array();
		
		$this->db->from('previous_cases')
				->join('catchment_area', 'catchment_area.person_id = previous_cases.person_id')
				->join('household_address', 'household_address.household_id = catchment_area.household_id');
		
		
		if ($start != FALSE && $end != FALSE)
			$this->db->where("created_on BETWEEN '$start' AND '$end'");
		
		$query2 = $this->db->get();
		
		$active_cases = $query->result_array();
		
		return array_merge($previous_cases, $active_cases);
	}
}

/* End of map_temp_model.php */
/* Location: ./application/models/map_temp_model.php */