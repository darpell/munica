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
    	<?php 	echo form_open('website/tweet_test/tweet');?>
	      	<div>
		        <h2>Tweet Status</h2> 
		        <div class="radio">
				  <label>
				    <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked>
				    There have been <?php echo $count;?> cases reported for the month of <?php echo date('F Y');?>	
				     <input type="hidden" name="hidden1"  value="There have been <?php echo $count;?> cases reported for the month of <?php echo date('F Y');?>">
				  </label>
				</div>
				<div class="radio">
				  <label>
				    <input type="radio" name="optionsRadios" id="optionsRadios2" value="option2">
				    The number of dengue cases are <?php echo $ave;?> compared to previous years
				    <input type="hidden" name="hidden2"  value= "The number of dengue cases are <?php echo $ave;?> compared to previous years" >
				  </label>
				</div>
				<div class="radio">
				  <label>
				    <input type="radio" name="optionsRadios" id="optionsRadios3" value="option3">
				    <input type="text" name="customtweettext" id="customtweettext" size = 70>
				  </label>
				</div>
				<div class="row">
				 <div class="col-md-2">
				 	<button type="submit" class="btn btn-primary">Tweet</button> 
				 </div>
				 <div class="col-md-1">
				 	<span class="help-block"><?php echo $status;?></span>
	        	</div>
	        	</div>
	        </div>
      </div>
	    <div class="col-md-5">
	      		<a class="twitter-timeline" href="https://twitter.com/ProjectMonica" data-widget-id="442831619682865152">Tweets by @ProjectMonica</a>
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