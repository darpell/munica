<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Notifications extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('notif_model','model');
	}
	
	function index()
	{
		$data['notifs'] = $this->model->getnotifs($this->session->userdata('TPusername'));
		$this->load->view('site/admin/notifications',$data);
	}
	
	function set_viewed($id)
	{
		$this->model->set_viewed($id);
		
		$this->index();
	}
	
	function clear_all()
	{
		$this->model->clear_all($this->session->userdata('TPusername'));
		$data['result'] = 'Successfully deleted all your notifications.';
		$this->load->view('site/success', $data);
	}
}

/* End of file notifications.php */
/* Location: ./application/controllers/website/notifications.php */