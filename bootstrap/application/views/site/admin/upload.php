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
						<td> <?php echo $values[$ctr]['cr_patient_no'];?> </td> <td> <?php echo $values[$ctr]['cr_name'];?> </td> <td> <?php echo $values[$ctr]['cr_dob'];?> </td> 
						<td> <?php echo $values[$ctr]['cr_address'];?> </td> <td> <?php echo $values[$ctr]['cr_date_onset'];?> </td> <td> <?php echo $values[$ctr]['cr_date_of_entry'];?> </td> 
					</tr>
					<?php } ?>
				</tbody>
			</table>
			<?php } ?>
		<!-- /end of Upload Result -->
		</div>
		<div class="col-md-4">
		<!-- Upload Form -->
			<div class="form-group">
			<?php
				echo form_open_multipart('website/upload/do_upload');
			?>
				<label for="userfile"> File Input </label>
				<input type="file" name="userfile" id="userfile" size="20" />
				<p class="help-block"> Upload the Dengue.mdb file</p>
				<label style="color:red"> <?php echo $error;?> </label> <br/>
				<button type="submit" value="Upload" class="btn btn-primary"> Upload <span class="glyphicon glyphicon-upload"> </span></button>
				</form>
			</div>
		<!-- /end of Upload Form -->
		</div>
</div>
</div>
<!-- FOOTER -->
<?php $this->load->view('/site/templates/footer');?>