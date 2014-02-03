<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pages extends CI_Controller
{
	public function view($page = 'home')
	{
		$this->load->library('mobile_detect');
		if ($this->mobile_detect->isTablet() || $this->mobile_detect->isMobile())
		{
			redirect('mobile');
		}
		else
		{
			if ( ! file_exists('application/views/site/'.$page.'.php'))
			{
				// Whoops, we don't have a page for that!
				show_404();
			}
			
			$this->load->view('site/'.$page);
		}
	}
}

/* End of file pages.php */
/* Location: ./application/controllers/website/pages.php */