<!-- HEADER -->
<?php $data['title'] = 'Search Results'; $this->load->view('/site/templates/header',$data);?>

<!-- ADDITIONAL FILES -->



<!-- end of ADDITIONAL FILES -->

</head>
<body>
<!-- CONTENT -->
<!-- Filters -->
<div class="container">
<div class="col-md-10">
	<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title"> <span class="glyphicon glyphicon-search"></span> Search Results </h3>
			</div>
			<div class="panel-body">
				<!-- Table of Users -->
				<table class="table">
					<thead>
						<tr>
							<th> House No </th> <th> Household Name</th> <th> Person Name </th> <th> Gender </th> <th> Fever Duration </th> <th> Suspected Source </th> <th> Contact Number </th>
						</tr>
					<thead>
					<tbody>
						<?php foreach ($results as $case) {?>
						<tr>
							<td> <?= $case['house_no']?> </td>
							<td> <?= $case['household_name']?> </td>
							<td> <a href="<?= site_url('website/cases/view_person/' . $case['imcase_no']) ?>"><?= $case['person_first_name'] . ' ' . $case['person_last_name'] ?> </a> </td> 
							<td> <?= $case['person_sex'] ?> </td>
							<td> <?= $case['days_fever'] ?> </td> 
							<td> <?= $case['suspected_source'] ?> </td>
							<td> <?= $case['person_contactno'] ?> </td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
				<!-- /end of Table of Users -->
				<div style="text-align:right">
					<?php echo $links; ?>
				</div>
			</div>
		</div>
</div>
</div>
<!-- /end of Filters -->
<!-- FOOTER -->
<?php $this->load->view('/site/templates/footer');?>