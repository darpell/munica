<?php

class Barangay_model extends CI_Model
{
	function __construct()
	{
		// Call the Model constructor
		parent::__construct();
	}
	
	function get_brgys($city = FALSE)
	{
		$query = $this->db->get('barangay');
		
		return $query->result_array();
			$query->free_result();
	}

}

/* End of barangay_model.php */
/* Location: ./application/models/barangay_model.php */