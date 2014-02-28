<!-- HEADER -->
<?php $data['title'] = 'Dashboard'; $this->load->view('/site/templates/header',$data);?>

<!-- ADDITIONAL FILES -->

<script>
var lat = new Array();
var lng = new Array();
var type = new Array();
var poi_name = new Array();
var created_on = new Array();
var notes = new Array();
var brgy = new Array();

var img_icon = ["<?= base_url('/images/source.png') ?>","<?= base_url('/images/risk.png') ?>"];

<?php for ($poi_ctr = 0; $poi_ctr < count($poi); $poi_ctr++) {?>
	lat.push("<?php echo $poi[$poi_ctr]['node_lat']?>");
	lng.push("<?php echo $poi[$poi_ctr]['node_lng']?>");
	type.push("<?php echo $poi[$poi_ctr]['node_type']?>");
	poi_name.push("<?php echo $poi[$poi_ctr]['node_name']?>");
	brgy.push("<?php echo $poi[$poi_ctr]['node_barangay']?>");
	notes.push("<?php echo $poi[$poi_ctr]['node_notes']?>");
	created_on.push("<?php echo $poi[$poi_ctr]['node_addedOn']?>");
<?php } ?>
</script>

	<!-- Maps -->
		<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?v=3&sensor=true"></script>
		<script type="text/javascript" src="http://google-maps-utility-library-v3.googlecode.com/svn/trunk/markerclusterer/src/markerclusterer.js"></script>
		<script src="<?= base_url('scripts/OverlappingMarkerSpiderfier.js') ?>"></script>
		<script src="<?= base_url('scripts/dashboard_s/map.js');?>"></script>
	<!-- end of Maps -->
		
<style>
html { height:100% }
body { height:100% }
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
					<li> <a href="<?= site_url('website/households/filter_brgys') ?>"> Households <span class="badge pull-right"><?= $hh_num ?></span></a> </li>
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
					<li> <a> No. of Midwives <span class="badge pull-right"><?= $mw_ctr ?></span></a> </li>
					<li> <a> No. of BHWs <span class="badge pull-right"><?= $bhw_ctr ?></span></a> </li>
				</ul>
			</div>
		</div>
		<!-- end of General Count -->
		
</div>
<div class="col-md-9">

	<!-- Map -->
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title"> Map </h3>
			</div>
			<div class="panel-body">
				<div class="col-md-8">
					<!-- <div> for map -->
					<div id="googleMap"></div>
					<!-- </div> for map -->
				</div>
				<div class="col-md-4">
					<table class="table">
						<tr>
							<th> Symbol </th> <th> Meaning</th>
						</tr>
						<tr>
							<td> <img src="<?= base_url('/images/source.png') ?> ?>" /> </td> <td> Source Area</td>
						</tr>
						<tr>
							<td> <img src="<?= base_url('/images/risk.png') ?> ?>" /> </td> <td> Risk Area</td>
						</tr>
					</table>
					
					<div>
						The map data is just a test. The map is too small for nodes. It would be changed to a heat map.
					</div>
					
				</div>
			</div>
		</div>
		<!-- end of Map -->		
</div>
</div>
<!-- FOOTER -->
<?php $this->load->view('/site/templates/footer');?>