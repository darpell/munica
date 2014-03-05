<!-- HEADER -->
<?php $data['title'] = 'Notifications'; $this->load->view('/site/templates/header',$data);?>

</head>
<body>
<!-- CONTENT -->
<div class="container">
<div class="panel panel-primary">
	<div class="panel-heading">
		<h3 class="panel-title"><span class="glyphicon glyphicon-exclamation-sign">&nbsp;</span> Notifications </h3>
	</div>
	<div class="panel-body">
		<table class="table table-striped">
			<thead>
				<tr>
					<th> Type </th> <th> Description </th> <th> Date </th> <th> &nbsp; </th>
				</tr>
			</thead>
			<tbody>			
				<?php foreach ($notifs as $notif) {?>
				<tr>
					<td> <?= ucfirst($notif['notif_type']) ?> </td> 
					<td>
						<!-- Icon -->
						<div class="col-md-1">
							<?php if ($notif['notif_type'] == '1') { ?>
								<img src="<?= base_url('/images/notice.png') ?>">
							<?php } else if ($notif['notif_type'] == '2') { ?>
								<img src="<?= base_url('/images/mosquito.png') ?>">
							<?php } else if ($notif['notif_type'] == '3') { ?>	
								<img src="<?= base_url('/images/group-2.png') ?>">
							<?php } ?>
						</div>
						<!-- /end of Icon -->
						<div class="col-md-8">
							<a href="<?= site_url($notif['unique_id']) ?>"> <?= $notif['notification']?> </a>
						</div>
					</td> 
					<td> 
						<?php 
							
							$old_date_timestamp = strtotime($notif['notif_createdOn']);
							$new_date = date('g:i:s, l, F d, Y', $old_date_timestamp);
							echo $new_date;
						?> 
					</td> 
					<td> <a href="<?= site_url('website/notifications/set_viewed/' . $notif['notif_id']) ?>"> <span class="glyphicon glyphicon-remove"></span> </a>
				</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
</div>
</div>
     
<!-- FOOTER -->
<?php $this->load->view('/site/templates/footer');?>