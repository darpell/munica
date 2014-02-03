<!-- HEADER -->
<?php $data['title'] = "System Users"; $this->load->view('/site/templates/header',$data);?>


</head>
<body>
<!-- CONTENT -->
<div class="container">
<div class="panel panel-primary">
	<div class="panel-heading">
		<h3 class="panel-title"><span class="glyphicon glyphicon-user">&nbsp;</span>Viewing All Users </h3>
	</div>
	<div class="panel-body">
	<!-- Table of Users -->
		<table class="table">
			<thead>
				<tr>
					<th> Username </th> <th> User Type </th> <th> First Name </th> <th> Middle Name </th> <th> Last Name </th> <th> Contact No. </th>
				</tr>
			<thead>
			<tbody>
				<?php foreach ($users as $user) {?>
				<tr>
					<td> <a href="<?= site_url('website/user/update/' . $user['user_username']) ?>"> <?= $user['user_username']?> </a> </td> <td> <?= $user['user_type']?> </td> <td> <?= $user['user_firstname']?> </td>
					<td> <?= $user['user_middlename']?> </td> <td> <?= $user['user_lastname']?> </td> <td> <?= $user['user_contact']?> </td> 
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