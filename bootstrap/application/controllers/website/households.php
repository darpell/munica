<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Households extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('hh_model','model');
		$this->load->model('barangay_model');
	}
	
	function filter_brgys()
	{
		$data['brgys'] = $this->barangay_model->get_brgys();
		
		foreach ($data['brgys'] as $brgy)
		{
			 $ca_count[$brgy['barangay']] = $this->model->get_catchment_area($brgy['barangay']);
		}
		
		$data['ca_count'] = $ca_count;
		
		$this->load->view('site/admin/brgy_filter', $data);
	}
	
	function filter_CAs($brgy)
	{
		$data['brgy'] = $brgy;
		$data['CAs'] = $this->model->get_catchment_area('LANGKAAN II'); //to fix problem of spacing in URL; "blank space" = %20
		
		foreach ($data['CAs'] as $ca)
		{
			$hh_count[$ca['bhw_id']] = $this->model->get_households('LANGKAAN II', $ca['bhw_id']);
		}
		
		$data['hh_count'] = $hh_count;
		
		$this->load->view('site/admin/ca_filter', $data);
	}
	
	function filter_hh($bhw)
	{
		$data['CA'] = $bhw;
		$data['HHs'] = $this->model->get_households('LANGKAAN II', $data['CA']); //to fix problem of spacing in URL; "blank space" = %20
		
		foreach ($data['HHs'] as $hh)
		{
			$person_count[$hh['household_id']] = $this->model->get_people($data['CA'], $hh['household_id']);
		}
		
		$data['person_count'] = $person_count;
		
		$this->load->view('site/admin/hh_filter', $data);
	}
	
	function get_person()
	{
		
	}
}

/* End of file households.php */
/* Location: ./application/controllers/website/households.php */