<!-- HEADER -->
<?php $data['title'] = 'Roaming'; $this->load->view('/site/templates/header',$data);?>

<!-- ADDITIONAL FILES -->

<style type="text/css">
<style>
html { height:100% }
body { height:100% }
#googleMap { width:700px; height:700px;max-width:100%; max-height:100%; }
</style>	
</style>

<script>
var cases = <?= json_encode($cases); ?>;

var san_agustin_iii = "San Agustin III";
var san_agustin_iii_cases_count = "<?= count($san_agustin_iii_cases); ?>";
var san_agustin_iii_lat = new Array();
var san_agustin_iii_lng = new Array();

<?php for ($brgy_ctr = 0; $brgy_ctr < count($san_agustin_iii); $brgy_ctr++) {?>
	san_agustin_iii_lat.push("<?php echo $san_agustin_iii[$brgy_ctr]['point_lat']?>");
	san_agustin_iii_lng.push("<?php echo $san_agustin_iii[$brgy_ctr]['point_lng']?>");
<?php } ?>

var langkaan_ii = "Langkaan II";
var langkaan_ii_cases_count = "<?= count($langkaan_ii_cases); ?>";
var langkaan_ii_lat = new Array();
var langkaan_ii_lng = new Array();

<?php for ($brgy_ctr = 0; $brgy_ctr < count($langkaan_ii); $brgy_ctr++) {?>
	langkaan_ii_lat.push("<?php echo $langkaan_ii[$brgy_ctr]['point_lat'] ?>");
	langkaan_ii_lng.push("<?php echo $langkaan_ii[$brgy_ctr]['point_lng'] ?>");
<?php } ?>

var sampaloc_i = "Sampaloc I";
var sampaloc_i_cases_count = "<?= count($sampaloc_i_cases); ?>";
var sampaloc_i_lat = new Array();
var sampaloc_i_lng = new Array();

<?php for ($brgy_ctr = 0; $brgy_ctr < count($sampaloc_i); $brgy_ctr++) {?>
	sampaloc_i_lat.push("<?php echo $sampaloc_i[$brgy_ctr]['point_lat'] ?>");
	sampaloc_i_lng.push("<?php echo $sampaloc_i[$brgy_ctr]['point_lng'] ?>");
<?php } ?>

var san_agustin_i = "San Agustin I";
var san_agustin_i_cases_count = "<?= count($san_agustin_i_cases); ?>";
var san_agustin_i_lat = new Array();
var san_agustin_i_lng = new Array();

<?php for ($brgy_ctr = 0; $brgy_ctr < count($san_agustin_i); $brgy_ctr++) {?>
	san_agustin_i_lat.push("<?php echo $san_agustin_i[$brgy_ctr]['point_lat'] ?>");
	san_agustin_i_lng.push("<?php echo $san_agustin_i[$brgy_ctr]['point_lng'] ?>");
<?php } ?>

</script>

<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?libraries=visualization&v=3&sensor=true"></script>
<script src="<?= base_url('scripts/cases/cases_map.js') ?>"></script>
  
<!-- end of ADDITIONAL FILES -->
</head>
<body onload="initialize()">
<!-- CONTENT -->
<!-- Filters -->
<div class="container">
	<div class="col-md-8">
		<!-- Map -->
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h3 class="panel-title"> Cases Map - <?= $period?> </h3>
				</div>
				<div class="panel-body">
					<div>
						<!-- <div> for map -->
						<div id="googleMap"></div>
						<!-- </div> for map -->
					</div>
				</div>
			</div>
			<!-- end of Map -->
	</div>
	<div class="col-md-4">
		<!-- Legend -->
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h3 class="panel-title"> Options </h3>
				</div>
				<div class="panel-body">				
					<form action="filter_view_map" method="post">
						<div class="form-group"> <input type="date" name="start" class="form-control" required /> </div>
						<div class="form-group"> <input type="date" name="end" class="form-control" required /> </div>
						<div class="form-group"> <center> <input type="submit" value="Filter" class="btn btn-md btn-primary" /> </center> </div>
					</form>
				</div>
			</div>
		<!-- end of Legend -->
	
		<!-- Household List
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h3 class="panel-title"> List </h3>
				</div>
				<div class="panel-body">
					<div>
						<ul class="nav nav-pills nav-stacked">
							<!-- <tr>
								<th> Household Name </th> <th> Address </th> <th> Barangay </th> <th> BHW assigned </th> <th> Date of Last Visit </th>
							</tr>  
						</ul>
					</div>
					<div class="col-md-4">
								
					</div>
				</div>
			</div>
			<!-- end of Household LIst -->
	</div>
	<div>
		<?php //var_dump($cases); ?>
	</div>
</div>
<!-- /end of Filters -->
<!-- FOOTER -->
<?php $this->load->view('/site/templates/footer');?>