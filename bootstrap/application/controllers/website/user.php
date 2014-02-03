<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('user_model','model');
		$this->load->model('barangay_model');
	}
	
	function redirectLogin()
	{	
		$this->load->library('mobile_detect');
		if ($this->mobile_detect->isTablet() || $this->mobile_detect->isMobile())
		{
			$this->load->view('mobile/index.php');
		}
		elseif ($this->session->userdata('logged_in') != TRUE && $this->session->userdata('TPtype') != 'CHO' ){
			redirect(substr(base_url(), 0, -1) . '/index.php/login');
		}
	}
	
	function login()
	{
		if ($this->form_validation->run('login') == FALSE)
		{
			$this->load->view('site/login');
		}
		else
		{
			$data = array(
						'TPusername-txt' => $this->input->post('TPusername'),
						'TPpassword-txt' => $this->input->post('TPpassword')
					);
			$userinfo  = $this->model->login($data);
			if($userinfo != false)
			{
				$this->session->set_userdata('TPusername', $userinfo[0]['TPusername']);
				$this->session->set_userdata('TPtype', $userinfo[0]['TPtype']);
				$this->session->set_userdata('TPfirstname', $userinfo[0]['TPfirstname']);
				$this->session->set_userdata('TPmiddlename', $userinfo[0]['TPmiddlename'] );
				$this->session->set_userdata('TPlastname', $userinfo[0]['TPlastname'] );
				$this->session->set_userdata('logged_in', true);
				redirect(substr(base_url(), 0, -1) . '/index.php/');
			}
			else
			{
				$this->load->view('site/login');
			}
		}
	}
	
	function add()
	{
		if ($this->form_validation->run('register') == FALSE)
		{
			$data['brgys'] = $this->barangay_model->get_brgys();
			$this->load->view('site/admin/register', $data);
		}
		else
		{
			$this->model->add();
			$this->load->view('site/success');
		}
	}
	
	function get_users()
	{
		/*
		 * http://draco-003.com/blog/archives/2013/10/07/CodeIgniter-Pagination-Integrated-with-Bootstrap/i-32
		 */
		
		$config['base_url'] = site_url('website/user/get_users');
		$config['total_rows'] = $this->db->get('users')->num_rows();
		$config['per_page'] = 5;
		$config['num_links'] = 3;
		$config['uri_segment'] = 4;
		
		$this->pagination->initialize($config);
		
		$data['users'] = $this->model->get_users($config['per_page'], $this->uri->segment(4));
		
		$data['links'] = $this->pagination->create_links();
		
		$this->load->view('site/admin/users',$data);
	}
	
	function update($username)
	{
		if ($this->form_validation->run('user_update') == FALSE)
		{
			$data['user'] = $this->model->get_user($username);
			$data['brgys'] = $this->barangay_model->get_brgys();
			$this->load->view('site/admin/user_view', $data);
		}
		else
		{
			$this->model->update($username);
			$this->load->view('site/success');
		}
	}
	
	function delete()
	{
		
	}
	
	function view($username)
	{		
		$data['brgys'] = $this->barangay_model->get_brgys();
		$data['user'] = $this->model->get_user($username);
		$this->load->view('site/admin/user_view',$data);
	}
	
	function logout()
	{
		$this->session->sess_destroy();
		redirect(base_url());
	}
}

/* End of file user.php */
/* Location: ./application/controllers/website/user.php */