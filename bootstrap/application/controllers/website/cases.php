<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cases extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('cases_model','model');
		$this->load->model('active_case_model','ac');
	}
	
	function add_case()
	{
		
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
}

/* End of file cases.php */
/* Location: ./application/controllers/website/cho/cases.php */