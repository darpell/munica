<?php 
class Larval_survey_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		//load monica database
		$this->load->database('default');
	}
	
	function add()
	{
		$data = array(
					'ls_household'		=> $this->input->post('TPhousehold-txt_r'),
					'ls_container'		=> $this->input->post('TPcontainer-txt_r'),
					'ls_barangay'		=> $this->input->post('TPbarangay-txt_r'),
					'ls_lat'			=> $this->input->post('lat'),
					'ls_lng'			=> $this->input->post('lng'),
					'created_by'		=> $this->session->userdata('TPusername'),
					'created_on'		=> date('Y-m-d H:i:s'),
					'last_updated_by'	=> $this->session->userdata('TPusername'),
					'last_updated_on'	=> date("Y-m-d H:i:s")
				);
		
		$this->db->insert('ls_report', $data);
	}
}

/* End of larval_survey.php */
/* Location: ./application/models/larval_survey.php */