<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Master_list extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		// Your own constructor code
		$this->load->model('hh_model','model');
	}
	
	function index()
	{
		$data['subjects'] = $this->model->get_households_limitless($this->session->userdata('TPusername'));
		
		$last_visits = array();
		
		foreach ($data['subjects'] as $hh)
		{
			$temp = $this->model->get_visits($hh['household_id']);
			array_push($last_visits, $temp);
		}
		
		$data['last_visits'] = $last_visits;
		
		$this->load->view('mobile/master_list', $data);
	}

	function add()
	{
		if ($this->form_validation->run('household') == FALSE)
		{
			$this->load->view('mobile/household_form');
		}
		else
		{
			$this->model->add_household();
			$data['result'] = 'Your entry has been recorded';
			$this->load->view('mobile/poi_success', $data);
		}
	}
	
	function add_member($hh)
	{
		if ($this->form_validation->run('new_member') == FALSE)
		{
			$data['household_id'] = $hh;
			$this->load->view('mobile/household_member_form',$data);
		}
		else
		{
			$this->model->add_hh_member($this->input->post('household_id'));
			$data['result'] = 'Your entry has been recorded';
			$this->load->view('mobile/poi_success', $data);
		}
	}
	
	function view_household($household_id)
	{
		$data['hh'] = $this->model->get_household($household_id);
		$data['household_persons'] = $this->model->get_people_limitless($household_id);
		$data['hh_id'] = $household_id;
		$this->load->view('mobile/master_list_view', $data);
	}
	
	function view_person($person_id)
	{
		$data['person'] = $this->model->get_person($person_id);
		$this->load->view('mobile/person_details_view', $data);
	}
}

/* End of file mobile/master_list.php */
/* Location: ./application/controllers/mobile/master_list.php */