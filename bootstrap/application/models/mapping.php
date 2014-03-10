<?php 
class Mapping extends CI_Model
{
		function __construct()
		{
			parent::__construct();
			//load monica database
			$this->load->database('default');
		}
	function addPolygon($id,$lat,$lng,$name)
		{
			$qString = 'CALL '; 
			$qString .= "add_polygonPoint("; // name of stored procedure
			$qString .= 
			//variables needed by the stored procedure
			$id . "," . 
			$lat . "," . 
			$lng . ",'" .
			$name . "'". ")";
			$query = $this->db->query($qString);
		}
	function delPolygon($name)
		{
			$qString = 'CALL '; 
			$qString .= "delete_polygon('"; // name of stored procedure
			$qString .= 
			//variables needed by the stored procedur
			$name . "'". ")";
			//echo $qString;
			$query = $this->db->query($qString);
		}
	function getPolygonNumberMax()
		{
			$qString = 'CALL getMAX_polygon_number';
			$query = $this->db->query($qString);
			foreach ($query->result() as $row)
			{
				$data=$row->polygon_ID;
			}
			return $data;
		}
	function mapByType($data)
		{//print_r($data);
			$returnValues['larvalValues'] =null;
			$returnValues['dengueValues'] =null;
			$returnValues['denguePoIDistanceValues'] =null;
			$returnValues['denguePoIBounceValues'] =null;
			$returnValues['dengueLarvalDistanceValues'] =null;
			$returnValues['dengueLarvalBounceValues'] =null;
			$returnValues['poiValues'] =null;
			$returnValues['poiDistanceValues'] =null;
			$returnValues['householdValues'] =0;
			$returnValues['householdDistanceValues'] =null;
			$returnValues['bbValues'] =null;//echo $data['date1']." ".$data['date2'];
			if($data['getLarva'])
			{//*
				$where="";
				$this->db->from('ls_report');
				$this->db->join('household_address', 'ls_report.ls_household=household_address.household_name');
				$this->db->join('users', 'users.user_username=ls_report.created_by');
				if ($data['brgy'] != NULL)
				{
					$where = "ls_barangay ='";
					foreach($data['brgy'] as $varr)
					{
						$where .= $varr."' OR ";
					}
					$where = (substr($where,0,-3));
					$where.=" AND ";
				}
				$where .= "created_on BETWEEN '".$data['date1']."' AND '".$data['date2']."'";
				$this->db->where($where);
				$this->db->group_by("ls_no"); 
				$q = $this->db->get();
				if($q->num_rows() > 0) 
				{	$tempp;
					foreach ($q->result() as $row) 
					{
						$tempp[]=array(
								'id'=> $row->ls_no,
								'householdId'=> $row->household_id,
								'household'=> $row->ls_household,
								'container'=> $row->ls_container,
								'lat'=> $row->ls_lat,
								'lng'=> $row->ls_lng,
								'createdBy'=> $row->created_by,
								'createdOn'=> $row->created_on,
								'updatedBy'=> $row->last_updated_by,
								'updatedOn'=> $row->last_updated_on,
								'barangay'=> $row->ls_barangay,
								'bhwID'=> $row->created_by,
								'bhwName'=> ($row->user_lastname.", ".$row->user_firstname." ".$row->user_middlename)
						);
					}//print_r($tempp);
					$returnValues['larvalValues'] =  $tempp;
					unset($tempp);
				}
			}
			if($data['getBB'])
			{
				$where="";
				$this->db->from('map_polygons');
				if ($data['brgy'] != NULL)
				{
					$where = "polygon_name ='";
					foreach($data['brgy'] as $varr)
					{
						$where .= $varr."' OR ";
					}
					$this->db->where(substr($where,0,-3));
				}//print_r($data['brgy'][0]);
				$q = $this->db->get();
				if($q->num_rows() > 0) 
				{	$temper;
					foreach ($q->result() as $row) 
					{
						$temper[]=array(//*
								'pName'=> $row->polygon_name,
								'pID'=> $row->polygon_ID,
								'lat'=> $row->point_lat,
								'lng'=> $row->point_lng
								//*/
						);
					}
					$returnValues['bbValues'] =  $temper;
				}
				$q->free_result();
			}
			if($data['getDengue'])
			{
				$where="";
				$this->db->select("imcase_no,active_cases.person_id,has_muscle_pain,has_joint_pain,has_headache,has_bleeding,has_rashes,days_fever,created_on,last_updated_on,suspected_source,remarks,status,household_address.household_id,bhw_id,household_name,house_no,street,household_lat,household_lng,user_username,barangay,MAX(visit_date) AS 'visit_date',person_first_name,person_last_name,person_dob,person_sex,person_marital,person_nationality,person_blood_type,person_guardian,person_adu,person_contactno");
				$this->db->from('active_cases');
				$this->db->join('catchment_area', 'catchment_area.person_id = active_cases.person_id');
				$this->db->join('household_address', 'household_address.household_id = catchment_area.household_id');
				$this->db->join('bhw', 'bhw.user_username = catchment_area.bhw_id');
				$this->db->join('house_visits', 'house_visits.household_id = household_address.household_id');
				$this->db->join('master_list', 'master_list.person_id = catchment_area.person_id');
				if ($data['brgy'] != NULL)
				{
					$where = "barangay ='";
					foreach($data['brgy'] as $varr)
					{
						$where .= $varr."' OR ";
					}
					$where = (substr($where,0,-3));
					$where.=" AND ";
				}
				$where .= "last_updated_on BETWEEN '".$data['date1']."' AND '".$data['date2']."'";
				$this->db->where($where);
				$this->db->group_by('active_cases.person_id');
				$q = $this->db->get();
				$tempest=array();
				if($q->num_rows() > 0) 
				{	
					foreach ($q->result() as $row) 
					{
						$tempest[]=array(//*
								'id'=> $row->imcase_no,
								'personID'=> $row->person_id,
								'hasMusclePain'=> $row->has_muscle_pain,
								'hasJointPain'=> $row->has_joint_pain,
								'hasHeadache'=> $row->has_headache,
								'hasBleeding'=> $row->has_bleeding,
								'hasRashes'=> $row->has_rashes,
								'daysFever'=> $row->days_fever,
								'createdOn'=> $row->created_on,
								'lastUpdatedOn'=> $row->last_updated_on,
								'suspectedSource'=> $row->suspected_source,
								'remarks'=> $row->remarks,
								'status'=> $row->status,
								'householdID'=> $row->household_id,
								'personID'=> $row->person_id,
								'bhwID'=> $row->bhw_id,
								'householdName'=> $row->household_name,
								'houseNo'=> $row->house_no,
								'street'=> $row->street,
								'lastVisited'=> $row->visit_date,
								'lat'=> $row->household_lat,
								'lng'=> $row->household_lng,
								'bhwName'=> $row->user_username,
								'barangay'=> $row->barangay,
								'fName'=> $row->person_first_name,
								'lName'=> $row->person_last_name,
								'dob'=> $row->person_dob,
								'sex'=> $row->person_sex,
								'guardian'=> $row->person_guardian,
								'contact'=> $row->person_contactno
								//*/
						);
					}//print_r("XSXSX".$tempest);
					//$returnValues['dengueValues'] =  $tempest;
				}
				$q->free_result();
				if(!$data['getActiveDengueOnly'])
				{
					$this->db->select("imcase_no,previous_cases.person_id,has_muscle_pain,has_joint_pain,has_headache,has_bleeding,has_rashes,days_fever,created_on,last_updated_on,suspected_source,remarks,outcome,household_address.household_id,bhw_id,household_name,house_no,street,household_lat,household_lng,user_username,barangay,MAX(visit_date) AS 'visit_date',person_first_name,person_last_name,person_dob,person_sex,person_marital,person_nationality,person_blood_type,person_guardian,person_adu,person_contactno");
					$this->db->from('previous_cases');
					$this->db->join('catchment_area', 'catchment_area.person_id = previous_cases.person_id');
					$this->db->join('household_address', 'household_address.household_id = catchment_area.household_id');
					$this->db->join('bhw', 'bhw.user_username = catchment_area.bhw_id');
					$this->db->join('house_visits', 'house_visits.household_id = household_address.household_id');
					$this->db->join('master_list', 'master_list.person_id = catchment_area.person_id');
					$this->db->where($where);
					$this->db->group_by('previous_cases.person_id');
					$q = $this->db->get();
					if($q->num_rows() > 0)
					{	//$tempest;
						foreach ($q->result() as $row)
						{
							$tempest[]=array(//*
									'id'=> $row->imcase_no,
									'personID'=> $row->person_id,
									'hasMusclePain'=> $row->has_muscle_pain,
									'hasJointPain'=> $row->has_joint_pain,
									'hasHeadache'=> $row->has_headache,
									'hasBleeding'=> $row->has_bleeding,
									'hasRashes'=> $row->has_rashes,
									'daysFever'=> $row->days_fever,
									'createdOn'=> $row->created_on,
									'lastUpdatedOn'=> $row->last_updated_on,
									'suspectedSource'=> $row->suspected_source,
									'remarks'=> $row->remarks,
									'outcome'=> $row->outcome,
									'householdID'=> $row->household_id,
									'personID'=> $row->person_id,
									'bhwID'=> $row->bhw_id,
									'householdName'=> $row->household_name,
									'houseNo'=> $row->house_no,
									'street'=> $row->street,
									'lastVisited'=> $row->visit_date,
									'lat'=> $row->household_lat,
									'lng'=> $row->household_lng,
									'bhwName'=> $row->user_username,
									'barangay'=> $row->barangay,
									'fName'=> $row->person_first_name,
									'lName'=> $row->person_last_name,
									'dob'=> $row->person_dob,
									'sex'=> $row->person_sex,
									'guardian'=> $row->person_guardian,
									'contact'=> $row->person_contactno
									//*/
							);
						}
					}
				}
				$returnValues['dengueValues'] =  $tempest;
				$q->free_result();
			}
			if ($data['getHouseholds'])//all polygons
			{
				$qry="
					SELECT household_address.household_id,household_name,house_no,street,household_lat,household_lng,catchment_area.person_id, bhw_id,users.user_username,barangay,person_first_name,person_last_name,person_dob,person_sex,person_marital,person_nationality,person_blood_type,person_guardian,person_adu,person_contactno,date(visit_date) as 'visit_date', users.user_firstname, users.user_middlename, users.user_lastname
					FROM household_address
					JOIN catchment_area ON catchment_area.household_id = household_address.household_id
					JOIN bhw ON catchment_area.bhw_id = bhw.user_username
					JOIN master_list ON master_list.person_id = catchment_area.person_id
					JOIN house_visits ON house_visits.household_id = household_address.household_id
					JOIN users ON users.user_username = bhw.user_username
					WHERE catchment_area.household_id IN (
						SELECT household_address.household_id
						FROM demo.household_address
						JOIN catchment_area ON catchment_area.household_id = household_address.household_id
						JOIN previous_cases ON catchment_area.person_id = previous_cases.person_id
						JOIN active_cases ON catchment_area.person_id = active_cases.person_id
						JOIN ls_report ON ls_report.ls_household = household_address.household_name
						WHERE (DATE(previous_cases.created_on) BETWEEN '".$data['date1']."' AND '".$data['date2']."') OR 
							(DATE(active_cases.created_on) BETWEEN '".$data['date1']."' AND '".$data['date2']."') OR
							(DATE(ls_report.created_on) BETWEEN '".$data['date1']."' AND '".$data['date2']."')
					)";
			
				if ($data['brgy'] != NULL)
				{
					$qry .= "AND bhw.barangay ='";
					foreach($data['brgy'] as $varr)
					{
						$qry .= $varr."' OR ";
					}
					$qry = (substr($qry,0,-3));
				}
				$q = $this->db->query($qry);
				
				if($q->num_rows() > 0) 
				{	$tempall;
					foreach ($q->result() as $row) 
					{
						$tempall[]=array(//*
								'id'=> $row->household_id,
								'houseName'=> $row->household_name,
								'houseNo'=> $row->house_no,
								'street'=> $row->street,
								'lastVisited'=> $row->visit_date,
								'lat'=> $row->household_lat,
								'lng'=> $row->household_lng,
								'personID'=> $row->person_id,
								'bhwID'=> $row->bhw_id,
								'bhwUsername'=> $row->user_username,
								'householdBarangay'=> $row->barangay,
								'personFName'=> $row->person_first_name,
								'personLName'=> $row->person_last_name,
								'personDoB'=> $row->person_dob,
								'personSex'=> $row->person_sex,
								'bhwFName'=> $row->user_firstname,
								'bhwMName'=> $row->user_middlename,
								'bhwLName'=> $row->user_lastname
								//*/
						);
					}
					$returnValues['householdValues'] =  $tempall;
				}
				$q->free_result();
			}
			if ($data['getPoI'])//all polygons
			{
				$where="";
				$this->db->from('map_nodes');
				if ($data['brgy'] != NULL)
				{
					$where = "node_barangay ='";
					foreach($data['brgy'] as $varr)
					{
						$where .= $varr."' OR ";
					}
					$where = (substr($where,0,-3));
					$where.=" AND ";
				}
				$where .= "(node_addedOn <= '".$data['date1']."' AND (node_endDate >= '".$data['date2']."' OR node_endDate = '0000-00-00'))";
				$this->db->where($where);
				$q = $this->db->get();
				if($q->num_rows() > 0) 
				{	$temppoi;
					foreach ($q->result() as $row) 
					{
						if($row->node_type==0)
						{
							$temp="<br/>Potential Source Area <br/><i>(Commonly bodies of water or abandoned areas)</i>";
						}
						else
						{
							$temp="<br/>Potential Risk Area <br/><i>(Commonly areas with high population density or traffic)</i>";
						}
						$temppoi[]=array(//*
								'id'=> $row->node_no,
								'name'=> $row->node_name,
								'lat'=> $row->node_lat,
								'lng'=> $row->node_lng,
								'notes'=> $row->node_notes."<br/>".$temp,
								'type'=> $row->node_type,
								'addedOn'=> $row->node_addedOn,
								'endDate'=> $row->node_endDate,
								'barangay'=> $row->node_barangay
								//*/
						);
					}
					$returnValues['poiValues'] =  $temppoi;
				}
				$q->free_result();
			}
			if($returnValues['dengueValues'] != null)
			{
				$temp=null;
				if($returnValues['poiValues'] != null)
				{
					$poi=$this->compareArraysDistanceFormula($returnValues['dengueValues'],$returnValues['poiValues']);
					$invariant=count($returnValues['dengueValues']);
					$temparr=null;//print_r($poi);
					for($i=0;$i < $invariant; $i++)
					{
						$temp="0";
						if($poi[$i] != 0)
						{
							$_invariant=count($poi[$i]);
							$temp="<b>".$_invariant."</b> Points of Interest(s) Detected Nearby.<br/>";
							for($_i=0;$_i < $_invariant; $_i++)
							{
								$temp.=$poi[$i][$_i]['name']."<br/>";
								$returnValues['denguePoIBounceValues'][] = $poi[$i][$_i]['id'];
							}
						}
						$temparr[]=$temp;
						$temp="";
					}
					$returnValues['denguePoIDistanceValues']=$temparr;
					unset($temparr);
					$poi=null;
				}
				if($returnValues['larvalValues'] != null)
				{//print_r("ATTENTION");
					$larval=$this->compareArraysDistanceFormula($returnValues['dengueValues'],$returnValues['larvalValues']);
					$invariant=count($returnValues['dengueValues']);
					$temparr=null;
					for($i=0;$i < $invariant; $i++)
					{	//$temp=null;
						$temp="0";
						if($larval[$i] != 0)
						{
							$_invariant=count($larval[$i]);
							$temp="<b>".$_invariant."</b> Larval Positive(s) Detected Nearby.<br/>";
							for($_i=0;$_i < $_invariant; $_i++)
							{
								$temp.=$larval[$i][$_i]['household']." Household, ".$larval[$i][$_i]['container']."<br/>";
								$returnValues['dengueLarvalBounceValues'][] = $larval[$i][$_i]['id'];
							}
						}
						$temparr[]=$temp;
						$temp="";
					}
					$returnValues['dengueLarvalDistanceValues']=$temparr;
					unset($temparr);
					$larval=null;
				}				
			}
			return $returnValues;
		}
	function compareArraysDistanceFormula($arr1, $arr2)
		{
			$retVal=array();
			$arr1length=count($arr1);
			$arr2length=count($arr2);
			for($i=0;$i<$arr1length;$i++)
			{
				$retChild=null;
				$amount200a=0;
				$lat_a = $arr1[$i]['lat'] * PI()/180;
				$long_a = $arr1[$i]['lng'] * PI()/180;
				for($_i=0;$_i<$arr2length;$_i++)
				{
					$distance=0;
					//echo "Comparing ".$data[$i][0]." and ".$data[$_i][0]." ";
				    $lat_b = $arr2[$_i]['lat'] * PI()/180;
				    $long_b = $arr2[$_i]['lng'] * PI()/180;
				    $distance =
				    	acos(
				        	sin($lat_a) * sin($lat_b) +
				            cos($lat_a) * cos($lat_b) * cos($long_b - $long_a)
				        ) * 6371;
				    $distance*=1000;
                	if ($distance<=200)
					{
						$retChild[]=$arr2[$_i];
					}
				}
				$retVal[]=$retChild;
				unset($retChild);
			}//print_r($retVal);
		return $retVal;
		}
		/*
	function getHouseholds($brgy = null)//all polygons
		{
		}
		//*/
	function weatherMapping($data)
	{
		$qString = 'CALL ';
		$qString .= "get_weather('"; // name of stored procedure
		$qString .=
		//variables needed by the stored procedure
		$data['date1']. "','".
		$data['date2']. "'". ")";
		
		$q = $this->db->query($qString);
		$data="";
		$ctr=0;
		$color="";
		if($q->num_rows() > 0) 
		{
			foreach ($q->result() as $row)
			{
				if($row->amount==0)
				{
					$color="C8FFFF";
				}
				else if($row->amount>0 && $row->amount<=5)
				{
					$color="96FFFF";
				}
				else if($row->amount>6 && $row->amount<=10)
				{
					$color="64FFFF";
				}
				else if($row->amount>11 && $row->amount<=15)
				{
					$color="32FFFF";
				}
				else if($row->amount>16 && $row->amount<=20)
				{
					$color="00FFFF";
				}
				else if($row->amount>21 && $row->amount<=25)
				{
					$color="00C8FF";
				}
				else if($row->amount>26 && $row->amount<=30)
				{
					$color="0096FF";
				}
				else if($row->amount>31 && $row->amount<=35)
				{
					$color="0064FF";
				}
				else if($row->amount>36 && $row->amount<=40)
				{
					$color="0032FF";
				}
				else if($row->amount>41 && $row->amount<=45)
				{
					$color="0000FF";
				}
				$data .=
				$row->barangay . "&&" . 
				$color . "%%";
				$ctr++;
			}
		}
		//echo ($data);
		return substr($data,0,-2);
	}
	function calculateDistanceFormula($data)
		{
			//QUERY LARVAL INFORMATION
			$qString = 'CALL ';
			$qString .= "view_larval_nodes('"; // name of stored procedure
			$qString .=
			//variables needed by the stored procedure
			$data['date1']. "','".
			$data['date2']. "'". ")";
			
			$q = $this->db->query($qString);
			
			
			//*
			$data=[];
			$ctr=0;
			if($q->num_rows() > 0) 
			{	
				foreach ($q->result() as $row) 
				{
					$data[$ctr][0] =$row->ls_no;
					$data[$ctr][1] =$row->ls_lat;
					$data[$ctr][2] =$row->ls_lng;
					$ctr++;
				}
			}
			else
			{
				$data[0][0]=0;
				$data[0][1]=0;
				$data[0][2]=0;
			}
			$dist="";
			//echo count($data);
			$datalength=count($data);
			for($i=0;$i<=$datalength-1;$i++)
			{
				$amount200a=0;
				$amount200p=0;
				$amount50a=0;
				$amount50p=0;
				$lat_a = $data[$i][1] * PI()/180;
				$long_a = $data[$i][2] * PI()/180;
				for($_i=0;$_i<=$datalength-1;$_i++)
				{
					$distance=0;
					if($data[$i][0]!==$data[$_i][0])
					{
						//echo "Comparing ".$data[$i][0]." and ".$data[$_i][0]." ";
				        $lat_b = $data[$_i][1] * PI()/180;
				        $long_b = $data[$_i][2] * PI()/180;
				        $distance =
				                acos(
				                        sin($lat_a ) * sin($lat_b) +
				                        cos($lat_a) * cos($lat_b) * cos($long_b - $long_a)
				                ) * 6371;
				        $distance*=1000;
                		if ($distance<=50)
						{
							$amount50a++;
							$amount200a++;
						}
						else if ($distance<=200)
						{
							$amount200a++;
						}
					}
				}
				$amount200p=100*number_format($amount200a/count($data),2,'.','');
				$amount50p=100*number_format($amount50a/count($data),2,'.','');
				$dist.=$data[$i][0]."&&".$amount200a."&&".$amount200p."&&".$amount50a."&&".$amount50p."%%";
			}
			return substr($dist,0,-2);
		}
	function getPointsOfInterest($d)//all polygons
		{	
			if($d)
			{

				$qString = 'CALL ';
				$qString .= "view_PoI_nodes()"; // name of stored procedure
					
				$q = $this->db->query($qString);
				//*
				$data="";
				if($q->num_rows() > 0)
				{
					foreach ($q->result() as $row)
					{
						if($row->node_type==0)
						{
							$temp="Potential Source Area <br/><i>(Commonly bodies of water or abandoned areas)</i>";
						}
						else
						{
							$temp="Potential Risk Area <br/><i>(Commonly areas with high population density or traffic)</i>";
						}
						$data .=
						$row->node_name . "&&" .
						$row->node_lat . "&&" .
						$row->node_lng . "&&" .
						$temp . "&&" .
						$row->node_notes . "&&" .
						$row->node_barangay . "&&" .
						$row->node_city . "&&" .
						$row->node_addedOn . "&&" .
						$row->node_type . "%%" ;
					}
				
					$q->free_result();
					return substr($data,0,-2);
				}
				else
				{
					$q->free_result();
					return 0;
				}
			}
		}
		//*/
		function getBarangayAgesF($data)
		{
			$tempage1;//print_r($tempage1);
			//echo $data['node_type'];
			$qry="
					SELECT barangay, count(barangay) as amount,floor((year(curdate())-year(person_dob) - (right(curdate(),5) < right(person_dob,5))) /10) as agerange
					FROM `active_cases` 
					JOIN `master_list` ON `master_list`.`person_id` = `active_cases`.`person_id`
					JOIN `catchment_area` ON `master_list`.`person_id` = `catchment_area`.`person_id`
					JOIN `bhw` ON `catchment_area`.`bhw_id` = `bhw`.`user_username`";
			
			if ($data['brgy'] != NULL)
			{
				$qry .= "node_barangay ='";
				foreach($data['brgy'] as $varr)
				{
					$qry .= $varr."' OR ";
				}
				$qry = (substr($qry,0,-3));
				$qry.=" AND ";
			}
			$qry .= "WHERE created_on BETWEEN '".$data['date1']."' AND '".$data['date2']."'";
			
			$qry .=" GROUP BY barangay,FLOOR((year(curdate())-year(person_dob) - (right(curdate(),5) < right(person_dob,5))) /10);";
			$q = $this->db->query($qry);
			//*
			if($q->num_rows() > 0)
			{
				foreach ($q->result() as $row)
				{
					$tempage1[]=array(//*
								'bgy'=> $row->barangay,
								'amt'=> $row->amount,
								'rng'=> $row->agerange
								//*/
						);
				}//print_r("1");
			}//print_r($tempage1);
			$q->free_result();
			
			//echo $data['node_type'];
			$qry="
					SELECT barangay, count(barangay) as amount,floor((year(curdate())-year(person_dob) - (right(curdate(),5) < right(person_dob,5))) /10) as agerange
					FROM `previous_cases`
					JOIN `master_list` ON `master_list`.`person_id` = `previous_cases`.`person_id`
					JOIN `catchment_area` ON `master_list`.`person_id` = `catchment_area`.`person_id`
					JOIN `bhw` ON `catchment_area`.`bhw_id` = `bhw`.`user_username` ";
				
			if ($data['brgy'] != NULL)
			{
				$qry .= "barangay ='";
				foreach($data['brgy'] as $varr)
				{
					$qry .= $varr."' OR ";
				}
				$qry = (substr($qry,0,-3));
				$qry.=" AND ";
			}
			$qry .= "WHERE created_on BETWEEN '".$data['date1']."' AND '".$data['date2']."'";
				
			$qry .=" GROUP BY barangay,FLOOR((year(curdate())-year(person_dob) - (right(curdate(),5) < right(person_dob,5))) /10);";
			$q = $this->db->query($qry);
			//*
			$data = "";
			if($q->num_rows() > 0)
			{
				foreach ($q->result() as $row)
				{
					$tempage1[]=array(//*
								'bgy'=> $row->barangay,
								'amt'=> $row->amount,
								'rng'=> $row->agerange
								//*/
						);
				}//print_r("2");
			}
			$q->free_result();
			$invariant=count($tempage1);
			for($i=0; $i<$invariant;$i++)
			{
				for($_i=0; $_i<$invariant;$_i++)
				{
					if (isset($tempage1[$i]) && isset($tempage1[$_i]))
					{
						if(($_i != $i) && ($tempage1[$i]['bgy'] == $tempage1[$_i]['bgy']) )
						{
							if($tempage1[$i]['rng'] == $tempage1[$_i]['rng'])
							{
								$tempage1[$i]['amt']=($tempage1[$i]['amt']+$tempage1[$_i]['amt']);
								unset($tempage1[$_i]);
							}
						}
					}
				}
			}
			//print_r($tempage1);
			$ret;
			
			foreach ($tempage1 as $row)
			{
				$agerange=null;
				if($row['rng']*10==0)
				{
					$agerange = ($row['rng']*10)."-".(($row['rng']*10)+10);
				}
				else
					$agerange = ($row['rng']*10+1)."-".(($row['rng']*10)+10);
			
				$ret[]=array(
						'cr_barangay'=> $row['bgy'],
						'patientcount'=> $row['amt'],
						'agerange'=>$agerange
				);
			}
			//print_r($ret);
			return $ret;
			//*/
		}
		function getBarangayAges2($data2)
		{
			//echo $data['node_type'];
			$qString = 'CALL ';
			$qString .= "get_empty_barangays()";
			$q = $this->db->query($qString);
			//*
			$data = "";
			if($q->num_rows() > 0)
			{
				foreach ($q->result() as $row)
				{
					$data .=
					$row->barangay . "&&0%%";
				}
			}
			$q->free_result();
		
			//echo $data['node_type'];
			$qString = 'CALL ';
			$qString .= "get_case_ages2('"; // name of stored procedure
			$qString .=
			//variables needed by the stored procedure
			$data2['date1']. "','".
			$data2['date2']. "'". ")";
			$qString." END ";
			$q = $this->db->query($qString);
			//*
			if($q->num_rows() > 0)
			{
				foreach ($q->result() as $row)
				{
					$data .=
					$row->cr_barangay . "&&" .
					$row->cr_age . "%%" ;
				}
				$q->free_result();
			}
			else
			{
				$q->free_result();
			}
			return substr($data,0,-2);
			//*/
		}
		function getBarangayAges($data2)
		{
			$qString = 'CALL ';
			$qString .= "get_case_ages('"; // name of stored procedure
			$qString .=
			//variables needed by the stored procedure
			$data2['date1']. "','".
			$data2['date2']. "'". ")";
			$qString." END ";
			$data[]=array(
				'cr_barangay'=>'Barangay',
				'pateintcount'=> 'Patient Count',
				'agerange'=> 'Age Range'
			);
				
			$q = $this->db->query($qString);
			//*
			if($q->num_rows() > 0)
			{
				foreach ($q->result() as $row)
				{
					$agerange=null;
					if($row->agerange*10==0)
					{
						$agerange = ($row->agerange*10)."-".(($row->agerange*10)+10);
					}
					else
						$agerange = ($row->agerange*10+1)."-".(($row->agerange*10)+10);
						
					$data[]=array(
						'cr_barangay'=> $row->cr_barangay,
						'patientcount'=> $row->patientcount,
						$agerange
					);
				}
				$q->free_result();
				return $data;
			}
			else
			{
				$q->free_result();
				return "";
			}
			//*/
		}
		function getBarangayAgesS($data2)//returns String for echoing directly to HTML
		{
			$qString = 'CALL ';
			$qString .= "get_case_ages('"; // name of stored procedure
			$qString .=
			//variables needed by the stored procedure
			$data2['cdate1']. "','".
			$data2['cdate2']. "'". ")";
			$qString." END ";
			$q = $this->db->query($qString);
		
			$arr1=[];
			$arr2=[];
			$temparr1=[];
			$temparr2=[];
			$swapped=false;
				
			$data=null;
		
			//*
			if($q->num_rows() > 0)
			{
				foreach ($q->result() as $row)
				{
					array_push($temparr1,array(
						'cr_barangay'=>$row->cr_barangay,
						'patientcount'=>$row->patientcount,
						'agerange'=>$row->agerange
					));
				}
			}
			//*/
			$q->free_result();
		
			$qString = 'CALL ';
			$qString .= "get_case_ages('"; // name of stored procedure
			$qString .=
			//variables needed by the stored procedure
			$data2['pdate1']. "','".
			$data2['pdate2']. "'". ")";
			$qString." END ";
			$q = $this->db->query($qString);
		
			//*
			if($q->num_rows() > 0)
			{
				foreach ($q->result() as $row)
				{
					array_push($temparr2,array(
						'cr_barangay'=>$row->cr_barangay,
						'patientcount'=>$row->patientcount,
						'agerange'=>$row->agerange
					));
				}
			}
			//*/
			$q->free_result();
			if(count($temparr1)>=count($temparr2))
			{
				$arr1=$temparr1;
				$arr2=$temparr2;
			}
			else
			{
				$arr1=$temparr2;
				$arr2=$temparr1;
				$swapped=true;
			}
			
			$data.="
				<table border='1' cellpadding='5' cellspacing='0' id='results' >
				<tr>
				<th>Barangay</th>
				<th>Current Patient Count</th>
				<th>Previous Patient Count</th>
				<th>Age Range</th>
				</tr>";
			$isSpanned=false;
			$llength=count($arr1);
			$slength=count($arr2);
			$arr1Pushtimes=0;
			$arr2Pushtimes=0;
			for($i=0;$i<$llength;$i++)
			{
				if(!array_key_exists($i, $arr1))
				{
					$arrTemp['cr_barangay']=$arr2[$i]['cr_barangay'];
					$arrTemp['patientcount']=0;
					$arrTemp['agerange']=$arr2[$i]['agerange'];
					array_push($arr1,$arrTemp);
				}
				if(!array_key_exists($i, $arr2))
				{
					$arrTemp['cr_barangay']=$arr1[$i]['cr_barangay'];
					$arrTemp['patientcount']=0;
					$arrTemp['agerange']=$arr1[$i]['agerange'];
					array_push($arr2,$arrTemp);
				}
				if($arr1[$i]['agerange']!=$arr2[$i]['agerange'])
				{
					if($arr1[$i]['agerange']<$arr2[$i]['agerange'])
					{
						$arrTemp['cr_barangay']=$arr1[$i]['cr_barangay'];
						$arrTemp['patientcount']=0;
						$arrTemp['agerange']=$arr1[$i]['agerange'];
						
						$newArray = array();
						$inserted = false;							
						foreach( $arr2 as $key => $value ) 
						{							
							if( !$inserted && $key === ($i+1) ) 
							{
								$newArray[ $i ] = $arrTemp;
								$inserted = true;
							}							
							$newArray[ $key ] = $value;							
						}
						$arr2 = $newArray;
						
						$slength=count($arr2);
					}
					else
					{
						$arrTemp['cr_barangay']=$arr2[$i]['cr_barangay'];
						$arrTemp['patientcount']=0;
						$arrTemp['agerange']=$arr2[$i]['agerange'];
						
						$newArray = array();
						$inserted = false;							
						foreach( $arr1 as $key => $value ) 
						{							
							if( !$inserted && $key === ($i+1) ) 
							{
								$newArray[ $i ] = $arrTemp;
								$inserted = true;
							}							
							$newArray[ $key ] = $value;							
						}
						$arr1 = $newArray;
						
						$llength=count($arr2);
					}
					if($slength>$llength)
					{
						$llength=$slength;
					}
				}
			}
			//echo count($arr1)." ";
			//echo count($arr2)." ";
			for($i=0; $i<count($arr1); $i++)
			{
				//ROW CREATION
				if($i % 2 == 0 )
				{
					$data.="<tr style='background-color: #e3e3e3'>";
				}
				else
				{
					$data.="<tr>";
				}
				
				//FIRST CELL (BARANGAY)
				$ctr=1;
				while(array_key_exists($i+$ctr,$arr1)&&$arr1[$i]['cr_barangay']==$arr1[$i+$ctr]['cr_barangay']&&!$isSpanned)
				{
					$ctr++;
				}
				if(!$isSpanned)
				{
					$data.=
					"<td align='center' rowspan='".$ctr."'>".$row->cr_barangay."</td>";
				}
				if(array_key_exists($i+$ctr,$arr1)&&$arr1[$i]['cr_barangay']==$arr1[$i+1]['cr_barangay'])
					$isSpanned=true;
				else
					$isSpanned=false;
				
				//SECOND AND THIRD CELLS (COUNT)
				if($swapped)
				$data.=
					"<td align='center'>".$arr1[$i]['patientcount']."</td>".
					"<td align='center'>".$arr2[$i]['patientcount']."</td>";
				else
				$data.=
					"<td align='center'>".$arr2[$i]['patientcount']."</td>".
					"<td align='center'>".$arr1[$i]['patientcount']."</td>";				
				
				//FOURTH CELL (AGERANGE)
				$agerange = ($arr1[$i]['agerange']*10)."-".(($arr1[$i]['agerange']*10)+10);
				$data.=
					"<td align='center'>".$agerange."</td>".
					"</tr>";
			}
			$data.="</table>";
			return $data;
		}
		function getBarangayCount($data2)
		{	
			$qString = 'CALL '; 
			$qString .= "get_empty_barangays()";
			$q = $this->db->query($qString);
			//*
			$data = "";
			if($q->num_rows() > 0) 
			{
				foreach ($q->result() as $row) 
				{
					$data .=
					$row->barangay . "&&0&&".$row->polygon_ID."%%";
				}
			}
			$q->free_result();
				
			$qString = 'CALL '; 
			$qString .= "get_brangay_count('"; // name of stored procedure
			$qString .= 
			//variables needed by the stored procedure
			$data2['date1']. "','". 
			$data2['date2']. "'". ")";
			$qString." END ";
			$q = $this->db->query($qString);
			//*
			if($q->num_rows() > 0) 
			{
				foreach ($q->result() as $row) 
				{
					$data .=
					$row->barangay . "&&" . 
					$row->amount . "&&" . 
					$row->polygon_ID . "%%" ;
				}
				$q->free_result();
				return substr($data,0,-2);
			}
			else
			{
				$q->free_result();
				return substr($data,0,-2);
			}
			//*/
		}
		function getBarangayInfo($data2)
		{
			$qString = 'CALL ';
			$qString .= "get_empty_barangays()";
			$q = $this->db->query($qString);
			//*
			$data = "";
			if($q->num_rows() > 0)
			{
				foreach ($q->result() as $row)
				{
					$data .=
					$row->barangay . "&&0&&0&&0&&0&&0&&0&&0&&0%%";
				}
			}
			$q->free_result();
				
			$qString = 'CALL ';
			$qString .= "get_brangay_count('"; // name of stored procedure
			$qString .=
			//variables needed by the stored procedure
			$data2['date1']. "','".
			$data2['date2']. "'". ")";
			$qString." END ";
			$q = $this->db->query($qString);
			//*
			if($q->num_rows() > 0)
			{
				foreach ($q->result() as $row)
				{
					$data .=
					$row->barangay . "&&" .
					$row->gendF . "&&" .
					$row->gendM . "&&" .
					$row->ageMin . "&&" .
					$row->ageMax . "&&" .
					$row->ageAve . "&&" .
					$row->outA . "&&" .
					$row->outD . "&&" .
					$row->outU . "%%" ;
				}
				$q->free_result();
				return substr($data,0,-2);
			}
			else
			{
				$q->free_result();
				return substr($data,0,-2);
			}
			//*/
		}
		function getBarangays()
		{		
			$qString = 'CALL '; 
			$qString .= "get_barangays("; // name of stored procedure
			$qString .= 
			//variables needed by the stored procedure
			")";
			
			$q = $this->db->query($qString);
			//*
			if($q->num_rows() > 0) 
			{
				foreach ($q->result() as $row) 
				{
					$data[$row->barangay]= $row->barangay;
				}
				
				$q->free_result();
				//print_r($data);
			}
			else
			{
				$q->free_result();
				$data[]=null;
			}
			return $data;
			//*/
		}
		function getAllBarangays()
		{	
			$qString = 'CALL '; 
			$qString .= "get_allbarangays("; // name of stored procedure
			$qString .= 
			//variables needed by the stored procedure
			")";
			
			$q = $this->db->query($qString);
			//*
			if($q->num_rows() > 0) 
			{
				foreach ($q->result() as $row) 
				{
					$data[$row->barangay]= $row->barangay;
				}
				
				$q->free_result();
				//print_r($data);
			}
			else
			{
				$q->free_result();
				$data[]=null;
			}
		return $data;
			//*/
		}
		function getNodes($data2)
		{	
			$qString = 'CALL '; 
			$qString .= "get_brangay_count('"; // name of stored procedure
			$qString .= 
			//variables needed by the stored procedure
			$data2['date1']. "','". 
			$data2['date2']. "'". ")";
			
			$q = $this->db->query($qString);
			//*
			if($q->num_rows() > 0) 
			{	$data = "";
				foreach ($q->result() as $row) 
				{
					$data .=
					$row->polygon_ID . "&&" .
					$row->cr_barangay . "&&" . 
					$row->amount . "%%" ;
				}
				$q->free_result();
				return substr($data,0,-2);
			}
			else
			{
				$q->free_result();
				return 0;
			}
			//*/
		}
		function getLarvals($data2)
		{	
			$qString = 'CALL '; 
			$qString .= "view_larval_nodes('"; // name of stored procedure
			$qString .= 
			//variables needed by the stored procedure
			$data2['date1']. "','". 
			$data2['date2']. "'". ")";
			
			$q = $this->db->query($qString);
			//*
			if($q->num_rows() > 0) 
			{	$data = "";
				foreach ($q->result() as $row) 
				{
					$data .=
					$row->created_on . "&&" .
					$row->ls_lat . "&&" . 
					$row->ls_lng . "&&" .
					$row->ls_result . "&&" .
					$row->ls_household . "&&" .
					$row->ls_container . "&&" . 
					$row->ls_updated_by . "&&" . 
					$row->ls_updated_on . "&&" . 
					$row->tracking_number . "%%" ;
				}
				$q->free_result();
				return substr($data,0,-2);
			}
			else
			{
				$q->free_result();
				return 0;
			}
		}
}

/* End of mapping.php */
/* Location: ./application/models/mapping.php */