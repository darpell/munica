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
					<?php $this->load->model('hh_model','model');
						$active_case = $this->model->check_if_has_fever($person['person_id']);
					if ($active_case != NULL)
					{
						if ($active_case['status'] == 'hospitalized') //is sick and hospitalized
						{
				?>
					
					<li> <a href="<?=site_url('website/households/view_person/' . $per) ?>"> <label style="color:GREEN;"> [Hospitalized] </label> <?php echo $name; ?> </a> </li>
					<?php
						}
						else //is sick but unhospitalized
						{
							//$this->masterlist->add_fever_day($household_persons[$ctr]['person_id']);
					?>
						<li> <a href="<?=site_url('website/households/view_person/' . $per) ?>"> <label style="color:RED;"> [Has fever] </label> <?php echo $name; ?> </a> </li>
					<?php } ?>
					
					<?php } else { ?>
						<li> <a href="<?=site_url('website/households/view_person/' . $per) ?>"> <label style="color:GREEN;"> </label> <?php echo $name; ?> </a> </li>
					<?php } } ?>
				</ul>
				<?php echo $links; ?>
			</div>
		</div>
</div>
</div>
<!-- /end of Filters -->
<!-- FOOTER -->
<?php $this->load->view('/site/templates/footer');?>