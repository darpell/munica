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
			FROM (`case_report_main`) 
					WHERE YEAR(cr_date_onset) < ".date('Y')."";
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
					WHERE YEAR(`cr_date_onset`) < ".date('Y')."
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
			
			$where = "count(imcase_no) as patientcount ,YEAR(active_cases.created_on) as caseyear,
				Month(active_cases.created_on) as casemonth 
				FROM (`active_cases`) 
				JOIN `master_list` ON `master_list`.`person_id` = `active_cases`.`person_id` 
				JOIN `catchment_area` ON `master_list`.`person_id` = `catchment_area`.`person_id` 
				JOIN `bhw` ON `catchment_area`.`bhw_id` = `bhw`.`user_username` 
				JOIN `household_address` ON `catchment_area`.`household_id` = `household_address`.`household_id` 
				WHERE YEAR(created_on) < ".date('Y')."
				GROUP BY   YEAR(created_on) ,MONTH(created_on)";
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
			
			$where = "count(imcase_no) as patientcount ,YEAR(previous_cases.created_on) as caseyear,
				Month(previous_cases.created_on) as casemonth
				FROM (`previous_cases`)
				JOIN `master_list` ON `master_list`.`person_id` = `previous_cases`.`person_id`
				JOIN `catchment_area` ON `master_list`.`person_id` = `catchment_area`.`person_id`
				JOIN `bhw` ON `catchment_area`.`bhw_id` = `bhw`.`user_username`
				JOIN `household_address` ON `catchment_area`.`household_id` = `household_address`.`household_id`
				WHERE YEAR(created_on) < ".date('Y')."
				GROUP BY   YEAR(created_on) ,MONTH(created_on)";
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
					
				$where = "count(imcase_no) as patientcount ,YEAR(active_cases.created_on) as caseyear,
				Month(active_cases.created_on) as casemonth
				FROM (`active_cases`)
				JOIN `master_list` ON `master_list`.`person_id` = `active_cases`.`person_id`
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
				
				$where = "count(imcase_no) as patientcount ,YEAR(previous_cases.created_on) as caseyear,
				Month(active_cases.created_on) as casemonth
				FROM (`previous_cases`)
				JOIN `master_list` ON `master_list`.`person_id` = `previous_cases`.`person_id`
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
			$data['max'] = 0;
			$data['max_mon']=null;
			$data['max_year']=null;
			
			$data['casecount'] = '';
			for($i=$data['yearstart'];$i<=DATE('Y');$i++)
			{
			for ($s= 1;$s<=12;$s++)
			{
			$data['casecount'] .= $data[$i][$s] . ',';
			
			if($data[$i][$s] >=$data['max'] )
			{
				$data['max'] = $data[$i][$s];
				$data['max_mon']=$s;
				$data['max_year']=$i;
			}
			
			
			}
			}
			
			return $data;	
		}
		function get_all_death_count()
		{
			$where = "MIN(YEAR(cr_date_onset)) as yearmin
			FROM (`case_report_main`)
					WHERE YEAR(cr_date_onset) < ".date('Y')."";
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
			
			$where = " count(cr_patient_no) as deaths , YEAR(cr_date_onset) as caseyear,
					Month(cr_date_onset) as casemonth
					FROM case_report_main
					WHERE YEAR(`cr_date_onset`) < ".date('Y')."
					AND cr_outcome = 'D'
					GROUP BY YEAR(`cr_date_onset`), MONTH(`cr_date_onset`)";
				
			$this->db->select($where,false);
			$q = $this->db->get();
			$yearstart= 0;
			if($q->num_rows() > 0)
			{
				foreach ($q->result() as $row)
				{ $x = $row->caseyear;
				  $y = $row->casemonth;
					$data[$x][$y] += $row->deaths;
				}
			}
			$data['count'] = '';
			for($i=$data['yearstart'];$i<=DATE('Y');$i++)
			{
				for ($s= 1;$s<=12;$s++)
				{
					$data['count'] .= $data[$i][$s] . ',';
								
								
				}
			}
				
			return $data;
		
		}
		function get_death_count($mon,$year)
		{
			$where = " count(cr_patient_no) as deaths , cr_barangay FROM (`case_report_main`)
					WHERE YEAR(cr_date_onset) =".$year." AND MONTH(cr_date_onset) =".$mon."
					AND cr_outcome = 'D'
					GROUP BY cr_barangay ";
			
			$this->db->select($where,false);
			$q = $this->db->get();
			$yearstart= 0;
			if($q->num_rows() > 0)
			{
				$data= $q->result_array();
			}
			return $data;
			
		}
		function get_death_count_daterange ($startdate = null,$enddate = null)
		{
			if($startdate == null or $enddate == null)
			{
				$where = " count(cr_patient_no) as deaths , cr_barangay FROM (`case_report_main`)
					WHERE  cr_outcome = 'D'
					GROUP BY cr_barangay ";
				
				$this->db->select($where,false);
				$q = $this->db->get();
				$yearstart= 0;
				if($q->num_rows() > 0)
				{
					$data= $q->result_array();
				}
				else 
				$data = null;
			}
			else
			{
			$where = " count(cr_patient_no) as deaths , cr_barangay FROM (`case_report_main`)
					WHERE cr_date_onset BETWEEN '".$startdate."'  AND '".$enddate."' 
					AND cr_outcome = 'D'
					GROUP BY cr_barangay ";
				
			$this->db->select($where,false);
			$q = $this->db->get();
			$yearstart= 0;
			if($q->num_rows() > 0)
			{
				$data= $q->result_array();
			}
			else
			$data = null;
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
				
			
			$data['immecase'] = null;
			
			$where = " *
				FROM (`active_cases`)
				JOIN `master_list` ON `master_list`.`person_id` = `active_cases`.`person_id`
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
					
					$q->free_result();
					
					$where = " *
				FROM (`previous_cases`)
				JOIN `master_list` ON `master_list`.`person_id` = `previous_cases`.`person_id`
				JOIN `catchment_area` ON `master_list`.`person_id` = `catchment_area`.`person_id`
				JOIN `bhw` ON `catchment_area`.`bhw_id` = `bhw`.`user_username`
				JOIN `household_address` ON `catchment_area`.`household_id` = `household_address`.`household_id`
				WHERE created_on BETWEEN '".$startdate."'  AND '".$enddate."' ";
					$this->db->select($where , false);
					$q = $this->db->get();
					
					if($q->num_rows() > 0)
					{
						$data['immecase']=array_merge($data['immecase'],$q->result_array());
					}
						
					$q->free_result();
						
		

			return $data;
							
		}
		function get_household_count($weekno)
		{
			$where = " *
				FROM (`active_cases`)
				JOIN `master_list` ON `master_list`.`person_id` = `active_cases`.`person_id`
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
			FROM (`ls_report`)
			WHERE YEAR(created_on) < ".date('Y')." ";
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
				WHERE YEAR(created_on) < ".date('Y')."
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
				WHERE YEAR(created_on) < ".date('Y')." AND ls_barangay ='".$brgy."'
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
			$data['max'] = 0;
			$data['max_mon']=null;
			$data['max_year']=null;
			$data['larvalcount'] = '';
			for($i=$data['yearstart'];$i<=DATE('Y');$i++)
			{
			for ($s= 1;$s<=12;$s++)
				{
				$data['larvalcount'] .= $data[$i][$s] . ',';
				
				if($data[$i][$s]>=$data['max'])
				{
					$data['max'] = $data[$i][$s];
					$data['max_mon']=$s;
					$data['max_year']=$i;
				}
				
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
		function get_summary_count($weekno , $brgy = null)
		{
			$brgys = $this->get_barangays();
			
			$data['total'] = 0;
			
			$gender['F'] = 0;
			$gender['M'] = 0;
			
			for($i = $weekno-4; $i<=$weekno; $i++)
			{
			
				for($s = date('Y')-5; $s<=date('Y'); $s++)
				{
				$data[$s][$i] = 0;
					foreach($brgys as $row)
					{
					$data[$row][$s][$i]=0;
					}
				
				}
				
				
				for($a = 0; $a < 5; $a ++)
				{
					$agegroup[$i][$a] = 0;
				}
				
				
				$average[$i] = 0;  
			}
			
			if($brgy == null){
			$where = "count(cr_barangay) as patientcount ,YEAR(cr_date_onset) as caseyear,   
						WEEK(cr_date_onset) as caseweek, cr_barangay, cr_age DIV 10 as agegroup, cr_sex
					

						FROM (`case_report_main`)
						WHERE WEEK(`cr_date_onset`) between ".$weekno."-4 AND ".$weekno." AND
						(YEAR(`cr_date_onset`) between ".date('Y')."-5 AND  ".date('Y').") 
						GROUP BY YEAR(`cr_date_onset`),WEEK(`cr_date_onset`), cr_barangay, agegroup, cr_sex
					";
			}
			$this->db->select($where,false);
			$q = $this->db->get();
			if($q->num_rows() > 0)
			{
				foreach ($q->result() as $row)
				{
					$data[$row->caseyear][$row->caseweek] +=$row->patientcount;
					if($row->caseyear != date('Y'))
					$average[$row->caseweek] += $row->patientcount;
					else
					{
						$data['total'] += $row->patientcount;
						if($row->agegroup < 3)
						$agegroup[$row->caseweek][$row->agegroup]++;
						else 
						$agegroup[$row->caseweek][3]++;
						
							if($row->cr_sex == 'F')
							{
								$gender['F']++;
							}
							else if ($row->cr_sex == 'M'){
								$gender['M']++;
							}
					}
					foreach($brgys as $temp)
					{
						if($temp == $row->cr_barangay)
						{
							$data[$temp][$row->caseyear][$row->caseweek] += $row->patientcount;
						}
					}
					
					
					
					
				}
				
			}
			$q->free_result();
			if($brgy == null){
			$where = "count(imcase_no) as patientcount ,YEAR(created_on) as caseyear,   
						WEEK(created_on) as caseweek, barangay ,  FLOOR(TIMESTAMPDIFF(YEAR,person_dob,CURDATE())/10) as agegroup, person_sex
						FROM (`active_cases`)
						JOIN `master_list` ON `master_list`.`person_id` = `active_cases`.`person_id`
						JOIN `catchment_area` ON `master_list`.`person_id` = `catchment_area`.`person_id`
						JOIN `bhw` ON `catchment_area`.`bhw_id` = `bhw`.`user_username`
						JOIN `household_address` ON `catchment_area`.`household_id` = `household_address`.`household_id`
			
						WHERE WEEK(`created_on`) between ".$weekno."-4 AND ".$weekno." AND
						(YEAR(`created_on`) between ".date('Y')."-5 AND  ".date('Y').")
						GROUP BY YEAR(`created_on`),WEEK(`created_on`), barangay,agegroup,person_sex";
			}
			$this->db->select($where,false);
			$q = $this->db->get();
			if($q->num_rows() > 0)
			{
				foreach ($q->result() as $row)
				{	
					$data[$row->caseyear][$row->caseweek] +=$row->patientcount;
					if($row->caseyear != date('Y'))
					$average[$row->caseweek] += $row->patientcount;
					else
					{$data['total'] += $row->patientcount;
					
					if($row->agegroup < 3)
						$agegroup[$row->caseweek][$row->agegroup]++;
					else
						$agegroup[$row->caseweek][3]++;
					
					if($row->person_sex == 'F')
					{
						$gender['F']++;
					}
					else if ($row->person_sex == 'M'){
						$gender['M']++;
					}
					
					}
					foreach($brgys as $temp)
					{
						if($temp == $row->barangay)
						{
							$data[$temp][$row->caseyear][$row->caseweek] += $row->patientcount;
						}
					}
				}
			}
			$q->free_result();
			
			$data['deaths'] = 0;
			
			if($brgy == null){
				$where = "count(cr_barangay) as patientcount ,YEAR(cr_date_onset) as caseyear,
						WEEK(cr_date_onset) as caseweek, cr_barangay
						FROM (`case_report_main`)
						WHERE WEEK(`cr_date_onset`) between ".$weekno."-4 AND ".$weekno." AND
						(YEAR(`cr_date_onset`) =  ".date('Y').") AND cr_outcome = 'D'
						GROUP BY YEAR(`cr_date_onset`),WEEK(`cr_date_onset`), cr_barangay
					";
			}
			$this->db->select($where,false);
			$q = $this->db->get();
			if($q->num_rows() > 0)
			{
				foreach ($q->result() as $row)
				{
					$data['deaths'] +=$row->patientcount;
				}
			
			}
			
			for($i = $weekno-4; $i<=$weekno; $i++)
			{
				 $average[$i] = round($average[$i]/5,0) ;
				 $average[$i].' ';
			}
			$data['average'] = $average;
			
			
			
			$data['gender'] = $gender;
			$data['agegroup'] = $agegroup;
			
			return $data;
		}
		function get_affected_household($weekno)
		{

			$where = "barangay,count(household_name) as ctr ,suspected_source, household_name , house_no, street, household_address.household_id as id
						FROM (`active_cases`)
						JOIN `master_list` ON `master_list`.`person_id` = `active_cases`.`person_id`
						JOIN `catchment_area` ON `master_list`.`person_id` = `catchment_area`.`person_id`
						JOIN `bhw` ON `catchment_area`.`bhw_id` = `bhw`.`user_username`
						JOIN `household_address` ON `catchment_area`.`household_id` = `household_address`.`household_id`
		
						WHERE WEEK(`created_on`) between ".$weekno."-4 AND ".$weekno." AND
						(YEAR(`created_on`) = ".date('Y').")
						GROUP BY household_name
					";
				
			$this->db->select($where,false);
			$q = $this->db->get();
			
			$data = null;
			
				
			if($q->num_rows() > 0)
			{
				foreach ($q->result_array() as $row)
				$data[$row['household_name']] = $row;
			}
			$q->free_result();
			return $data;
		}
		
		function get_larval_count($weekno)
		{	
			$brgys = $this->get_barangays();
			for($i = $weekno-4; $i<=$weekno; $i++)
			{
				$data[$i] = 0;
			}
			foreach ($brgys as $row)
			{
				
				for($i = $weekno-4; $i<=$weekno; $i++)
				{
				$data[$row][$i] = 0;
				}
			} 
			
			$where = "count(ls_no) as count ,WEEK(created_on) as caseweek, ls_barangay FROM (`ls_report`)
				WHERE WEEK(`created_on`) between ".$weekno."-4 AND ".$weekno." AND
				(YEAR(`created_on`) = ".date('Y').")
				GROUP BY WEEK(created_on), ls_barangay";
			$this->db->select($where);
			$q = $this->db->get();
			$yearstart= 0;
			if($q->num_rows() > 0)
			{
				foreach ($q->result() as $row)
				{
				$data[$row->caseweek] += $row->count;
				$data[$row->ls_barangay][$row->caseweek] += $row->count;
				}
			}
			
			$q->free_result();
			return $data;
		}

		
	}

	
/* End of master_list_model.php */
/* Location: ./application/models/master_list_model.php */
