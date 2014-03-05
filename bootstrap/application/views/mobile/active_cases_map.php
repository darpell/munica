<!-- HEADER -->
<?= $this->load->view('/mobile/templates/mob_header') ?>

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
<!-- end of ADDITIONAL FILES -->

<!-- CONTENT -->
    
<style type="text/css">
html {height:100%}
body {height:100%;margin:0;padding:0}
#googleMap {height:100%; max-width:100%;max-height:100%}
</style>

<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?libraries=visualization&v=3&sensor=true"></script>
<script type="text/javascript" src="http://google-maps-utility-library-v3.googlecode.com/svn/trunk/markerclusterer/src/markerclusterer.js"></script>
<script src="<?= base_url('scripts/OverlappingMarkerSpiderfier.js') ?>"></script>
<script src="<?= base_url('scripts/dashboard_s/map.js') ?>"></script>

</head>
<body>
<div data-role="page" style="top:0;left:0; right:0; bottom:0;">
	<div data-role="header" ><!-- data-position="fixed"> -->
    	<h2> Active Cases Map </h2>
		<a href="<?php echo site_url('mobile');?>" data-ajax="false" data-icon="arrow-l"> Back </a>
    	</div> <!-- /header-->
	<div data-role="content" style="width:100%; height:100%;">
		<div id="googleMap" style="margin:-15px 0 0 -15px;"></div>
	</div><!-- /content -->
</div><!-- /page -->
</body>
</html>