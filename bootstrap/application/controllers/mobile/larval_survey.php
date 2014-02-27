<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Larval_survey extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		//$this->load->model('poi_model','poi');
		$this->load->model('larval_survey_model','model');
	}
	
	function index()
	{
		$this->load->view('mobile/poi_form');
	}
	
	function add()
	{
		if ($this->form_validation->run('ls_form') == FALSE)
		{
			$this->load->view('mobile/ls_form');
		}
		else
		{
			$this->model->add();
			$return_data['result'] = 'Your entry has been recorded';
			$this->load->view('mobile/success',$return_data);
		}
	}
}

/* End of file mobile/larval_survey.php */
/* Location: ./application/controllers/mobile/larval_survey.php */