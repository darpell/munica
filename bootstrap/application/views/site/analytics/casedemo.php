<!-- HEADER -->
<?php $data['title'] = 'Dashboard'; $this->load->view('/site/templates/header',$data);?>

<!-- ADDITIONAL FILES -->
<script src="<?php echo base_url('scripts/highcharts/highcharts.js');?>"></script>
<script src="<?php echo base_url('scripts/highcharts/modules/data.js');?>"></script>
<script src="<?php echo base_url('scripts/highcharts/modules/exporting.js');?>"></script>


<script src="<?php echo base_url('scripts/analytics/combocases.js');?>"></script>
<script src="<?php echo base_url('scripts/analytics/fatalityrate.js');?>"></script>


<style>
html { height:100% }
body { height:100% }
#googleMap { width:700px; height:500px;max-width:100%; max-height:100%; }
</style>		

<!-- end of ADDITIONAL FILES -->
</head>
<body onload="initialize()">
<!-- CONTENT -->

<?php  $data['title'] = 'home'; $this->load->view('/site/analytics/analyticslinks',$data);?>
<div class="col-md-9">
		
	<!-- combo chart for dengue cases -->
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title"> Case Demographics </h3>
			</div>
			<div class="panel-body">
				<div id="combocases" style="min-width: 310px; height: 400px; margin: 0 auto"> graph of distribution </div>
			</div>
		</div>
	<!-- fatality rate -->
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title"> Case Fatality </h3>
			</div>
			<div class="panel-body">
				<div id="fatalityrate" style="min-width: 310px; height: 400px; margin: 0 auto"> graph of distribution </div>
			</div>
		</div>
		
	
<script>

  <!-- combo chart -->
  var brgycount = <?php echo json_encode($brgycount); ?>;
  var agegroup = <?php echo json_encode($agegroup); ?>;
  var brgys = <?php echo json_encode($brgys); ?>;

  <!-- fatality rate --->
  var fatality = <?php echo json_encode($fatality); ?>;
</script>
	<!-- end of Graph -->
</div>      
<!-- FOOTER -->
<?php $this->load->view('/site/templates/footer');?>