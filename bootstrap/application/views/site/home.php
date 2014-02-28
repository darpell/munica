<!-- HEADER -->
<?php $data['title'] = "Home"; $this->load->view('/site/templates/header',$data);?>

</head>
<body>
<!-- CONTENT -->
	<!-- Custom styles for this template -->
    <link href="<?php echo base_url('style/css/jumbotron.css'); ?>" rel="stylesheet">
    
    <!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="container">
    	<div class="jumbotron col-md-7">
	      	<div>
		        <h1>Project Monica</h1> 
		        <p> An ounce of prevention is better than a pound of cure </p>
				<p> Monitor cases. Check places. Save Lives. </p>
		        <p><a class="btn btn-primary btn-lg" role="button">Learn more &raquo;</a></p>
	        </div>
      </div>
	    <div class="col-md-5">
	      		<a class="twitter-timeline" href="https://twitter.com/DOHgovph" data-widget-id="439450663181750272">Tweets by @DOHgovph</a>
					<script>
						!function(d,s,id)
						{
							var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';
							if(!d.getElementById(id))
							{
								js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";
								fjs.parentNode.insertBefore(js,fjs);
							}
						}
						(document,"script","twitter-wjs");
					</script>
	      </div>
    </div>
      
<!-- FOOTER -->
<?php $this->load->view('/site/templates/footer');?>