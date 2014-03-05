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
				<h3 class="panel-title"> Filter Households under <?= $CA ?></h3>
			</div>
			<div class="panel-body">
				<ul class="nav nav-pills nav-stacked">
					<?php foreach ($HHs as $hh) { $household = $hh['household_id']; $name = $hh['household_name']; ?>
					<li> 
						<a href="<?=site_url('website/households/filter_persons/' . $household) ?>"> <?php echo $name; ?> Household 
						with <span class="badge"> <?php echo count($person_count[$household]) ?> </span> people 
						and <span class="badge"> <?= count($case_count[$household]) ?> </span> active cases</a> 
					</li>
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