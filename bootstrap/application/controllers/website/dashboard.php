<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		//$this->load->model('threshold_model','model');
		$this->load->model('barangay_model','brgy');
		$this->load->model('map_temp_model','map');
		$this->load->model('active_case_model','ac');
		$this->load->model('notif_model');
		$this->load->model('hh_model');
	}
	
	function index()
	{
		if ($this->session->userdata('TPtype') == 'BHW' || $this->session->userdata('TPtype') == 'MIDWIFE')
			$this->notif_model->check_on_hospitalized_cases();		
		$data['notif_count'] = count($this->notif_model->getnotifs($this->session->userdata('TPusername')));
		
		
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
		
		$data['poi'] = $this->ac->get_cases();
		
		$data['san_agustin_iii_cases'] = $this->ac->get_cases_per_brgy('san agustin iii');
		$data['san_agustin_iii'] = $this->map->get_brgys('san agustin iii');
		
		$data['langkaan_ii_cases'] = $this->ac->get_cases_per_brgy('langkaan ii');
		$data['langkaan_ii'] = $this->map->get_brgys('langkaan ii');
		
		$data['sampaloc_i_cases'] = $this->ac->get_cases_per_brgy('sampaloc i');
		$data['sampaloc_i'] = $this->map->get_brgys('sampaloc i');
		
		$data['san_agustin_i_cases'] = $this->ac->get_cases_per_brgy('san agustin i');
		$data['san_agustin_i'] = $this->map->get_brgys('san agustin i');
		
		$this->load->model('barangay_model','brgy');
		$data['brgys'] = $this->brgy->get_brgys();

		$this->load->view('site/dashboard',$data);
	}
}

/* End of file dashboard.php */
/* Location: ./application/controllers/website/cho/dashboard.php */