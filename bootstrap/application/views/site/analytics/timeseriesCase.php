<!-- HEADER -->
<?php $data['title'] = 'Dashboard'; $this->load->view('/site/templates/header',$data);?>

<!-- ADDITIONAL FILES -->
<script src="<?php echo base_url('scripts/highcharts/highcharts.js');?>"></script>
<script src="<?php echo base_url('scripts/highcharts/modules/data.js');?>"></script>
<script src="<?php echo base_url('scripts/highcharts/modules/exporting.js');?>"></script>


<script src="<?php echo base_url('scripts/analytics/timeseriesAllCases.js');?>"></script>



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

	<?php 
	
					$month = '';
					switch ($cases['max_mon'])
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
		
	<!-- Graph timeseriescases -->
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title"> Total Case Count </h3>
			</div>
			<center>
			 <fieldset  style="width: 50%;">
			 <legend>Summary</legend>
			<p>The most number of cases reported was <b><?php echo $cases['max'] ?> cases</b>.</p>
			<p>During the <b> <?php echo $month; ?> <?php echo $cases['max_year'] ?>.</b></p>
			 <p>Resulting in <b> deaths at <?php foreach ($death as $row)
			 {
			 	echo "<br />" . $row['cr_barangay'] . " : " . $row['deaths']; 
			 }
			 	?></b></p>
			 
			 </fieldset>
			 </center>
			<div class="panel-body">
				<div id="timeseriescases" style="min-width: 310px; height: 400px; margin: 0 auto"> graph of distribution </div>
			</div>
		</div>
	
<script>
<!-- time series cases -->
  var cases = <?php echo json_encode($cases['casecount']); ?>;
  var cyearstart = parseInt(<?php echo json_encode($cases['yearstart']); ?>);
  cases = cases.split(",");
  cases.pop();
  for (var i=0;i<cases.length;i++)
  {
	  cases[i] = parseInt(cases[i]);
  }

  var dyearstart = parseInt(<?php echo json_encode($deathcount['yearstart']); ?>);
  var deathcount = <?php echo json_encode($deathcount['count']); ?>;
  deathcount = deathcount.split(",");
  deathcount.pop();
  for (var i=0;i<deathcount.length;i++)
  {
	  deathcount[i] = parseInt(deathcount[i]);
  }
  
</script>
	<!-- end of Graph -->
</div>      
<!-- FOOTER -->
<?php $this->load->view('/site/templates/footer');?>