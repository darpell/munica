<!-- Bootstrap core CSS -->
    <link href="<?php echo base_url('style/css/bootstrap.min.css'); ?>" rel="stylesheet">
    
    <link href="<?php echo base_url('style/css/jumbotron.css'); ?>" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]><script src="../../docs-assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
  

<!-- ADDITIONAL FILES -->
<script src="<?php echo base_url('scripts/highcharts/highcharts.js');?>"></script>
<script src="<?php echo base_url('scripts/highcharts/modules/data.js');?>"></script>
<script src="<?php echo base_url('scripts/highcharts/modules/exporting.js');?>"></script>
<script src="<?php echo base_url('scripts/highcharts/modules/drilldown.js');?>"></script>

<script src="<?php echo base_url('scripts/analytics/bhw_count.js');?>"></script>

<style>
html { height:100% }
body { height:100% }
#googleMap { width:700px; height:500px;max-width:100%; max-height:100%; }
</style>		

<!-- end of ADDITIONAL FILES -->
</head>
<body onload="initialize()">
<!-- CONTENT -->

<div class="col-md-12">		
	<!-- combo chart for dengue cases -->
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title"> <center>Case Count Report</center></h3>
			</div>
			
			<center><h4><?php
			 $temp = date('M d, Y', strtotime("-".(date('W')-$weekno). " week"));
			 echo   $temp .' to '.date('M d, Y', strtotime($temp. "+6 days"));?></h4></center>
			<div class="row">
			<div class="col-md-1">	

				</div>
				<div class="col-md-4">	
				<legend><center>Case Count</center></legend>
					<table class= "table">
					<tr>
					<td>Suspected</td><td><span class="badge"><?php echo $case_data['suspected_count']?></span></td>
					</tr>
					<tr>
					<td>Threatening</td><td><span class="badge"><?php echo $case_data['threatening_count']?></span></td>
					</tr>
					<tr>
					<td>Serious</td><td><span class="badge"><?php echo $case_data['serious_count']?></span></td>
					</tr>
					<tr>
					<td>Hospitalized</td><td><span class="badge"><?php echo $case_data['hospitalized_count']?></span></td>
					</tr>
					</tr>
					<tr class="danger">
					<td>Total</td><td><span class="badge"><?php echo $case_data['hospitalized_count']+$case_data['serious_count']+$case_data['threatening_count']+$case_data['suspected_count']?></span></td>
					</tr>
					</table>
					 </fieldset>
				</div>
				<div class="col-md-7">	
					<div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
				</div>
			</div>
			<h4>Barangay: <?php echo $user[0];?></h4>
			<h4>Prepared by: <?php echo $this->session->userdata('TPfirstname') . " " . 
								$this->session->userdata('TPmiddlename'). " " . 
								$this->session->userdata('TPlastname') ?></h4>
			<h4>Prepared on: <?php echo date('M d, Y');?></h4>
			 
			
</div>
		

<script>

var case_data = <?php echo json_encode($case_data); ?>;

</script>
	<!-- end of Graph -->
</div>      
<script>
window.print();
</script>