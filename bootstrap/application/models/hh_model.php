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
}


/* End of hh_model.php */
/* Location: ./application/models/hh_model.php */