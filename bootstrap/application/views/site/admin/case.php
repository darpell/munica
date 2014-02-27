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
						<td> First encoded on: </td> <td> <?= date('d/m/Y',strtotime($person['created_on'])) ?> </td>
					</tr>
					<tr>
						<td> Last updated on: </td> <td> <?= date('d/m/Y',strtotime($person['last_updated_on'])) ?> </td>
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
						<td> Date of Birth: </td> <td> <?= date('d/m/Y',strtotime($person['person_dob'])) ?> </td>
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
			</div>
		</div>
</div>
</div>
<!-- /end of Filters -->
<!-- FOOTER -->
<?php $this->load->view('/site/templates/footer');?>