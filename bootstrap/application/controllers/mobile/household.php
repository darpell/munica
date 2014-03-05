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
		//$this->load->view('mobile/poi_form');
		$data['households'] = $this->map->get_households($this->session->userdata('TPusername'));
		
		$this->load->view('mobile/household_map', $data);
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