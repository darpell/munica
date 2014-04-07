<!-- HEADER -->
<?php $data['title'] = $person['person_first_name'] . ' ' . $person['person_last_name']; $this->load->view('/site/templates/header',$data);?>

</head>
<body>
<style>
td { font-weight:bold }
</style>
<!-- CONTENT -->
<!-- Filters -->
<div class="container">
<div class="col-md-10">
	<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title"> <span class="glyphicon glyphicon-user">&nbsp;</span> <?= $person['person_first_name'] . ' ' . $person['person_last_name'] ?> </h3>
			</div>
			<div class="panel-body">
				<table class="table">
					<tr>
						<td> Status: </td> <td> <?= ucfirst($person['status']) ?> </td>
					</tr>
					<tr>
						<td> First encoded on: </td> <td> <?= date('D, M d Y',strtotime($person['created_on'])) ?> </td>
					</tr>
					<tr>
						<td> Last updated on: </td> <td> <?= date('D, M d Y',strtotime($person['last_updated_on'])) ?> </td>
					</tr>
					<tr>
						<td> Suspected Source: </td> <td> <?= $person['suspected_source']?> </td>
					</tr>
					<tr>
						<td> Remarks: </td> <td> <?= $person['remarks'] ?> </td>
					</tr>
					<tr>
						<td> Name: </td> <td> <?= $person['person_first_name'] . ' ' . $person['person_last_name'] ?> </td>
					</tr>
					<tr>
						<td> Gender: </td> <td> <?php if($person['person_sex'] == 'M') echo 'Male'; else echo 'Female'; ?> </td>
					</tr>
					<tr>
						<td> Contact No: </td> <td> <?= $person['person_contactno'] ?> </td>
					</tr>
					<tr>
						<td> Landline No: </td> <td> <?= $person['person_landline'] ?> </td>
					</tr>
					<tr>
						<td> Email Address: </td> <td> <?= $person['person_email'] ?> </td>
					</tr>
					<tr>
						<td> Facebook: </td> <td> <?= $person['person_fb'] ?> </td>
					</tr>
					<tr>
						<td> Twitter: </td> <td> <?= $person['person_tw'] ?> </td>
					</tr>
					<tr>
						<td> Yahoo Messenger: </td> <td> <?= $person['person_ym'] ?> </td>
					</tr>
					<tr>
						<td> Date of Birth: </td> <td> <?= date('D, M d Y',strtotime($person['person_dob'])) ?> </td>
					</tr>
					<tr>
						<td> Lives in: </td> <td> <?= $person['household_name']?> at <?= $person['house_no']?> <?= $person['street']?> </td>
					</tr>
					<tr>
						<td> Marital Status: </td> <td> <?= $person['person_marital'] ?> </td>
					</tr>
					<tr>
						<td> Nationality: </td> <td> <?= $person['person_nationality'] ?> </td>
					</tr>
					<tr>
						<td> Blood Type: </td> <td> <?= $person['person_blood_type'] ?> </td>
					</tr>
					<tr>
						<td> Guardian: </td> <td> <?= $person['person_guardian'] ?> </td>
					</tr>
				</table>
				<?php 
				$attributes = array(
										'id' 	=> 'TPupdate_to_previous',
										'role'	=> 'form'
									);
				echo form_open('website/cases/update_to_previous',$attributes); ?>
				<div class="col-md-6">
					<div class="row">
					<input type="hidden" name="current_url" value="<?= current_url() ?>" />
					<input type="hidden" name="imcase_no" value="<?= $person['imcase_no'] ?>" />
					<input type="hidden" name="person_name" value="<?= $person['person_first_name'] . ' ' . $person['person_last_name'] ?>" />
					<!-- Outcome -->
						<label> Outcome: </label>
					    <div class="radio">
					        <label><input name="outcome" type="radio" value="A" checked="checked" /> Alive </label>
					   	</div>
					   	<div class="radio">
					   		<label><input name="outcome" type="radio" value="D" /> Dead </label>
					   	</div>
					<!-- end of Outcome -->
					
					<!-- Remarks -->
			        	<div class="form-group">
				        	<label for="TPlastname-txt"> Additional Remarks: </label>
							<textarea class="form-control" rows="3" name="remarks"></textarea>
			        	</div>
			        <!-- end of Remarks -->
			        	<div class="form-group"><center><input type="submit" value="Update" class="btn btn-lg btn-primary" /></center></div>
	        		</div>
        		</div>
        		</form>
				
			</div>
		</div>
</div>
</div>
<!-- /end of Filters -->
<!-- FOOTER -->
<?php $this->load->view('/site/templates/footer');?>