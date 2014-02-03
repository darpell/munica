<?php 

class Threshold_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		//load monica database
		$this->load->database('default');
	}
	
	function getAllBarangays()
	{
		$this->db->select('barangay')
					->from('barangay')
					->group_by('barangay');
		
		return $this->db->get()->result_array();
	}
	
	function epidemic_threshold($year = FALSE, $month = FALSE, $brgy = FALSE)
	{
		$this->db->select('count(cr_barangay) as total_count')
					->from('case_report_main');
		
		if ($year != FALSE) $this->db->where('YEAR(cr_date_onset) = ' . $year);
		if ($month != FALSE) $this->db->where('MONTH(cr_date_onset) = ' . $month);
		if ($brgy != FALSE) $this->db->where('cr_barangay = ' . $brgy);
		
		$query = $this->db->get();
		if ($query->num_rows() > 0)
		{
			$row = $query->row_array();
			return $row['total_count'];
		}
		else
			return FALSE;
	}
}

/* End of threshold_model.php */
/* Location: ./application/models/threshold_model.php */