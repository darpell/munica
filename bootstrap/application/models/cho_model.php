<?php 
	
	class Cho_model extends CI_Model
	{
		function __construct()
		{
			parent::__construct();
			//load monica database
			$this->load->database('default');
		}
		
		function get_tasks()
		{
			
			$qString = 'CALL ';
			$qString .= "get_all_tasks ('"; // name of stored procedure
			$qString .=
			//variables needed by the stored procedure	
			date('Y-m-d') . "'". ")";
				
			$q = $this->db->query($qString);
			if($q->num_rows() > 0)
			{	$data =
				'Name' . "&&" .
				'Barangay' . "&&" .
				'Task Header' . "&&" .
				'Task' . "&&" .
				'Status' . "&&" .
				'Date Assigned'. "&&" .
				'Remarks'  . "%%" ;
			foreach ($q->result() as $row)
			{	if($row->date_accomplished == '0000-00-00' )
					$status = 'Not Done';
				else 
					$status = 'Completed';
				$name = $row->user_firstname . ' ' . $row->user_middlename . ' ' . $row->user_lastname;
				$date= explode ('-', $row->date_sent);
				$data .=
				$name . "&&" .
				$row->barangay . "&&" .
				$row->task_header . "&&" .
				$row->task . "&&" .
				$status . "&&" .
				$date[1].'/'.$date[2].'/'.$date[0]  . "&&" .
				$row->remarks . "%%" ;
				
			}
			
			return $data;
			}
			else
			{
				return 0;
			}
		}
		function get_pending_tasks()
		{
				
			$qString = 'CALL ';
			$qString .= "get_all_pending_tasks ()";
		
			$q = $this->db->query($qString);
			if($q->num_rows() > 0)
			{	$data['table'][] =array(
				'Name' => 'Name'  ,
				'Barangay'=>'Barangay' ,
				'Task Header'=> 'Task Header',
				'Task'=> 'Task',
				'Date Assigned'=>'Date Assigned',
				'Approve'=>'Approve',
				'Deny'=>'Deny',
				 );
				$data['task'] = '';
			foreach ($q->result() as $row)
			{
			$name = $row->user_firstname . ' ' . $row->user_middlename . ' ' . $row->user_lastname;
			$date= explode ('-', $row->date_sent);
			$data['table'][] =array(
					'Name' => $name ,
					'Barangay'=>$row->barangay ,
					'Task Header'=> $row->task_header,
					'Task'=> $row->task,
					'Date Assigned'=> $row->date_sent,
					'Approve'=>'<input type="radio" name="'.$row->task_no.'" value="approved" checked="true">',
					'Deny'=>'<input type="radio" name="'.$row->task_no.'" value="denied">',
			);
			$data['task'] .=  $row->task_no . "/";
			}
				
			return $data;
			}
			else
			{
				return null;
			}
		}
		function get_bhw()
		{
				
			$qString = 'CALL ';
			$qString .= "get_bhw ()"; // name of stored procedure
			//$qString .=
			//variables needed by the stored procedure
		
			//date('Y-m-d') . "'". ")";
		
			$q = $this->db->query($qString);
			if($q->num_rows() > 0)
			{
			foreach ($q->result() as $row)
			{	
			$name = $row->user_firstname . ' ' . $row->user_middlename . ' ' . $row->user_lastname;
			$data[$row->barangay][$row->user_username]=$name;
			}
				
			return $data;
			}
			
		}
		function add_task($data)
		{
			$qString = 'CALL ';
			$qString .= "add_task ('"; // name of stored procedure
			$qString .=
					$data['task'] . "','" .
					$data['date_sent'] ."','".
					$data['sent_to']. "','".
					$data['sent_by']. "','".
					$data['task_header']. "'". ")";
			
			$query = $this->db->query($qString);
			$query->free_result();
		}
		function approve_task($data)
		{
			$qString = 'CALL ';
			$qString .= "approve_task ('"; // name of stored procedure
			$qString .=
			$data['task'] . "','" .
			$data['status']. "'". ")";
			$query = $this->db->query($qString);
			$query->free_result();
		}
		function get_barangay_count()
		{
			$qString = 'CALL ';
			$qString .= "get_barangay_dashboard_data ('"; // name of stored procedure
			$qString .=
			date('y-m-d'). "'". ")";
				
			$q = $this->db->query($qString);

			if($q->num_rows() > 0)
			{	$data ='';
			foreach ($q->result() as $row)
			{	
			$data .=
			$row->ctr . "&&" .
			$row->cr_barangay . "&&" .
			$row->year . "%%" ;
			}
				
			return $data;
			}
			else
			{
				return 0;
			}
		}
		function get_age_count()
		{
			$qString = 'CALL ';
			$qString .= "get_dashboard_data_age ('"; // name of stored procedure
			$qString .=
			date('y-m-d'). "'". ")"; 
		
			$q = $this->db->query($qString);
		
			if($q->num_rows() > 0)
			{	$data ="";
			foreach ($q->result() as $row)
			{	
				$data .=
				$row->cr_barangay . "&&" .
				($row->agerange * 10)."-".(($row->agerange *10)+10) . "&&" .
				$row->patientcount . "%%" ;
			}
		
			return $data;
			}
			else
			{
				return 0;
			}
		}
		
		function getAllBarangays()
		{
			//echo $data['node_type'];
			$qString = 'CALL ';
			$qString .= "get_barangays("; // name of stored procedure
			$qString .=
			//variables needed by the stored procedure
			")";
			$data['All'] = 'All';	
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
				return $data;
			}
			else
			{
				$q->free_result();
				return 0;
			}
			//*/
		}
		function getPositiveSurveys()
		{
			//echo $data['node_type'];
			$qString = 'CALL ';
			$qString .= "positive_larval_nodes('"; // name of stored procedure
			$qString .=
			//variables needed by the stored procedure
			date('y-m-d'). "'". ")";
			$q = $this->db->query($qString);
			//*
			if($q->num_rows() > 0)
			{	$data ='';
				foreach ($q->result() as $row)
				{
					$data .=
				$row->ctr . "&&" .
				$row->ls_barangay . "%%" ;
				}
				return $data;
			}
			else
			{
				$q->free_result();
				return 0;
			}
			//*/
		}
		function randomfact()
		{
			$fact[]='Dengue is a mosquito-borne viral infection. ';
			$fact[]="The global incidence of dengue has grown dramatically in recent decades. About half of the world's population is now at risk.";
			$fact[]='Severe dengue is a leading cause of serious illness and death among children in some Asian and Latin American countries.';
			$fact[]='There is no specific treatment for dengue/ severe dengue, but early detection and access to proper medical care lowers fatality rates below 1%.';
			$fact[]='Dengue is only really transmitted through mosquitoes. ';
			$fact[]='Dengue infects 50-100 million people each year ';
			$fact[]='Mothers who are pregnant and give birth while sick with Dengue Fever will share their sickness with their newborn child.';
			$fact[]='The middle aged has more of a chance of mild symptoms';
			$fact[]='The mosquito usually bites at dusk and dawn but may bite at any time during the day � especially indoors, in shady areas, or when the weather is cloudy, ';
			$fact[]='mosquitos need to bite an infected human and then bite a new person to transmit the disease. This means that populated areas are more prone to risk.';
			$fact[]='Cases of dengue fever increase during the rainy season.';
			$fact[]='Dengue is transmitted through the bite of the Aedes Agypti mosquito.';
			$fact[]='Dengue fever is not transmitted between humans.';
			$fact[]='Dengue fever can be caught more than once (although it will never be the same type). Those who have contracted dengue fever in the past should be extra careful as dengue hemorrhagic fever seems to develop almost exclusively on patients that had had classic dengue fever before';
			
			return $fact[rand(0, (count($fact))-1)];
		}
		function get_immediate_cases()
		{
			$qString = 'CALL ';
			$qString .= "get_immediate_case('"; // name of stored procedure
			$qString .=
			//variables needed by the stored procedure
			date('Y-m').'-01' . "','" .
			date('Y-m').'-31' . "'". ")";
			$q = $this->db->query($qString);
			//*
			if($q->num_rows() > 0)
			{	$data ='';
			foreach ($q->result() as $row)
			{
				$data .=
				$row->cr_first_name.' '.$row->cr_last_name . "&&" .
				$row->cr_age . "&&" .	
				$row->cr_sex . "&&" .
				$row->cr_barangay . "&&" .
				$row->cr_street . "&&" .
				$row->cr_date_onset . "%%" ;
			}
			return $data;
			}
			else
			{
				$q->free_result();
				return 0;
			}
		}
		function get_dengue_profile($data = null)
		{
			if($data!= null)
			{
			$qString = 'CALL ';
			$qString .= "get_case_ages_gender ('"; // name of stored procedure
			$qString .=
						$data['datefrom']. "','".
						$data['dateto']. "'". ")";
			$q = $this->db->query($qString);
			if($q->num_rows() > 0)
			{	
				$dateto= explode ('/', $data['dateto']);
				$datefrom= explode ('/', $data['datefrom']);
				
				for($i = $datefrom[0] ; $i <= $dateto[0]  ; $i++ )
				{
					foreach ($data['barangay'] as $row)
					{
						$data2['values'][$i][$row]['M'][0] = 0;
						$data2['values'][$i][$row]['M'][1] = 0;
						$data2['values'][$i][$row]['M'][2] = 0;
						$data2['values'][$i][$row]['M'][3] = 0;
						$data2['values'][$i][$row]['M'][4] = 0;
						$data2['values'][$i][$row]['F'][0] = 0;
						$data2['values'][$i][$row]['F'][1] = 0;
						$data2['values'][$i][$row]['F'][2] = 0;
						$data2['values'][$i][$row]['F'][3] = 0;
						$data2['values'][$i][$row]['F'][4] = 0;
						
						$data2['total'][$i][$row] = 0;
					}
				}
				
				foreach ($q->result() as $row)
				{	
					for($i = 0 ; $i < count($data['barangay']) ; $i++ )
					{	$range = null;
						if($data['barangay'][$i] == $row->cr_barangay)
						{	$range = null;
							if($row->agerange >= 4)
							{$range = 4;}
							else {$range =  $row->agerange;}
					
									$data2['values']
									[$row->caseyear]
									[$row->cr_barangay]
									[$row->cr_sex]
									[$range]
									+= //array(
									//'barangay'=>$row->cr_barangay ,
									$row->patientcount;
									//'range'=> (($row->agerange * 10)+1)."-".(($row->agerange *10)+10),
									//'sex'=>$row->cr_sex,
									//'year'=>$row->caseyear,
									//);
									
							$data2['total'][$row->caseyear][$row->cr_barangay] += $row->patientcount;
							$barangay [] = $row->cr_barangay ;
							$year[] = $row->caseyear;
							
						}
					}
				}
				$data2['barangay'] = array_values(array_unique($barangay));
				$data2['year'] = array_values(array_unique($year));
			}
			
			else {$data2 = null;}
			}
			
			return $data2;
		}
		
		function get_investigated_cases($data = null)
		{
			if($data!= null)
			{
				$qString = 'CALL ';
				$qString .= "get_investigated_cases ('"; // name of stored procedure
				$qString .=
				$data['datefrom']. "','".
				$data['dateto']. "'". ")";
				$q = $this->db->query($qString);
				if($q->num_rows() > 0)
				{
					$data2 = array();
					$data2[]=array(
							'Name'=>'Name',
							'Barangay'=>'Barangay',
							'Result'=> 'Result');
					foreach ($q->result() as $row)
					{
						for($i = 0 ; $i < count($data['barangay']) ; $i++ )
						{	$range = null;
						if($data['barangay'][$i] == $row->cr_barangay)
						{	
							
							$data2[]=array(
									'Name'=>$row->cr_last_name . ", ". $row->cr_first_name,
									'Barangay'=>$row->cr_barangay,
									'Result'=> $row->feedback);
							
						}
						}
					}
				}
					
				else {$data2 = null;}
			}
				
			return $data2;
		}
		
		
	}

/* End of cho_model.php */
/* Location: ./application/models/cho_model.php */
