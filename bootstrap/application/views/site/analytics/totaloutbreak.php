<!-- HEADER -->
<?php $data['title'] = 'Dashboard'; $this->load->view('/site/templates/header',$data);?>

<!-- ADDITIONAL FILES -->
<script src="<?php echo base_url('scripts/highcharts/highcharts.js');?>"></script>
<script src="<?php echo base_url('scripts/highcharts/modules/data.js');?>"></script>
<script src="<?php echo base_url('scripts/highcharts/modules/exporting.js');?>"></script>


<script src="<?php echo base_url('scripts/analytics/totaloutbreak.js');?>"></script>

<style>
html { height:100% }
body { height:100% }
#googleMap { width:700px; height:500px;max-width:100%; max-height:100%; }
</style>		

<!-- end of ADDITIONAL FILES -->
</head>
<body onload="initialize()">
<!-- CONTENT -->
<?php  $data['title'] = 'outbreak'; $this->load->view('/site/analytics/analyticslinks', $data);?>
<div class="col-md-9">

		
	<!-- population demographics -->
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title"> Outbreak Count </h3>
			</div>
			<div class="panel-body">
				<div id="totaloutbreak" style="min-width: 310px; height: 400px; margin: 0 auto"> graph of distribution </div>
			</div>
		</div>
<script>


  <!-- total outbreaks --->
  var outbreak = <?php echo json_encode($outbreak['data']); ?>;
  var outbreakmonth = <?php echo json_encode($outbreak['outbreakmonth']); ?>;
  var yearstart = <?php echo json_encode($outbreak['yearstart']); ?>;
  var yearend = <?php echo json_encode($outbreak['yearend']); ?>;

  
</script>
	<!-- end of Graph -->
</div>      
<!-- FOOTER -->
<?php $this->load->view('/site/templates/footer');?>