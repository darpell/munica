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
			$returnValues['larvalValues'] =0;
			$returnValues['dengueValues'] =0;
			$returnValues['poiValues'] =0;
			$returnValues['householdValues'] =0;
			$returnValues['bbValues'] =0;
			if($data['getLarva'])
			{/*
				$where="";
				$this->db->from('ls_report');
				if ($data['brgy'] != NULL)
				{
					$where = "ls_barangay ='";
					foreach($data['brgy'] as $varr)
					{
						$where .= $varr."' OR ";
					}
					$this->db->where(substr($where,0,-3));
				}$this->db->group_by("ls_no"); 
				$q = $this->db->get();
				if($q->num_rows() > 0) 
				{	$tempp;
					foreach ($q->result() as $row) 
					{
						$tempp[]=array(
								'ls_no'=> $row->ls_no,
								'household'=> $row->ls_household,
								'container'=> $row->ls_container,
								'lat'=> $row->ls_lat,
								'lng'=> $row->ls_lng,
								'createdBy'=> $row->created_by,
								'createdOn'=> $row->created_on,
								'updatedBy'=> $row->last_updated_by,
								'updatedOn'=> $row->last_updated_on
						);
					}
					$returnValues['larvalValues'] =  $tempp;
				}//*/
				$where;
				$qString = 'CALL ';
				$qString .= "view_larval_nodes('"; // name of stored procedure
				$qString .=
				//variables needed by the stored procedure
				$data['date1']. "','".
				$data['date2']. "'". ")";
				
				$q = $this->db->query($qString);
				//*
				if($q->num_rows() > 0)
				{	$temp = "";
				foreach ($q->result() as $row)
				{
					//if($row->ls_result=="positive") // disabled for now since only a few (or non) entries would be positive
					$temp .=
					"larvalpositive" . "&&" .
					$row->ls_no . "&&" .
					$row->ls_lat . "&&" .
					$row->ls_lng . "&&" .
					$row->ls_household . "&&" .
					$row->ls_container . "&&".
					$row->created_on . "&&".
					$row->last_updated_on . "&&".
					$row->ls_barangay . "&&".
					$row->created_by . "%%"  ;
				}
				$q->free_result();
				$returnValues['larvalValues'] = substr($temp,0,-2);
				}
				else
				{
					$q->free_result();
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
				$this->db->from('active_cases');
				$this->db->join('catchment_area', 'catchment_area.person_id = active_cases.person_id');
				$this->db->join('household_address', 'household_address.household_id = catchment_area.household_id');
				$this->db->join('bhw', 'bhw.user_username = catchment_area.bhw_id');
				$this->db->join('master_list', 'master_list.person_id = catchment_area.person_id');
				if ($data['brgy'] != NULL)
				{
					$where = "barangay ='";
					foreach($data['brgy'] as $varr)
					{
						$where .= $varr."' OR ";
					}
					$this->db->where(substr($where,0,-3));
				}	
				$q = $this->db->get();
				if($q->num_rows() > 0) 
				{	$tempest;
					foreach ($q->result() as $row) 
					{
						$tempest[]=array(//*
								'caseNo'=> $row->imcase_no,
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
								'lastVisited'=> $row->last_visited,
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
					$returnValues['dengueValues'] =  $tempest;
				}
				$q->free_result();
			}
			if ($data['getHouseholds'])//all polygons
			{
				$where="";
				$this->db->from('household_address');
				$this->db->join('catchment_area', 'catchment_area.household_id = household_address.household_id');
				$this->db->join('bhw', 'catchment_area.bhw_id = bhw.user_username');
				$this->db->join('master_list', 'master_list.person_id = catchment_area.person_id');
				if ($data['brgy'] != NULL)
				{
					$where = "barangay ='";
					foreach($data['brgy'] as $varr)
					{
						$where .= $varr."' OR ";
					}
					$this->db->where(substr($where,0,-3));
				}
				$q = $this->db->get();
				if($q->num_rows() > 0) 
				{	$tempall;
					foreach ($q->result() as $row) 
					{
						$tempall[]=array(//*
								'householdID'=> $row->household_id,
								'houseName'=> $row->household_name,
								'houseNo'=> $row->house_no,
								'street'=> $row->street,
								'lastVisited'=> $row->last_visited,
								'lat'=> $row->household_lat,
								'lng'=> $row->household_lng,
								'personID'=> $row->person_id,
								'bhwID'=> $row->bhw_id,
								'bhwUsername'=> $row->user_username,
								'householdBarangay'=> $row->barangay,
								'personFName'=> $row->person_first_name,
								'personLName'=> $row->person_last_name,
								'personDoB'=> $row->person_dob,
								'personSex'=> $row->person_sex
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
					$this->db->where(substr($where,0,-3));
				}
				$q = $this->db->get();
				if($q->num_rows() > 0) 
				{	$temppoi;
					foreach ($q->result() as $row) 
					{
						$temppoi[]=array(//*
								'name'=> $row->node_name,
								'lat'=> $row->node_lat,
								'lng'=> $row->node_lng,
								'notes'=> $row->node_notes,
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
			if(true)
			{
				
			}
			return $returnValues;
		}
		//*
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
	function compareArraysDistanceFormula($arr1, $arr2)
		{
			$retVal=array();
			$retChild=array();
			$arr1length=count($arr1);
			$arr2length=count($arr2);
			for($i=0;$i<=$arr1length-1;$i++)
			{
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
					else 
					{
						$retChild[]=0;
					}
				}
				$retVal[]=$retChild;
			}
		return $retVal;
		}
		/*
	function getHouseholds($brgy = null)//all polygons
		{
		}
		//*/
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