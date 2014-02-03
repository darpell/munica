<?php 
class Cases_model extends CI_Model
{
	function __construct()
	{
		// Call the Model constructor
		parent::__construct();
	}
	
	function get_suspected_cases($offset, $limit)
	{
		$query = $this->db->get_where('immediate_cases',array('status' => 'suspected'),$offset,$limit);
		return $query->result_array();
		$query->free_result();
	}
	
	function get_threatening_cases($offset, $limit)
	{
		$query = $this->db->get_where('immediate_cases',array('status' => 'threatening'),$offset,$limit);
		return $query->result_array();
		$query->free_result();
	}
	
	function get_serious_cases($offset, $limit)
	{
		$query = $this->db->get_where('immediate_cases',array('status' => 'serious'),$offset,$limit);
		return $query->result_array();
		$query->free_result();
	}
	
	function get_hospitalized_cases($offset, $limit)
	{
		$query = $this->db->get_where('immediate_cases',array('status' => 'hospitalized'),$offset,$limit);
		return $query->result_array();
		$query->free_result();
	}
}


/* End of cases_model.php */
/* Location: ./application/models/cases_model.php */