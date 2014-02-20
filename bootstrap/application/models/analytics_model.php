<?php 
	
	class Analytics_model extends CI_Model
	{
		function __construct()
		{
			parent::__construct();
			//load monica database
			$this->load->database('default');
		}
		function get_barangays()
		{
			$data[] = 'LANGKAAN II';
			$data[] = 'SAN AGUSTIN I';
			$data[] = 'SAN AGUSTIN III';
			$data[] = 'SAMPALOC I';
			return $data;
		}
		function get_all_cases_count($brgy = null)
		{	
			$where = "MIN(YEAR(cr_date_onset)) as yearmin
			FROM (`case_report_main`) ";
			$this->db->select($where);
			$q = $this->db->get();
			if($q->num_rows() > 0)
			{
				foreach ($q->result() as $row)
				{ 
					$data['yearstart']= $row->yearmin;
				}
			}
			$q->free_result();
			
			
			for($i=$data['yearstart'];$i<=DATE('Y');$i++)
			{
				for ($s= 1;$s<=12;$s++)
				{
					$data[$i][$s]=0;
				}
			}
			if($brgy == null)
			{

			$where = "count(cr_barangay) as patientcount ,YEAR(cr_date_onset) as caseyear,   
					Month(cr_date_onset) as casemonth 
					FROM (`case_report_main`)
					GROUP BY YEAR(`cr_date_onset`),MONTH(`cr_date_onset`)";
			$this->db->select($where);
			$q = $this->db->get();
			$yearstart= 0;
			if($q->num_rows() > 0)
			{
				foreach ($q->result() as $row)
				{ $x = $row->caseyear;
				  $y = $row->casemonth;
					$data[$x][$y] += $row->patientcount;
				}
			}
			$q->free_result();
			
			$where = "count(imcase_no) as patientcount ,YEAR(immediate_cases.created_on) as caseyear,
				Month(immediate_cases.created_on) as casemonth 
				FROM (`immediate_cases`) 
				JOIN `master_list` ON `master_list`.`person_id` = `immediate_cases`.`person_id` 
				JOIN `catchment_area` ON `master_list`.`person_id` = `catchment_area`.`person_id` 
				JOIN `bhw` ON `catchment_area`.`bhw_id` = `bhw`.`user_username` 
				JOIN `household_address` ON `catchment_area`.`household_id` = `household_address`.`household_id` 
				GROUP BY   YEAR( created_on ) ,MONTH( created_on )";
			$this->db->select($where);
			$q = $this->db->get();
			$yearstart= 0;
			if($q->num_rows() > 0)
			{
				foreach ($q->result() as $row)
				{ $x = $row->caseyear;
				$y = $row->casemonth;
				$data[$x][$y] += $row->patientcount;
				}
			}
			$q->free_result();
			

			}
			else 
			{
				$where = "count(cr_barangay) as patientcount ,YEAR(cr_date_onset) as caseyear,
					Month(cr_date_onset) as casemonth
					FROM (`case_report_main`)
					WHERE cr_barangay= '". $brgy ."'
					GROUP BY YEAR(`cr_date_onset`),MONTH(`cr_date_onset`)";
				$this->db->select($where);
				$q = $this->db->get();
				$yearstart= 0;
				if($q->num_rows() > 0)
				{
					foreach ($q->result() as $row)
					{ $x = $row->caseyear;
					$y = $row->casemonth;
					$data[$x][$y] += $row->patientcount;
					}
				}
				$q->free_result();
					
				$where = "count(imcase_no) as patientcount ,YEAR(immediate_cases.created_on) as caseyear,
				Month(immediate_cases.created_on) as casemonth
				FROM (`immediate_cases`)
				JOIN `master_list` ON `master_list`.`person_id` = `immediate_cases`.`person_id`
				JOIN `catchment_area` ON `master_list`.`person_id` = `catchment_area`.`person_id`
				JOIN `bhw` ON `catchment_area`.`bhw_id` = `bhw`.`user_username`
				JOIN `household_address` ON `catchment_area`.`household_id` = `household_address`.`household_id`
				WHERE barangay= '". $brgy ."'
				GROUP BY   YEAR( created_on ) ,MONTH( created_on )";
				$this->db->select($where);
				$q = $this->db->get();
				$yearstart= 0;
				if($q->num_rows() > 0)
				{
					foreach ($q->result() as $row)
					{ $x = $row->caseyear;
					$y = $row->casemonth;
					$data[$x][$y] += $row->patientcount;
					}
				}
				$q->free_result();
					
			}
			$data['casecount'] = '';
			for($i=$data['yearstart'];$i<=DATE('Y');$i++)
			{
			for ($s= 1;$s<=12;$s++)
			{
			$data['casecount'] .= $data[$i][$s] . ',';
			}
			}
			
			return $data;
			
		}
		function get_all_cases_data($startdate, $enddate)
		{
	
		
			$where = " * FROM (`case_report_main`)
					WHERE cr_date_onset BETWEEN '".$startdate."'  AND '".$enddate."' ";
			$this->db->select($where,false);
			$q = $this->db->get();
			$yearstart= 0;
			if($q->num_rows() > 0)
			{
 				$data['casereport'] = $q->result_array();
			}
			else 
				$data['casereport'] = null;
			$q->free_result();
				
			$where = " *
				FROM (`immediate_cases`)
				JOIN `master_list` ON `master_list`.`person_id` = `immediate_cases`.`person_id`
				JOIN `catchment_area` ON `master_list`.`person_id` = `catchment_area`.`person_id`
				JOIN `bhw` ON `catchment_area`.`bhw_id` = `bhw`.`user_username`
				JOIN `household_address` ON `catchment_area`.`household_id` = `household_address`.`household_id`
				WHERE created_on BETWEEN '".$startdate."'  AND '".$enddate."' ";
				$this->db->select($where , false);
				$q = $this->db->get();
				
					if($q->num_rows() > 0)
					{ 
						$data['immecase'] = $q->result_array();
					}
					else
						$data['immecase'] = null;
					$q->free_result();
						
		

			return $data;
							
		}
		function get_all_larval_count($brgy = null)
		{
			$where = "MIN(YEAR(created_on)) as yearmin
			FROM (`ls_report`) ";
			$this->db->select($where);
			$q = $this->db->get();
			if($q->num_rows() > 0)
			{
				foreach ($q->result() as $row)
				{
					$data['yearstart']= $row->yearmin;
				}
			}
			$q->free_result();
				
				
			for($i=$data['yearstart'];$i<=DATE('Y');$i++)
			{
			for ($s= 1;$s<=12;$s++)
			{
			$data[$i][$s]=0;
			}
			}
			if($brgy == null)
			{
		
			$where = "count(ls_no) as count ,YEAR(created_on) as caseyear,
				Month(created_on) as casemonth
				FROM (`ls_report`)
				GROUP BY YEAR(`created_on`),MONTH(`created_on`)";
			$this->db->select($where);
			$q = $this->db->get();
			$yearstart= 0;
			if($q->num_rows() > 0)
			{
			foreach ($q->result() as $row)
			{ $x = $row->caseyear;
			$y = $row->casemonth;
			$data[$x][$y] += $row->count;
			}
			}
			$q->free_result();
			
			}
			else
			{
				$where = "count(ls_no) as count ,YEAR(created_on) as caseyear,
				Month(created_on) as casemonth
				FROM (`ls_report`)
				WHERE ls_barangay ='".$brgy."'
				GROUP BY YEAR(`created_on`),MONTH(`created_on`)";
				$this->db->select($where);
				$q = $this->db->get();
				$yearstart= 0;
				if($q->num_rows() > 0)
				{
					foreach ($q->result() as $row)
					{ $x = $row->caseyear;
					$y = $row->casemonth;
					$data[$x][$y] += $row->count;
					}
				}
				$q->free_result();
			}
			$data['larvalcount'] = '';
			for($i=$data['yearstart'];$i<=DATE('Y');$i++)
			{
			for ($s= 1;$s<=12;$s++)
			{
				$data['larvalcount'] .= $data[$i][$s] . ',';
				}
				}
							
			return $data;
							
		}
		function get_all_person_data()
		{

			$where = "*
				FROM (`master_list`)
				JOIN `catchment_area` ON `master_list`.`person_id` = `catchment_area`.`person_id`
				JOIN `bhw` ON `catchment_area`.`bhw_id` = `bhw`.`user_username`
				JOIN `household_address` ON `catchment_area`.`household_id` = `household_address`.`household_id`";
			
			$this->db->select($where,false);
			$q = $this->db->get();
			if($q->num_rows() > 0)
			{
				$data = $q->result_array();
			}
			$q->free_result();
			return $data;
		}
		
	}

	
/* End of master_list_model.php */
/* Location: ./application/models/master_list_model.php */
