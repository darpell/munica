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
		
		$this->load->view('site/admin/cases_map', $data);
	}
	
	function view_suspected()
	{
		/*
		 * Case Data
		 */
		$config['base_url'] = site_url('website/cases/view_suspected');
		$config['total_rows'] = $this->db->get_where('active_cases',array('status' => 'suspected'))->num_rows();
		$config['per_page'] = 5;
		$config['num_links'] = 3;
		$config['uri_segment'] = 4;
		
		$this->pagination->initialize($config);
		
		$data['cases'] = $this->model->get_cases('suspected', $config['per_page'], $this->uri->segment(4));
		$data['links'] = $this->pagination->create_links();
		
		$data['type'] = 'Suspected';
		/*
		 * end of Case Data
		 */
		
		// Graph data
		$STATUS = 'suspected';
		
		$data['distribution'] = $this->ac->check_gender_distribution($this->model->get_cases($STATUS));
		$data['male_age_dist'] = $this->ac->age_distribution($this->model->get_cases($STATUS),'M');
		$data['female_age_dist'] = $this->ac->age_distribution($this->model->get_cases($STATUS),'F');
		
		$data['offices'] = $this->ac->check_sources('office',$STATUS);
		$data['schools'] = $this->ac->check_sources('school',$STATUS);
		
		$data['symptoms'] = array(
								'has_muscle_pain'	=> count($this->ac->get_symptom('has_muscle_pain', $STATUS)),
								'has_joint_pain'	=> count($this->ac->get_symptom('has_joint_pain', $STATUS)),
								'has_headache'		=> count($this->ac->get_symptom('has_headache', $STATUS)),
								'has_bleeding'		=> count($this->ac->get_symptom('has_bleeding', $STATUS)),
								'has_rashes'		=> count($this->ac->get_symptom('has_rashes', $STATUS))
							);
		// end of Graph Data
		
		$this->load->view('site/admin/cases',$data);
	}
	
	function view_threatening()
	{
		$config['base_url'] = site_url('website/cases/view_threatening');
		$config['total_rows'] = $this->db->get_where('active_cases',array('status' => 'threatening'))->num_rows();
		$config['per_page'] = 5;
		$config['num_links'] = 3;
		$config['uri_segment'] = 4;
		
		$this->pagination->initialize($config);
		
		$data['cases'] = $this->model->get_cases('threatening', $config['per_page'], $this->uri->segment(4));
		$data['links'] = $this->pagination->create_links();
		
		$data['type'] = 'Threatening';
		
		// Graph data
		$STATUS = 'threatening';
		
		$data['distribution'] = $this->ac->check_gender_distribution($this->model->get_cases($STATUS));
		$data['male_age_dist'] = $this->ac->age_distribution($this->model->get_cases($STATUS),'M');
		$data['female_age_dist'] = $this->ac->age_distribution($this->model->get_cases($STATUS),'F');
		
		$data['offices'] = $this->ac->check_sources('office',$STATUS);
		$data['schools'] = $this->ac->check_sources('school',$STATUS);
		
		$data['symptoms'] = array(
				'has_muscle_pain'	=> count($this->ac->get_symptom('has_muscle_pain', $STATUS)),
				'has_joint_pain'	=> count($this->ac->get_symptom('has_joint_pain', $STATUS)),
				'has_headache'		=> count($this->ac->get_symptom('has_headache', $STATUS)),
				'has_bleeding'		=> count($this->ac->get_symptom('has_bleeding', $STATUS)),
				'has_rashes'		=> count($this->ac->get_symptom('has_rashes', $STATUS))
		);
		// end of Graph Data
		
		$this->load->view('site/admin/cases',$data);
	}
	
	function view_serious()
	{
		$config['base_url'] = site_url('website/cases/view_serious');
		$config['total_rows'] = $this->db->get_where('active_cases',array('status' => 'serious'))->num_rows();
		$config['per_page'] = 5;
		$config['num_links'] = 3;
		$config['uri_segment'] = 4;
		
		$this->pagination->initialize($config);
		
		$data['cases'] = $this->model->get_cases('serious', $config['per_page'], $this->uri->segment(4));
		$data['links'] = $this->pagination->create_links();
		
		$data['type'] = 'Serious';
		
		// Graph data
		$STATUS = 'serious';
		
		$data['distribution'] = $this->ac->check_gender_distribution($this->model->get_cases($STATUS));
		$data['male_age_dist'] = $this->ac->age_distribution($this->model->get_cases($STATUS),'M');
		$data['female_age_dist'] = $this->ac->age_distribution($this->model->get_cases($STATUS),'F');
		
		$data['offices'] = $this->ac->check_sources('office',$STATUS);
		$data['schools'] = $this->ac->check_sources('school',$STATUS);
		
		$data['symptoms'] = array(
				'has_muscle_pain'	=> count($this->ac->get_symptom('has_muscle_pain', $STATUS)),
				'has_joint_pain'	=> count($this->ac->get_symptom('has_joint_pain', $STATUS)),
				'has_headache'		=> count($this->ac->get_symptom('has_headache', $STATUS)),
				'has_bleeding'		=> count($this->ac->get_symptom('has_bleeding', $STATUS)),
				'has_rashes'		=> count($this->ac->get_symptom('has_rashes', $STATUS))
		);
		// end of Graph Data
		
		$this->load->view('site/admin/cases',$data);
	}
	
	function view_hospitalized()
	{
		$config['base_url'] = site_url('website/cases/view_hospitalized');
		$config['total_rows'] = $this->db->get_where('active_cases',array('status' => 'hospitalized'))->num_rows();
		$config['per_page'] = 5;
		$config['num_links'] = 3;
		$config['uri_segment'] = 4;
	
		$this->pagination->initialize($config);
	
		$data['cases'] = $this->model->get_cases('hospitalized', $config['per_page'], $this->uri->segment(4));
		$data['links'] = $this->pagination->create_links();
	
		$data['type'] = 'Serious';
		
		// Graph data
		$STATUS = 'serious';
		
		$data['distribution'] = $this->ac->check_gender_distribution($this->model->get_cases($STATUS));
		$data['male_age_dist'] = $this->ac->age_distribution($this->model->get_cases($STATUS),'M');
		$data['female_age_dist'] = $this->ac->age_distribution($this->model->get_cases($STATUS),'F');
		
		$data['offices'] = $this->ac->check_sources('office',$STATUS);
		$data['schools'] = $this->ac->check_sources('school',$STATUS);
		
		$data['symptoms'] = array(
				'has_muscle_pain'	=> count($this->ac->get_symptom('has_muscle_pain', $STATUS)),
				'has_joint_pain'	=> count($this->ac->get_symptom('has_joint_pain', $STATUS)),
				'has_headache'		=> count($this->ac->get_symptom('has_headache', $STATUS)),
				'has_bleeding'		=> count($this->ac->get_symptom('has_bleeding', $STATUS)),
				'has_rashes'		=> count($this->ac->get_symptom('has_rashes', $STATUS))
		);
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