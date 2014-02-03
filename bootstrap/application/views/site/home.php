<!-- HEADER -->
<?php $data['title'] = "Home"; $this->load->view('/site/templates/header',$data);?>

</head>
<body>
<!-- CONTENT -->
	<!-- Custom styles for this template -->
    <link href="<?php echo base_url('style/css/jumbotron.css'); ?>" rel="stylesheet">
    
    <!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="jumbotron">
      <div class="container">
        <h1>Project Monica</h1> 
        <p> An ounce of prevention is better than a pound of cure </p>
		<p> Monitor cases. Check places. Save Lives. </p>
        <p><a class="btn btn-primary btn-lg" role="button">Learn more &raquo;</a></p>
      </div>
    </div>

      </div>
      
<!-- FOOTER -->
<?php $this->load->view('/site/templates/footer');?>