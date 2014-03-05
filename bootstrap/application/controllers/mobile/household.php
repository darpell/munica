<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Household extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('map_temp_model','map');
		$this->load->model('hh_model', 'hh');
	}
	
	function index()
	{
		$data['households'] = $this->map->get_households($this->session->userdata('TPusername'));
		
		$last_visits = array();
		
		foreach ($data['households'] as $hh)
		{
			$temp = $this->hh->get_visits($hh['household_id']);
			array_push($last_visits, $temp);
		}
		
		$data['last_visits'] = $last_visits;
		
		$this->load->view('mobile/household_map', $data);
	}
	
	function get_to_visit_list()
	{
		$data['subjects'] = $this->hh->get_to_visit_list($this->session->userdata('TPusername'));
		
		$last_visits = array();
		$temp_cases = array();
		
		foreach ($data['subjects'] as $hh)
		{
			$temp = $this->hh->get_visits($hh['household_id']);
			array_push($last_visits, $temp);
			$temp_cases = $this->hh->get_cases($this->session->userdata('TPusername'),$subjects[$ctr]['household_id']);
		}
		
		$data['last_visits'] = $last_visits;
		$data['cases'] = $temp_cases;
		
		$this->load->view('mobile/master_list', $data);
	}
	
	function mark_visit($hh_id)
	{
		$hh_name = $this->hh->mark_visit($hh_id);
		
		$data['result'] = 'Household ' . $hh_name['household_name'] . ' is marked as visited';
		$data['treatment'] = ''; // for the sake of not having an error
		
		$this->load->view('mobile/im_case_success', $data);
	}
}

/* End of file mobile/poi.php */
/* Location: ./application/controllers/mobile/poi.php */