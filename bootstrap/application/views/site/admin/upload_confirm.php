<!-- HEADER -->
<?php $data['title'] = "Upload PIDSR Forms"; $this->load->view('/site/templates/header',$data);?>

</head>
<body>
<!-- CONTENT -->
<div class="container">
<div class="panel panel-primary">
	<div class="panel-heading">
		<h3 class="panel-title"> Upload PIDSR Form </h3>
	</div>
	<div class="panel-body">
		<div class="col-md-8">
		
		<!-- Initial Upload -->
		<!-- /end of Initial Upload -->
		<!-- Upload Result -->
			<?php if ($values != FALSE) { ?>
			<table class="table">
				<thead>
					<tr>
						<th> Patient No. </th> <th> Patient Name </th> <th> Date of birth </th> <th> Address </th> <th> Date onset of illness </th> <th> Date of Entry </th>
					</tr>
				</thead>
				<tbody>
					<?php for ($ctr=0; $ctr < count($values); $ctr++) {?>
					<tr>
						<td> <?php echo $values[$ctr]['cr_patient_no'];?> </td> <td> <?php echo $values[$ctr]['cr_first_name'] . ' ' . $values[$ctr]['cr_last_name'];?> </td> <td> <?php echo $values[$ctr]['cr_dob'];?> </td> 
						<td> <?php echo $values[$ctr]['cr_address'];?> </td> <td> <?php echo $values[$ctr]['cr_date_onset'];?> </td> <td> <?php echo $values[$ctr]['cr_date_of_entry'];?> </td> 
					</tr>
					<?php } ?>
				</tbody>
			</table>
			<?php } ?>
		<!-- /end of Upload Result -->
		</div>
		<div class="col-md-4">
			<div class="form-group">
			<h2> Summary: </h2>
			<p> There are <span class="badge"> <?= $entry_count ?> </span> cases recorded. </p>
			<p> <span class="badge"> <?= $distribution['male'] ?> </span> are Male. <span class="badge"> <?= $distribution['female'] ?> </span> are Female. </p>
			<p> <span class="badge"> <?= count($residents) ?> </span> patient/s that are part of your master list. </p>
			<p> <span class="badge"> <?= $entry_count - count($residents) ?> </span> are NOT part of you master list</p>
			
			<?php echo form_open_multipart(); ?>
				<br/><button type="submit" value="Upload" class="btn btn-primary"> Confirm <span class="glyphicon glyphicon-upload"> </span></button>
			<?php echo form_close(); ?>
			</div>
			
			<div>
				<?php var_dump('test area'); ?>
			</div>
			
		</div>
</div>
</div>
<!-- FOOTER -->
<?php $this->load->view('/site/templates/footer');?>