<!-- HEADER -->
<?= $this->load->view('/mobile/templates/mob_header') ?>

<!-- CONTENT -->
    
<style type="text/css">
html {height:100%}
body {height:100%;margin:0;padding:0}
#googleMap {height:100%; max-width:100%;max-height:100%}
</style>

<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?v=3&sensor=true"></script>
<script type="text/javascript" src="http://google-maps-utility-library-v3.googlecode.com/svn/trunk/markerclusterer/src/markerclusterer.js"></script>
<script src="<?= base_url('scripts/OverlappingMarkerSpiderfier.js') ?>"></script>
<script src="<?= base_url('scripts/households/visits_map.js') ?>"></script>

<script>
var households = <?= json_encode($households); ?>;
var last_visits = <?= json_encode($last_visits); ?>;
var hh_img = [
				'<?= base_url('images/house visited.png'); ?>',
				'<?= base_url('images/house not visited.PNG'); ?>'
              ];
</script>
<body onload="initialize()">
<div data-role="page" style="top:0;left:0; right:0; bottom:0;">
	<div data-role="header" ><!-- data-position="fixed"> -->
    	<h2> Households </h2>
		<a href="<?php echo site_url('mobile');?>" data-ajax="false" data-icon="arrow-l"> Back </a>
    	</div> <!-- /header-->
	<div data-role="content" style="width:100%; height:100%;">
		<div id="googleMap" style="margin:-15px 0 0 -15px;"></div>
	</div><!-- /content -->
</div><!-- /page -->
</body>
</html>