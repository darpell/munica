<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Household extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('map_temp_model','map');
	}
	
	function index()
	{
		//$this->load->view('mobile/poi_form');
		$data['households'] = $this->map->get_households($this->session->userdata('TPusername'));
		
		$this->load->view('mobile/household_map', $data);
	}
}

/* End of file mobile/poi.php */
/* Location: ./application/controllers/mobile/poi.php */