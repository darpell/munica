<!-- HEADER -->
<?php $data['title'] = 'Dashboard'; $this->load->view('/site/templates/header',$data);?>

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
<div class="col-md-3">	
<?php
		echo form_open('website/analytics/casecount_report');
		?>
		<!-- Filters -->
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title"> Options </h3>
			</div>
			<div class="panel-body">
				<ul class="nav nav-pills nav-stacked">
				<li>Week No:</li>
				 <li>
 				<?php  
 				
		 		for($i = 5; $i <= date('W');$i++)
		 		{
		 			$options[$i]=$i. ': '. date('M d, Y', strtotime("-".(date('W')-$i). " week"));
		 		}
		 		echo form_dropdown('weekno', $options,$weekno);
		    	?>
		   
		    	<br />
		   
		    	<li><input type="submit" class="submitButton" value="View"/>
		    	<?php echo form_close(); ?>
		    	
		    	</li>
		    	<br />
		    	<li>
		    	<a href="<?php echo site_url('website/analytics').'/casecount_report/'.$weekno;?>" target="_blank">Print Case Count Report</a>
		    	</li>
 				</ul>
			</div>
		</div>
</div>

<div class="col-md-9">		
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
<!-- FOOTER -->
<?php $this->load->view('/site/templates/footer');?>