<!-- HEADER -->
<?php $data['title'] = 'Filter'; $this->load->view('/site/templates/header',$data);?>

</head>
<body>
<!-- CONTENT -->
<!-- Filters -->
<div class="container">
<div class="col-md-10">
	<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title"> Filter Barangays in Dasmarinas CHO-I </h3>
			</div>
			<div class="panel-body">
				<ul class="nav nav-pills nav-stacked">
					<?php foreach ($brgys as $brgy) { $barangay = $brgy['barangay'];?>
					<li> <a href="<?= site_url('website/households/filter_CAs/' . $barangay) ?>"> <?= $barangay ?> with <span class="badge"> <?php echo count($ca_count[$barangay]) ?> </span> Catchment Areas </a> </li>
					<?php } ?>
				</ul>
			</div>
		</div>
</div>
</div>
<!-- /end of Filters -->
<!-- FOOTER -->
<?php $this->load->view('/site/templates/footer');?>