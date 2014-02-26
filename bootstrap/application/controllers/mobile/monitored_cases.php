<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Monitored_cases extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		// Your own constructor code
		$this->load->model('active_case_model','model');
	}
	
	function view_cases($status)
	{
		$data['cases'] = $this->model->get_cases($this->session->userdata('TPusername'),$status);
		$this->load->view('mobile/cases', $data);
	}
	
	function view_case($imcase)
	{
		$data['case'] = $this->model->get_case($imcase);
		$this->load->view('mobile/case_details', $data);
	}
}

/* End of file mobile/monitored_cases.php */
/* Location: ./application/controllers/mobile/monitored_cases.php */