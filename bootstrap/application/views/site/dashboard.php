<!-- HEADER -->
<?php $data['title'] = 'Dashboard'; $this->load->view('/site/templates/header',$data);?>

<!-- ADDITIONAL FILES -->

<script>
var lat = new Array();
var lng = new Array();
<?php for ($poi_ctr = 0; $poi_ctr < count($poi); $poi_ctr++) {?>
	lat.push("<?php echo $poi[$poi_ctr]['household_lat']?>");
	lng.push("<?php echo $poi[$poi_ctr]['household_lng']?>");
<?php } ?>

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

//var img_icon = ["<?= base_url('/images/source.png') ?>","<?= base_url('/images/risk.png') ?>"];


</script>

	<!-- Maps -->
		<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?libraries=visualization&v=3&sensor=true"></script>
		<script type="text/javascript" src="http://google-maps-utility-library-v3.googlecode.com/svn/trunk/markerclusterer/src/markerclusterer.js"></script>
		<script src="<?= base_url('scripts/OverlappingMarkerSpiderfier.js') ?>"></script>
		<script src="<?= base_url('scripts/dashboard_s/map.js');?>"></script>
	<!-- end of Maps -->
		
<style>
html { height:100% }
body { height:100% }
#panel {
        position: absolute;
        top: 70px;
        left: 40%;
        margin-left: -180px;
        z-index: 5;
        background-color: #fff;
        padding: 5px;
        border: 1px solid #999;
        text-color:BLACK;
      }
#googleMap { width:700px; height:500px;max-width:100%; max-height:100%; }
</style>		

<!-- end of ADDITIONAL FILES -->
</head>
<body onload="initialize()">
<!-- CONTENT -->
<div class="container">
<div class="col-md-3">		
		<!-- Links -->
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title"> Links </h3>
			</div>
			<div class="panel-body">
				<ul class="nav nav-pills nav-stacked">
					<li> <a href="<?= site_url('website/notifications') ?>"> Notifications <span class="badge pull-right"> <?= $notif_count?> </span></a> </li>
					<li> <a href="<?= site_url('website/analytics') ?>"> Analytics</a> </li>
					<li> <a href="<?= site_url('website/map/view') ?>"> Maps </a> </li>
					<?php if ($this->session->userdata('TPtype') != 'BHW') { ?>
					<li> <a href="<?= site_url('website/households/filter_brgys') ?>"> Households <span class="badge pull-right"><?= $hh_num ?></span></a> </li>
					<?php } else { ?>
					<li> <a href="<?= site_url('website/households/filter_HHs/' . $this->session->userdata('TPusername')) ?>"> Households <span class="badge pull-right"><?= $hh_num ?></span></a> </li>
					<?php } ?>
				</ul>
			</div>
		</div>
		<!-- end of Links -->
		
		<!-- Cases -->
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title"> Cases </h3>
			</div>
			<div class="panel-body">
				<ul class="nav nav-pills nav-stacked">
				  <li> <a href="<?= site_url('website/cases/view_suspected') ?>"> Suspected <span class="badge pull-right"><?php echo $this->db->get_where('active_cases',array('status' => 'suspected'))->num_rows(); ?></span> </a> </li>
				  <li> <a href="<?= site_url('website/cases/view_threatening') ?>"> Threatening <span class="badge pull-right"><?php echo $this->db->get_where('active_cases',array('status' => 'threatening'))->num_rows(); ?></span> </a> </li>
				  <li> <a href="<?= site_url('website/cases/view_serious') ?>"> Serious <span class="badge pull-right"><?php echo $this->db->get_where('active_cases',array('status' => 'serious'))->num_rows();?></span> </a> </li>
				  <li> <a href="<?= site_url('website/cases/view_hospitalized') ?>"> Hospitalized <span class="badge pull-right"><?php echo $this->db->get_where('active_cases',array('status' => 'hospitalized'))->num_rows()?></span> </a> </li>
				</ul>
			</div>
		</div>
		<!-- end of Cases -->
		
		<!-- General Count -->
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title"> General Count </h3>
			</div>
			<div class="panel-body">
				<ul class="nav nav-pills nav-stacked">
					<li> <a> No. of Households <span class="badge pull-right"><?= $hh_num ?></span></a> </li>
					<?php if ($this->session->userdata('TPtype') != 'BHW') { ?>
					<li> <a> No. of Midwives <span class="badge pull-right"><?= $mw_ctr ?></span></a> </li>
					<li> <a> No. of BHWs <span class="badge pull-right"><?= $bhw_ctr ?></span></a> </li>
					<?php } ?>
				</ul>
			</div>
		</div>
		<!-- end of General Count -->
		
</div>
<div class="col-md-9">

	<!-- Map -->
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title"> Case Map of current active cases</h3>
			</div>
			<div class="panel-body">
				<div class="col-md-8">
					<!-- <div> for map -->
					<div id="googleMap"></div>
					<!-- </div> for map -->
				</div>
				<div class="col-md-4">
					<div>
						<h3> Options </h3>
						<button class="btn btn-default" style="width:150px;" onclick="toggleHeatmap()">Toggle Heatmap</button> <br/>
						<button class="btn btn-default" style="width:150px;" onclick="changeRadius()">Change radius</button> <br/>
						<button class="btn btn-default" style="width:150px;" onclick="changeGradient()">Change gradient</button> <br/>
						<button class="btn btn-default" style="width:150px;" onclick="changeOpacity()">Change opacity</button> <br/>
					</div>
						<br/>
					<div>
						<h3> Case Count per Barangay </h3>
						<p> San Agustin III <span class="badge pull-right"> <?= count($san_agustin_iii_cases) ?> </span></p>
						<p> San Agustin I <span class="badge pull-right"> <?= count($san_agustin_i_cases) ?> </span></p>
						<p> Langkaan II <span class="badge pull-right"> <?= count($langkaan_ii_cases) ?> </span></p>
						<p> Sampaloc I <span class="badge pull-right"> <?= count($sampaloc_i_cases) ?> </span></p>
					</div>				
				</div>
			</div>
		</div>
		<!-- end of Map -->
</div>
</div>
<!-- FOOTER -->
<?php $this->load->view('/site/templates/footer');?>