<!-- HEADER -->
<?php $data['title'] = 'Dashboard'; $this->load->view('/site/templates/header',$data);?>

<!-- ADDITIONAL FILES -->
<script src="<?php echo base_url('scripts/highcharts/highcharts.js');?>"></script>
<script src="<?php echo base_url('scripts/highcharts/modules/data.js');?>"></script>
<script src="<?php echo base_url('scripts/highcharts/modules/exporting.js');?>"></script>
<?php
if ($casereportANDimmecase['casereport'] != null OR $casereportANDimmecase['immecase'] != null )
			{ ?>
<script src="<?php echo base_url('scripts/analytics/combocases.js');?>"></script>
<?php if ($max_fatality > 0)
			{ ?>
<script src="<?php echo base_url('scripts/analytics/fatalityrate.js');?>"></script> <?php }?>
<?php }?>

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
			<?php if ($casereportANDimmecase['casereport'] != null OR $casereportANDimmecase['immecase'] != null )
			{?>
			<center>
			 <fieldset  style="width: 50%;">
			 <legend>Summary</legend>
			<p>Most cases reported was at  <b><?php echo $brgys[$brgy_max]; ?></b></p>
			<p>The number of deaths reported was <b><?php echo $deaths; ?> cases</b>.
			<b><?php 
			if($deathcount != null){
			foreach ($deathcount as $row)
			 {
			 	echo "<br />" . $row['cr_barangay'] . " : " . $row['deaths']; 
			 }
			 }
			 ?></b>
			 </fieldset>
			 </center>
			 
			<div class="panel-body">
				<div id="combocases" style="min-width: 310px; height: 400px; margin: 0 auto"> graph of distribution </div>
			</div>
		</div>
		<?php if($max_fatality > 0 ){
				$age = '';
				switch ($max_fatality_group)
				{
					case '0': $age = 'Below 1'; break;
					case '1': $age = '1-10'; break;
					case '2': $age = '11-20'; break;
					case '3': $age = '21-30'; break;
					case '4': $age = '31-40'; break;
					case '5': $age = '>40'; break;
				}
				
				?>
	<!-- fatality rate -->
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title"> Case Fatality </h3>
			</div>
				<center>
			 <fieldset  style="width: 50%;">
			 <legend>Summary</legend>
			
			<p>The Highest Fatality Rate is <b><?php echo $max_fatality*100; ?> Percent</b> for age group <?php echo $age;?>.</p>
			
			 </fieldset>
			 </center>
			<div class="panel-body">
				<div id="fatalityrate" style="min-width: 310px; height: 400px; margin: 0 auto"> graph of distribution </div>
			</div>
		</div>
		
	
<script>
var fatality =  <?php echo json_encode($fatality);?>;
</script>
<?php }?>
<script>
  <!-- combo chart -->
  var brgycount = <?php  if ($casereportANDimmecase['casereport'] != null OR $casereportANDimmecase['immecase'] != null )
			echo json_encode($brgycount); else echo json_encode('null') ?>;
  var agegroup = <?php if ($casereportANDimmecase['casereport'] != null OR $casereportANDimmecase['immecase'] != null )
			echo json_encode($agegroup); else echo json_encode('null')?>;
  var brgys = <?php if ($casereportANDimmecase['casereport'] != null OR $casereportANDimmecase['immecase'] != null )
			echo json_encode($brgys); else echo json_encode('null')?>;

var gender = <?php echo json_encode($gender);?>;
</script>
	<!-- end of Graph -->

		<?php } else {?>
		<center>
			 <fieldset  style="width: 50%;">
			 <legend>No Cases Found</legend>
			 </fieldset>
			 </center>
		<?php }?>
</div>      
<!-- FOOTER -->
<?php $this->load->view('/site/templates/footer');?>