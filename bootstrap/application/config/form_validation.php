<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config = array(
				'login' => array(
								array(
										'field' => 'TPusername',
										'label' => 'username',
										'rules' => 'required'
								),
								array(
										'field' => 'TPpassword',
										'label' => 'password',
										'rules' => 'required'
								)
							),
		
                 'register' => array(
                                    array(
                                            'field' => 'TPusername-txt',
                                            'label' => 'username',
                                            'rules' => 'required|is_unique[users.user_username]'
                                         ),
                                    array(
                                            'field' => 'TPpassword-txt',
                                            'label' => 'password',
                                            'rules' => 'required|matches[TPpassword2-txt]'
                                         ),
                                    array(
                                            'field' => 'TPpassword2-txt',
                                            'label' => 'password confirmation',
                                            'rules' => 'required'
                                         ),
                                    array(
                                            'field' => 'TPfirstname-txt',
                                            'label' => 'first name',
                                            'rules' => 'required|alpha'
                                         ),
			                 		array(
			                 				'field' => 'TPmiddlename-txt',
			                 				'label' => 'middle name',
			                 				'rules' => 'required|alpha'
			                 			),
			                 		array(
			                 				'field' => 'TPlastname-txt',
			                 				'label' => 'last name',
			                 				'rules' => 'required|alpha-dash'
			                 			),
			                 		array(
			                 				'field' => 'TPcontactno-txt',
			                 				'label' => 'contact number',
			                 				'rules' => 'required|numeric'
			                 			)
                 					
                                    ),
		
					'im_case' => array(
										array(
												'field' => 'TPdate-txt_r',
												'label' => 'Date',
												'rules' => 'required'
										),
										array(
												'field' => 'TPfname-txt_r',
												'label' => 'First Name',
												'rules' => 'required'
										),
										array(
												'field' => 'TPlname-txt_r',
												'label' => 'Last Name',
												'rules' => 'required'
										),
										array(
												'field' => 'TPage-txt_r',
												'label' => 'Age',
												'rules' => 'required'
										),
										array(
												'field' => 'TPsex-txt_r',
												'label' => 'Gender',
												'rules' => 'required'
										),
										array(
												'field' => 'TPdob-txt_r',
												'label' => 'Date of Birth',
												'rules' => 'required'
										),
										array(
												'field' => 'TPaddress-txt_r',
												'label' => 'Address',
												'rules' => 'required'
										)
								),
		
					'user_update' => array(
							array(
									'field' => 'TPusername-txt',
									'label' => 'username',
									'rules' => 'required'
							),
							array(
									'field' => 'TPpassword-txt',
									'label' => 'password',
									'rules' => 'required|matches[TPpassword2-txt]'
							),
							array(
									'field' => 'TPpassword2-txt',
									'label' => 'password confirmation',
									'rules' => 'required'
							),
							array(
									'field' => 'TPfirstname-txt',
									'label' => 'first name',
									'rules' => 'required|alpha'
							),
							array(
									'field' => 'TPmiddlename-txt',
									'label' => 'middle name',
									'rules' => 'required|alpha'
							),
							array(
									'field' => 'TPlastname-txt',
									'label' => 'last name',
									'rules' => 'required|alpha-dash'
							),
							array(
									'field' => 'TPcontactno-txt',
									'label' => 'contact number',
									'rules' => 'required|numeric'
							)
					
					),
		
				'household' => array(
									array(
											'field' => 'hh_name',
											'label' => 'household name',
											'rules' => 'required'
											),
									array(
											'field' => 'hh_no',
											'label' => 'household number',
											'rules' => 'required'
									),
									array(
											'field' => 'hh_street',
											'label' => 'household street',
											'rules' => 'required'
									)
							),
		
				'poi'		=> array(
								array(
									'field' => 'TPname-txt_r',
									'label'	=> 'name',
									'rules'	=> 'required'
								),
								array(
									'field' => 'TPremarks-txt_r',
									'label'	=> 'remarks',
									'rules'	=> 'required'
								)
							),
				'ls_form'	=> array(
								array(
									'field' => 'TPcontainer-txt_r',
									'label'	=> 'container',
									'rules'	=> 'required'
								),
								array(
									'field' => 'TPhousehold-txt_r',
									'label'	=> 'household',
									'rules'	=> 'required'
						),
						)                   
               );

/* End of file form_validation.php */
/* Location: ./application/config/form_validation.php */