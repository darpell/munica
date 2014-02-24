<!-- HEADER -->
<?php $data['title'] = 'Dashboard'; $this->load->view('/site/templates/header',$data);?>

<!-- ADDITIONAL FILES -->
<script src="<?php echo base_url('scripts/highcharts/highcharts.js');?>"></script>
<script src="<?php echo base_url('scripts/highcharts/modules/data.js');?>"></script>
<script src="<?php echo base_url('scripts/highcharts/modules/exporting.js');?>"></script>

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
<?php  $this->load->view('/site/analytics/analyticslinks',$data);?>
<div class="col-md-9">



		
	<!-- combo chart for dengue cases -->
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title"> Case Count </h3>
			</div>
			<center>
			 <fieldset  style="width: 50%;">
			 <legend>Summary</legend>
			<p></>A total of <b><?php echo $cases['total'] ?> cases</b> reported for the last 4 weeks.</p>
			<p></>A total of <b><?php echo $cases['deaths'] ?> deaths</b> reported for the last 4 weeks.</p>
			 </fieldset>
			 </center>
			 
			<div class="panel-body">
				<div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"> graph of distribution </div>
			</div>
			
			
			<br />
			<table class="table" border="1">
			<thead>
				<tr>
					<th> <?php echo date('Y')?> </th>
					<?php
						for ($week_ctr = (int)date('W')-4; $week_ctr <= (int)date('W'); $week_ctr++) 
						{
							
					?>
					<th> <?php if($week_ctr != (int)date('W')){ echo 'Week '.$week_ctr;} else {echo 'Current Week';}  ?> </th>
					<?php } ?>
				</tr>
			</thead>
				<tbody>
				<?php
					for ($ctr = 0; $ctr < 4; $ctr++) 
					{
				?>
					<tr>
					<td> <?= $barangay[$ctr] ?> </td>
				<?php 
						for ($week_ctr = (int)date('W')-4; $week_ctr <= (int)date('W'); $week_ctr++)
						{
				?>
				
					<td> <?= $cases[$barangay[$ctr]][date('Y')][$week_ctr]?> </td>
				<?php } ?>
				</tr>
				<?php } ?>
			</tbody>
			
		</table>
		
		<table class="table" border="1">
			<thead>
				<tr>
					<th> <?php echo date('Y')-1?> </th>
					<?php
						for ($week_ctr = (int)date('W')-4; $week_ctr <= (int)date('W'); $week_ctr++) 
						{
							
					?>
					<th> <?php if($week_ctr != (int)date('W')){ echo 'Week '.$week_ctr;} else {echo 'Current Week';}  ?> </th>
					<?php } ?>
				</tr>
			</thead>
				<tbody>
				<?php
					for ($ctr = 0; $ctr < 4; $ctr++) 
					{
				?>
					<tr>
					<td> <?= $barangay[$ctr] ?> </td>
				<?php 
						for ($week_ctr = (int)date('W')-4; $week_ctr <= (int)date('W'); $week_ctr++)
						{
				?>
				
					<td> <?= $cases[$barangay[$ctr]][date('Y')-1][$week_ctr]?> </td>
				<?php } ?>
				</tr>
				<?php } ?>
			</tbody>
			
		</table>
		<br />
		
		</div>
		
		
		
		
		

<script>

var weekno = <?php echo json_encode((int)date('W')); ?>;
weekno = parseInt(weekno);

var year = <?php echo json_encode((int)date('Y')); ?>;
year = parseInt(year);

var cases = <?php echo json_encode($cases); ?>;


var ave = <?php echo json_encode($cases['average']); ?>;




</script>
	<!-- end of Graph -->
</div>      
<!-- FOOTER -->
<?php $this->load->view('/site/templates/footer');?>