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
		
		$this->db->group_by('point_no');
		$this->db->order_by('point_no','asc');
		
		$query = $this->db->get();
		return $query->result_array();
			$query->free_result();
	}
}

/* End of map_temp_model.php */
/* Location: ./application/models/map_temp_model.php */