<?php

	class Tweet_test extends CI_Controller {
		
		public function __construct()
		{
			parent::__construct();
			$this->load->model('Analytics_model');
		}
		
		function index()
		{
			$temp =  $this->Analytics_model->get_case_count(date('m'),date('Y'));
			
			$data['status'] = 'asdasd';
			$data['count'] =$temp['count'];
			if ($temp['count'] > $temp['ave'])
			$data['ave'] = 'above average';
			else
			$data['ave'] = 'below average';
			
			$this->load->view('site/twitter',$data);
		}
		function tweet()
		{
			$option = $this->input->post('optionsRadios');
			
			if($option == 'option1')
			$status = $this->input->post('hidden1');
			else if($option == 'option2')
			$status = $this->input->post('hidden2');
			else if($option == 'option3')
			$status = $this->input->post('customtweettext');
			
			
			
			$this->load->library('tmhOAuth');
			$tmhOAuth = new tmhOAuth(array(
					'consumer_key' => '8gkYNsW6qLZynKvBr0Lw',
					'consumer_secret' => 'B3N2jyxh9iSR1cMeQjfS4JlRHYHPSwb44BYbz5YRXtc',
					'token' => '1295280488-CqrrGf67KuJoCm1SWnh3AplzznuI3kopOJsNjqc',
					'secret' => 'EF8LrWjT5kloG4TXmbAiuBZqoixC1aBk508ze3X66dK1u',
			));
			
			$response = $tmhOAuth->request('POST', $tmhOAuth->url('1.1/statuses/update'), array(
					'status' => $status
			));
				
			if ($response != 200) {
				//Do something if the request was unsuccessful
				echo 'There was an error posting the message.';
			}
			
			redirect('website/tweet_test', 'refresh');  
			
		}
		
		
	}