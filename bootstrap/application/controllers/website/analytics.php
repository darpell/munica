<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Analytics extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		//$this->load->model('threshold_model','model');
	}
	
	function index()
	{
		$this->load->model('Analytics_model');
		//timeseriesallcases
		$data['cases'] = $this->Analytics_model->get_all_cases_count();
		//timeseriesalllarval
		$data['larval']= $this->Analytics_model->get_all_larval_count();
		//areacasesand larval
		if ($data['cases']['yearstart']<=$data['cases']['yearstart'])
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
		{	$data['caseandlarval']['yearstart'] = $data['cases']['yearstart'];		

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
		
		//combocases
		$casereportANDimmecase = $this->Analytics_model->get_all_cases_data('2000-01-01', '2013-12-31');
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
		
		for($i=0; $i<count($fatality);$i++)
		{
			$fatality[$i]= round($fatality[$i] / $agegroupsum[$i],2);
		}
		$data['fatality'] = $fatality; 
		
		
		$this->load->view('site/analytics',$data);
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