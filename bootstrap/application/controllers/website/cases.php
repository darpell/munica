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
	
	function view($status)
	{
		$config['base_url'] = site_url('website/cases/view/' . $status);
		$config['total_rows'] = $this->db->get_where('active_cases',array('status' => $status))->num_rows();
		$config['per_page'] = 5;
		$config['num_links'] = 3;
		$config['uri_segment'] = 4;
	
		$this->pagination->initialize($config);
	
		$data['cases'] = $this->model->get_cases($status, $config['per_page'], $this->uri->segment(5));
		$data['links'] = $this->pagination->create_links();
	
		$data['type'] = ucfirst($status);
		$this->load->view('site/admin/cases',$data);
	}
	
	function view_person($id)
	{
		$data['person'] = $this->model->get_case($id);
		
		$this->load->view('site/admin/case',$data);
	}
}

/* End of file cases.php */
/* Location: ./application/controllers/website/cho/cases.php */