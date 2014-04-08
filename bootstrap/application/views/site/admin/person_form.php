<!-- HEADER -->
<?php $data['title'] = 'Update User'; $this->load->view('/site/templates/header', $data);?>

</head>
<body>
<!-- CONTENT -->    
<div class="container">
<div class="panel panel-primary">
	<div class="panel-heading">
		<h3 class="panel-title"><span class="glyphicon glyphicon-user">&nbsp;</span> View Person </h3>
	</div>
	<div class="panel-body">
	
	
	<?php 
	$attributes = array(
							'id' 	=> 'TPperson_update',
							'role'	=> 'form'
						);
	echo form_open('website/households/update_person/' . $person['person_id'], $attributes); ?>
	<div class="row">
        <div class="col-lg-6">
        	<!-- First Name -->
        	<div class="form-group">
	        	<label for="hh_fname"> First name:  </label> <label class="text-danger"><?php echo form_error('hh_fname'); ?></label>
	        	<input type="text" class="form-control" name="hh_fname" id="hh_fname" value="<?php echo $person['person_first_name']; ?>" placeholder="First name" required autofocus/>
        	</div>
        	<!-- end of First Name -->
        	
        	<!-- Last Name -->
        	<div class="form-group">
	        	<label for="hh_lname"> Last name: </label> <label class="text-danger"><?php echo form_error('hh_lname'); ?></label>
				<input type="text" class="form-control" name="hh_lname" id="hh_lname" value="<?php echo $person['person_last_name']; ?>" placeholder="Last name" required/>
        	</div>
        	<!-- end of Last Name -->
        	
        	<!-- DOB -->
        	<div class="form-group">
	        	<label for="hh_dob"> Date of Birth: </label> <label class="text-danger"><?php echo form_error('hh_dob'); ?></label>
				<input type="date" class="form-control" name="hh_dob" id="hh_dob" value="<?php echo $person['person_dob']; ?>" required/>
        	</div>
        	<!-- end of DOB  -->
			
			<!-- Gender -->
			<label> Gender: </label>
		    <div class="radio">
		        <label><input name="hh_gender" type="radio" value="M" /> Male </label>
		   	</div>
		   	<div class="radio">
		   		<label><input name="hh_gender" type="radio" value="F" /> Female </label>
		   	</div>
		   	<!-- end of Gender -->
		   	
		   	<!-- Marital -->
        	<div class="form-group">
	        	<label for="hh_marital"> Marital Status: </label> <label class="text-danger"><?php echo form_error('hh_marital'); ?></label>
				<input type="text" class="form-control" name="hh_marital" id="hh_marital" value="<?php echo $person['person_marital']; ?>" placeholder="Marital Status" required/>
        	</div>
        	<!-- end of Marital -->
        	
        	<!-- Nationality -->
        	<div class="form-group">
	        	<label for="hh_nationality"> Nationality: </label> <label class="text-danger"><?php echo form_error('hh_nationality'); ?></label>
				<input type="text" class="form-control" name="hh_nationality" id="hh_nationality" value="<?php echo $person['person_nationality']; ?>" placeholder="Nationality" required/>
        	</div>
        	<!-- end of Nationality -->
        	
        	<!-- Blood Type -->
        	<div class="form-group">
	        	<label for="hh_blood"> Blood Type: </label> <label class="text-danger"><?php echo form_error('hh_blood'); ?></label>
				<input type="text" class="form-control" name="hh_blood" id="hh_blood" value="<?php echo $person['person_blood_type']; ?>" placeholder="Blood Type" required/>
        	</div>
        	<!-- end of Blood Type -->
		   	
        </div>
        <div class="col-lg-6">			
			<!-- Guardian -->
        	<div class="form-group">
	        	<label for="TPguardian-txt"> Guardian: </label> <label class="text-danger"><?php echo form_error('TPguardian-txt'); ?></label>
				<input type="text" class="form-control" name="TPguardian-txt" id="TPguardian-txt" value="<?php echo $person['person_guardian']; ?>" placeholder="Guardian"/>
        	</div>
        	<!-- end of Guardian -->
			
			<!-- Contact Number -->
        	<div class="form-group">
	        	<label for="TPcontactno-txt"> Contact Number: </label> <label class="text-danger"><?php echo form_error('TPcontactno-txt'); ?></label>
				<input type="text" class="form-control" name="TPcontactno-txt" id="TPcontactno-txt" value="<?php echo $person['person_contactno']; ?>" placeholder="e.g. 09XX XXXXXXX, 999-9999"/>
			</div>
			<!-- end of Contact Number -->
			
			<!-- Landline -->
        	<div class="form-group">
	        	<label for="TPlandline-txt"> Landline: </label> <label class="text-danger"><?php echo form_error('TPlandline-txt'); ?></label>
				<input type="tel" class="form-control" name="TPlandline-txt" id="TPlandline-txt" value="<?php echo $person['person_landline']; ?>" placeholder="Landline"/>
        	</div>
        	<!-- end of Landline -->
        	
        	<!-- Email -->
        	<div class="form-group">
	        	<label for="TPemail-txt"> Email Address: </label> <label class="text-danger"><?php echo form_error('TPemail-txt'); ?></label>
				<input type="email" class="form-control" name="TPemail-txt" id="TPemail-txt" value="<?php echo $person['person_email']; ?>" placeholder="Email Address"/>
        	</div>
        	<!-- end of Email -->
        	
        	<!-- FB -->
        	<div class="form-group">
	        	<label for="TPfb-txt"> Facebook: </label> <label class="text-danger"><?php echo form_error('TPfb-txt'); ?></label>
				<input type="text" class="form-control" name="TPfb-txt" id="TPfb-txt" value="<?php echo $person['person_fb']; ?>" placeholder="Facebook Account"/>
        	</div>
        	<!-- end of FB -->
        	
        	<!-- Twitter -->
        	<div class="form-group">
	        	<label for="TPtwitter-txt"> Twitter: </label> <label class="text-danger"><?php echo form_error('TPtwitter-txt'); ?></label>
				<input type="text" class="form-control" name="TPtwitter-txt" id="TPtwitter-txt" value="<?php echo $person['person_tw']; ?>" placeholder="Twitter"/>
        	</div>
        	<!-- end of Twitter -->
        	
        	<!-- ym -->
        	<div class="form-group">
	        	<label for="TPym-txt"> Yahoo Messenger: </label> <label class="text-danger"><?php echo form_error('TPym-txt'); ?></label>
				<input type="text" class="form-control" name="TPym-txt" id="TPym-txt" value="<?php echo $person['person_ym']; ?>" placeholder="Yahoo Messenger"/>
        	</div>
        	<!-- end of ym -->
			
			<div class="form-group"><center><input type="submit" value="Update" class="btn btn-lg btn-primary" /></center></div>
        </div>
    </div>
	</form>
	</div>
</div>
</div>
      
<!-- FOOTER -->
<?php $this->load->view('/site/templates/footer');?>