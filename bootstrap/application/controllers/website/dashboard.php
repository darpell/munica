<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		//$this->load->model('threshold_model','model');
	}
	
	function index()
	{
		$this->load->model('notif');
		$this->notif->check_on_hospitalized_cases();		
		$data['notif_count'] = count($this->notif->getnotifs($this->session->userdata('TPusername')));
		
		$this->load->model('hh_model');
		if ($this->session->userdata('TPtype') == 'CHO')
			$user = FALSE;
		else if ($this->session->userdata('TPtype') == 'MIDWIFE')
			$user = 'MIDWIFE';
		else if ($this->session->userdata('TPtype') == 'BHW')
			$user = $this->session->userdata('TPusername');
		$data['hh_num'] = $this->hh_model->get_hh_count($user);
		
		$this->load->model('user_model');
		$data['bhw_ctr'] = $this->db->get_where('users', array('user_type' => 'bhw'))->num_rows();
		$data['mw_ctr'] = $this->db->get_where('users', array('user_type' => 'midwife'))->num_rows();
		
		// map data
		$this->load->model('active_case_model','ac');
		$data['poi'] = $this->ac->get_cases();
		$data['brgy_cases'] = $this->ac->get_cases_per_brgy('san agustin iii');
		$this->load->model('map_temp_model','map');
		$data['brgy'] = $this->map->get_brgys('san agustin iii');
		
		$this->load->model('barangay_model','brgy');
		$data['brgys'] = $this->brgy->get_brgys();
		// end of map data

		$this->load->view('site/dashboard',$data);
	}
	
	function map()
	{
		$temp = $this->brgy->get_brgys();
		
		for ($ctr = 0; $ctr < count($temp); $ctr++)
		{
			//$brgys[$temp['barangay']] = ;
		}
	}
}

/* End of file dashboard.php */
/* Location: ./application/controllers/website/cho/dashboard.php */