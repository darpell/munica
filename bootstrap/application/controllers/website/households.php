<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Households extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('hh_model','model');
		$this->load->model('barangay_model');
	}
	
	function index()
	{
		$data['brgys'] = $this->barangay_model->get_brgys();
		$this->load->view('site/admin/filter', $data);
	}
}

/* End of file households.php */
/* Location: ./application/controllers/website/households.php */