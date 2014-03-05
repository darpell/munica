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
				<h3 class="panel-title"> People living in <?= $persons[0]['household_name'] ?></h3>
			</div>
			<div class="panel-body">
				<ul class="nav nav-pills nav-stacked">
					<?php foreach ($persons as $person) { $per = $person['person_id']; $name = $person['person_first_name'] . ' ' . $person['person_last_name']; ?>
					<li> <a href="<?=site_url('website/households/view_person/' . $per) ?>"> <?php echo $name; ?> </a> </li>
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