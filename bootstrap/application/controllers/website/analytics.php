<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Analytics extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		//$this->load->model('threshold_model','model');
		$this->load->model('Analytics_model');
	}
	function get_user_barangay()
	{
		if($this->session->userdata('TPtype') == 'CHO')
		return 'CHO';
		else 
		
		{
		$data[] =	$this->Analytics_model->get_user_barangay($this->session->userdata('TPusername'));
		}
		return $data;
	}
	function index()
	{	$user = $this->get_user_barangay();
		
		$this->form_validation->set_rules('weekno', 'Date from', 'required');
		$this->form_validation->set_rules('barangay', 'Date to', 'required');
		$data['barangay'] = $this->Analytics_model->get_barangays();
		$data['brgys'] = $this->Analytics_model->get_barangays();
		if ($this->form_validation->run('') == FALSE)
		{
			if($user == 'CHO')
			$data['cases']= $this->Analytics_model->get_summary_count((int)date("W"),$data['barangay']);
			else
			$data['cases']= $this->Analytics_model->get_summary_count((int)date("W"),$user);
			
			$data['household']= $this->Analytics_model->get_affected_household((int)date("W"));
			
			$data['weekno'] = (int)date("W");
		}
		else {

			$data['brgys'] = $this->input->post('barangay');
			if($user == 'CHO')
			{
			$data['cases']= $this->Analytics_model->get_summary_count((int)$this->input->post('weekno'),$data['brgys']);
			}
			else
			$data['cases']= $this->Analytics_model->get_summary_count((int)$this->input->post('weekno'),$user);
					
			
			$data['household']= $this->Analytics_model->get_affected_household((int)$this->input->post('weekno'));
			$data['weekno'] = (int)$this->input->post('weekno');
		}
		


		

		$temp= $this->Analytics_model->get_all_person_data();
		$data['personcount']= 0;
		foreach ($temp as $row)
		{
			$data['personcount']++;
		}
		$this->load->view('site/analytics',$data);
	}
	function setfilter()
	{
	
		$this->session->set_userdata('datefrom', $this->input->post('datepicker'));
		$this->session->set_userdata('dateto', $this->input->post('datepicker2'));
		 	
		redirect($this->input->post('url'), 'refresh');  
	}
	function resetfilter()
	{
	
		$this->session->unset_userdata('datefrom');
		$this->session->unset_userdata('dateto');
	
		redirect($this->input->post('url'), 'refresh');
	}
	
	function calculate_median($arr) {
		sort($arr);
		$count = count($arr); //total numbers in array
		$middleval = floor(($count-1)/2); // find the middle value, or the lowest middle value
		if($count % 2) { // odd number, middle is the median
			$median = $arr[$middleval];
		} else { // even number, calculate avg of 2 medians
			$low = $arr[$middleval];
			$high = $arr[$middleval+1];
			$median = (($low+$high)/2);
		}
		return $median;
	}
	function calculate_average($arr) {
		$count = count($arr); //total numbers in array
		foreach ($arr as $value) {
			$total = $total + $value; // total value of array numbers
		}
		$average = ($total/$count); // get average value
		return $average;
	}
	function compute_age($dob) {
		//yyyy-mm-dd
		$birthDate = $dob;
		//explode the date to get month, day and year
		$birthDate = explode("-", $birthDate);
		//get age from date or birthdate
		$age = (date("md", date("U", mktime(0, 0, 0, $birthDate[1], $birthDate[2], $birthDate[0]))) > date("md")
				? ((date("Y") - $birthDate[0]) - 1)
				: (date("Y") - $birthDate[0]));
		return $age;
	}
	function caselist()
	{
		$user = $this->get_user_barangay();
		
		$data['barangay'] = $this->Analytics_model->get_barangays();
		
		$this->form_validation->set_rules('month', 'Date from', 'required');
		$this->form_validation->set_rules('year', 'Date to', 'required');
		$this->form_validation->set_rules('barangay', 'Date to', 'required');
		
		if ($this->form_validation->run('') == FALSE)
		{	
			$data['year'] = date('Y');
			$data['month2'] = date('m');
			if($user == 'CHO')
			$data['cases'] = $this->Analytics_model->get_case_list($data['month2'],$data['year'],$data['barangay']);
			else 
				$data['cases'] = $this->Analytics_model->get_case_list($data['month2'],$data['year'],$user);
		}
		else
		{
			$data['year'] = $this->input->post('year');
			$data['month2'] =  $this->input->post('month');
			if($user == 'CHO')
			$data['cases'] = $this->Analytics_model->get_case_list($data['month2'],$data['year'],$this->input->post('barangay'));
			else
			$data['cases'] = $this->Analytics_model->get_case_list($data['month2'],$data['year'],$user);			
		}
		
		
		$this->load->view('site/analytics/caselist',$data);
	}
	function case_demographics()
	{
		$user = $this->get_user_barangay();
		
		$data['dateto'] = date('m/d/Y');
		$data['datefrom'] = '01/01/2006';
		$brgys = $this->Analytics_model->get_barangays();
		
		$this->form_validation->set_rules('monthstart', 'Date from', 'required');
		$this->form_validation->set_rules('monthend', 'Date to', 'required');
		$this->form_validation->set_rules('yearstart', 'Date from', 'required');
		$this->form_validation->set_rules('yearend', 'Date to', 'required');
		$this->form_validation->set_rules('barangay', 'Date to', 'required');
		
		if ($this->form_validation->run('') == FALSE)
		{
			$data['monthstart'] =1;
		 	$data['monthend'] = date('m');
				
			$data['yearstart'] = 2006;
			$data['yearend'] = date('Y');
			
			$temp = $data['yearstart'].'/'.$data['monthstart'].'/1';
			$temp2 =  date("Y-m-t", strtotime($data['yearend'].'/'.$data['monthend'].'/1'));
			
			$data['barangay'] = $brgys;
			if($user != 'CHO')
			{
				$data['barangay'] = $user;
			}
			$casereportANDimmecase = $this->Analytics_model->get_all_cases_data($temp, $temp2,$data['barangay']);
			$data['deathcount'] = $this->Analytics_model->get_death_count_daterange($temp, $temp2,$data['barangay']);
		}
		else
		{
			$data['monthstart'] = $this->input->post('monthstart');
			$data['monthend'] = $this->input->post('monthend');
			
			$data['yearstart'] = $this->input->post('yearstart');
			$data['yearend'] = $this->input->post('yearend');
			
			$temp = $data['yearstart'].'/'.$data['monthstart'].'/1';
			$temp2 =  date("Y-m-t", strtotime($data['yearend'].'/'.$data['monthend'].'/1'));
			
			$data['barangay'] = $this->input->post('barangay');
			
			if($user != 'CHO')
			{
				$data['barangay'] = $user;
			}
			
			$casereportANDimmecase = $this->Analytics_model->get_all_cases_data($temp, $temp2,$data['barangay']);
			$data['deathcount'] = $this->Analytics_model->get_death_count_daterange($temp, $temp2,$data['barangay']);
			
		}
		
		
		
		
		
		for ($i = 0; $i < 4; $i++)
		{
		$brgycount[$i]= 0;
		for ($s = 0; $s < 6; $s++)
		{
		$agegroup[$i][$s]= 0;
		$fatality[$s] = 0;
		}
		$median[$i] = null;
			
		}
		
		$gender['m'] = 0;
		$gender['f'] = 0;
		if ($casereportANDimmecase['casereport'] != [])
		{
			
		foreach ($casereportANDimmecase['casereport'] as $row)
		{	// barangay count
			
			if($row['cr_sex'] == 'M')
			{
				$gender['m']++;
			}
			else if($row['cr_sex'] == 'F')
			{
				$gender['f']++;
			}
				for ($i = 0; $i < count($brgys); $i++)
						{
						if ($row['cr_barangay'] == $brgys[$i])
							{
							$brgycount[$i] += 1;
		
							//agegroup
							if($row['cr_age'] == 0){
							$agegroup[$i][0] += 1;
							if($row['cr_outcome'] == 'D')  $fatality[0] += 1 ;
							}
							else if ($row['cr_age'] >= 1 && $row['cr_age'] <= 10 ){
							$agegroup[$i][1] += 1;
							if($row['cr_outcome'] == 'D')  $fatality[1] += 1 ;
							}
							else if ($row['cr_age'] >= 11 && $row['cr_age'] <= 20 ){
							$agegroup[$i][2] += 1;
							if($row['cr_outcome'] == 'D')  $fatality[2] += 1 ;
							}
							else if ($row['cr_age'] >= 21 && $row['cr_age'] <= 30 ){
							$agegroup[$i][3] += 1;
							if($row['cr_outcome'] == 'D')  $fatality[3] += 1 ;
							}
							else if ($row['cr_age'] >= 31 && $row['cr_age'] <= 40 ){
							$agegroup[$i][4] += 1;
							if($row['cr_outcome'] == 'D')  $fatality[4] += 1 ;
							}
							else{
							$agegroup[$i][5] += 1;
							if($row['cr_outcome'] == 'D')  $fatality[5] += 1 ;
		}
		}
			
		}
		
		}
			
		}
		if ($casereportANDimmecase['immecase'] != [])
		{
		
				foreach ($casereportANDimmecase['immecase'] as $row)
			{
			$age = $this->compute_age($row['person_dob']);
			// barangay count
			for ($i = 0; $i < count($brgys); $i++)
			{
			if ($row['barangay'] == $brgys[$i])
			{
			$brgycount[$i] += 1;
				
			if($row['person_sex'] == 'M')
			{
				$gender['m']++;
			}
			else if(($row['person_sex'] == 'F'))
			{
				$gender['f']++;
			}	
		
			//agegroup
			if($age == 0)
				$agegroup[$i][0] += 1;
				else if ($age >= 1 && $age <= 10 )
				$agegroup[$i][1] += 1;
				else if ($age >= 11 && $age <= 20 )
				$agegroup[$i][2] += 1;
				else if ($age >= 21 && $age <= 30 )
				$agegroup[$i][3] += 1;
				else if ($age >= 31 && $age <= 40 )
				$agegroup[$i][4] += 1;
				else
				$agegroup[$i][5] += 1;
					
			}
				
			}
		
			}
				
			}
		
			for ($i = 0; $i < 4; $i++)
			{
			$median[$i] = $this->calculate_median($agegroup[$i]);
			}
		
		$data['brgys'] = $brgys;
		$data['agegroup'] = $agegroup;
		$data['brgycount'] = $brgycount;
		
		$data['brgy_max'] = null;
		$tempcount = 0;
		for($i=0;$i<count($brgys);$i++)
		{
		if($brgycount[$i] > $tempcount)
			{
			$tempcount = $brgycount[$i];
			$data['brgy_max'] = $i;
			}
		}
		
		//fatality rate  --agegroup computation must be included
				for ($i=0; $i<6; $i++)
			{
			$agegroupsum[$i] = 0;
		}
		for($i=0;$i<count($brgys);$i++)
		{
			$agegroupsum[0] += $agegroup[$i][0];
			$agegroupsum[1] += $agegroup[$i][1];
			$agegroupsum[2] += $agegroup[$i][2];
			$agegroupsum[3] += $agegroup[$i][3];
			$agegroupsum[4] += $agegroup[$i][4];
			$agegroupsum[5] += $agegroup[$i][5];
		}
		$data['deaths'] = 0;
		$data['max_fatality'] = 0;
		$data['max_fatality_group'] = '';
			for($i=0; $i<count($fatality);$i++)
			{
			$data['deaths'] += $fatality[$i];
			
			if($agegroupsum[$i] > 0)
			$fatality[$i]= round($fatality[$i] / $agegroupsum[$i],2);
			else
			$fatality[$i]=0;
			
			if($fatality[$i] > $data['max_fatality'] )
			{
				$data['max_fatality'] = $fatality[$i];
				$data['max_fatality_group'] = $i;
			}
			
			}
			$data['fatality'] = $fatality;
			$data['casereportANDimmecase'] = $casereportANDimmecase;
			
			$data['gender'] = $gender;
		
			
			$this->load->view('site/analytics/casedemo',$data);
	}
	function population_demographics()
	{

		$temp= $this->Analytics_model->get_all_person_data();
		$brgys = $this->Analytics_model->get_barangays();
		
		$gender['m'] = 0;
		$gender['f'] = 0;
		for ($i = 0; $i < 4; $i++)
		{
			
		$population['brgy_count'][$i]= 0;
		for ($s = 0; $s < 6; $s++)
		{
		$population['agegroup'][$i][$s]= 0;
		}
			
		}
		foreach ($temp as $row)
		{	// barangay count
		if($row['person_sex'] == 'M')
		{
			$gender['m']++;
		}
		else if ($row['person_sex'] == 'F')
		{
			$gender['f']++;
		}
		for ($i = 0; $i < count($brgys); $i++)
		{
		$age = $this->compute_age($row['person_dob']);
			
		if ($row['barangay'] == $brgys[$i])
		{
		$population['brgy_count'][$i] += 1;
			
		//agegroup
		if($age == 0){
				$population['agegroup'][$i][0] += 1;
			
		}
		else if ($age >= 1 && $age <= 10 ){
				$population['agegroup'][$i][1] += 1;
		
		}
		else if ($age>= 11 && $age <= 20 ){
			$population['agegroup'][$i][2] += 1;
				
		}
		else if ($age >= 21 && $age<= 30 ){
		$population['agegroup'][$i][3] += 1;
					
		}
		else if ($age>= 31 && $age <= 40 ){
		$population['agegroup'][$i][4] += 1;
		
		}
		else{
						$population['agegroup'][$i][5] += 1;
		
		}
		}
		
		}
		
		}
		$data['brgys'] = $brgys;
			$data['population'] = $population;
			$data['gender'] = $gender;
		
			$this->load->view('site/analytics/populationdemo',$data);
	}
	function totalcasecount()
	{ $user = $this->get_user_barangay();
	
		$data['brgys'] = $brgys = $this->Analytics_model->get_barangays();
		
		$this->form_validation->set_rules('monthstart', 'Date from', 'required');
		$this->form_validation->set_rules('monthend', 'Date from', 'required');
		$this->form_validation->set_rules('yearstart', 'Date from', 'required');
		$this->form_validation->set_rules('yearend', 'Date from', 'required');
		$this->form_validation->set_rules('yearend', 'Date from', 'greater_than['.$this->input->post('yearstart').']');
		$this->form_validation->set_rules('barangay', 'Date from', 'required');
		if ($this->form_validation->run('') == FALSE)
		{
			if($user != 'CHO')
			$brgys = $user;
				
			$data['cases'] = $this->Analytics_model->get_all_cases_count(1,null,12,null,$brgys);
			$data['deathcount'] = $this->Analytics_model->get_all_death_count(1,null,12,null,$brgys);
			$data['death'] = $this->Analytics_model->get_death_count($data['cases']['max_mon'],$data['cases']['max_year'],$brgys);
			

		}
		else
		{
			if($user == 'CHO')
			{
			$data['cases'] = $this->Analytics_model->get_all_cases_count($this->input->post('monthstart'),$this->input->post('yearstart'),$this->input->post('monthend'),$this->input->post('yearend'),$this->input->post('barangay'));
			$data['deathcount'] = $this->Analytics_model->get_all_death_count($this->input->post('monthstart'),$this->input->post('yearstart'),$this->input->post('monthend'),$this->input->post('yearend'),$this->input->post('barangay'));
			$data['death'] = $this->Analytics_model->get_death_count($data['cases']['max_mon'],$data['cases']['max_year'],$this->input->post('barangay'));
			}
			else
			{
			$data['cases'] = $this->Analytics_model->get_all_cases_count($this->input->post('monthstart'),$this->input->post('yearstart'),$this->input->post('monthend'),$this->input->post('yearend'),$user);
			$data['deathcount'] = $this->Analytics_model->get_all_death_count($this->input->post('monthstart'),$this->input->post('yearstart'),$this->input->post('monthend'),$this->input->post('yearend'),$user);
			$data['death'] = $this->Analytics_model->get_death_count($data['cases']['max_mon'],$data['cases']['max_year'],$user);
			}
		}
		

		
			
		$this->load->view('site/analytics/timeseriesCase',$data);
	}
	function totaloutbreakcount()
	{
		$data['barangay'] = $this->Analytics_model->get_barangays();
		$data['outbreak'] = $this->Analytics_model->get_outbreak_count();
		$this->load->view('site/analytics/totaloutbreak',$data);
	}
	function outbreakcountyear()
	{
		$user = $this->get_user_barangay();
		
		$this->form_validation->set_rules('barangay', 'Date from', 'required');
		$this->form_validation->set_rules('yearselected', 'Date from', 'required');
		
		if ($this->form_validation->run('') == FALSE)
		{
			if($user == 'CHO')
				$data['brgy'] = $this->input->post('barangay');
			else
				$data['brgy'] = $user;
			
			
			$data['outbreak'] = $this->Analytics_model->get_outbreak_count_year(2014,$data['brgy']);
			
			
		}
		else
		{
			if($user == 'CHO')
				$data['brgy'] = $this->input->post('barangay');
			else
				$data['brgy'] = $user;
				
			$year = $this->input->post('yearselected');
			$data['outbreak'] = $this->Analytics_model->get_outbreak_count_year($year,$data['brgy']);
			
		}
	
		
		$data['barangay']=$this->Analytics_model->get_barangays();
		$this->load->view('site/analytics/outbreakperyear',$data);
	}
	function totallarvalcount()
	{
		$data['larval'] = $this->Analytics_model->get_all_larval_count();
		$this->load->view('site/analytics/timeseriesLarval',$data);
	}
	function totalcaselarvalcount()
	{
		$user = $this->get_user_barangay();
		
		$data['brgys'] = $brgys = $this->Analytics_model->get_barangays();
		
		$this->form_validation->set_rules('monthstart', 'Date from', 'required');
		$this->form_validation->set_rules('monthend', 'Date from', 'required');
		$this->form_validation->set_rules('yearstart', 'Date from', 'required');
		$this->form_validation->set_rules('yearend', 'Date from', 'required');
		$this->form_validation->set_rules('yearend', 'Date from', 'greater_than['.$this->input->post('yearstart').']');
		$this->form_validation->set_rules('barangay', 'Date from', 'required');
		
		
		if ($this->form_validation->run('') == FALSE)
		{
			if($user != 'CHO')
			 $brgys = $user ;
			$data['cases'] = $this->Analytics_model->get_all_cases_count(1,null,12,null,$brgys);
			$data['larval']= $this->Analytics_model->get_all_larval_count(1,null,12,null,$brgys);
		}
		else
		{
			if($user != 'CHO')
			$brgys=$user;
			else 
			$brgys = $this->input->post('barangay');
			
			$data['cases'] = $this->Analytics_model->get_all_cases_count($this->input->post('monthstart'),$this->input->post('yearstart'),$this->input->post('monthend'),$this->input->post('yearend'),$brgys);
			$data['larval']= $this->Analytics_model->get_all_larval_count($this->input->post('monthstart'),$this->input->post('yearstart'),$this->input->post('monthend'),$this->input->post('yearend'),$brgys);
		}
		


		if ($data['cases']['yearstart']<=$data['larval']['yearstart'])
		{	$data['caseandlarval']['yearstart'] = $data['cases']['yearstart'];
			$data['caseandlarval']['monthstart'] = $data['cases']['monthstart'];
			
			$data['caseandlarval']['yearend'] = $data['cases']['yearend'];
			$data['caseandlarval']['monthend'] = $data['cases']['monthend'];
			
			$data['caseandlarval']['yearmin'] = $data['cases']['yearmin'];

			for($i=$data['caseandlarval']['yearstart'];$i<=DATE('Y');$i++)
			{
				for ($s= 1;$s<=12;$s++)
				{
					$data['caseandlarval'][$i][$s]=0;
				}
			}
			for($i=$data['larval']['yearstart'];$i<=DATE('Y');$i++)
			{
			for ($s= 1;$s<=12;$s++)
			{
			$data['caseandlarval'][$i][$s] += $data['larval'][$i][$s];
			}
			}
		}
		
		else
		{	$data['caseandlarval']['yearstart'] = $data['larval']['yearstart'];		
			$data['caseandlarval']['monthstart'] = $data['larval']['monthstart'];
				
			$data['caseandlarval']['yearend'] = $data['larval']['yearend'];
			$data['caseandlarval']['monthend'] = $data['larval']['monthend '];
			
			$data['caseandlarval']['yearmin'] = $data['larval']['yearmin'];
			for($i=$data['caseandlarval']['yearstart'];$i<=DATE('Y');$i++)
			{
				for ($s= 1;$s<=12;$s++)
				{
				$data['caseandlarval'][$i][$s]=0;
				}
			}
			for($i=$data['cases']['yearstart'];$i<=DATE('Y');$i++)
			{
				for ($s= 1;$s<=12;$s++)
				{
					$data['caseandlarval'][$i][$s] += $data['cases'][$i][$s];
				}
			}
		}
		
		$data['caseandlarval']['count'] = '';
		for($i=$data['caseandlarval']['yearstart'];$i<=DATE('Y');$i++)
		{
		for ($s= 1;$s<=12;$s++)
		{
		$data['caseandlarval']['count']  .= $data['caseandlarval'][$i][$s] . ',';
		}
		}
		$this->load->view('site/analytics/timeseriesCaseLarval',$data);
	}
	
	
	
	function notifications()
	{
		
	}
	
	function cases()
	{
		
	}
	
	function general_count()
	{
		
	}
	
	function map()
	{
		
	}
	
	function distribution()
	{
		
	}
}

/* End of file dashboard.php */
/* Location: ./application/controllers/website/cho/dashboard.php */