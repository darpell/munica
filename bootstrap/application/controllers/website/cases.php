<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cases extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('cases_model','model');
	}
	
	function add_case()
	{
		
	}
	
	function view_suspected()
	{
		$config['base_url'] = site_url('website/cases/view_suspected');
		$config['total_rows'] = $this->db->get_where('immediate_cases',array('status' => 'suspected'))->num_rows();
		$config['per_page'] = 5;
		$config['num_links'] = 3;
		$config['uri_segment'] = 4;
		
		$this->pagination->initialize($config);
		
		$data['cases'] = $this->model->get_cases('suspected', $config['per_page'], $this->uri->segment(4));
		$data['links'] = $this->pagination->create_links();
		
		$data['type'] = 'Suspected';
		$this->load->view('site/admin/cases',$data);
	}
	
	function view_threatening()
	{
		$config['base_url'] = site_url('website/cases/view_threatening');
		$config['total_rows'] = $this->db->get_where('immediate_cases',array('status' => 'threatening'))->num_rows();
		$config['per_page'] = 5;
		$config['num_links'] = 3;
		$config['uri_segment'] = 4;
		
		$this->pagination->initialize($config);
		
		$data['cases'] = $this->model->get_cases('threatening', $config['per_page'], $this->uri->segment(4));
		$data['links'] = $this->pagination->create_links();
		
		$data['type'] = 'Threatening';
		$this->load->view('site/admin/cases',$data);
	}
	
	function view_serious()
	{
		$config['base_url'] = site_url('website/cases/view_serious');
		$config['total_rows'] = $this->db->get_where('immediate_cases',array('status' => 'serious'))->num_rows();
		$config['per_page'] = 5;
		$config['num_links'] = 3;
		$config['uri_segment'] = 4;
		
		$this->pagination->initialize($config);
		
		$data['cases'] = $this->model->get_cases('serious', $config['per_page'], $this->uri->segment(4));
		$data['links'] = $this->pagination->create_links();
		
		$data['type'] = 'Serious';
		$this->load->view('site/admin/cases',$data);
	}
	
	function view_hospitalized()
	{
		$config['base_url'] = site_url('website/cases/view_hospitalized');
		$config['total_rows'] = $this->db->get_where('immediate_cases',array('status' => 'hospitalized'))->num_rows();
		$config['per_page'] = 5;
		$config['num_links'] = 3;
		$config['uri_segment'] = 4;
	
		$this->pagination->initialize($config);
	
		$data['cases'] = $this->model->get_cases('hospitalized', $config['per_page'], $this->uri->segment(4));
		$data['links'] = $this->pagination->create_links();
	
		$data['type'] = 'Serious';
		$this->load->view('site/admin/cases',$data);
	}
	
}

/* End of file cases.php */
/* Location: ./application/controllers/website/cho/cases.php */