<!-- HEADER -->
<?php $data['title'] = 'Dashboard'; $this->load->view('/site/templates/header',$data);?>

<!-- ADDITIONAL FILES -->
<script src="<?php echo base_url('scripts/highcharts/highcharts.js');?>"></script>
<script src="<?php echo base_url('scripts/highcharts/modules/data.js');?>"></script>
<script src="<?php echo base_url('scripts/highcharts/modules/exporting.js');?>"></script>
<script src="<?php echo base_url('scripts/highcharts/modules/drilldown.js');?>"></script>

<script src="<?php echo base_url('scripts/analytics/summaryCases.js');?>"></script>

<style>
html { height:100% }
body { height:100% }
#googleMap { width:700px; height:500px;max-width:100%; max-height:100%; }
</style>		

<!-- end of ADDITIONAL FILES -->
</head>
<body onload="initialize()">
<!-- CONTENT -->
<?php $data['title'] = 'casesummary'; $this->load->view('/site/analytics/analyticslinks',$data);?>

<div class="col-md-9">		
	<!-- combo chart for dengue cases -->
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title"> Case Summary </h3>
			</div>
			<center><h4><?php echo  date('M d, Y', strtotime("-4 week")). ' (Week'.(date('W')-4).') to '.date('M d, Y').'(Week '.date('W').')';?></h4></center>
			<div class="row">
			<div class="col-md-1">	

				</div>
				<div class="col-md-4">	
					<legend><center></>Summary</center></legend>
					<p></>A total of <b><?php echo $cases['total'] ?> cases</b> reported for the last 4 weeks. Amounting to <b><?php echo round(($cases['total']/$personcount)*100,2)  ?>%</b> of the population of Dasmarinas</p>
					<p></>A total of <b><?php echo $cases['deaths'] ?> deaths</b> reported for the last 4 weeks.</p>
					 </fieldset>
					 <legend><center></>Suspected Sources</center></legend>
					<?php 
					if($household != null)foreach ($household as $row)
					{
						if($row['suspected_source'] != null OR $row['suspected_source'] != '' OR $row['suspected_source'] != 'null')
						echo '<li>'. $row['suspected_source'].'</li>';
					}	
					?>
					 </fieldset>
				</div>
				<div class="col-md-7">	
					<div id="container3" style="min-width: 210px; height: 300px; margin: 0 auto";align="left"></div>
				</div>
			
			</div>
			 
			<div class="panel-body">
				<div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"> graph of distribution </div>
			
			
			
		</div>
			
</div>
		

<script>

var weekno = <?php echo json_encode($weekno); ?>;
weekno = parseInt(weekno);


var year = <?php echo json_encode((int)date('Y')); ?>;
year = parseInt(year);

var cases = <?php echo json_encode($cases); ?>;

var personcount = <?php echo json_encode($personcount); ?>;
personcount = parseInt(personcount);

var ave = <?php echo json_encode($cases['average']); ?>;

var household = <?php echo json_encode($household); ?>;

var barangay = <?php echo json_encode($barangay); ?>;

var agegroup = <?php echo json_encode($cases['agegroup']); ?>;
var gender = <?php echo json_encode($cases['gender']) ?>;

</script>
	<!-- end of Graph -->
</div>      
<!-- FOOTER -->
<?php $this->load->view('/site/templates/footer');?>