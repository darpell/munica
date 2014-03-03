<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Threshold extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('threshold_model','model');
	}
	
	function epidemic_threshold()
	{
		$COMPARING_YEARS = 6; /* signifying a 5 year duration */
		$MONTHS = 12; /* signifying a 12 months in a year */
		
		for ($ctr = 0; $ctr < $COMPARING_YEARS;$ctr++)
		{
			for($mth_ctr = 0; $mth_ctr < $MONTHS;$mth_ctr++)
			{
				$period[$ctr . '_' . $mth_ctr] = $this->model->epidemic_threshold(date('Y') - $ctr, 1 + $mth_ctr);
				if($ctr != 5)
				$sorted[$mth_ctr][]=$period[$ctr . '_' . $mth_ctr];
			}
		}
		for($mth_ctr = 0; $mth_ctr < $MONTHS;$mth_ctr++)
		{
		sort($sorted[$mth_ctr],1);
		}
		$data['sorted'] = $sorted;
		
		$data['results'] = $period;
		$data['years'] = $COMPARING_YEARS;
		$data['months'] = $MONTHS;
		
		$median = null;
		$quartile1 = null;
		$quartile3 = null;
		
		for ($i = 1; $i<6; $i++)
		{
			for($s=0; $s<12; $s++)
			{
				$median[$s][$i] = $period[$i .'_' .$s ];
				$quartile1[$s][$i] = $period[$i .'_' .$s ];
				$quartile3[$s][$i] = $period[$i .'_' .$s ];
			}	
		}
		for($s=0; $s<12; $s++)
		{
		$median[$s] = $this->calculate_median($median[$s]);
	
		sort($quartile1[$s]);
		$quartile1[$s] = $quartile1[$s][1];

		sort($quartile3[$s]);
		$quartile3[$s] = $quartile3[$s][3];
		
		}
		for($s=0; $s<12; $s++)
		{
		$currentcases[$s] = $period[0 .'_' .$s ];
		}
		
		$data['median'] = $median;
		$data['quartile1'] = $quartile1;
		$data['quartile3'] = $quartile3;
		$data['currentcases'] = $currentcases;
		
		
		
		
		$this->load->view('site/reports/epidemic_threshold',$data);
	}
	function epidemic_threshold_print()
	{
		$COMPARING_YEARS = 6; /* signifying a 5 year duration */
		$MONTHS = 12; /* signifying a 12 months in a year */
	
		for ($ctr = 0; $ctr < $COMPARING_YEARS;$ctr++)
		{
		for($mth_ctr = 0; $mth_ctr < $MONTHS;$mth_ctr++)
		{
		$period[$ctr . '_' . $mth_ctr] = $this->model->epidemic_threshold(date('Y') - $ctr, 1 + $mth_ctr);
		if($ctr != 5)
			$sorted[$mth_ctr][]=$period[$ctr . '_' . $mth_ctr];
		}
		}
		for($mth_ctr = 0; $mth_ctr < $MONTHS;$mth_ctr++)
		{
		sort($sorted[$mth_ctr],1);
		}
		$data['sorted'] = $sorted;
	
		$data['results'] = $period;
			$data['years'] = $COMPARING_YEARS;
			$data['months'] = $MONTHS;
	
		$median = null;
			$quartile1 = null;
			$quartile3 = null;
	
			for ($i = 1; $i<6; $i++)
			{
			for($s=0; $s<12; $s++)
			{
				$median[$s][$i] = $period[$i .'_' .$s ];
				$quartile1[$s][$i] = $period[$i .'_' .$s ];
				$quartile3[$s][$i] = $period[$i .'_' .$s ];
				}
				}
				for($s=0; $s<12; $s++)
				{
					$median[$s] = $this->calculate_median($median[$s]);
	
					sort($quartile1[$s]);
					$quartile1[$s] = $quartile1[$s][1];
	
					sort($quartile3[$s]);
					$quartile3[$s] = $quartile3[$s][3];
	
					}
					for($s=0; $s<12; $s++)
					{
					$currentcases[$s] = $period[0 .'_' .$s ];
					}
	
					$data['median'] = $median;
					$data['quartile1'] = $quartile1;
					$data['quartile3'] = $quartile3;
					$data['currentcases'] = $currentcases;
	
	
	
	
					$this->load->view('site/reports/epidemic_threshold_print',$data);
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
	
	function alert_threshold()
	{
		
	}
}

/* End of file threshold.php */
/* Location: ./application/controllers/website/threshold.php */