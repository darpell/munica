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

		$this->load->view('site/dashboard',$data);
	}
}

/* End of file dashboard.php */
/* Location: ./application/controllers/website/cho/dashboard.php */