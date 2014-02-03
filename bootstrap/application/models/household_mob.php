<?php 
class Household_mob extends CI_Model
{
	function __construct()
	{
		// Call the Model constructor
		parent::__construct();
	}
	
	function add()
	{
		$input_data = array(
				'household_name'=>	$this->input->post('hh_name'),
				'household_lat'	=>	$this->input->post('lat'),
				'household_lng'	=>	$this->input->post('lng'),
				'house_no'		=>	$this->input->post('hh_no'),
				'street'		=>	$this->input->post('hh_street'),
				'last_visited'	=>	date("Y-m-d H:i:s")
		);
		$this->db->insert('household_address',$input_data);
	}
	
	function add_member()
	{
		$input_data = array(
				'person_first_name'	=>	$this->input->post('hh_fname'),
				'person_last_name'	=>	$this->input->post('hh_lname'),
				'person_dob'		=>	$this->input->post('hh_dob'),
				'person_sex'		=>	$this->input->post('hh_gender'),
				'person_marital'	=>	$this->input->post('hh_marital'),
				'person_nationality'=>	$this->input->post('hh_nationality'),
				'person_blood_type'	=>	$this->input->post('hh_blood'),
				'person_guardian'	=>	$this->input->post('hh_guardian'),
				'person_adu'		=>	'alive',
				'person_contactno'	=>	$this->input->post('hh_contact')
		);
		$this->db->insert('master_list',$input_data);
	}
}


/* End of household_mob.php */
/* Location: ./application/models/household_mob.php */