<?php 

class Threshold_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		//load monica database
		$this->load->database('default');
	}
	function get_user_barangay($userid)
	{
		$where = "*
			FROM (`bhw`)
			WHERE user_username = '".$userid."'";
		$this->db->select($where,false);
		$q = $this->db->get();
		if($q->num_rows() > 0)
		{
			foreach ($q->result() as $row)
			{
				$data = $row->barangay;
			}
			return $data;
		}
		else return null;
			
	}
	function getAllBarangays()
	{
		$data =[];
		$this->db->select('barangay')
					->from('barangay')
					->group_by('barangay');
		$query = $this->db->get();
		
		if ($query->num_rows() > 0)
		{
			foreach ($query->result() as $row)
				{ 
					$data[]= $row->barangay;
				}
		}
		return $data;
	}
	
	function epidemic_threshold($year = FALSE, $month = FALSE, $brgy = FALSE)
	{
		$count = 0;
		
		$this->db->select('count(cr_barangay) as total_count')
					->from('case_report_main');
		
		if ($year != FALSE) $this->db->where('YEAR(cr_date_onset) = ' . $year);
		if ($month != FALSE) $this->db->where('MONTH(cr_date_onset) = ' . $month);
		if ($brgy != FALSE) $this->db->where("cr_barangay = '" . $brgy."'");
		
		$query = $this->db->get();
		if ($query->num_rows() > 0)
		{
			$row = $query->row_array();
			$count += $row['total_count'];
		}
		$query->free_result();
		
		$this->db->select('count(previous_cases.person_id) as total_count')
		->from('previous_cases');
		$this->db->join('master_list', 'master_list.person_id = previous_cases.person_id');
		$this->db->join('catchment_area', 'catchment_area.person_id = previous_cases.person_id');
		$this->db->join('bhw', 'bhw.user_username = catchment_area.bhw_id');
		$this->db->join('household_address', 'household_address.household_id = catchment_area.household_id');
		
		if ($year != FALSE) $this->db->where('YEAR(created_on) = ' . $year);
		if ($month != FALSE) $this->db->where('MONTH(created_on) = ' . $month);
		if ($brgy != FALSE) $this->db->where("barangay = '" . $brgy."'");
		
		$query = $this->db->get();
		if ($query->num_rows() > 0)
		{
			$row = $query->row_array();
			$count += $row['total_count'];
		}
		$query->free_result();
		
		$this->db->select('count(active_cases.person_id) as total_count')
		->from('active_cases');
		$this->db->join('master_list', 'master_list.person_id = active_cases.person_id');
		$this->db->join('catchment_area', 'catchment_area.person_id = active_cases.person_id');
		$this->db->join('bhw', 'bhw.user_username = catchment_area.bhw_id');
		$this->db->join('household_address', 'household_address.household_id = catchment_area.household_id');
		
		if ($year != FALSE) $this->db->where('YEAR(created_on) = ' . $year);
		if ($month != FALSE) $this->db->where('MONTH(created_on) = ' . $month);
		if ($brgy != FALSE) $this->db->where("barangay = '" . $brgy."'");
		
		$query = $this->db->get();
		if ($query->num_rows() > 0)
		{
			$row = $query->row_array();
			$count += $row['total_count'];
		}
		$query->free_result();
		
		
		
		return $count;
		
	}
}

/* End of threshold_model.php */
/* Location: ./application/models/threshold_model.php */