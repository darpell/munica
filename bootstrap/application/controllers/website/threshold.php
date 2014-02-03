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
			}
		}
		$data['results'] = $period;
		$data['years'] = $COMPARING_YEARS;
		$data['months'] = $MONTHS;
		$this->load->view('site/reports/epidemic_threshold',$data);
	}
	
	function alert_threshold()
	{
		
	}
}

/* End of file threshold.php */
/* Location: ./application/controllers/website/threshold.php */