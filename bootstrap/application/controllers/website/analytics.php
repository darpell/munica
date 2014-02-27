<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Analytics extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		//$this->load->model('threshold_model','model');
		$this->load->model('Analytics_model');
	}
	
	function index()
	{
		$data['cases']= $this->Analytics_model->get_summary_count((int)date("W"));
		
		$data['larval']= $this->Analytics_model->get_larval_count((int)date("W"));
		
		$data['barangay'] = $this->Analytics_model->get_barangays();
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
	function case_demographics()
	{
		$data['dateto'] = '';
		$data['datefrom'] = '';
		
		$this->form_validation->set_rules('datepicker', 'Date from', 'required');
		$this->form_validation->set_rules('datepicker2', 'Date to', 'required');
		
		if ($this->form_validation->run('') == FALSE)
		{
			
			$casereportANDimmecase = $this->Analytics_model->get_all_cases_data('2000-01-01', '2013-12-31');
			$data['deathcount'] = $this->Analytics_model->get_death_count_daterange('2000-01-01', '2013-12-31');
		}
		else
		{
			$data['datefrom'] = $this->input->post('datepicker');
			$data['dateto'] = $this->input->post('datepicker2');
			
			$temp= explode ('/', $data['datefrom']);
			$temp = $temp[2].'/'.$temp[0].'/'.$temp[1];
			
			$temp2= explode ('/', $data['dateto']);
			$temp2 = $temp2[2].'/'.$temp2[0].'/'.$temp2[1];
			
			$casereportANDimmecase = $this->Analytics_model->get_all_cases_data($temp, $temp2);
			$data['deathcount'] = $this->Analytics_model->get_death_count_daterange($temp, $temp2);
			
		}
		
		
		
		$brgys = $this->Analytics_model->get_barangays();
		
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
		
		
		if ($casereportANDimmecase['casereport'] != null)
		{
			
		foreach ($casereportANDimmecase['casereport'] as $row)
		{	// barangay count
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
		if ($casereportANDimmecase['immecase'] != null)
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
			
			
		
			
			$this->load->view('site/analytics/casedemo',$data);
	}
	function population_demographics()
	{

		$temp= $this->Analytics_model->get_all_person_data();
		$brgys = $this->Analytics_model->get_barangays();
		
		
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
		
			$this->load->view('site/analytics/populationdemo',$data);
	}
	function totalcasecount()
	{
		$data['cases'] = $this->Analytics_model->get_all_cases_count();
		$data['death'] = $this->Analytics_model->get_death_count($data['cases']['max_mon'],$data['cases']['max_year']);
		$data['deathcount'] = $this->Analytics_model->get_all_death_count();
			
		$this->load->view('site/analytics/timeseriesCase',$data);
	}
	function totallarvalcount()
	{
		$data['larval'] = $this->Analytics_model->get_all_larval_count();
		$this->load->view('site/analytics/timeseriesLarval',$data);
	}
	function totalcaselarvalcount()
	{
		//timeseriesallcases
		$data['cases'] = $this->Analytics_model->get_all_cases_count();
		//timeseriesalllarval
		$data['larval']= $this->Analytics_model->get_all_larval_count();
		//areacasesand larval

		if ($data['cases']['yearstart']<=$data['larval']['yearstart'])
		{	$data['caseandlarval']['yearstart'] = $data['cases']['yearstart'];
			

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