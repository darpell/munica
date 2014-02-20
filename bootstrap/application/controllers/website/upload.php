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
			
			for ($i=0; $i < count($patientnum); $i++)
			{
				$values[$i] = array(
							'cr_patient_no'		=> $patientnum[$i],
							'cr_first_name'		=> $firstname[$i],
							'cr_last_name'		=> $familyname[$i],
							'cr_dob'			=> $DOB[$i] ,
							'cr_address'		=> $street[$i] . " " . $barangay[$i] . " " . $city[$i] . " " . $province[$i] ,
							'cr_date_onset'		=> $dOnset[$i],
							'cr_date_of_entry'	=> $dateofentry[$i],
							'cr_sex'			=> $sex[$i],
							'cr_barangay'		=> $barangay[$i]
						);
			}
			
			$data['error'] = '';
			$data['values'] = $values;
			
			$data['entry_count'] = count($patientnum);
			$data['residents'] = $this->model->check_case_resident($values);
			$data['distribution'] = $this->model->check_gender_distribution($values);
			
			$this->load->view('site/admin/upload_confirm',$data);
			//$this->session->set_userdata('TPuploadvalues', $upload['full_path']);
			
			
			//$data['result'] = 'succeeded';
			//$this->load->view('site/success', $data);
		}
	}
	
	function confirmUpload()
	{	$this->redirectLogin();	
		if($this->input->post('TPsubmit') == 'Confirm Upload')
		{
		$this->load->model('Case_report');
		$this->load->model('notif');
		$this->load->model('midwife','masterlist');
		$db_connection = new COM("ADODB.Connection", NULL, 1251);
		$db_connstr = "DRIVER={Microsoft Access Driver (*.mdb)}; DBQ=" .
		$this->session->userdata('TPuploadvalues')  . "; ''; '';";
		
		$db_connection->open($db_connstr);
		$rs = $db_connection->execute("SELECT * FROM Dengue");
		
		$rs_fld0 = $rs->Fields(1);
		$rs_fld1 = $rs->Fields(1);
		$rs_fld2 = $rs->Fields(2);
		$rs_fld3 = $rs->Fields(3);
		$rs_fld4 = $rs->Fields(4);
		$rs_fld5 = $rs->Fields(5);
		$rs_fld6 = $rs->Fields(6);
		$rs_fld7 = $rs->Fields(7);
		$rs_fld8 = $rs->Fields(8);
		$rs_fld9 = $rs->Fields(9);
		$rs_fld10 = $rs->Fields(10);
		$rs_fld11 = $rs->Fields(11);
		$rs_fld12 = $rs->Fields(12);
		$rs_fld13 = $rs->Fields(13);
		$rs_fld14 = $rs->Fields(14);
		$rs_fld15 = $rs->Fields(15);
		$rs_fld16 = $rs->Fields(16);
		$rs_fld17 = $rs->Fields(17);
		$rs_fld18 = $rs->Fields(18);
		$rs_fld19 = $rs->Fields(19);
		$rs_fld20 = $rs->Fields(20);
		$rs_fld21 = $rs->Fields(21);
		$rs_fld22 = $rs->Fields(22);
		$rs_fld23 = $rs->Fields(23);
		$rs_fld24 = $rs->Fields(24);
		$rs_fld25 = $rs->Fields(25);
		$rs_fld26 = $rs->Fields(26);
		$rs_fld27 = $rs->Fields(27);
		$rs_fld28 = $rs->Fields(28);
		$rs_fld29 = $rs->Fields(29);
		$rs_fld30 = $rs->Fields(30);
		$rs_fld30 = $rs->Fields(30);
		$rs_fld31 = $rs->Fields(31);
		$rs_fld32 = $rs->Fields(32);
		$rs_fld33 = $rs->Fields(33);
		$rs_fld34 = $rs->Fields(34);
		$rs_fld35 = $rs->Fields(35);
		$rs_fld36 = $rs->Fields(36);
		$rs_fld37 = $rs->Fields(37);
		$rs_fld38 = $rs->Fields(38);
		$rs_fld39 = $rs->Fields(39);
		$rs_fld40 = $rs->Fields(40);
		$rs_fld41 = $rs->Fields(41);
		$rs_fld42 = $rs->Fields(42);
		$rs_fld43 = $rs->Fields(43);
		
		while (!$rs->EOF) {
		
		$region[]	=$rs_fld0->value;
		$province[]	=$rs_fld1->value;
		$city[]	=$rs_fld2->value;
		$street[]	=$rs_fld3->value;
		$dateofentry[]	=$rs_fld4->value;
		$DRU[]	=$rs_fld5->value;
		$patientnum[]	=$rs_fld6->value;
		$firstname[]	=$rs_fld7->value;
		$familyname[]	=$rs_fld8->value; 
		$fullname[]	=$rs_fld9->value; 
		$ageyears[]	=$rs_fld10->value;
		$agemonths[]	=$rs_fld11->value;
		$agedays[]	=$rs_fld12->value;
		$sex[]	=$rs_fld13->value;
		$addressofDRU[]	=$rs_fld14->value;
		$provofDRU[]	=$rs_fld15->value;
		$cityofDRU[]	=$rs_fld16->value;
		$DOB[]	=$rs_fld17->value;
		$admitted[]	=$rs_fld18->value;
		$dAdmit[]	=$rs_fld19->value; 
		$dOnset[]	=$rs_fld20->value;
		$type[]	=$rs_fld21->value;
		$labres[]	=$rs_fld22->value;
		$caseclassifiaction[]	=$rs_fld23->value;
		$outcome[]	=$rs_fld24->value;
		$regionofDRU[]	=$rs_fld25->value;
		$EPIID[]	=$rs_fld26->value;
		$DateDied[]	=$rs_fld27->value;
		$icdCode[]	=$rs_fld28->value;
		$MorbidityMonth[]	=$rs_fld29->value;
		$MorbidityWeek[]	=$rs_fld30->value; 
		$admittoentry[]	=$rs_fld31->value;
		$onsettoadmit[]	=$rs_fld32->value;
		$sentinelsite[]	=$rs_fld33->value;
		$deleterecord[]	=$rs_fld34->value;
		$year[]	=$rs_fld35->value;
		$recStatus[]	=$rs_fld36->value;
		$uniqueKey[]	=$rs_fld37->value;
		$NameofDRU[]	=$rs_fld38->value;
		$ILHZ[]	=$rs_fld39->value;
		$district[]	=$rs_fld40->value;
		$barangay[]	=$rs_fld41->value; 
		$typeofhospital[]	=$rs_fld42->value;
		$sent[]	=$rs_fld43->value;
		
		$rs->MoveNext();
		// Do something with the data here, like put it into mysql, put it into a file, or print it to the screen
		
		}
		$rs->Close();
		$db_connection->Close();
		$crno = time().'-'.mt_rand();
			for ($i=0; $i < count($patientnum); $i++)
			{
			$firstname[$i] = preg_replace('/\s+/', '', $firstname[$i]);
			$familyname[$i] = preg_replace('/\s+/', '', $familyname[$i]);
			
			$date= explode ('/', $DOB[$i]);
			$date2= explode ('/', $dAdmit[$i]);
			$date3= explode ('/', $dOnset[$i]);
			$date4= explode ('/', $dateofentry[$i]);
			$data = array(
			'TPpatientno-txt' => $patientnum[$i],
			'TPfirstname-txt' => $firstname[$i],
			'TPlastname-txt' => $familyname[$i],			
			'TPage-txt' => $ageyears[$i],
			'TPsex-dd' => $sex[$i],
			'TPbirthdate-txt' =>  $date[2].'-'.$date[0].'-'.$date[1],
			'TPcity-txt' => $city[$i],
			'TPbarangay-txt' => $barangay[$i], 
			'TPstreet-txt' => 	$street[$i], 			
			'TPadmitted-rd' => 	$admitted[$i],
			'TPconsuldate-txt' =>  $date2[2].'-'.$date2[0].'-'.$date2[1],
			'TPillnessdate-txt' =>  $date3[2].'-'.$date3[0].'-'.$date3[1],
			'TPclassification-rd'=>$caseclassifiaction[$i],
			'TPtype-rd'=>$type[$i],
			'TPregion-txt' => $region[$i],
			'TPprovince2-txt' => $provofDRU[$i],
			'TPdru-txt' => $NameofDRU[$i],
			'TPaddress-txt'=>$addressofDRU[$i]	,
			'TPcity2-txt'=>$cityofDRU[$i],
			'TPprovince-txt' =>$province[$i]	,
			'TPoutcome-rd'=> $outcome[$i],
			'TPcrno-txt' => $crno,
			'TPdateofentry-txt' => $date4[2].'-'.$date4[0].'-'.$date4[1],
			);
			$this->Case_report->addCase($data);
			
			$this->add_case_notif('newcase',$patientnum[$i],$barangay[$i]);
			$this->check_prev_case_notif($barangay[$i]);

			
			
			}


				
			

			$data['title'] = 'View patients';
			$data['table'] = null;
			$data['script'] = '';
			$data['error'] =  '';
		$data['result'] = "Successfully Uploaded " .  count($patientnum) . " Cases";
		$this->load->view('site/cho/upload',$data);
		
		}
		else if ($this->input->post('TPsubmit') == 'Cancel')
		{
			$this->session->unset_userdata('TPuploadvalues');
		 	redirect('/upload/', 'refresh');
		}
	}
	function add_case_notif($type,$id,$barangay)
	{
		if ($type == 'imcase')
		{//chance to person_id
			$msg = 'New Immediate Case:';
		}
		else if($type == 'invcase')
		{//change to patient_no'
			$msg = 'Plotted Uninvestigated Case:';
		}
		else if($type == 'newcase')
		{//change to patient_no'
		$msg = 'New Dengue Case Reported:';
		}
	
		$midwife = $this->notif->get_midwife_by_barangay($barangay);
		$personid = $id;
		$data2 = array(
				'notif_type' => 1,
				'notification' => $msg,
				'unique_id' => $type.'-'.$personid,
				'notif_viewed' => 'N',
				'notif_createdOn' => Date('Y-m-d'),
				'notif_user' => $midwife,
		);
		$this->notif->addnotif($data2);
	}
	function check_prev_case_notif($bgy)
	{
		$barangay =  $bgy;
		$data = $this->masterlist->get_cases($barangay);
		$midwife = $this->notif->get_midwife_by_barangay($barangay);
		if(($data[date('Y')] > $data[date('Y')-1]))
		{
			$id='highcase-'.date('Y-m');
			if ($this->notif->checknotifexist($id,$midwife))
			{
				$data2 = array(
						'notif_type' => 2,
						'notification' => 'current number of dengue cases exceeded the previous cases from last year',
						'unique_id' => $id,
						'notif_viewed' => 'N',
						'notif_createdOn' => Date('Y-m-d'),
						'notif_user' => $midwife,
	
				);
				$this->notif->addnotif($data2);
			}
		}
	}
}
		
/* End of file user/upload.php */
/* Location: ./application/controllers/website/cho/upload.php */