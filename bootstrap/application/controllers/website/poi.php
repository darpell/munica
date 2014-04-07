<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Poi extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('poi_model','model');
	}
	
	function get_source_pois()
	{
		$TYPE = 0;
		
		$config['base_url'] = site_url('website/poi/get_source_pois');
		$config['total_rows'] = $this->db->get_where('map_nodes', array('node_type' => $TYPE))->num_rows();
		$config['per_page'] = 10;
		$config['num_links'] = 3;
		$config['uri_segment'] = 4;
		
		$this->pagination->initialize($config);
		
		$data['pois'] = $this->model->get_POIs($TYPE, $config['per_page'], $this->uri->segment(4));
		
		$data['links'] = $this->pagination->create_links();
		
		$this->load->view('site/poi/poi_list', $data);
	}
	
	function get_risk_pois()
	{
		$TYPE = 1;
	
		$config['base_url'] = site_url('website/poi/get_risk_pois');
		$config['total_rows'] = $this->db->get_where('map_nodes', array('node_type' => $TYPE))->num_rows();
		$config['per_page'] = 10;
		$config['num_links'] = 3;
		$config['uri_segment'] = 4;
	
		$this->pagination->initialize($config);
	
		$data['pois'] = $this->model->get_POIs($TYPE, $config['per_page'], $this->uri->segment(4));
	
		$data['links'] = $this->pagination->create_links();
	
		$this->load->view('site/poi/poi_list', $data);
	}
	
	function get_unending_pois()
	{
		$this->session->unset_userdata('poi_start_date');
		$this->session->unset_userdata('poi_end_date');
		
		$config['base_url'] = site_url('website/poi/get_unending_pois');
		$config['total_rows'] = $this->db->get_where('map_nodes', array('node_endDate' => 0))->num_rows();
		$config['per_page'] = 10;
		$config['num_links'] = 3;
		$config['uri_segment'] = 4;
	
		$this->pagination->initialize($config);
	
		$data['pois'] = $this->model->get_unending_POIs($config['per_page'], $this->uri->segment(4));
	
		$data['links'] = $this->pagination->create_links();
	
		$this->load->view('site/poi/poi_list', $data);
	}
	
	function get_pois_in_between()
	{
		if ($this->session->userdata('poi_start_date') == FALSE)
			$this->session->set_userdata('poi_start_date', $this->input->post('poi_start_date'));
		if ($this->session->userdata('poi_end_date') == FALSE)
			$this->session->set_userdata('poi_end_date', $this->input->post('poi_end_date'));
		
		$start = $this->session->userdata('poi_start_date');
		$end = $this->session->userdata('poi_end_date');
		
		$config['base_url'] = site_url('website/poi/get_pois_in_between');
		$config['total_rows'] = count($this->model->get_POIs_in_between_limitless($start, $end));
		$config['per_page'] = 10;
		$config['num_links'] = 3;
		$config['uri_segment'] = 4;
		
		$this->pagination->initialize($config);
		
		$data['pois'] = $this->model->get_POIs_in_between($start, $end, $config['per_page'], $this->uri->segment(4));
		
		$data['links'] = $this->pagination->create_links();
		
		$this->load->view('site/poi/poi_list', $data);
	}
	
	function update($no)
	{
		if ($this->form_validation->run('poi_update') == FALSE)
		{
			$data['poi'] = $this->model->get_poi($no);
			$this->load->view('site/poi/poi_form', $data);
		}
		else
		{
			$input_data = array(
							'node_name'		=>	$this->input->post('TPname-txt'),
							'node_notes'	=>	$this->input->post('TPnotes-txt'),
							'node_endDate'	=>	$this->input->post('TPend-date')
						);
			
			$this->model->edit($no,$input_data);
			
			$data['result'] = 'Successfully updated!';
			$this->load->view('site/success',$data);
		}
	}
	
	function search()
	{
		$config['base_url'] = site_url('website/poi/search');
		$config['total_rows'] = count($this->model->search_limitless($this->input->post('TPsearch-txt')));
		$config['per_page'] = 10;
		$config['num_links'] = 3;
		$config['uri_segment'] = 4;
	
		$this->pagination->initialize($config);
	
		$data['results'] = $this->model->search($this->input->post('TPsearch-txt'), $config['per_page'], $this->uri->segment(4));
		$data['links'] = $this->pagination->create_links();
	
		$this->load->view('site/poi/poi_search_results', $data);
	}
	
}

/* End of file poi.php */
/* Location: ./application/controllers/website/poi.php */