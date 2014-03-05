<!-- HEADER -->
<?php $data['title'] = 'Roaming'; $this->load->view('/site/templates/header',$data);?>

<!-- ADDITIONAL FILES -->

<style type="text/css">
<style>
html { height:100% }
body { height:100% }
#hh_map { width:700px; height:500px;max-width:100%; max-height:100%; }
</style>	
</style>

<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?v=3&sensor=true"></script>
<script type="text/javascript" src="http://google-maps-utility-library-v3.googlecode.com/svn/trunk/markerclusterer/src/markerclusterer.js"></script>
<script src="<?= base_url('scripts/OverlappingMarkerSpiderfier.js') ?>"></script>
<script src="<?= base_url('scripts/households/hh_mapping.js') ?>"></script>

<!-- end of ADDITIONAL FILES -->

<!-- map data -->
<?php $this->load->model('hh_model','hh');?>
<input type="hidden" id="result_length" value="<?php echo count($households); ?>" />
	<?php for ($ctr = 0; $ctr < count($households); $ctr++) {?>
	
	<?php 
		$date = $this->hh->get_visits($households[$ctr]['household_id'], TRUE);//$households[$ctr]['last_visited'];
		$year = date('Y', strtotime($date['visit_date']));
		$month = date('m', strtotime($date['visit_date']));
		$date = date('d', strtotime($date['visit_date']));
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
<!-- end of map data -->
</head>
<body>
<!-- CONTENT -->
<!-- Filters -->
<div class="container">
	<div class="col-md-6">
		<!-- Map -->
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h3 class="panel-title"> Map of Household Visits</h3>
				</div>
				<div class="panel-body">
					<div class="col-md-8">
						<!-- <div> for map -->
						<div id="hh_map"></div>
						<!-- </div> for map -->
					</div>
					<div class="col-md-4">
								
					</div>
				</div>
			</div>
			<!-- end of Map -->
	</div>
</div>
<!-- /end of Filters -->
<!-- FOOTER -->
<?php $this->load->view('/site/templates/footer');?>