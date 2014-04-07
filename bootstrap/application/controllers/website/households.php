<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Households extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('hh_model','model');
		$this->load->model('barangay_model');
		$this->load->model('active_case_model','ac');
		$this->load->model('map_temp_model','map');
	}
	
	function visits()
	{
		$data['households'] = $this->map->get_households($this->session->userdata('TPusername'));
		$data['to_visit'] = $this->model->get_to_visit_list($this->session->userdata('TPusername'));
		
		$last_visits = array();
		
		foreach ($data['households'] as $hh)
		{
			$temp = $this->model->get_visits($hh['household_id']);
			array_push($last_visits, $temp);
		}
		
		$data['last_visits'] = $last_visits;
		
		$this->load->view('site/house_visits', $data);
	}
	
	function add_to_visit_list($hh_id)
	{
		$query = $this->db->get_where('to_visit', array('household_id' => $hh_id));
		if ($query->num_rows() > 0)
		{
			$data['result'] = 'Household is already in To Visit List';
			$this->load->view('site/success', $data);
		}
		else
		{
			$this->model->add_to_visit($hh_id);
			redirect('website/households/visits');
		}
	}
	
	function filter_brgys()
	{		
		$data['brgys'] = $this->barangay_model->get_brgys();
		
		foreach ($data['brgys'] as $brgy)
		{
			 $ca_count[$brgy['barangay']] = $this->model->get_catchment_area_limitless($brgy['barangay']);
			 $case_count[$brgy['barangay']] = $this->ac->get_cases_per_brgy($brgy['barangay']);
		}
		
		$data['brgy_cases'] = $this->ac->get_cases_per_brgy();
		
		$data['ca_count'] = $ca_count;
		$data['case_count'] = $case_count;
		
		// Graph data
		$STATUS = 'suspected';
		
		$data['distribution'] = $this->ac->check_gender_distribution($this->ac->get_cases_per_brgy());
		$data['male_age_dist'] = $this->ac->age_distribution($this->ac->get_cases_per_brgy(),'M');
		$data['female_age_dist'] = $this->ac->age_distribution($this->ac->get_cases_per_brgy(),'F');
		
		$data['offices'] = $this->ac->check_sources('office');
		$data['schools'] = $this->ac->check_sources('school');
		
		$data['symptoms'] = array(
				'has_muscle_pain'	=> count($this->ac->get_symptom('has_muscle_pain')),
				'has_joint_pain'	=> count($this->ac->get_symptom('has_joint_pain')),
				'has_headache'		=> count($this->ac->get_symptom('has_headache')),
				'has_bleeding'		=> count($this->ac->get_symptom('has_bleeding')),
				'has_rashes'		=> count($this->ac->get_symptom('has_rashes'))
		);
		// end of Graph Data
		
		$this->load->view('site/admin/brgy_filter', $data);
	}
	
	function filter_CAs($brgy)
	{
		$data['brgy'] = str_replace('%20',' ',$brgy);
		
		$config['base_url'] = site_url('website/households/filter_CAs/' . $brgy);
		$config['total_rows'] = count($this->model->get_catchment_area_limitless($data['brgy']));
		$config['per_page'] = 5;
		$config['num_links'] = 3;
		$config['uri_segment'] = 5;
		
		$this->pagination->initialize($config);
		
		$data['CAs'] = $this->model->get_catchment_area($data['brgy'], $config['per_page'], $this->uri->segment(5));
		
		$data['links'] = $this->pagination->create_links();
		
		foreach ($data['CAs'] as $ca)
		{
			$hh_count[$ca['bhw_id']] = $this->model->get_households_limitless($ca['bhw_id']);
			$case_count[$ca['bhw_id']] = $this->ac->get_cases_per_ca($ca['bhw_id']);
		}
		
		$data['hh_count'] = $hh_count;
		$data['case_count'] = $case_count;
		
		$this->load->view('site/admin/ca_filter', $data);
	}
	
	function filter_HHs($bhw)
	{
		$data['CA'] = $bhw;
		
		$config['base_url'] = site_url('website/households/filter_HHs/' . $bhw);
		$config['total_rows'] = count($this->model->get_households_limitless($data['CA']));
		$config['per_page'] = 5;
		$config['num_links'] = 3;
		$config['uri_segment'] = 5;
		
		$this->pagination->initialize($config);
		
		$data['HHs'] = $this->model->get_households($data['CA'], $config['per_page'], $this->uri->segment(5));
		
		$data['links'] = $this->pagination->create_links();		
		
		foreach ($data['HHs'] as $hh)
		{
			$person_count[$hh['household_id']] = $this->model->get_people_limitless($hh['household_id']);
			$case_count[$hh['household_id']] = $this->ac->get_cases_per_hh($hh['household_id']);
		}
		
		$data['person_count'] = $person_count;
		$data['case_count'] = $case_count;
		
		$this->load->view('site/admin/hh_filter', $data);
	}
	
	function filter_persons($hh)
	{
		$data['HH'] = $hh;
		
		$config['base_url'] = site_url('website/households/filter_persons/' . $data['HH']);
		$config['total_rows'] = count($this->model->get_people_limitless($data['HH']));
		$config['per_page'] = 5;
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