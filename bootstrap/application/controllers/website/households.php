<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Households extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('hh_model','model');
		$this->load->model('barangay_model');
		$this->load->model('active_case_model','ac');
	}
	
	function filter_brgys()
	{		
		$data['brgys'] = $this->barangay_model->get_brgys();
		
		foreach ($data['brgys'] as $brgy)
		{
			 $ca_count[$brgy['barangay']] = $this->model->get_catchment_area($brgy['barangay']);
		}
		
		$data['brgy_cases'] = $this->ac->get_cases_per_brgy();
		
		$data['ca_count'] = $ca_count;
		
		$this->load->view('site/admin/brgy_filter', $data);
	}
	
	function filter_CAs($brgy)
	{
		$data['brgy'] = str_replace('%20',' ',$brgy);
		
		$config['base_url'] = site_url('website/households/filter_CAs/' . $brgy);
		$config['total_rows'] = count($this->model->get_catchment_area($data['brgy']));
		$config['per_page'] = 5;
		$config['num_links'] = 3;
		$config['uri_segment'] = 5;
		
		$this->pagination->initialize($config);
		
		$data['CAs'] = $this->model->get_catchment_area($data['brgy'], $config['per_page'], $this->uri->segment(5));
		
		$data['links'] = $this->pagination->create_links();
		
		foreach ($data['CAs'] as $ca)
		{
			$hh_count[$ca['bhw_id']] = $this->model->get_households($ca['bhw_id']);
		}
		
		$data['hh_count'] = $hh_count;
		
		$this->load->view('site/admin/ca_filter', $data);
	}
	
	function filter_HHs($bhw)
	{
		$data['CA'] = $bhw;
		
		$config['base_url'] = site_url('website/households/filter_HHs/' . $bhw);
		$config['total_rows'] = count($this->model->get_households($data['CA']));
		$config['per_page'] = 5;
		$config['num_links'] = 3;
		$config['uri_segment'] = 5;
		
		$this->pagination->initialize($config);
		
		$data['HHs'] = $this->model->get_households($data['CA'], $config['per_page'], $this->uri->segment(5));
		
		$data['links'] = $this->pagination->create_links();		
		
		foreach ($data['HHs'] as $hh)
		{
			$person_count[$hh['household_id']] = $this->model->get_people($hh['household_id']);
		}
		
		$data['person_count'] = $person_count;
		
		$this->load->view('site/admin/hh_filter', $data);
	}
	
	function filter_persons($hh)
	{
		$data['HH'] = $hh;
		
		$config['base_url'] = site_url('website/households/filter_persons/' . $data['HH']);
		$config['total_rows'] = count($this->model->get_people($data['HH']));
		$config['per_page'] = 2;
		$config['num_links'] = 3;
		$config['uri_segment'] = 5;
		
		$this->pagination->initialize($config);
		
		$data['persons'] = $this->model->get_people($data['HH'], $config['per_page'], $this->uri->segment(5));
		
		$data['links'] = $this->pagination->create_links();
		
		$this->load->view('site/admin/person_filter', $data);
	}
	
	function view_person($id)
	{
		$data['person'] = $this->model->get_person($id);
		
		$this->load->view('site/admin/person', $data);
	}
}

/* End of file households.php */
/* Location: ./application/controllers/website/households.php */