<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Immediate_case extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('im_case_model','im_case');
	}
	
	function index()
	{
		$this->load->view('mobile/immediate_case_form');
	}
	
	/*
	 * 
	 * FILE IS SUBJECT FOR DELETION
	 * 
	 */
	
	function add()
	{
		//$this->form_validation->set_rules('TPremarks-txt_r', 'remarks', 'required');
			
		if ($this->form_validation->run('im_case') == FALSE)
		{
			$this->load->view('mobile/immediate_case_form');
		}
		else
		{
			$input_data = array(
					'f_name'		=>	$this->input->post('TPfname-txt_r'),
					'l_name'		=>	$this->input->post('TPlname-txt_r'),
					'age'			=>	$this->input->post('TPage-txt_r'),
					'sex'			=>	$this->input->post('TPsex-txt_r'),
					'dob'			=>	date('Y-m-d', strtotime($this->input->post('TPdob-txt_r'))),
					'address'		=>	$this->input->post('TPaddress-txt_r'),
					'remarks'		=>	$this->input->post('TPremarks-txt_r'),
					'created_by'	=>	$this->session->userdata('TPusername'),
					'created_on'	=>	date("Y-m-d H:i:s")
				);
			
			$this->im_case->add($input_data);
			$data['result'] = 'Your entry has been recorded';
			$this->load->view('mobile/im_case_success',$data);
		}
	}
}

/* End of file mobile/immediate_case.php */
/* Location: ./application/controllers/mobile/immediate_case.php */