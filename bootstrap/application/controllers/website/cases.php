<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cases extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('cases_model','model');
		$this->load->model('active_case_model','ac');
		$this->load->model('map_temp_model','map');
	}
	
	function search()
	{
		$config['base_url'] = site_url('website/cases/search');
		$config['total_rows'] = count($this->ac->search($this->input->post('TPsearch-txt')));
		$config['per_page'] = 5;
		$config['num_links'] = 3;
		$config['uri_segment'] = 4;
		
		$this->pagination->initialize($config);
		
		$data['results'] = $this->ac->search($this->input->post('TPsearch-txt'), $config['per_page'], $this->uri->segment(4));
		$data['links'] = $this->pagination->create_links();
		
		$this->load->view('site/search_results', $data);
	}
	
	function view_map()
	{
		$data['cases'] = $this->map->get_all_cases();
		$data['period'] = 'All active cases and previous';
		
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
		
		$this->load->view('site/admin/cases_map', $data);
	}
	
	function filter_view_map()
	{
		$data['cases'] = $this->map->get_all_cases($this->input->post('start'), $this->input->post('end'));
		$data['period'] = 'Displaying all cases since ' . date('D, M d Y',strtotime($this->input->post('start'))) . ' to ' . date('D, M d Y',strtotime($this->input->post('end')));
		
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
		
		$this->load->view('site/admin/cases_map', $data);
	}
	
	function view_suspected()
	{
		/*
		 * Case Data
		 */
		$STATUS = 'suspected';
		
		$config['base_url'] = site_url('website/cases/view_suspected');
		$config['per_page'] = 10;
		$config['num_links'] = 3;
		$config['uri_segment'] = 4;
		if ($this->session->userdata('TPtype') != 'BHW')
			$config['total_rows'] = count($this->model->get_cases_limitless($STATUS));
		else
			$config['total_rows'] = count($this->model->get_cases_limitless($STATUS, $this->session->userdata('TPusername')));
		
		$this->pagination->initialize($config);
		
		if ($this->session->userdata('TPtype') != 'BHW')
			$data['cases'] = $this->model->get_cases($STATUS, FALSE, $config['per_page'], $this->uri->segment(4));
		else
			$data['cases'] = $this->model->get_cases($STATUS, $this->session->userdata('TPusername'), $config['per_page'], $this->uri->segment(4));
		
		$data['links'] = $this->pagination->create_links();
		
		$data['type'] = 'Suspected';
		/*
		 * end of Case Data
		 */
		
		// Graph data
		
		if ($this->session->userdata('TPtype') != 'BHW')
		{
			$data['distribution'] = $this->ac->check_gender_distribution($this->model->get_cases_limitless($STATUS));
			$data['male_age_dist'] = $this->ac->age_distribution($this->model->get_cases_limitless($STATUS),'M');
			$data['female_age_dist'] = $this->ac->age_distribution($this->model->get_cases_limitless($STATUS),'F');
				
			$data['offices'] = $this->ac->check_sources('office',$STATUS);
			$data['schools'] = $this->ac->check_sources('school',$STATUS);
				
			$data['symptoms'] = array(
					'has_muscle_pain'	=> count($this->ac->get_symptom('has_muscle_pain', $STATUS)),
					'has_joint_pain'	=> count($this->ac->get_symptom('has_joint_pain', $STATUS)),
					'has_headache'		=> count($this->ac->get_symptom('has_headache', $STATUS)),
					'has_bleeding'		=> count($this->ac->get_symptom('has_bleeding', $STATUS)),
					'has_rashes'		=> count($this->ac->get_symptom('has_rashes', $STATUS))
			);
		}
		else
		{
			$data['distribution'] = $this->ac->check_gender_distribution($this->model->get_cases_limitless($STATUS, $this->session->userdata('TPusername')));
			$data['male_age_dist'] = $this->ac->age_distribution($this->model->get_cases_limitless($STATUS, $this->session->userdata('TPusername')),'M');
			$data['female_age_dist'] = $this->ac->age_distribution($this->model->get_cases_limitless($STATUS, $this->session->userdata('TPusername')),'F');
			
			$data['offices'] = $this->ac->check_sources('office', $STATUS, $this->session->userdata('TPusername'));
			$data['schools'] = $this->ac->check_sources('school', $STATUS, $this->session->userdata('TPusername'));
			
			$data['symptoms'] = array(
									'has_muscle_pain'	=> count($this->ac->get_symptom('has_muscle_pain', $STATUS, $this->session->userdata('TPusername'))),
									'has_joint_pain'	=> count($this->ac->get_symptom('has_joint_pain', $STATUS, $this->session->userdata('TPusername'))),
									'has_headache'		=> count($this->ac->get_symptom('has_headache', $STATUS, $this->session->userdata('TPusername'))),
									'has_bleeding'		=> count($this->ac->get_symptom('has_bleeding', $STATUS, $this->session->userdata('TPusername'))),
									'has_rashes'		=> count($this->ac->get_symptom('has_rashes', $STATUS, $this->session->userdata('TPusername')))
								);
		}
		// end of Graph Data
		
		$this->load->view('site/admin/cases',$data);
	}
	
	function view_threatening()
	{
		$STATUS = 'threatening';
		
		$config['base_url'] = site_url('website/cases/view_threatening');
		if ($this->session->userdata('TPtype') != 'BHW')
			$config['total_rows'] = count($this->model->get_cases_limitless($STATUS));
		else
			$config['total_rows'] = count($this->model->get_cases_limitless($STATUS, $this->session->userdata('TPusername')));
		$config['per_page'] = 10;
		$config['num_links'] = 3;
		$config['uri_segment'] = 4;
		
		$this->pagination->initialize($config);
		
		if ($this->session->userdata('TPtype') != 'BHW')
			$data['cases'] = $this->model->get_cases($STATUS, FALSE, $config['per_page'], $this->uri->segment(4));
		else
			$data['cases'] = $this->model->get_cases($STATUS, $this->session->userdata('TPusername'), $config['per_page'], $this->uri->segment(4));
		
		$data['links'] = $this->pagination->create_links();
		
		$data['type'] = 'Threatening';
		
		// Graph data
		
		if ($this->session->userdata('TPtype') != 'BHW')
		{
			$data['distribution'] = $this->ac->check_gender_distribution($this->model->get_cases_limitless($STATUS));
			$data['male_age_dist'] = $this->ac->age_distribution($this->model->get_cases_limitless($STATUS),'M');
			$data['female_age_dist'] = $this->ac->age_distribution($this->model->get_cases_limitless($STATUS),'F');
			
			$data['offices'] = $this->ac->check_sources('office',$STATUS);
			$data['schools'] = $this->ac->check_sources('school',$STATUS);
			
			$data['symptoms'] = array(
					'has_muscle_pain'	=> count($this->ac->get_symptom('has_muscle_pain', $STATUS)),
					'has_joint_pain'	=> count($this->ac->get_symptom('has_joint_pain', $STATUS)),
					'has_headache'		=> count($this->ac->get_symptom('has_headache', $STATUS)),
					'has_bleeding'		=> count($this->ac->get_symptom('has_bleeding', $STATUS)),
					'has_rashes'		=> count($this->ac->get_symptom('has_rashes', $STATUS))
			);
		}
		else
		{
			$data['distribution'] = $this->ac->check_gender_distribution($this->model->get_cases_limitless($STATUS, $this->session->userdata('TPusername')));
			$data['male_age_dist'] = $this->ac->age_distribution($this->model->get_cases_limitless($STATUS, $this->session->userdata('TPusername')),'M');
			$data['female_age_dist'] = $this->ac->age_distribution($this->model->get_cases_limitless($STATUS, $this->session->userdata('TPusername')),'F');
			
			$data['offices'] = $this->ac->check_sources('office', $STATUS, $this->session->userdata('TPusername'));
			$data['schools'] = $this->ac->check_sources('school', $STATUS, $this->session->userdata('TPusername'));
			
			$data['symptoms'] = array(
					'has_muscle_pain'	=> count($this->ac->get_symptom('has_muscle_pain', $STATUS, $this->session->userdata('TPusername'))),
					'has_joint_pain'	=> count($this->ac->get_symptom('has_joint_pain', $STATUS, $this->session->userdata('TPusername'))),
					'has_headache'		=> count($this->ac->get_symptom('has_headache', $STATUS, $this->session->userdata('TPusername'))),
					'has_bleeding'		=> count($this->ac->get_symptom('has_bleeding', $STATUS, $this->session->userdata('TPusername'))),
					'has_rashes'		=> count($this->ac->get_symptom('has_rashes', $STATUS, $this->session->userdata('TPusername')))
			);
		}
		// end of Graph Data
		
		$this->load->view('site/admin/cases',$data);
	}
	
	function view_serious()
	{
		$STATUS = 'serious';
		
		$config['base_url'] = site_url('website/cases/view_serious');
		if ($this->session->userdata('TPtype') != 'BHW')
			$config['total_rows'] = count($this->model->get_cases_limitless($STATUS));
		else
			$config['total_rows'] = count($this->model->get_cases_limitless($STATUS, $this->session->userdata('TPusername')));
		$config['per_page'] = 10;
		$config['num_links'] = 3;
		$config['uri_segment'] = 4;
		
		$this->pagination->initialize($config);
		
		if ($this->session->userdata('TPtype') != 'BHW')
			$data['cases'] = $this->model->get_cases($STATUS, FALSE, $config['per_page'], $this->uri->segment(4));
		else
			$data['cases'] = $this->model->get_cases($STATUS, $this->session->userdata('TPusername'), $config['per_page'], $this->uri->segment(4));
		
		$data['links'] = $this->pagination->create_links();
		
		$data['type'] = 'Serious';
		
		// Graph data
		
		if ($this->session->userdata('TPtype') != 'BHW')
		{
			$data['distribution'] = $this->ac->check_gender_distribution($this->model->get_cases_limitless($STATUS));
			$data['male_age_dist'] = $this->ac->age_distribution($this->model->get_cases_limitless($STATUS),'M');
			$data['female_age_dist'] = $this->ac->age_distribution($this->model->get_cases_limitless($STATUS),'F');
			
			$data['offices'] = $this->ac->check_sources('office',$STATUS);
			$data['schools'] = $this->ac->check_sources('school',$STATUS);
			
			$data['symptoms'] = array(
					'has_muscle_pain'	=> count($this->ac->get_symptom('has_muscle_pain', $STATUS)),
					'has_joint_pain'	=> count($this->ac->get_symptom('has_joint_pain', $STATUS)),
					'has_headache'		=> count($this->ac->get_symptom('has_headache', $STATUS)),
					'has_bleeding'		=> count($this->ac->get_symptom('has_bleeding', $STATUS)),
					'has_rashes'		=> count($this->ac->get_symptom('has_rashes', $STATUS))
			);
		}
		else
		{
			$data['distribution'] = $this->ac->check_gender_distribution($this->model->get_cases_limitless($STATUS, $this->session->userdata('TPusername')));
			$data['male_age_dist'] = $this->ac->age_distribution($this->model->get_cases_limitless($STATUS, $this->session->userdata('TPusername')),'M');
			$data['female_age_dist'] = $this->ac->age_distribution($this->model->get_cases_limitless($STATUS, $this->session->userdata('TPusername')),'F');
			
			$data['offices'] = $this->ac->check_sources('office', $STATUS, $this->session->userdata('TPusername'));
			$data['schools'] = $this->ac->check_sources('school', $STATUS, $this->session->userdata('TPusername'));
			
			$data['symptoms'] = array(
					'has_muscle_pain'	=> count($this->ac->get_symptom('has_muscle_pain', $STATUS, $this->session->userdata('TPusername'))),
					'has_joint_pain'	=> count($this->ac->get_symptom('has_joint_pain', $STATUS, $this->session->userdata('TPusername'))),
					'has_headache'		=> count($this->ac->get_symptom('has_headache', $STATUS, $this->session->userdata('TPusername'))),
					'has_bleeding'		=> count($this->ac->get_symptom('has_bleeding', $STATUS, $this->session->userdata('TPusername'))),
					'has_rashes'		=> count($this->ac->get_symptom('has_rashes', $STATUS, $this->session->userdata('TPusername')))
			);
		}
		// end of Graph Data
		
		$this->load->view('site/admin/cases',$data);
	}
	
	function view_hospitalized()
	{
		$STATUS = 'hospitalized';
		
		$config['base_url'] = site_url('website/cases/view_hospitalized');
		if ($this->session->userdata('TPtype') != 'BHW')
			$config['total_rows'] = count($this->model->get_cases_limitless($STATUS));
		else
			$config['total_rows'] = count($this->model->get_cases_limitless($STATUS, $this->session->userdata('TPusername')));
		$config['per_page'] = 10;
		$config['num_links'] = 3;
		$config['uri_segment'] = 4;
	
		$this->pagination->initialize($config);
	
		if ($this->session->userdata('TPtype') != 'BHW')
			$data['cases'] = $this->model->get_cases($STATUS, FALSE, $config['per_page'], $this->uri->segment(4));
		else
			$data['cases'] = $this->model->get_cases($STATUS, $this->session->userdata('TPusername'), $config['per_page'], $this->uri->segment(4));
		
		$data['links'] = $this->pagination->create_links();
	
		$data['type'] = 'Hospitalized';
		
		// Graph data
		
		if ($this->session->userdata('TPtype') != 'BHW')
		{
			$data['distribution'] = $this->ac->check_gender_distribution($this->model->get_cases_limitless($STATUS));
			$data['male_age_dist'] = $this->ac->age_distribution($this->model->get_cases_limitless($STATUS),'M');
			$data['female_age_dist'] = $this->ac->age_distribution($this->model->get_cases_limitless($STATUS),'F');
			
			$data['offices'] = $this->ac->check_sources('office',$STATUS);
			$data['schools'] = $this->ac->check_sources('school',$STATUS);
			
			$data['symptoms'] = array(
					'has_muscle_pain'	=> count($this->ac->get_symptom('has_muscle_pain', $STATUS)),
					'has_joint_pain'	=> count($this->ac->get_symptom('has_joint_pain', $STATUS)),
					'has_headache'		=> count($this->ac->get_symptom('has_headache', $STATUS)),
					'has_bleeding'		=> count($this->ac->get_symptom('has_bleeding', $STATUS)),
					'has_rashes'		=> count($this->ac->get_symptom('has_rashes', $STATUS))
			);
		}
		else
		{
			$data['distribution'] = $this->ac->check_gender_distribution($this->model->get_cases($STATUS, $this->session->userdata('TPusername')));
			$data['male_age_dist'] = $this->ac->age_distribution($this->model->get_cases($STATUS, $this->session->userdata('TPusername')),'M');
			$data['female_age_dist'] = $this->ac->age_distribution($this->model->get_cases($STATUS, $this->session->userdata('TPusername')),'F');
			
			$data['offices'] = $this->ac->check_sources('office', $STATUS, $this->session->userdata('TPusername'));
			$data['schools'] = $this->ac->check_sources('school', $STATUS, $this->session->userdata('TPusername'));
			
			$data['symptoms'] = array(
					'has_muscle_pain'	=> count($this->ac->get_symptom('has_muscle_pain', $STATUS, $this->session->userdata('TPusername'))),
					'has_joint_pain'	=> count($this->ac->get_symptom('has_joint_pain', $STATUS, $this->session->userdata('TPusername'))),
					'has_headache'		=> count($this->ac->get_symptom('has_headache', $STATUS, $this->session->userdata('TPusername'))),
					'has_bleeding'		=> count($this->ac->get_symptom('has_bleeding', $STATUS, $this->session->userdata('TPusername'))),
					'has_rashes'		=> count($this->ac->get_symptom('has_rashes', $STATUS, $this->session->userdata('TPusername')))
			);
		}
		// end of Graph Data
		
		$this->load->view('site/admin/cases',$data);
	}
	
	function view_person($id)
	{
		$data['person'] = $this->ac->get_case($id);
		
		$this->load->view('site/admin/case',$data);
	}
	
	function update_to_previous()
	{
		$this->ac->update_to_previous($this->input->post('imcase_no'));
			
		$data['result'] = $this->input->post('person_name') . '\'s status has been updated.';
		$this->load->view('site/success',$data);
	}
}

/* End of file cases.php */
/* Location: ./application/controllers/website/cho/cases.php */