<!-- HEADER -->
<?php $data['title'] = "System Users"; $this->load->view('/site/templates/header',$data);?>


</head>
<body>
<!-- CONTENT -->
<div class="container">
<div class="panel panel-primary">
	<div class="panel-heading">
		<h3 class="panel-title"><span class="glyphicon glyphicon-user">&nbsp;</span> Viewing All <?= $type ?> Cases </h3>
	</div>
	<div class="panel-body">
	<!-- Table of Users -->
		<table class="table">
			<thead>
				<tr>
					<th> person_id </th> <th> days_fever </th> <th> suspected_source </th> <th> Status </th> <th> Contact Number </th>
				</tr>
			<thead>
			<tbody>
				<?php foreach ($cases as $case) {?>
				<tr>
					<td> <a href="<?= site_url('website/cases/view_person/' . $case['person_id']) ?>"><?= $case['person_first_name'] . ' ' . $case['person_last_name'] ?> </a> </td> <td> <?= $case['days_fever'] ?> </td> 
					<td> <?= $case['suspected_source'] ?> </td> <td> <?= $case['status'] ?> </td> <td> <?= $case['person_contactno'] ?> </td>
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
<!-- FOOTER -->
<?php $this->load->view('/site/templates/footer');?>