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

<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?v=3&sensor=true"></script>
<script type="text/javascript" src="http://google-maps-utility-library-v3.googlecode.com/svn/trunk/markerclusterer/src/markerclusterer.js"></script>

<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<script type="text/javascript" src="<?= base_url('scripts/tablesorter/jquery.tablesorter.min.js') ?>"></script>
<script type="text/javascript">
$(document).ready(function() 
	    { 
	        $("#suggested").tablesorter( {sortList: [[0,0], [1,0]]} ); 
	    } 
	); 
</script>

<script src="<?= base_url('scripts/OverlappingMarkerSpiderfier.js') ?>"></script>
<script src="<?= base_url('scripts/households/visits_map.js') ?>"></script>

<script>
var households = <?= json_encode($households); ?>;
var last_visits = <?= json_encode($last_visits); ?>;
var hh_img = [
				'<?= base_url('images/house visited.png'); ?>',
				'<?= base_url('images/house unvisited.png'); ?>',
				'<?= base_url('images/house not visited.PNG'); ?>'
              ];
</script>

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
					<h3 class="panel-title"> Map of Household Visits</h3>
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
					<h3 class="panel-title"> Legends </h3>
				</div>
				<div class="panel-body">
					<table class="table">
						<tr>
							<td> <img src="<?= base_url('images/house visited.png'); ?>" /> </td> <td> House is has been recently visited </td>
						</tr>
						<tr>
							<td> <img src="<?= base_url('images/house not visited.PNG'); ?>" /> </td> <td> House has not been visited for more than 7 days </td>
						</tr>					
					</table>
				</div>
			</div>
		<!-- end of Legend -->
	
		<!-- To Visit List -->
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h3 class="panel-title"> To Visit List </h3>
				</div>
				<div class="panel-body">
					<div>
						<ul class="nav nav-pills nav-stacked">
							<!-- <tr>
								<th> Household Name </th> <th> Address </th> <th> Barangay </th> <th> BHW assigned </th> <th> Date of Last Visit </th>
							</tr>  -->
							<?php foreach ($to_visit as $house) { ?>
							<li> <a> <?= $house['household_name'] . ' at ' . $house['house_no'] . ' ' . $house['street'] . ' Street'?></a> </li>
							<?php } ?>
						</ul>
					</div>
					<div class="col-md-4">
								
					</div>
				</div>
			</div>
			<!-- end of To Visit List -->
			
		<!-- Household List -->
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h3 class="panel-title"> Suggested Order of Visit </h3>
				</div>
				<div class="panel-body">
					<div>
						<table id="suggested" class="table">
							<thead>
								<tr>
									<th> Household Name </th> <th> Address </th> <th> Date of Last Visit </th>
								</tr> 
							</thead>
							<tbody>
								<?php foreach ($last_visits as $house) { ?>
								<tr>
									<td> <a href="<?= site_url('website/households/add_to_visit_list/' . $house['household_id']) ?>"><?= $house['household_name'] ?></a> </td> <td> <?= $house['house_no'] . ' ' . $house['street'] . ' Street'?> </td> <td> <?= $house['visit_date'] ?></td>
								</tr>
								<?php } ?>
							</tbody>
						</table>
					
						<!-- <ul class="nav nav-pills nav-stacked">
							<!--  
							
							<li> <a>  . ' at ' .</a> </li>
							
						</ul> -->
					</div>
					<div class="col-md-4">
								
					</div>
				</div>
			</div>
			<!-- end of Household LIst -->
	</div>
</div>
<!-- /end of Filters -->
<!-- FOOTER -->
<?php $this->load->view('/site/templates/footer');?>