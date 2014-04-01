<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Map extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Mapping');
		$this->load->model('remap_model');
		$this->load->helper('url');
	}
	
	public function view()
	{
		$data['node_type'] = $this->input->post('NDtype-ddl');
		$data['title'] = 'View map';
		//scripts if none keep ''
		$data['script'] = 'view_casereport';
		
		$getLarva=False;
		$getDengue=False;
		$getPoI=False;
		$getHouseholds=False;
		$getBB=False;
		$getActiveDengueOnly=False;
				
		/** Validation rules could be seen at application/config/form_validation.php **/
		//*
		if ($this->form_validation->run('') == FALSE)
		{
			{
				if (strtoupper($_SERVER['REQUEST_METHOD']) == 'POST')
				{
					$date1=$this->input->post('YearStart-ddl').'-'.$this->input->post('MonthStart-ddl').'-'.'01';
					$date2=$this->input->post('YearEnd-ddl').'-'.$this->input->post('MonthEnd-ddl').'-'.'01';
					$date2=date('Y-m-t', strtotime($date2));
					
					if ($this->input->post('cboxLarva'))
					{
						$getLarva=True;
					}
					if ($this->input->post('cboxDengue'))
					{
						$getDengue=True;
						if ($this->input->post('cboxActiveDengueOnly'))
						{
							$getActiveDengueOnly=True;
						}
					}
					if ($this->input->post('cboxPoI'))
					{
						$getPoI=True;
					}
					if ($this->input->post('cboxHouseholds'))
					{
						$getHouseholds=True;
					}
					if ($this->input->post('cboxBB'))
					{
						$getBB=True;
					}
				}
				else
				{
					$date1=date('Y-m-01');
					$date2=date('Y-m-t');
					$getLarva=False;
					$getDengue=False;
					$getPoI=False;
					$getHouseholds=False;
					$getBB=True;
					$getActiveDengueOnly=False;
					
				}
				
				//*DATE MANIPULATION BEGINS HERE
				//yyyy-mm-dd
				$data['date1']=$date1;
				$data['date2']=$date2;
				
				$dateData1['date1']=$date1;
				$dateData1['date2']=$date2;

				if($this->input->post('deflt')==1||strtoupper($_SERVER['REQUEST_METHOD']) != 'POST')
				{
					//*PREVIOUS DATE INTERVAL DATA PREPARATION
					$dateTemp1=explode("-",$date1);
					$dateTemp2=explode("-",$date2);
	
					$dateTemp1[0]=intval($dateTemp1[0]);
					$dateTemp2[0]=intval($dateTemp2[0]);
					if((($dateTemp1[0]-($dateTemp2[0]-$dateTemp1[0]))==$date2))
					{
						$dateData2['date1']=($dateTemp1[0]-1)."-".$dateTemp1[1]."-".$dateTemp1[2];
						$dateData2['date2']=($dateTemp2[0]-1)."-".$dateTemp2[1]."-01";
						$dateData2['date2']=date('Y-m-t', strtotime($dateData2['date2']));
					}
					else
					{
						$dateData2['date1']=($dateTemp1[0]-($dateTemp2[0]-$dateTemp1[0]+1))."-".$dateTemp1[1]."-".$dateTemp1[2];
						$dateData2['date2']=($dateTemp2[0]-($dateTemp2[0]-$dateTemp1[0]+1))."-".$dateTemp2[1]."-01";
						$dateData2['date2']=date('Y-m-t', strtotime($dateData2['date2']));
					}
					//*/					
				}
				else
				{
					$dateData2['date1']=$this->input->post('PYearStart-ddl').'-'.$this->input->post('PMonthStart-ddl').'-'.'01';
					$dateData2['date2']=$this->input->post('PYearEnd-ddl').'-'.$this->input->post('PMonthEnd-ddl').'-'.'01';
					$dateData2['date2']=date('Y-m-t', strtotime($dateData2['date2']));
				}

				//echo $dateData2['date1']." to ".$dateData2['date2']." : ";
				//echo $dateData1['date1']." to ".$dateData1['date2'];
				/*
				$paths1;
				$paths2;
				$paths1[]=array(
						'lat'=> "25.774252",
						'lng'=> "-80.190262"
				);
				$paths1[]=array(
						'lat'=> "18.466465",
						'lng'=> "-66.118292"
				);
				$paths1[]=array(
						'lat'=> "32.321384",
						'lng'=> "-64.75737"
				);
				$paths2[]=array(
						'lat'=> "25.774232",
						'lng'=> "-80.190242"
				);
				$paths2[]=array(
						'lat'=> "18.436365",
						'lng'=> "-66.158592"
				);
				$paths2[]=array(
						'lat'=> "33.121384",
						'lng'=> "-63.65737"
				);
				$paths2[]=array(
						'lat'=> "32.451384",
						'lng'=> "-64.25737"
				);
				print_r($this->Mapping->compareArraysDistanceFormula($paths1,$paths2));//*/

				$data['denguePoIDistance'] =null;
				$data['denguePoIBounce'] = null;
				$data['dengueLarvalDistance'] =null;
				$data['dengueLarvalBounce'] = null;
				$data['PdenguePoIDistance'] =null;
				$data['PdenguePoIBounce'] = null;
				$data['PdengueLarvalDistance'] =null;
				$data['PdengueLarvalBounce'] = null;
				$data['getLarva'] = $getLarva;
				$data['getDengue'] = $getDengue;
				$data['getPoI'] = $getPoI;
				$data['getHouseholds'] = $getHouseholds;
				$data['getBB'] = $getBB;
				$data['getActiveDengueOnly'] = $getActiveDengueOnly;
				$data['brgy']=null;//print_r($data['brgy']);
				$values = $this->Mapping->mapByType($data);
				
				//*CURRENT DATE INTERVAL DATA EXTRACTION
				$data['larval'] = $values['larvalValues'];
				$data['dengue'] = $values['dengueValues'];
				$data['poi'] = $values['poiValues'];
				$data['household'] = $values['householdValues'];
				$data['bb'] = $values['bbValues'];
				if($values['denguePoIDistanceValues'] != null)
				{
					$data['denguePoIDistance'] = $values['denguePoIDistanceValues'];
					$data['denguePoIBounce'] = $values['denguePoIBounceValues'];
					//print_r($data['denguePoIDistance']);
				}
				if($values['dengueLarvalDistanceValues'] != null)
				{
					$data['dengueLarvalDistance'] = $values['dengueLarvalDistanceValues'];
					$data['dengueLarvalBounce'] = $values['dengueLarvalBounceValues'];
					//print_r($data['dengueLarvalDistance']);
				}
				if($getBB)
				{
					$data['bcount'] = $this->Mapping->getBarangayCount($dateData1);
					$data['bage'] = $this->Mapping->getBarangayAges2($dateData1);
					$data['binfo'] = $this->Mapping->getBarangayInfo($dateData1);
				}
				else
				{
					$data['bcount'] = 0;
					$data['bage'] = 0;
					$data['binfo'] = 0;
				}
				if($getLarva)
					$data['dist'] = $this->Mapping->calculateDistanceFormula($dateData1);
				else
					$data['dist'] = 0;
				//$data['weather'] = $this->Mapping->weatherMapping($dateData1);
				//*/
				
				$this->Mapping->getBarangayAgesF($data);

				$data['date1']=$dateData2['date1'];
				$data['date2']=$dateData2['date2'];
				$data['cdate1']=$dateData1['date1'];
				$data['cdate2']=$dateData1['date2'];
				$data['pdate1']=$dateData2['date1'];
				$data['pdate2']=$dateData2['date2'];
				$values = $this->Mapping->mapByType($data);
				
				
				//*PREVIOUS DATE INTERVAL DATA EXTRACTION
				$data['Plarval'] = $values['larvalValues'];//print_r($data['Plarval']);
				$data['Pdengue'] = $values['dengueValues'];//print_r($data['Pdengue']);
				$data['Phousehold'] = $values['householdValues'];//print_r($data['Pdengue']);
				$data['Ppoi'] = $values['poiValues'];
				
				//$data['Pnodes'] = $this->Mapping->mapByType($data);
				if($values['denguePoIDistanceValues'] != null)
				{
					$data['PdenguePoIDistance'] = $values['denguePoIDistanceValues'];
					$data['PdenguePoIBounce'] = $values['denguePoIBounceValues'];
					//print_r($data['denguePoIDistance']);
				}
				if($values['dengueLarvalDistanceValues'] != null)
				{
					$data['PdengueLarvalDistance'] = $values['dengueLarvalDistanceValues'];
					$data['PdengueLarvalBounce'] = $values['dengueLarvalBounceValues'];
					//print_r($data['dengueLarvalDistance']);
				}
				if($getBB)
				{
					$data['Pbcount'] = $this->Mapping->getBarangayCount($dateData1);
					$data['Pbage'] = $this->Mapping->getBarangayAges2($dateData1);
					$data['Pbinfo'] = $this->Mapping->getBarangayInfo($dateData1);
					$data['table1'] = $this->Mapping->getBarangayAgesF($data);//print_r($data['table1']);
					$data['table2'] = $this->Mapping->getBarangayAgesF($data);
				}
				else
				{
					$data['Pbcount'] = 0;
					$data['Pbage'] = 0;
					$data['Pbinfo'] = 0;
					$data['table1'] = 0;
					$data['table2'] = 0;
				}
				if($getLarva)
					$data['Pdist'] = $this->Mapping->calculateDistanceFormula($dateData1);
				else
					$data['Pdist'] = 0;/*
				$data['Pbage'] = $this->Mapping->getBarangayAges2($dateData2);
				$data['Pbinfo'] = $this->Mapping->getBarangayInfo($dateData2);
				$data['Pbcount'] = $this->Mapping->getBarangayCount($dateData2);
				$data['Pdist'] = $this->Mapping->calculateDistanceFormula($dateData2);
				//*/
				//-------------------*/
				if($getPoI)
					$data['interest'] = $this->Mapping->getPointsOfInterest($getPoI);
				else
					$data['interest'] =0;
				//*
				$data['SA1_l']=0;
				$data['SA3_l']=0;
				$data['L2_l']=0;
				$data['S1_l']=0;
				$data['SA1_d']=0;
				$data['SA3_d']=0;
				$data['L2_d']=0;
				$data['S1_d']=0;
				$data['SA1_p']=0;
				$data['SA3_p']=0;
				$data['L2_p']=0;
				$data['S1_p']=0;
				$data['SA1_h']=0;
				$data['SA3_h']=0;
				$data['L2_h']=0;
				$data['S1_h']=0;
				if($getLarva)
				foreach($data['larval'] as $row)
				{
					if($row['barangay']=='SAN AGUSTIN I')
					{
						$data['SA1_l']++;
					}
					if($row['barangay']=='SAN AGUSTIN III')
					{
						$data['SA3_l']++;
					}
					if($row['barangay']=='LANGKAAN II')
					{
						$data['L2_l']++;
					}
					if($row['barangay']=='SAMPALOC I')
					{
						$data['S1_l']++;
					}
				}

				if($getDengue)
					foreach($data['dengue'] as $row)
					{
						if($row['barangay']=='SAN AGUSTIN I')
						{
							$data['SA1_d']++;
						}
						if($row['barangay']=='SAN AGUSTIN III')
						{
							$data['SA3_d']++;
						}
						if($row['barangay']=='LANGKAAN II')
						{
							$data['L2_d']++;
						}
						if($row['barangay']=='SAMPALOC I')
						{
							$data['S1_d']++;
						}
					}
					
				if($getPoI)
				foreach($data['poi'] as $row)
				{
					if($row['barangay']=='SAN AGUSTIN I')
					{
						$data['SA1_p']++;
					}
					if($row['barangay']=='SAN AGUSTIN III')
					{
						$data['SA3_p']++;
					}
					if($row['barangay']=='LANGKAAN II')
					{
						$data['L2_p']++;
					}
					if($row['barangay']=='SAMPALOC I')
					{
						$data['S1_p']++;
					}
				}
					
				if($getHouseholds)
				foreach($data['household'] as $row)
				{
					if($row['barangay']=='SAN AGUSTIN I')
					{
						$data['SA1_h']++;
					}
					if($row['barangay']=='SAN AGUSTIN III')
					{
						$data['SA3_h']++;
					}
					if($row['barangay']=='LANGKAAN II')
					{
						$data['L2_h']++;
					}
					if($row['barangay']=='SAMPALOC I')
					{
						$data['S1_h']++;
					}
				}
				$data['PSA1_l']=0;
				$data['PSA3_l']=0;
				$data['PL2_l']=0;
				$data['PS1_l']=0;
				$data['PSA1_d']=0;
				$data['PSA3_d']=0;
				$data['PL2_d']=0;
				$data['PS1_d']=0;
				$data['PSA1_p']=0;
				$data['PSA3_p']=0;
				$data['PL2_p']=0;
				$data['PS1_p']=0;
				$data['PSA1_h']=0;
				$data['PSA3_h']=0;
				$data['PL2_h']=0;
				$data['PS1_h']=0;
				if($getLarva)
				foreach($data['Plarval'] as $row)
				{
					if($row['barangay']=='SAN AGUSTIN I')
					{
						$data['PSA1_l']++;
					}
					if($row['barangay']=='SAN AGUSTIN III')
					{
						$data['PSA3_l']++;
					}
					if($row['barangay']=='LANGKAAN II')
					{
						$data['PL2_l']++;
					}
					if($row['barangay']=='SAMPALOC I')
					{
						$data['PS1_l']++;
					}
				}
				
				if($getDengue)
				foreach($data['Pdengue'] as $row)
				{
					if($row['barangay']=='SAN AGUSTIN I')
					{
						$data['PSA1_d']++;
					}
					if($row['barangay']=='SAN AGUSTIN III')
					{
						$data['PSA3_d']++;
					}
					if($row['barangay']=='LANGKAAN II')
					{
						$data['PL2_d']++;
					}
					if($row['barangay']=='SAMPALOC I')
					{
						$data['PS1_d']++;
					}
				}

				if($getPoI)
					foreach($data['Ppoi'] as $row)
					{
						if($row['barangay']=='SAN AGUSTIN I')
						{
							$data['PSA1_p']++;
						}
						if($row['barangay']=='SAN AGUSTIN III')
						{
							$data['PSA3_p']++;
						}
						if($row['barangay']=='LANGKAAN II')
						{
							$data['PL2_p']++;
						}
						if($row['barangay']=='SAMPALOC I')
						{
							$data['PS1_p']++;
						}
					}

				if($getHouseholds)
					foreach($data['Phousehold'] as $row)
					{
						if($row['barangay']=='SAN AGUSTIN I')
						{
							$data['PSA1_h']++;
						}
						if($row['barangay']=='SAN AGUSTIN III')
						{
							$data['PSA3_h']++;
						}
						if($row['barangay']=='LANGKAAN II')
						{
							$data['PL2_h']++;
						}
						if($row['barangay']=='SAMPALOC I')
						{
							$data['PS1_h']++;
						}
					}
				//*/
				
				//$data['test'] = $this->Mapping->getBarangayAgesS($data);
				//print_r($data['table1']);	
				$this->load->library('table');
				$this->load->view('site/maps/view_map',$data);
			}
		}
		else
		{
			$this->load->view('pages/success');
		}//*/
	}
}