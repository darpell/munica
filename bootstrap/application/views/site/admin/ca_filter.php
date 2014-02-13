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
				<h3 class="panel-title"> Filter Catchment Areas in <?= $brgy ?></h3>
			</div>
			<div class="panel-body">
				<ul class="nav nav-pills nav-stacked">
					<?php foreach ($CAs as $ca) { $bhw = $ca['bhw_id']; ?>
					<li> <a href="<?=site_url('website/households/filter_HHs/' . $bhw) ?>"> <?= $bhw ?> who is responsible for <span class="badge"> <?php echo count($hh_count[$bhw]) ?> </span> Households </a> </li>
					<?php } ?>
				</ul>
				<?php echo $links; ?>
			</div>
		</div>
</div>
</div>
<!-- /end of Filters -->
<!-- FOOTER -->
<?php $this->load->view('/site/templates/footer');?>