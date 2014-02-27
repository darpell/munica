<!-- HEADER -->
<?php $data['title'] = 'Dashboard'; $this->load->view('/site/templates/header',$data);?>

<!-- ADDITIONAL FILES -->
<script src="<?php echo base_url('scripts/highcharts/highcharts.js');?>"></script>
<script src="<?php echo base_url('scripts/highcharts/modules/data.js');?>"></script>
<script src="<?php echo base_url('scripts/highcharts/modules/exporting.js');?>"></script>

<script src="<?php echo base_url('scripts/analytics/timeseriesAllLarval.js');?>"></script>

<style>
html { height:100% }
body { height:100% }
#googleMap { width:700px; height:500px;max-width:100%; max-height:100%; }
</style>		

<!-- end of ADDITIONAL FILES -->
</head>
<body onload="initialize()">
<!-- CONTENT -->
<?php  $this->load->view('/site/analytics/analyticslinks');?>
<div class="col-md-9">

		

	<!-- Graph timeserieslarval -->
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title"> Total Larval Count </h3>
			</div>
				<?php 
	
					$month = '';
					switch ($larval['max_mon'])
					{
						case '1': $month = 'JAN'; break;
						case '2': $month = 'FEB'; break;
						case '3': $month = 'MAR'; break;
						case '4': $month = 'APR'; break;
						case '5': $month = 'MAY'; break;
						case '6': $month = 'JUN'; break;
						case '7': $month = 'JUL'; break;
						case '8': $month = 'AUG'; break;
						case '9': $month = 'SEP'; break;
						case '10': $month = 'OCT'; break;
						case '11': $month = 'NOV'; break;
						case '12': $month = 'DEC'; break;
					}
		?>
		
			
				<center>
			 <fieldset  style="width: 50%;">
			 <legend>Summary</legend>
			<p>The most number of Larval Breeding spots reported was <b><?php echo $larval['max'] ?></b>.</p>
			<p>During the <b> <?php echo $month; ?> <?php echo $larval['max_year'] ?>.</b></p>
			 </fieldset>
			 </center>
			 
			<div class="panel-body">
				<div id="timeserieslarval" style="min-width: 310px; height: 400px; margin: 0 auto"> graph of distribution </div>
			</div>
		</div>

<script>
<!-- time series cases -->

  <!-- time series larval  -->
  var larval = <?php echo json_encode($larval['larvalcount']); ?>;
  var lyearstart = parseInt(<?php echo json_encode($larval['yearstart']); ?>);
  larval = larval.split(",");
  larval.pop();
  for (var i=0;i<larval.length;i++)
  {
	  larval[i] = parseInt(larval[i]);
  }
  
</script>
	<!-- end of Graph -->
</div>      
<!-- FOOTER -->
<?php $this->load->view('/site/templates/footer');?>