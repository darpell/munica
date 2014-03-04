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
<script src="<?= base_url('scripts/mobile/households/hh_mapping.js') ?>"></script>

</head>

<input type="hidden" id="result_length" value="<?php echo count($households); ?>" />
	<?php for ($ctr = 0; $ctr < count($households); $ctr++) {?>
	
	<?php 
		$date = $households[$ctr]['last_visited'];
		$year = date('Y', strtotime($date));
		$month = date('m', strtotime($date));
		$date = date('d', strtotime($date));
	?>
	
		<input type="hidden" id="pt_id<?= $ctr ?>" 				value="<?php echo $households[$ctr]['household_id']; ?>"	/>
		<input type="hidden" id="pt_name<?= $ctr ?>" 			value="<?php echo $households[$ctr]['household_name']; ?>"	/>
		<input type="hidden" id="pt_no<?= $ctr ?>"				value="<?php echo $households[$ctr]['house_no']; ?>"	/>
		<input type="hidden" id="pt_lat<?= $ctr ?>" 			value="<?php echo $households[$ctr]['household_lat']; ?>"	/>
		<input type="hidden" id="pt_lng<?= $ctr ?>" 			value="<?php echo $households[$ctr]['household_lng']; ?>"	/>
		<input type="hidden" id="pt_last_visit_year<?= $ctr ?>" value="<?php echo $year; ?>"	/>
		<input type="hidden" id="pt_last_visit_month<?= $ctr ?>" value="<?php echo $month; ?>"	/>
		<input type="hidden" id="pt_last_visit_date<?= $ctr ?>" value="<?php echo $date; ?>"	/>
		<input type="hidden" id="pt_street<?= $ctr ?>" 			value="<?php echo $households[$ctr]['street']; ?>"			/>
		<input type="hidden" id="pt_bhw<?= $ctr ?>" 			value="<?php echo $households[$ctr]['bhw_id']; ?>"			/>
		<input type="hidden" id="pt_barangay<?= $ctr ?>" 		value="<?php echo $households[$ctr]['barangay']; ?>"		/>
	<?php } ?>

	<input type="hidden" id="image_visited" value="<?php echo base_url('images/house visited.png'); ?>"		/>
	<input type="hidden" id="image_unvisited" value="<?php echo base_url('images/house unvisited.png'); ?>"		/>
	<input type="hidden" id="image_not_visited" value="<?php echo base_url('images/house not visited.PNG'); ?>"		/>
	
<body>
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