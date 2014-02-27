<!-- HEADER -->
<?php $data['title'] = 'Dashboard'; $this->load->view('/site/templates/header',$data);?>

<!-- ADDITIONAL FILES -->

	<!-- Maps -->
		<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?v=3&sensor=true"></script>
		<script src="<?php echo base_url('scripts/dashboard_s/map.js');?>"></script>
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
					Options & Legends 
				</div>
			</div>
		</div>
		<!-- end of Map -->

</div>
</div>
<!-- FOOTER -->
<?php $this->load->view('/site/templates/footer');?>