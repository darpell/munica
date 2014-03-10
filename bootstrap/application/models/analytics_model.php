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
		function get_all_cases_count($monthstart = 1, $yearstart = null,$monthend =12, $yearend = null, $brgy)
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
					$data['yearmin'] =$row->yearmin;
				}
			}
			if($yearstart != null)
			{
				$data['yearstart'] = $yearstart;
			}
			
			$data['monthstart'] = $monthstart;
			
			$q->free_result();
			
			for($i=$data['yearstart'];$i<=DATE('Y');$i++)
			{
				for ($s= 1;$s<=12;$s++)
				{
					$data[$i][$s]=0;
				}
			}
			foreach($brgy as $brgy) 
			{
				if ($yearstart == null AND  $yearend == null)
				{
				$where = "count(cr_barangay) as patientcount ,YEAR(cr_date_onset) as caseyear,
					Month(cr_date_onset) as casemonth
					FROM (`case_report_main`)
					WHERE cr_barangay= '". $brgy ."'
					GROUP BY YEAR(`cr_date_onset`),MONTH(`cr_date_onset`)";
				}
				else 
				{
					$where = "count(cr_barangay) as patientcount ,YEAR(cr_date_onset) as caseyear,
					Month(cr_date_onset) as casemonth
					FROM (`case_report_main`)
					WHERE cr_barangay= '". $brgy ."' AND YEAR(cr_date_onset) between ".$yearstart." AND ".$yearend."
					GROUP BY YEAR(`cr_date_onset`),MONTH(`cr_date_onset`)";
				}
				
				$this->db->select($where);
				$q = $this->db->get();
				
				if($q->num_rows() > 0)
				{
					foreach ($q->result() as $row)
					{ $x = $row->caseyear;
					$y = $row->casemonth;
					$data[$x][$y] += $row->patientcount;
					}
				}
				$q->free_result();
				if ($yearstart == null AND  $yearend == null)
				{
				$where = "count(imcase_no) as patientcount ,YEAR(active_cases.created_on) as caseyear,
				Month(active_cases.created_on) as casemonth
				FROM (`active_cases`)
				JOIN `master_list` ON `master_list`.`person_id` = `active_cases`.`person_id`
				JOIN `catchment_area` ON `master_list`.`person_id` = `catchment_area`.`person_id`
				JOIN `bhw` ON `catchment_area`.`bhw_id` = `bhw`.`user_username`
				JOIN `household_address` ON `catchment_area`.`household_id` = `household_address`.`household_id`
				WHERE barangay= '". $brgy ."'
				GROUP BY   YEAR( created_on ) ,MONTH( created_on )";
				}
				else {
					$where = "count(imcase_no) as patientcount ,YEAR(active_cases.created_on) as caseyear,
				Month(active_cases.created_on) as casemonth
				FROM (`active_cases`)
				JOIN `master_list` ON `master_list`.`person_id` = `active_cases`.`person_id`
				JOIN `catchment_area` ON `master_list`.`person_id` = `catchment_area`.`person_id`
				JOIN `bhw` ON `catchment_area`.`bhw_id` = `bhw`.`user_username`
				JOIN `household_address` ON `catchment_area`.`household_id` = `household_address`.`household_id`
				WHERE barangay= '". $brgy ."' AND YEAR(created_on) between ".$yearstart." AND ".$yearend."
				GROUP BY   YEAR( created_on ) ,MONTH( created_on )";
				}
				$this->db->select($where);
				$q = $this->db->get();
				
				if($q->num_rows() > 0)
				{
					foreach ($q->result() as $row)
					{ $x = $row->caseyear;
					$y = $row->casemonth;
					$data[$x][$y] += $row->patientcount;
					}
				}
				$q->free_result();
				
				if ($yearstart == null AND  $yearend == null)
				{
				$where = "count(imcase_no) as patientcount ,YEAR(previous_cases.created_on) as caseyear,
				Month(previous_cases.created_on) as casemonth
				FROM (`previous_cases`)
				JOIN `master_list` ON `master_list`.`person_id` = `previous_cases`.`person_id`
				JOIN `catchment_area` ON `master_list`.`person_id` = `catchment_area`.`person_id`
				JOIN `bhw` ON `catchment_area`.`bhw_id` = `bhw`.`user_username`
				JOIN `household_address` ON `catchment_area`.`household_id` = `household_address`.`household_id`
				WHERE barangay= '". $brgy ."'
				GROUP BY   YEAR( created_on ) ,MONTH( created_on )";
				}
				else{
					$where = "count(imcase_no) as patientcount ,YEAR(previous_cases.created_on) as caseyear,
				Month(previous_cases.created_on) as casemonth
				FROM (`previous_cases`)
				JOIN `master_list` ON `master_list`.`person_id` = `previous_cases`.`person_id`
				JOIN `catchment_area` ON `master_list`.`person_id` = `catchment_area`.`person_id`
				JOIN `bhw` ON `catchment_area`.`bhw_id` = `bhw`.`user_username`
				JOIN `household_address` ON `catchment_area`.`household_id` = `household_address`.`household_id`
				WHERE barangay= '". $brgy ."' AND YEAR(created_on) between ".$yearstart." AND ".$yearend."
				GROUP BY   YEAR( created_on ) ,MONTH( created_on )";
				}
				$this->db->select($where);
				$q = $this->db->get();
				
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
			
			$ctr = 0;
			$data['casecount'] = '0,';
			
			if($yearend != null)
			$x = $yearend;
			else 
			$x = date('Y');
			
			for($i=$data['yearstart'];$i<=$x;$i++)
			{
			if($i == $data['yearstart'])
			$s = $monthstart;
			else
			$s = 1;
			for ($s= 1;$s<=12;$s++)
			{
			
			
			
				
			$data['casecount'] .= $data[$i][$s] . ',';
			
			if($data[$i][$s] >=$data['max'] )
			{
				$data['max'] = $data[$i][$s];
				$data['max_mon']=$s;
				$data['max_year']=$i;
			}
			if($i == $yearend AND $s == $monthend)
				$s = 13;
			}
			}
			$data['monthend'] = $monthend;
			$data['yearend'] = $x;
			return $data;	
		}
		function get_outbreak_count()
		{
			
			$brgys = $this->get_barangays();

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
			foreach ($brgys as $row)
					
			$data[$row][$i][$s]=0;
			
			}
			}

		
			$where = "count(cr_barangay) as patientcount ,cr_barangay,YEAR(cr_date_onset) as caseyear,
					Month(cr_date_onset) as casemonth
					FROM (`case_report_main`)
					GROUP BY YEAR(`cr_date_onset`),MONTH(`cr_date_onset`),cr_barangay ";
			$this->db->select($where);
			$q = $this->db->get();
			$yearstart= 0;
			if($q->num_rows() > 0)
			{
			foreach ($q->result() as $row)
			{ $x = $row->caseyear;
			$y = $row->casemonth;
			$data[$row->cr_barangay][$x][$y] += $row->patientcount;
			}
			}
			$q->free_result();
				
			$where = "count(imcase_no) as patientcount ,barangay,YEAR(active_cases.created_on) as caseyear,
				Month(active_cases.created_on) as casemonth
				FROM (`active_cases`)
				JOIN `master_list` ON `master_list`.`person_id` = `active_cases`.`person_id`
				JOIN `catchment_area` ON `master_list`.`person_id` = `catchment_area`.`person_id`
				JOIN `bhw` ON `catchment_area`.`bhw_id` = `bhw`.`user_username`
				JOIN `household_address` ON `catchment_area`.`household_id` = `household_address`.`household_id`
				GROUP BY   YEAR(created_on) ,MONTH(created_on),barangay ";
			$this->db->select($where);
			$q = $this->db->get();
					$yearstart= 0;
					if($q->num_rows() > 0)
					{
					foreach ($q->result() as $row)
					{ $x = $row->caseyear;
					$y = $row->casemonth;
					$data[ $row->barangay][$x][$y] += $row->patientcount;
					}
					}
					$q->free_result();
						
					$where = "count(imcase_no) as patientcount ,barangay,YEAR(previous_cases.created_on) as caseyear,
				Month(previous_cases.created_on) as casemonth
				FROM (`previous_cases`)
				JOIN `master_list` ON `master_list`.`person_id` = `previous_cases`.`person_id`
				JOIN `catchment_area` ON `master_list`.`person_id` = `catchment_area`.`person_id`
				JOIN `bhw` ON `catchment_area`.`bhw_id` = `bhw`.`user_username`
				JOIN `household_address` ON `catchment_area`.`household_id` = `household_address`.`household_id`
				GROUP BY   YEAR(created_on) ,MONTH(created_on),barangay";
			$this->db->select($where);
			$q = $this->db->get();
			$yearstart= 0;
					if($q->num_rows() > 0)
					{
						foreach ($q->result() as $row)
						{ $x = $row->caseyear;
						$y = $row->casemonth;
						$data[$row->barangay][$x][$y] += $row->patientcount;
						}
					}
					if($data['yearstart']<=date('Y')-5)
					{
					
						for($s = 1; $s<=12; $s++)
						{
							$month = '';
							switch ($s)
							{
								case '1': $month = 'JAN'; break;
								case '2': $month = 'FEB'; break;
								case '3': $month = 'MAR'; break;
								case '4': $month = 'APR'; break;
								case '5': $month = 'MAY'; break;
								case '6': $month = 'JUN'; break;
								case '7': $month = 'JUL'; break;
								case '8': $month = 'AUG'; break;
								case '9': $month = 'SEP'; break;
								case '10': $month = 'OCT'; break;
								case '11': $month = 'NOV'; break;
								case '12': $month = 'DEC'; break;
							}
							
							$outbreakpermonth[$month] = 0;
						}
						foreach($brgys as $row)
						{
						for($y = $data['yearstart']+5 ; $y <= date('Y');$y++)
						{
							$outbreak[$row][$y] = 0;
							for($s = 1; $s<=12; $s++)
							{
								
								for($i = 1; $i <=5 ;$i++)
								{
									$threshold[$row][$y][$s][]=$data[$row][$y-$i][$s];
									
									
								}
								sort($threshold[$row][$y][$s],1);
								if($threshold[$row][$y][$s][3]<=$data[$row][$y][$s])
								{
									$outbreak[$row][$y] ++;
									$month = '';
									switch ($s)
									{
										case '1': $month = 'JAN'; break;
										case '2': $month = 'FEB'; break;
										case '3': $month = 'MAR'; break;
										case '4': $month = 'APR'; break;
										case '5': $month = 'MAY'; break;
										case '6': $month = 'JUN'; break;
										case '7': $month = 'JUL'; break;
										case '8': $month = 'AUG'; break;
										case '9': $month = 'SEP'; break;
										case '10': $month = 'OCT'; break;
										case '11': $month = 'NOV'; break;
										case '12': $month = 'DEC'; break;
									}
										
									$outbreakpermonth[$month] ++;
								}
								
								
							}
							
						}
						}
						$data2['data'] = $outbreak;
						$data2['yearstart'] = $data['yearstart']+5;
						$data2['yearend'] = date('Y');
						$data2['outbreakmonth'] = $outbreakpermonth;
						return $data2;
					}
					else return null;
						
					
					
						
					
					
					}
			function get_outbreak_count_year($year){
					
					
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
					$brgys = $this->get_barangays();
					foreach($brgys as $row)
					{
						for($i=$data['yearstart'];$i<=DATE('Y');$i++)
						{
						for ($s= 1;$s<=12;$s++)
						{
						$data['month'][$row][$i][$s]=0;
							for($x = 0 ; $x< 5; $x++)
							{
							$threshold2[$i][$s][$x] = 0;
							}
						}
						}
						for ($s= 0;$s<12;$s++)
						{
						$data[$row][$s]=0;
						$monthsum[$row][$s]=0;
						}
					}
						
						


					
					
					$where = "count(cr_barangay) as patientcount,cr_barangay,YEAR(cr_date_onset) as caseyear,
					Month(cr_date_onset) as casemonth
					FROM (`case_report_main`)
					GROUP BY YEAR(`cr_date_onset`),MONTH(`cr_date_onset`),cr_barangay";
			$this->db->select($where);
								$q = $this->db->get();
								$yearstart= 0;
						if($q->num_rows() > 0)
						{
						foreach ($q->result() as $row)
						{ $x = $row->caseyear;
						$y = $row->casemonth;
						if($x == $year)
						$data[$row->cr_barangay][$y-1] += $row->patientcount;
						$data['month'][$row->cr_barangay][$x][$y] += $row->patientcount;
						}
						}
						$q->free_result();
					
						$where = "count(imcase_no) as patientcount ,barangay,YEAR(active_cases.created_on) as caseyear,
				Month(active_cases.created_on) as casemonth
				FROM (`active_cases`)
				JOIN `master_list` ON `master_list`.`person_id` = `active_cases`.`person_id`
				JOIN `catchment_area` ON `master_list`.`person_id` = `catchment_area`.`person_id`
				JOIN `bhw` ON `catchment_area`.`bhw_id` = `bhw`.`user_username`
				JOIN `household_address` ON `catchment_area`.`household_id` = `household_address`.`household_id`
				GROUP BY   YEAR(created_on) ,MONTH(created_on),barangay";
			$this->db->select($where);
			$q = $this->db->get();
								$yearstart= 0;
								if($q->num_rows() > 0)
								{
								foreach ($q->result() as $row)
								{ $x = $row->caseyear;
								$y = $row->casemonth;
								if($x == $year)
								$data[$row->barangay][$y-1] += $row->patientcount;
								$data['month'][$row->barangay][$x][$y] += $row->patientcount;
								}
						}
								$q->free_result();
					
								$where = "count(imcase_no) as patientcount ,barangay,YEAR(previous_cases.created_on) as caseyear,
				Month(previous_cases.created_on) as casemonth
				FROM (`previous_cases`)
				JOIN `master_list` ON `master_list`.`person_id` = `previous_cases`.`person_id`
				JOIN `catchment_area` ON `master_list`.`person_id` = `catchment_area`.`person_id`
				JOIN `bhw` ON `catchment_area`.`bhw_id` = `bhw`.`user_username`
				JOIN `household_address` ON `catchment_area`.`household_id` = `household_address`.`household_id`
				GROUP BY   YEAR(created_on) ,MONTH(created_on),barangay";
			$this->db->select($where);
			$q = $this->db->get();
			$yearstart= 0;
					if($q->num_rows() > 0)
					{
						foreach ($q->result() as $row)
						{ $x = $row->caseyear;
						$y = $row->casemonth;
						if($x == $year)
						$data[$row->barangay][$y-1] += $row->patientcount;
						$data['month'][$row->barangay][$x][$y] += $row->patientcount;
						}
					}
					if($data['yearstart']<=date('Y')-5)
					{
						
					for($s = 1; $s<=12; $s++)
						{
							$month = '';
							switch ($s)
							{
							case '1': $month = 'JAN'; break;
							case '2': $month = 'FEB'; break;
								case '3': $month = 'MAR'; break;
								case '4': $month = 'APR'; break;
								case '5': $month = 'MAY'; break;
								case '6': $month = 'JUN'; break;
								case '7': $month = 'JUL'; break;
								case '8': $month = 'AUG'; break;
								case '9': $month = 'SEP'; break;
								case '10': $month = 'OCT'; break;
								case '11': $month = 'NOV'; break;
								case '12': $month = 'DEC'; break;
							}
								
							$outbreakpermonth[$month] = 0;
							}
							foreach ($brgys as $row)
							{
							for($y = $data['yearstart']+5 ; $y <= date('Y');$y++)
							{
							$outbreak[$row][$y] = 0;
							for($s = 1; $s<=12; $s++)
							{
							for($i = 1; $i <=5 ;$i++)
							{
							$threshold[$row][$y][$s][]=$data['month'][$row][$y-$i][$s];
							//$threshold2[$y][$s][$i][] += $data['month'][$row][$y-$i][$s];
							}
							
						sort($threshold[$row][$y][$s],1);
						if($threshold[$row][$y][$s][3]<=$data['month'][$row][$y][$s])
						{
						$outbreak[$row][$y] ++;
						$month = '';
							switch ($s)
							{
							case '1': $month = 'JAN'; break;
							case '2': $month = 'FEB'; break;
							case '3': $month = 'MAR'; break;
							case '4': $month = 'APR'; break;
							case '5': $month = 'MAY'; break;
							case '6': $month = 'JUN'; break;
							case '7': $month = 'JUL'; break;
							case '8': $month = 'AUG'; break;
							case '9': $month = 'SEP'; break;
							case '10': $month = 'OCT'; break;
							case '11': $month = 'NOV'; break;
							case '12': $month = 'DEC'; break;
								}
					
								$outbreakpermonth[$month] ++;
								}
								}
									
								}
							}
								$month = [];
								$month[]= 'JAN'; 
								$month[] = 'FEB';
								$month[]= 'MAR';
								$month[] = 'APR'; 
								$month[]= 'MAY'; 
								$month[]= 'JUN'; 
								$month[]= 'JUL';
								$month[] = 'AUG'; 
								$month[]= 'SEP';
								$month[] = 'OCT'; 
								$month[] = 'NOV'; 
								$month[]= 'DEC'; 
								
								$data2['months'] = $month;
								$data2['data'] = $outbreak;
								$data2['yearstart'] = $data['yearstart']+5;
								$data2['yearend'] = date('Y');
								$data2['outbreakmonth'] = $outbreakpermonth;
								$data2['yearsel'] = $year;
								$data2['threshold'] =$threshold;
								foreach ($brgys as $row)
								{
								$data2['barangay'][$row] = $data[$row]; 
								for($s = 0;$s<12;$s++)
								{
									$monthsum[$row][$s] += $data[$row][$s];
								}
								}
								$data2['monthsum'] =$monthsum;
								for($y = $data['yearstart']+5 ; $y <= date('Y');$y++)
								{ 
									sort($threshold2[$y][$s],1);
								}
								// to do total for each month threshold
								
								return $data2;
								}
								else return null;
					
															
															
				
															
															
								}
		function get_all_death_count($monthstart = 1, $yearstart = null,$monthend =12, $yearend = null, $brgy)
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
			
			if($yearstart != null)
			{
				$data['yearstart'] = $yearstart;
			}
			
			$data['monthstart'] = $monthstart;
			
			
			for($i=$data['yearstart'];$i<=DATE('Y');$i++)
			{
			for ($s= 1;$s<=12;$s++)
			{
			$data[$i][$s]=0;
			}
			}
			
			foreach($brgy as $brgy){
			if($yearstart == null AND $yearend == null)
			{
			$where = " count(cr_patient_no) as deaths , YEAR(cr_date_onset) as caseyear,
					Month(cr_date_onset) as casemonth
					FROM case_report_main
					WHERE cr_barangay= '". $brgy ."' AND YEAR(`cr_date_onset`) < ".date('Y')."
					AND cr_outcome = 'D'
					GROUP BY YEAR(`cr_date_onset`), MONTH(`cr_date_onset`)";
			}
			else
			{
				$where = " count(cr_patient_no) as deaths , YEAR(cr_date_onset) as caseyear,
					Month(cr_date_onset) as casemonth
					FROM case_report_main
					WHERE cr_barangay= '". $brgy ."' AND YEAR(`cr_date_onset`) between ".$yearstart." AND ".$yearend."
					AND cr_outcome = 'D'
					GROUP BY YEAR(`cr_date_onset`), MONTH(`cr_date_onset`)";
			}	
			$this->db->select($where,false);
			$q = $this->db->get();
			if($q->num_rows() > 0)
			{
				foreach ($q->result() as $row)
				{ $x = $row->caseyear;
				  $y = $row->casemonth;
					$data[$x][$y] += $row->deaths;
				}
			}
			}
			
			if($yearstart != null)
			$x = $yearend;
			else
			$x = date('Y');
			
			$data['count'] = '0,';
			
			for($i=$data['yearstart'];$i<=$x;$i++)
			{
				if($i == $data['yearstart'])
					$s = $monthstart;
				else
					$s = 1;
				
				for ($s= 1;$s<=12;$s++)
				{
					
					$data['count'] .= $data[$i][$s] . ',';
								

					if($i == $yearend AND $s == $monthend)
						$s = 13;
				}
			}
				
			
			return $data;
		
		}
		function get_death_count($mon,$year,$brgy)
		{
			$data = [];
			foreach($brgy as $brgy)
			{
			$where = " count(cr_patient_no) as deaths , cr_barangay FROM (`case_report_main`)
					WHERE YEAR(cr_date_onset) =".$year." AND MONTH(cr_date_onset) =".$mon."
					AND cr_outcome = 'D' AND cr_barangay = '".$brgy."'
					GROUP BY cr_barangay ";
			
			$this->db->select($where,false);
			$q = $this->db->get();
			$yearstart= 0;
			if($q->num_rows() > 0)
			{
				$data= array_merge($data,$q->result_array());
			}
			}
			
			if($data == [])
			return null;
			else
			return $data;
			
		}
		function get_death_count_daterange ($startdate,$enddate,$brgy)
		{
		
			$data = [];
			foreach($brgy as $brgy)
			{
			$where = " count(cr_patient_no) as deaths , cr_barangay FROM (`case_report_main`)
					WHERE cr_date_onset BETWEEN '".$startdate."'  AND '".$enddate."' 
					AND cr_outcome = 'D' AND cr_barangay = '".$brgy."'
					GROUP BY cr_barangay ";
				
			$this->db->select($where,false);
			$q = $this->db->get();
			$yearstart= 0;
			if($q->num_rows() > 0)
			{

				$data=array_merge($data,$q->result_array());
				
			}
			}

			
			return $data;
				
		}
		function get_all_cases_data($startdate, $enddate ,$brgy)
		{
			$data['casereport'] = [];
			$data['immecase'] = [];
		foreach ($brgy as $brgy)
		{
			$where = " * FROM (`case_report_main`)
					WHERE cr_barangay = '".$brgy."' AND  cr_date_onset BETWEEN '".$startdate."'  AND '".$enddate."' ";
			$this->db->select($where,false);
			$q = $this->db->get();
			$yearstart= 0;
			if($q->num_rows() > 0)
			{
 				$data['casereport']=array_merge($data['casereport'],$q->result_array());
			}
			 
				
			$q->free_result();
				
			
			
			
			$where = " *
				FROM (`active_cases`)
				JOIN `master_list` ON `master_list`.`person_id` = `active_cases`.`person_id`
				JOIN `catchment_area` ON `master_list`.`person_id` = `catchment_area`.`person_id`
				JOIN `bhw` ON `catchment_area`.`bhw_id` = `bhw`.`user_username`
				JOIN `household_address` ON `catchment_area`.`household_id` = `household_address`.`household_id`
				WHERE barangay = '".$brgy."' AND created_on BETWEEN '".$startdate."'  AND '".$enddate."' ";
				$this->db->select($where , false);
				$q = $this->db->get();
				
					if($q->num_rows() > 0)
					{ 
						$data['immecase']=array_merge($data['immecase'],$q->result_array());
					}
					
					$q->free_result();
					
					$where = " *
				FROM (`previous_cases`)
				JOIN `master_list` ON `master_list`.`person_id` = `previous_cases`.`person_id`
				JOIN `catchment_area` ON `master_list`.`person_id` = `catchment_area`.`person_id`
				JOIN `bhw` ON `catchment_area`.`bhw_id` = `bhw`.`user_username`
				JOIN `household_address` ON `catchment_area`.`household_id` = `household_address`.`household_id`
				WHERE barangay = '".$brgy."' AND created_on BETWEEN '".$startdate."'  AND '".$enddate."' ";
					$this->db->select($where , false);
					$q = $this->db->get();
					
					if($q->num_rows() > 0)
					{
						$data['immecase']=array_merge($data['immecase'],$q->result_array());
					}
						
					$q->free_result();
						
		}

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
		function get_all_larval_count($monthstart = 1, $yearstart = null,$monthend =12, $yearend = null, $brgy)
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
					$data['yearmin']= $row->yearmin;
				}
			}
			$q->free_result();
			
			if($yearstart != null)
			{
				$data['yearstart'] = $yearstart;
			}
			$data['monthstart'] = $monthstart;
				
				
			for($i=$data['yearstart'];$i<=DATE('Y');$i++)
			{
			for ($s= 1;$s<=12;$s++)
			{
			$data[$i][$s]=0;
			}
			}
			
			foreach ($brgy as $brgy)
			{
				if($yearstart == null AND $yearend == null)
				{
				$where = "count(ls_no) as count ,YEAR(created_on) as caseyear,
				Month(created_on) as casemonth
				FROM (`ls_report`)
				WHERE YEAR(created_on) < ".date('Y')." AND ls_barangay ='".$brgy."'
				GROUP BY YEAR(`created_on`),MONTH(`created_on`)";
				}
				else
				{
				$where = "count(ls_no) as count ,YEAR(created_on) as caseyear,
				Month(created_on) as casemonth
				FROM (`ls_report`)
				WHERE YEAR(created_on) between ".$yearstart." AND ".$yearend." AND ls_barangay ='".$brgy."'
				GROUP BY YEAR(`created_on`),MONTH(`created_on`)";
				}
				$this->db->select($where);
				$q = $this->db->get();
				
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
			$data['larvalcount'] = '0,';
			
			if($yearend != null)
				$x = $yearend;
			else
				$x = date('Y');
			
			for($i=$data['yearstart'];$i<=$x;$i++)
			{
				if($i == $data['yearstart'])
					$s = $monthstart;
				else
					$s = 1;
				
			for ($s= 1;$s<=12;$s++)
				{
				$data['larvalcount'] .= $data[$i][$s] . ',';
				
				if($data[$i][$s]>=$data['max'])
				{
					$data['max'] = $data[$i][$s];
					$data['max_mon']=$s;
					$data['max_year']=$i;
				}
				
				if($i == $yearend AND $s == $monthend)
					$s = 13;
				
				}
			}
			$data['monthend'] = $monthend;
			$data['yearend'] = $x;			
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
		function get_case_list($month,$year,$brgy)
		{	
			$data['immecase'] = [];
			$data['casereport'] = [];
		
			foreach($brgy as $brgy)
			{
			$where = " *
				FROM (`active_cases`)
				JOIN `master_list` ON `master_list`.`person_id` = `active_cases`.`person_id`
				JOIN `catchment_area` ON `master_list`.`person_id` = `catchment_area`.`person_id`
				JOIN `bhw` ON `catchment_area`.`bhw_id` = `bhw`.`user_username`
				JOIN `household_address` ON `catchment_area`.`household_id` = `household_address`.`household_id`
				WHERE barangay = '".$brgy."' AND 
				YEAR(created_on) = ".$year."  AND
				MONTH(created_on) = ".$month." 
					";
			$this->db->select($where , false);
			$q = $this->db->get();
		
			if($q->num_rows() > 0)
			{
				$data['immecase'] = array_merge($data['immecase'],$q->result_array());
			}
			$q->free_result();
			$where = " *
				FROM (`previous_cases`)
				JOIN `master_list` ON `master_list`.`person_id` = `previous_cases`.`person_id`
				JOIN `catchment_area` ON `master_list`.`person_id` = `catchment_area`.`person_id`
				JOIN `bhw` ON `catchment_area`.`bhw_id` = `bhw`.`user_username`
				JOIN `household_address` ON `catchment_area`.`household_id` = `household_address`.`household_id`
				WHERE barangay = '".$brgy."' AND
				YEAR(created_on) = ".$year."  AND
				MONTH(created_on) = ".$month." 
					";
			$this->db->select($where , false);
			$q = $this->db->get();
			
			if($q->num_rows() > 0)
			{
				$data['immecase'] = array_merge($data['immecase'],$q->result_array());
			}
			
			
			$q->free_result();
			
			$where = " * FROM (`case_report_main`)
					WHERE cr_barangay = '".$brgy."' AND  
					YEAR(cr_date_onset) = ".$year."  AND
					MONTH(cr_date_onset) = ".$month." 
					";
			$this->db->select($where,false);
			$q = $this->db->get();
			if($q->num_rows() > 0)
			{
				$data['casereport']=array_merge($data['casereport'],$q->result_array());
			}
			$q->free_result();
			
			}
			return $data;
		}
		function get_summary_count($weekno , $brgy)
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
			foreach ($brgy as $brgy)
			{
			$where = "count(cr_barangay) as patientcount ,YEAR(cr_date_onset) as caseyear,   
						WEEK(cr_date_onset) as caseweek, cr_barangay, cr_age DIV 10 as agegroup, cr_sex
					

						FROM (`case_report_main`)
						WHERE WEEK(`cr_date_onset`) between ".$weekno."-4 AND ".$weekno." AND
						(YEAR(`cr_date_onset`) between ".date('Y')."-5 AND  ".date('Y').")
						AND cr_barangay ='".$brgy."' 
						GROUP BY YEAR(`cr_date_onset`),WEEK(`cr_date_onset`), cr_barangay, agegroup, cr_sex
					";
			
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
			
			$where = "count(imcase_no) as patientcount ,YEAR(created_on) as caseyear,   
						WEEK(created_on) as caseweek, barangay ,  FLOOR(TIMESTAMPDIFF(YEAR,person_dob,CURDATE())/10) as agegroup, person_sex
						FROM (`active_cases`)
						JOIN `master_list` ON `master_list`.`person_id` = `active_cases`.`person_id`
						JOIN `catchment_area` ON `master_list`.`person_id` = `catchment_area`.`person_id`
						JOIN `bhw` ON `catchment_area`.`bhw_id` = `bhw`.`user_username`
						JOIN `household_address` ON `catchment_area`.`household_id` = `household_address`.`household_id`
			
						WHERE WEEK(`created_on`) between ".$weekno."-4 AND ".$weekno." AND
						(YEAR(`created_on`) between ".date('Y')."-5 AND  ".date('Y').")
						AND barangay ='".$brgy."' 
						GROUP BY YEAR(`created_on`),WEEK(`created_on`), barangay,agegroup,person_sex";
			
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
			
			
				$where = "count(cr_barangay) as patientcount ,YEAR(cr_date_onset) as caseyear,
						WEEK(cr_date_onset) as caseweek, cr_barangay
						FROM (`case_report_main`)
						WHERE WEEK(`cr_date_onset`) between ".$weekno."-4 AND ".$weekno." AND
						(YEAR(`cr_date_onset`) =  ".date('Y').") AND cr_outcome = 'D'
						AND cr_barangay ='".$brgy."' 
						GROUP BY YEAR(`cr_date_onset`),WEEK(`cr_date_onset`), cr_barangay
					";
			
			$this->db->select($where,false);
			$q = $this->db->get();
			if($q->num_rows() > 0)
			{
				foreach ($q->result() as $row)
				{
					$data['deaths'] +=$row->patientcount;
				}
			
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
			$data = null;
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
			if($q->num_rows() > 0)
			{
				foreach ($q->result_array() as $row)
				{
				if(!isset($data[$row['household_name']]))
					$data[$row['household_name']] = $row;
				
				else
					$data[$row['household_name']]['ctr'] += $row['ctr'];
				}
			}
			$where = "barangay,count(household_name) as ctr ,suspected_source, household_name , house_no, street, household_address.household_id as id
						FROM (`previous_cases`)
						JOIN `master_list` ON `master_list`.`person_id` = `previous_cases`.`person_id`
						JOIN `catchment_area` ON `master_list`.`person_id` = `catchment_area`.`person_id`
						JOIN `bhw` ON `catchment_area`.`bhw_id` = `bhw`.`user_username`
						JOIN `household_address` ON `catchment_area`.`household_id` = `household_address`.`household_id`
			
						WHERE WEEK(`created_on`) between ".$weekno."-4 AND ".$weekno." AND
						(YEAR(`created_on`) = ".date('Y').")
						GROUP BY household_name
					";
			
			$this->db->select($where,false);
			$q = $this->db->get();
				
				
				
			if($q->num_rows() > 0)
			{
				foreach ($q->result_array() as $row)
				{
				if(isset($data[$row['household_name']]))
				$data[$row['household_name']]['ctr'] += $row['ctr'];
				else
				$data[$row['household_name']] = $row;
				}
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
