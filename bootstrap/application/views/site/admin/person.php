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
				<h3 class="panel-title"> <span class="glyphicon glyphicon-user">&nbsp;</span> <?= $person['person_first_name'] . ' ' . $person['person_last_name'] ?> </h3>
			</div>
			<div class="panel-body">
				<table class="table">
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
						<td> Email Address: </td> <td> <a href="mailto:<?= $person['person_email'] ?>"> <?= $person['person_email'] ?> </a> </td>
					</tr>
					<tr>
						<td> Facebook: </td> <td> <a href="http://www.facebook.com/<?= $person['person_fb'] ?>">  facebook.com/<?= $person['person_fb'] ?> </a> </td>
					</tr>
					<tr>
						<td> Twitter: </td> <td> <a href="http://www.twitter.com/<?= $person['person_tw'] ?>"> <?= $person['person_tw'] ?> </a></td>
					</tr>
					<tr>
						<td> Date of Birth: </td> <td> <?= date('D, M d Y', strtotime($person['person_dob'])) ?> </td>
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