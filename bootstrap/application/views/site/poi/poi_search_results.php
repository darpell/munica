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
				<!-- Table of poi results -->
				<table class="table">
					<thead>
						<tr>
							<th> Node Name </th> <th> Type </th> <th> Barangay </th> <th> Notes </th> <th> Created On </th> <th> End Date </th>
						</tr>
					<thead>
					<tbody>
						<?php foreach ($results as $poi) {?>
						<tr>
							<td> <a href="<?= site_url('website/poi/update/' . $poi['node_no']) ?>"> <?= $poi['node_name']?> </a> </td> 
							<td> <?php if ($poi['node_type'] == 0) echo 'Source Area'; else if ($poi['node_type'] == 1) echo 'Risk Area'; ?> </td> 
							<td> <?= $poi['node_barangay']?> </td>
							<td> <?= $poi['node_notes']?> </td> <td> <?= $poi['node_addedOn']?> </td> <td> <?= $poi['node_endDate']?> </td> 
						</tr>
						<?php } ?>
					</tbody>
				</table>
				<!-- /end of Table of poi results -->
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