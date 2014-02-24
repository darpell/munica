<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Upload extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('cases_model','model');
	}
	
	public function index()
	{
		$data['error'] = '';
		$this->load->view('site/admin/upload', $data);
	}
	
	function do_upload()
	{	
		//$this->redirectLogin();
		$config['upload_path'] = './uploads/';
		$config['allowed_types'] = 'mdb';
		$config['max_size'] = '10000';
		
		$this->load->library('upload', $config);
		
		if ( ! $this->upload->do_upload() )
		{
			$data['error'] = $this->upload->display_errors();
			$this->load->view('site/admin/upload',$data);
		}
		else
		{
			$upload = $this->upload->data();
			
			$db_connection = new COM("ADODB.Connection", NULL, 1251);
			$db_connstr = "DRIVER={Microsoft Access Driver (*.mdb)}; DBQ=" . $upload['full_path']  . "; ''; '';";
			$db_connection->open($db_connstr);
			$rs = $db_connection->execute("SELECT * FROM Dengue");
		
			$FIELD_CTR = 43;
		
			for ($ctr = 0; $ctr <= $FIELD_CTR ; $ctr++)
			{
				$rs_fld[$ctr] = $rs->Fields($ctr);
			}
		
			while ( !$rs->EOF ) 
			{
				$region[]				= $rs_fld[0]->value;
				$province[]				= $rs_fld[1]->value;
				$city[]					= $rs_fld[2]->value;
				$street[]				= $rs_fld[3]->value;
				$dateofentry[]			= $rs_fld[4]->value;
				$DRU[]					= $rs_fld[5]->value;
				$patientnum[]			= $rs_fld[6]->value;
				$firstname[]			= $rs_fld[7]->value;
				$familyname[]			= $rs_fld[8]->value; 
				$fullname[]				= $rs_fld[9]->value; 
				$ageyears[]				= $rs_fld[10]->value;
				$agemonths[]			= $rs_fld[11]->value;
				$agedays[]				= $rs_fld[12]->value;
				$sex[]					= $rs_fld[13]->value;
				$addressofDRU[]			= $rs_fld[14]->value;
				$provofDRU[]			= $rs_fld[15]->value;
				$cityofDRU[]			= $rs_fld[16]->value;
				$DOB[]					= $rs_fld[17]->value;
				$admitted[]				= $rs_fld[18]->value;
				$dAdmit[]				= $rs_fld[19]->value; 
				$dOnset[]				= $rs_fld[20]->value;
				$type[]					= $rs_fld[21]->value;
				$labres[]				= $rs_fld[22]->value;
				$caseclassification[]	= $rs_fld[23]->value;
				$outcome[]				= $rs_fld[24]->value;
				$regionofDRU[]			= $rs_fld[25]->value;
				$EPIID[]				= $rs_fld[26]->value;
				$DateDied[]				= $rs_fld[27]->value;
				$icdCode[]				= $rs_fld[28]->value;
				$MorbidityMonth[]		= $rs_fld[29]->value;
				$MorbidityWeek[]		= $rs_fld[30]->value; 
				$admittoentry[]			= $rs_fld[31]->value;
				$onsettoadmit[]			= $rs_fld[32]->value;
				$sentinelsite[]			= $rs_fld[33]->value;
				$deleterecord[]			= $rs_fld[34]->value;
				$year[]					= $rs_fld[35]->value;
				$recStatus[]			= $rs_fld[36]->value;
				$uniqueKey[]			= $rs_fld[37]->value;
				$NameofDRU[]			= $rs_fld[38]->value;
				$ILHZ[]					= $rs_fld[39]->value;
				$district[]				= $rs_fld[40]->value;
				$barangay[]				= $rs_fld[41]->value; 
				$typeofhospital[]		= $rs_fld[42]->value;
				$sent[]					= $rs_fld[43]->value;
				
				$rs->MoveNext();
				// Do something with the data here, like put it into mysql, put it into a file, or print it to the screen
			}
			$rs->Close();
			$db_connection->Close();
			
			$cr_no = date('Ymd-s');
			
			$header_values = array(
						'cr_no' 		=> $cr_no,
						'cr_region'		=> $region[0],
						'cr_province'	=> $province[0],
						'cr_city'		=> $city[0],
						'cr_name_dru'	=> $NameofDRU[0],
						'cr_address'	=> $addressofDRU[0],
						//'created_by'	=> ,
						'created_on'	=> date('Y-m-d')
					);
			
			for ($i=0; $i < count($patientnum); $i++)
			{
				$values[$i] = array(
							'cr_patient_no'		=> $patientnum[$i],
							'cr_first_name'		=> $firstname[$i],
							'cr_last_name'		=> $familyname[$i],
							'cr_sex'			=> $sex[$i],
							'cr_admitted'		=> $admitted[$i],
							'cr_date_admitted'	=> $dAdmit[$i],
							'cr_date_onset'		=> $dOnset[$i],
							'cr_classification'	=> $caseclassification[$i],
							'cr_type'			=> $type[$i],
							'cr_outcome'		=> $outcome[$i],
							'cr_dob'			=> $DOB[$i],
							'cr_street'			=> $street[$i],
							'cr_barangay'		=> $barangay[$i],
							'cr_city'			=> $city[$i],
							'cr_province'		=> $province[$i],
							'uploaded_by'		=> $this->session->userdata('TPusername'),
							'created_on'		=> $dateofentry[$i],
							'last_updated_by'	=> $this->session->userdata('TPusername'),
							'last_updated_on'	=> $dateofentry[$i],
							'cr_age'			=> $ageyears[$i],
							'cr_date_of_entry'	=> $dateofentry[$i]
						);
			}
			
			$data['error'] = '';
			$data['header_values'] = $header_values;
			$data['values'] = $values;
			
			$data['entry_count'] = count($patientnum);
			$data['residents'] = $this->model->get_case_resident($values);
			$data['active_cases'] = $this->model->check_if_active($values);
			$data['distribution'] = $this->model->check_gender_distribution($values);
			
			$this->session->set_userdata('TPuploadPath', $upload['full_path']);
			$this->load->view('site/admin/upload_confirm',$data);
			
			//$data['result'] = 'succeeded';
			//$this->load->view('site/success', $data);
		}
	}
	
	function confirm_upload()
	{	
		if ($this->input->post('TPsubmit') == 'Confirm')
		{
			$db_connection = new COM("ADODB.Connection", NULL, 1251);
			$db_connstr = "DRIVER={Microsoft Access Driver (*.mdb)}; DBQ=" . $this->session->userdata('TPuploadPath')  . "; ''; '';";
			$db_connection->open($db_connstr);
			$rs = $db_connection->execute("SELECT * FROM Dengue");
			
			$FIELD_CTR = 43;
			
			for ($ctr = 0; $ctr <= $FIELD_CTR ; $ctr++)
			{
				$rs_fld[$ctr] = $rs->Fields($ctr);
			}
			
			while ( !$rs->EOF ) 
			{
				$region[]				= $rs_fld[0]->value;
				$province[]				= $rs_fld[1]->value;
				$city[]					= $rs_fld[2]->value;
				$street[]				= $rs_fld[3]->value;
				$dateofentry[]			= $rs_fld[4]->value;
				$DRU[]					= $rs_fld[5]->value;
				$patientnum[]			= $rs_fld[6]->value;
				$firstname[]			= $rs_fld[7]->value;
				$familyname[]			= $rs_fld[8]->value; 
				$fullname[]				= $rs_fld[9]->value; 
				$ageyears[]				= $rs_fld[10]->value;
				$agemonths[]			= $rs_fld[11]->value;
				$agedays[]				= $rs_fld[12]->value;
				$sex[]					= $rs_fld[13]->value;
				$addressofDRU[]			= $rs_fld[14]->value;
				$provofDRU[]			= $rs_fld[15]->value;
				$cityofDRU[]			= $rs_fld[16]->value;
				$DOB[]					= $rs_fld[17]->value;
				$admitted[]				= $rs_fld[18]->value;
				$dAdmit[]				= $rs_fld[19]->value; 
				$dOnset[]				= $rs_fld[20]->value;
				$type[]					= $rs_fld[21]->value;
				$labres[]				= $rs_fld[22]->value;
				$caseclassification[]	= $rs_fld[23]->value;
				$outcome[]				= $rs_fld[24]->value;
				$regionofDRU[]			= $rs_fld[25]->value;
				$EPIID[]				= $rs_fld[26]->value;
				$DateDied[]				= $rs_fld[27]->value;
				$icdCode[]				= $rs_fld[28]->value;
				$MorbidityMonth[]		= $rs_fld[29]->value;
				$MorbidityWeek[]		= $rs_fld[30]->value; 
				$admittoentry[]			= $rs_fld[31]->value;
				$onsettoadmit[]			= $rs_fld[32]->value;
				$sentinelsite[]			= $rs_fld[33]->value;
				$deleterecord[]			= $rs_fld[34]->value;
				$year[]					= $rs_fld[35]->value;
				$recStatus[]			= $rs_fld[36]->value;
				$uniqueKey[]			= $rs_fld[37]->value;
				$NameofDRU[]			= $rs_fld[38]->value;
				$ILHZ[]					= $rs_fld[39]->value;
				$district[]				= $rs_fld[40]->value;
				$barangay[]				= $rs_fld[41]->value; 
				$typeofhospital[]		= $rs_fld[42]->value;
				$sent[]					= $rs_fld[43]->value;
					
				$rs->MoveNext();
				// Do something with the data here, like put it into mysql, put it into a file, or print it to the screen
			}
			$rs->Close();
			$db_connection->Close();
			
			$cr_no = date('Ymd-gis');
			
			$header_values = array(
					'cr_no' 		=> $cr_no,
					'cr_region'		=> $region[0],
					'cr_province'	=> $province[0],
					'cr_city'		=> $city[0],
					'cr_name_dru'	=> $NameofDRU[0],
					'cr_address'	=> $addressofDRU[0],
					//'created_by'	=> ,
					'created_on'	=> date('Y-m-d')
			);
				
			for ($i=0; $i < count($patientnum); $i++)
			{
				$values[$i] = array(
						'cr_no'				=> $cr_no,
						'cr_patient_no'		=> $patientnum[$i],
						'cr_first_name'		=> $firstname[$i],
						'cr_last_name'		=> $familyname[$i],
						'cr_sex'			=> $sex[$i],
						'cr_admitted'		=> $admitted[$i],
						'cr_date_admitted'	=> $dAdmit[$i],
						'cr_date_onset'		=> $dOnset[$i],
						'cr_classification'	=> $caseclassification[$i],
						'cr_type'			=> $type[$i],
						'cr_outcome'		=> $outcome[$i],
						'cr_dob'			=> $DOB[$i],
						'cr_street'			=> $street[$i],
						'cr_barangay'		=> $barangay[$i],
						'cr_city'			=> $city[$i],
						'cr_province'		=> $province[$i],
						'uploaded_by'		=> $this->session->userdata('TPusername'),
						'created_on'		=> $dateofentry[$i],
						'last_updated_by'	=> $this->session->userdata('TPusername'),
						'last_updated_on'	=> $dateofentry[$i],
						'cr_age'			=> $ageyears[$i],
						'date_of_entry'		=> $dateofentry[$i]
					);
			}
			
			$this->model->add_case($header_values,$values);			
			
			$data['result'] = "You have successfully uploaded " .  count($patientnum) . " cases";
			
			$this->load->view('site/success',$data);
		}
		else if ($this->input->post('TPsubmit') == 'Cancel')
		{
			$this->session->unset_userdata('TPuploadvalues');
		 	redirect('/website/upload');
		}
	}
}
		
/* End of file user/upload.php */
/* Location: ./application/controllers/website/cho/upload.php */