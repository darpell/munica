<!-- HEADER -->
<?php $data['title'] = 'Dashboard'; $this->load->view('/site/templates/header',$data);?>

<!-- ADDITIONAL FILES -->
<script src="<?php echo base_url('scripts/highcharts/highcharts.js');?>"></script>
<script src="<?php echo base_url('scripts/highcharts/modules/data.js');?>"></script>
<script src="<?php echo base_url('scripts/highcharts/modules/exporting.js');?>"></script>

<script src="<?php echo base_url('scripts/analytics/areaCasesAndLarval.js');?>"></script>


<style>
html { height:100% }
body { height:100% }
#googleMap { width:700px; height:500px;max-width:100%; max-height:100%; }
</style>		

<!-- end of ADDITIONAL FILES -->
</head>
<body onload="initialize()">
<!-- CONTENT -->
<?php  $data['title'] ='totalcaselarval'; $this->load->view('/site/analytics/analyticslinks' , $data);?>
<div class="col-md-9">

		
	<!-- Graph area cases and larval -->
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title"> Total Case and Larval Count </h3>
			</div>
			<center>
			 <fieldset  style="width: 50%;">
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
					
					$month2 = '';
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
			 <legend>Summary from <?php echo $caseandlarval['yearstart'].' to '. date('Y')?></legend>
			<p>The most number of cases reported was <b><?php echo $cases['max'] ?> cases</b>.</p>
			<p>During the <b> <?php echo $month2; ?> <?php echo $cases['max_year'] ?>.</b></p>
			<br />
			<p>The most number of Larval Breeding spots reported was <b><?php echo $larval['max'] ?></b>.</p>
			<p>During the <b> <?php echo $month; ?> <?php echo $larval['max_year'] ?>.</b></p>
			 </fieldset>
			 </center>
			<div class="panel-body">
				<div id="areaCasesAndLarval" style="min-width: 310px; height: 400px; margin: 0 auto"> graph of distribution </div>
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
  <!-- time series larval  -->
  var larval = <?php echo json_encode($larval['larvalcount']); ?>;
  var lyearstart = parseInt(<?php echo json_encode($larval['yearstart']); ?>);
  larval = larval.split(",");
  larval.pop();
  for (var i=0;i<larval.length;i++)
  {
	  larval[i] = parseInt(larval[i]);
  }
  <!-- time series larval and cases -->
  var caseandlarval = <?php echo json_encode($caseandlarval['count']); ?>;
  var clyearstart = parseInt(<?php echo json_encode($caseandlarval['yearstart']); ?>);
  caseandlarval = caseandlarval.split(",");
  caseandlarval.pop();
  for (var i=0;i<caseandlarval.length;i++)
  {
	  caseandlarval[i] = parseInt(caseandlarval[i]);
  }
  
</script>
	<!-- end of Graph -->
</div>      
<!-- FOOTER -->
<?php $this->load->view('/site/templates/footer');?>