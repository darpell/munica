<?php 
class Cases_model extends CI_Model
{
	function __construct()
	{
		// Call the Model constructor
		parent::__construct();
	}
	
	function get_cases($type, $offset, $limit)
	{
		$this->db->from('immediate_cases')
					->join('master_list','immediate_cases.person_id = master_list.person_id')
					->where('status',$type)
					->limit($offset,$limit);
		
		$query = $this->db->get();
		return $query->result_array();
		$query->free_result();
	}
}


/* End of cases_model.php */
/* Location: ./application/models/cases_model.php */