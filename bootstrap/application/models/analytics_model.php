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
		function get_immediate_cases($midwife)
		{
			$barangay = $this->get_barangay_midwife($midwife);
			
			$this->db->from('immediate_cases');
			$this->db->join('master_list','master_list.person_id = immediate_cases.person_id');
			$this->db->join('catchment_area','master_list.person_id = catchment_area.person_id');
			$this->db->join('bhw','catchment_area.bhw_id = bhw.user_username');
			$this->db->join('household_address','catchment_area.household_id = household_address.household_id');
			$this->db->where('bhw.barangay', $barangay);
			$this->db->where("YEAR(created_on) =".date('Y'));
			$this->db->where("MONTH(created_on) =".date('m'));
			$q = $this->db->get();
			if($q->num_rows() > 0)
			{
				foreach ($q->result() as $row)
				{
		
					$name = $row->person_first_name . ' ' . $row->person_last_name;
					$date = explode ('-', $row->created_on);
					$birthDate = explode ('-', $row->person_dob);
					$birthDate = $birthDate[1].'/'.$birthDate[2].'/'.$birthDate[0];
					//explode the date to get month, day and year
					$birthDate = explode("/", $birthDate);
					//get age from date or birthdate
					$age = (date("md", date("U", mktime(0, 0, 0, $birthDate[0], $birthDate[1], $birthDate[2]))) > date("md") ? ((date("Y")-$birthDate[2])-1):(date("Y")-$birthDate[2]));
					$data[] =array(
							'Name' => anchor(base_url('index.php/master_list/view_immediate_case').'/'. $row->person_id .'/'. $row->imcase_no ,  $name, 'target="_blank"') ,
							'Address' => $row->house_no .' '. $row->street ,
							'Contact Nos' => $row->person_contactno ,
							'Age' => $age,
							'Days Of Fever' => $row->days_fever ,
							'Muscle Pain' => $row->has_muscle_pain ,
							'Joint Pain' => $row->has_joint_pain ,
							'Head Ache' => $row->has_headache ,
							'Bleeding'  => $row->has_bleeding ,
							'Rashes' => $row->has_rashes ,
							'Status' => $row->status ,
							'Date Onset' => $date[1].'/'.$date[2].'/'.$date[0] ,
							'Remarks' => $row->remarks
					);
				}
			}
			else $data = null;
			return $data;
		}
	function get_con_immediate_cases($midwife)
		{
			$barangay = $this->get_barangay_midwife($midwife);
			
			
			
			$this->db->from('immediate_cases');
			$this->db->join('master_list','master_list.person_id = immediate_cases.person_id');
			$this->db->join('catchment_area','master_list.person_id = catchment_area.person_id');
			$this->db->join('bhw','catchment_area.bhw_id = bhw.user_username');
			$this->db->where('bhw.barangay', $barangay);
			$this->db->where("YEAR(created_on) =".date('Y'));
			$this->db->where("MONTH(created_on) =".date('m'));
			$this->db->order_by('immediate_cases.created_on', 'desc');
			$q = $this->db->get();
			if($q->num_rows() > 0)
			{
				foreach ($q->result() as $row)
				{
						$data[] =array(
						'first_name' => $row->person_first_name ,
						'last_name' => $row->person_last_name ,
						'dob' => $row->person_dob ,
						'Date Onset' => $row->created_on ,
				);
				}
			}
			else $data = null;
			$q->free_result();
			if($data != null) 
			{
			$this->db->from('case_report_main');
			
			
			
			$this->db->where("YEAR(cr_date_onset) =".date('Y'));
			$this->db->where("MONTH(cr_date_onset) =".date('m'));
			$this->db->order_by('cr_date_onset', 'desc');
			$q = $this->db->get();
			
			if($q->num_rows() > 0)
			{$data2=null;
				foreach ($q->result() as $row)
				{
					
					$name = $row->cr_first_name . ' ' . $row->cr_last_name;
					$date = explode ('-', $row->cr_date_onset);
					
					for ($i = 0 ; $i< count($data); $i++)
					{
					if($row->cr_first_name == $data[$i]['first_name'] AND $row->cr_last_name == $data[$i]['last_name'])
					{
						//if($row->cr_barangay == $barangay)
						{
							$data2[] =array(
									'Name' => $name ,
									'Age' => $row->cr_age,
									'Type' => $row->cr_type,
									'Outcome' => $row->cr_outcome,
									'Date Onset' => $date[1].'/'.$date[2].'/'.$date[0],
									'View Details' =>anchor(base_url('index.php/master_list/view_patient').'/'. $row->cr_patient_no ,  'View' , 'target="_blank"'),
							);
						}
					
					}
					}
					
					
				}
			}
			}
			
			
			else $data2 =  null;
			
			
			
			
			return $data2;
		}
		function get_masterlist($bhw = FALSE,$midwife = FALSE)
		{
			$this->db->from('master_list');
			$this->db->join('catchment_area','master_list.person_id = catchment_area.person_id');
		
			$q = $this->db->get();
			if($q->num_rows() > 0)
			{
				if( $bhw != FALSE){
					foreach ($q->result() as $row)
					{
						if($bhw === $row->bhw_id)
						{
							$name = $row->person_first_name . ' ' . $row->person_last_name;
							$date= explode ('-', $row->person_dob);
							if( $row->person_blood_type === null || $row->person_blood_type == 'null')
								$bloodtype = 'Not Indicated';
							else
								$bloodtype = $row->person_blood_type;
							$data[$row->household_id][$row->person_id] =array(
									'Name' => $name ,
									'Birthday'=>$date[1].'/'.$date[2].'/'.$date[0]  ,
									'Contact Nos.'=> $row->person_contactno,
									'Gender'=> $row->person_sex,
									'Marital Status'=> $row->person_marital,
									'Nationality'=> $row->person_nationality,
									'Blood type'=> $bloodtype,
									'Delete'=> anchor(base_url('index.php/master_list/delete_person').'/'. $row->person_id  ,'Delete', 'target="_blank"') ,
							
							);
							$data2[] = array(
									'h_id' => $row->household_id,
									'first_name' => $row->person_first_name,
									'last_name' => $row->person_last_name,
									);
						}
					}
				}
				else {
					foreach ($q->result() as $row)
					{
						$name = $row->person_first_name . ' ' . $row->person_last_name;
						$date= explode ('-', $row->person_dob);
						if( $row->person_blood_type === null || $row->person_blood_type == 'null')
							$bloodtype = 'Not Indicated';
						else
							$bloodtype = $row->person_blood_type;
						$data[$row->household_id][$row->person_id] =array(
								'Name' => $name ,
								'Birthday'=>$date[1].'/'.$date[2].'/'.$date[0]  ,
								'Contact Nos.'=> $row->person_contactno,
								'Gender'=> $row->person_sex,
								'Marital Status'=> $row->person_marital,
								'Nationality'=> $row->person_nationality,
								'Blood type'=> $bloodtype,
								'Delete'=> anchor(base_url('index.php/master_list/delete_person').'/'. $row->person_id  ,'Delete', 'target="_blank"') ,
							
						);
						/*
						$data2[] = array(
								'h_id' => $row->household_id,
								'p_id' => $row->person_id,
								'first_name' => $row->person_first_name,
								'last_name' => $row->person_last_name,
								'dob' => $row->person_dob,
						);
						*/
		
					}
						
				}
				$q->free_result();
	/*
				if($data != null)
				{
					$this->db->from('case_report_main');
					

					$this->db->order_by("cr_date_onset", "asc");
					
					$q = $this->db->get();
						
					if($q->num_rows() > 0)
					{
						foreach ($q->result() as $row)
						{
								for ($i = 0 ; $i< count($data2); $i++)
								{
									if($row->cr_first_name == $data2[$i]['first_name'] AND $row->cr_last_name == $data2[$i]['last_name']  AND $row->cr_dob == $data2[$i]['dob'] )	
									{
										print_r($row->cr_first_name);
										$pid =  $data2[$i]['h_id'];
										$hid =  $data2[$i]['p_id'];
										$data[$hid][$pid]['Previous Dengue Case'] = anchor(base_url('index.php/master_list/view_patient').'/'. $row->cr_patient_no ,  $row->cr_patient_no  , 'target="_blank"');
										
									}
								}

						}
					}
						
						
				}	
				*/
					
				return $data;
			}
			else
			{
				return null;
			}
		
		
		
		}
		
		function get_households($bhw = FALSE,$midwife = FALSE)
		{	
			if ($bhw == FALSE)
			{
				$barangay = $this->get_barangay_midwife($midwife);
				
				$this->db->from('catchment_area');
				$this->db->join('household_address','catchment_area.household_id = household_address.household_id');
				$this->db->join('bhw','catchment_area.bhw_id = bhw.user_username');
				$this->db->join('users','users.user_username = bhw.user_username');
				$this->db->where('barangay', $barangay);
				$this->db->group_by('household_address.house_no');
				$query = $this->db->get();
				return $query->result_array();
				$query->free_result();
			}
			else
			{
				$this->db->from('catchment_area');
				$this->db->join('household_address','catchment_area.household_id = household_address.household_id');
				$this->db->where('catchment_area.bhw_id',$bhw);
				$this->db->group_by('household_address.house_no');
				$query = $this->db->get();
				return $query->result_array();
				$query->free_result();
			}
		}
		
		function add_household($household,$houseno,$street)
		{
			$data = array(
					'household_name' => $household ,
					'house_no' => $houseno ,
					'street' => $street,
					'last_visited' => '0000-00-00',
			);
			
			$this->db->insert('household_address', $data);
			$this->db->select_max('household_id');
			
			$query = $this->db->get('household_address');
			$query = $query->result_array();
			return $query[0]['household_id'];

		}
		function add_catchment_area($houseid,$person_id,$bhw)
		{
			$data = array(
					'household_id' => $houseid ,
					'person_id' => $person_id,
					'bhw_id' => $bhw,
			);
				
			$this->db->insert('catchment_area', $data);
		}
		function add_masterlist($data)
		{
			
			$this->db->insert('master_list', $data);
			
			$this->db->select_max('person_id');
			$query = $this->db->get('master_list');
			$query = $query->result_array();
			return $query[0]['person_id'];
		
		}
		function add_masterlist_midwife($house_id,$data)
		{
			$this->db->from('catchment_area');
			$this->db->join('household_address','catchment_area.household_id = household_address.household_id');
			$this->db->join('bhw','catchment_area.bhw_id = bhw.user_username');
			$this->db->where('catchment_area.household_id', $house_id);
			$this->db->group_by('household_address.house_no');
			$query = $this->db->get();
			$query = $query->result_array();
			$bhw =  $query[0]['user_username'];
			
			$person_id = $this->add_masterlist($data);
			
			$this->add_catchment_area($house_id, $person_id,$bhw );
		}
		
		function get_list($bhw, $person_id = FALSE)
		{
			/*
			$this->db->query('
						SELECT *
						FROM master_list ml 
						INNER JOIN catchment_area ca
							ON ml.person_id = ca.person_id
						INNER JOIN household_address ha
							ON ca.household_id = ha.household_id
						INNER JOIN bhw b
							ON b.user_username = ca.bhw_id
						
					');
			*/
			//$this->db->select();
			$this->db->from('master_list');
			$this->db->join('catchment_area','catchment_area.person_id = master_list.person_id','inner');
			$this->db->join('household_address','household_address.household_id = catchment_area.household_id','inner');
			$this->db->join('bhw','bhw.user_username = catchment_area.bhw_id','inner');
			$this->db->where('catchment_area.bhw_id',$bhw);
			
			if ($person_id === FALSE)
			{
				$query = $this->db->get();
				return $query->result_array();
				$query->free_result();
			}
			
			$query = $this->db->get_where('master_list.person_id',$person_id);
				return $query->row_array();
				$query->free_result();
			
		}
		function get_immediate_case($person_id,$case)
		{
			/*
			 $this->db->query('
			 		SELECT *
			 		FROM master_list ml
			 		INNER JOIN catchment_area ca
			 		ON ml.person_id = ca.person_id
			 		INNER JOIN household_address ha
			 		ON ca.household_id = ha.household_id
			 		INNER JOIN bhw b
			 		ON b.user_username = ca.bhw_id
		
			 		');
			*/
			//$this->db->select();
			$this->db->from('master_list');
			
			$this->db->where('master_list.person_id',$person_id);
			
			$q= $this->db->get();
			if($q->num_rows() > 0)
			{
			foreach ($q->result() as $row)
			{
					$name = $row->person_first_name . ' ' . $row->person_last_name;
					$date= explode ('-', $row->person_dob);
					if( $row->person_blood_type === null || $row->person_blood_type == 'null')
						$bloodtype = 'Not Indicated';
					else
						$bloodtype = $row->person_blood_type;
					$data['table'][]=array(
							'Name' => $name ,
							'Birthday'=>$date[1].'/'.$date[2].'/'.$date[0]  ,
							'Contact Nos.'=> $row->person_contactno,
							'Gender'=> $row->person_sex,
							'Marital Status'=> $row->person_marital,
							'Nationality'=> $row->person_nationality,
							'Blood type'=> $bloodtype,

					);
					$data['hidden']=array(
							'person_id' => $row->person_id,
					); 
			}
			$q->free_result();
			
			$q = null;
			$this->db->from('immediate_cases');
			$this->db->join('master_list','master_list.person_id = immediate_cases.person_id');
			$this->db->where('imcase_no', $case);
			$q = $this->db->get();
			if($q->num_rows() > 0)
			{
				foreach ($q->result() as $row)
				{
		
					$date = explode ('-', $row->created_on);
					$birthDate = explode ('-', $row->person_dob);
					$birthDate = $birthDate[1].'/'.$birthDate[2].'/'.$birthDate[0];
					//explode the date to get month, day and year
					$birthDate = explode("/", $birthDate);
					//get age from date or birthdate
					$age = (date("md", date("U", mktime(0, 0, 0, $birthDate[0], $birthDate[1], $birthDate[2]))) > date("md") ? ((date("Y")-$birthDate[2])-1):(date("Y")-$birthDate[2]));
					$data['symptoms']=array(
							'Severity' => $row->status ,
							'Age' => $age,
							'Days Of Fever' => $row->days_fever ,
							'Muscle Pain' => $row->has_muscle_pain ,
							'Joint Pain' => $row->has_joint_pain ,
							'Head Ache' => $row->has_headache ,
							'Bleeding'  => $row->has_bleeding ,
							'Rashes' => $row->has_rashes ,
							'Remarks' => $row->remarks,
							'Date Onset' => $date[1].'/'.$date[2].'/'.$date[0] ,
					);
					$data['hidden2']=array(
							'imcase_no' => $row->imcase_no,
					);
				}
			}
			
			return $data;
			}
			else return null;
			
			$query->free_result();
				
		}
		function update_immediate_case($data,$id)
		{
			$this->db->where('imcase_no', $id);
			$this->db->update('immediate_cases', $data);
		}
		function delete_person($id)
		{
			$this->db->delete('immediate_cases', array('person_id' => $id));
			$this->db->delete('catchment_area', array('person_id' => $id));
			$this->db->delete('master_list', array('person_id' => $id));
			
		}
		function get_barangay_midwife($midwife)
		{
			$this->db->from('bhw');
			$this->db->where('user_username', $midwife);
			$query = $this->db->get();
			$query = $query->result_array();
			$barangay =  $query[0]['barangay'];
			return $barangay;
		}
		function get_barangay($midwife)
		{
			$this->db->from('bhw');
			$this->db->where('user_username', $midwife);
			$query = $this->db->get();
			$query = $query->result_array();
			$barangay =  $query[0]['barangay'];
			return $barangay;
		}

		
		
		function get_bhw_catchment($midwife)
		{
			$barangay = $this->get_barangay_midwife($midwife);
				
			$this->db->from('immediate_cases');
			$this->db->join('master_list','master_list.person_id = immediate_cases.person_id');
			$this->db->join('catchment_area','master_list.person_id = catchment_area.person_id');
			$this->db->join('bhw','catchment_area.bhw_id = bhw.user_username');
			$this->db->join('users','users.user_username = bhw.user_username');
			$this->db->where('bhw.barangay', $barangay);
			$q = $this->db->get();
			if($q->num_rows() > 0)
			{
				foreach ($q->result() as $row)
				{
		
					$name = $row->person_first_name . ' ' . $row->person_last_name;
					$date = explode ('-', $row->created_on);
					$birthDate = explode ('-', $row->person_dob);
					$birthDate = $birthDate[1].'/'.$birthDate[2].'/'.$birthDate[0];
					//explode the date to get month, day and year
					$birthDate = explode("/", $birthDate);
					//get age from date or birthdate
					$age = (date("md", date("U", mktime(0, 0, 0, $birthDate[0], $birthDate[1], $birthDate[2]))) > date("md") ? ((date("Y")-$birthDate[2])-1):(date("Y")-$birthDate[2]));
					$data[] =array(
							'Name' => $name ,
							'Age' => $age,
							'Days Of Fever' => $row->days_fever ,
							'Muscle Pain' => $row->has_muscle_pain ,
							'Joint Pain' => $row->has_joint_pain ,
							'Head Ache' => $row->has_headache ,
							'Bleedling'  => $row->has_bleeding ,
							'Rashes' => $row->has_rashes ,
							'Date Onset' => $date[1].'/'.$date[2].'/'.$date[0] ,
							'Remarks' => $row->remarks
					);
				}
			}
			else $data = null;
			return $data;
		}
	}

	
/* End of master_list_model.php */
/* Location: ./application/models/master_list_model.php */
