<?php
class Cases extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		// Your own constructor code
		$this->load->model('active_case_model','model');
		
	}

	function add()
	{
		$this->form_validation->set_rules('duration', 'Dengue Fever Duration', 'callback_check_range|required');
	
		if ($this->form_validation->run() === FALSE)
		{
			$this->load->model('hh_model','hh');
			$data['person'] = $this->hh->get_person($person_id);
			$this->load->view('mobile/person_details_view', $data);
		}
		else
		{
			$return_data = $this->model->add_case();
	
			if ($return_data[0] == 'suspected')
				$color = 'YELLOW' ;
			else if ($return_data[0] == 'threatening')
				$color = 'ORANGE' ;
			else if ($return_data[0] == 'serious')
				$color = 'RED' ;
				
			if ($return_data[0] != null || $return_data[0] != "")
			{
				$data['result'] = "<label style=\"color:" . $color . "\">[" . strtoupper($return_data[0]) .
				" CASE] </label>Please give your contact details and/or the brgy contact no and tell
				the person and/or the people living in the same household to contact you
				immediately if the patient condition worsens.";
	
				if (in_array('Bleeding',$return_data[1]) || in_array('Rashes',$return_data[1]))
					$data['treatment'] = "Please ask the patient to have a check up to in the Barangay Health Center or at a nearby hospital due to bleeding and/or rashes.";
				else if (in_array('Headache',$return_data[1]) || in_array('Muscle Pain',$return_data[1]) || in_array('Joint Pain',$return_data[1]))
				{
					$data['treatment'] = "Pain Relievers (for muscle pain, joint pain, and severe headache)
											Acetaminophen (Tylenol), codeine, or analgesics.
											Avoid using ibuprofen, naproxen and aspirin as they might increase bleeding problems.";
				}
				else
					$data['treatment'] = "Please continue monitoring the fever.";
			}
			else
			{
				$data['result'] = 'Your entry has been recorded';
				$data['treatment'] = "Please continue monitoring the fever.";
			}
			$this->load->view('mobile/im_case_success',$data);
		}
	}
	
	public function check_range($num)
	{
		if ($num <= 0)
		{
			$this->form_validation->set_message('check_range', 'The %s field could not be less than nor equal to 0');
			return FALSE;
		}
		else if ($num > 20)
		{
			$this->form_validation->set_message('check_range', 'The %s field could not more than 20');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
	
	function edit($imcase)
	{
		// form validate
		$this->form_validation->set_rules('duration', 'Dengue Fever Duration', 'callback_check_range|required');
	
		if ($this->form_validation->run() === FALSE)
		{
			//$this->view_edit_person();
			$data['person'] = $this->model->get_case($imcase);
			$this->load->view('mobile/person_edit_details_view',$data);
		}
		else
		{
			// update
			$return_data = $this->model->update_im($imcase);
			if ($return_data[0] == 'suspected')
				$color = 'YELLOW' ;
			else if ($return_data[0] == 'threatening')
				$color = 'ORANGE' ;
			else if ($return_data[0] == 'serious')
				$color = 'RED' ;
				
			// redirect to person_edit_details_view
			if ($return_data[0] != null || $return_data[0] != "")
			{
				$data['result'] = "<label style=\"color:" . $color . "\">[" . strtoupper($return_data[0]) .
				" CASE] </label>Please give your contact details and/or the brgy contact no and tell
				the person and/or the people living in the same household to contact you
				immediately if the patient condition worsens.";
	
				if (in_array('Bleeding',$return_data[1]) || in_array('Rashes',$return_data[1]))
					$data['treatment'] = "Please ask the patient to have a check up to in the Barangay Health Center or at a nearby hospital due to bleeding and/or rashes.";
				else if (in_array('Headache',$return_data[1]) || in_array('Muscle Pain',$return_data[1]) || in_array('Joint Pain',$return_data[1]))
				{
					$data['treatment'] = "Treat with pain relievers like
											Acetaminophen (Tylenol), codeine, or analgesics. <br/>
											Avoid using ibuprofen, naproxen and aspirin as they might cause bleeding problems.";
				}
				else
					$data['treatment'] = "Please continue monitoring the fever.";
			}
			else
			{
				$data['result'] = 'Your entry has been recorded';
				$data['treatment'] = "Please continue monitoring the fever.";
			}
			$this->load->view('mobile/im_case_success',$data);
		}
	}
}

/* End of file mobile/case.php */
/* Location: ./application/controllers/mobile/case.php */