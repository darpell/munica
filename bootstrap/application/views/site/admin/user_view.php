<!-- HEADER -->
<?php $data['title'] = 'Update User'; $this->load->view('/site/templates/header', $data);?>

</head>
<body>
<!-- CONTENT -->    
<div class="container">
<div class="panel panel-primary">
	<div class="panel-heading">
		<h3 class="panel-title"><span class="glyphicon glyphicon-user">&nbsp;</span> View User </h3>
	</div>
	<div class="panel-body">
	
	
	<?php 
	$attributes = array(
							'id' 	=> 'TPregister',
							'role'	=> 'form'
						);
	echo form_open('website/user/update/' . $user['user_username'],$attributes); ?>
	<div class="row">
        <div class="col-lg-6">
        	<!-- First Name -->
        	<div class="form-group">
	        	<label for="TPfirstname-txt"> First name:  </label> <label class="text-danger"><?php echo form_error('TPfirstname-txt'); ?></label>
	        	<input type="text" class="form-control" name="TPfirstname-txt" id="TPfirstname-txt" value="<?php echo $user['user_firstname']; ?>" placeholder="First name" required autofocus/>
        	</div>
        	<!-- end of First Name -->
        	
        	<!-- Middle Name -->
        	<div class="form-group">
	        	<label for="TPmiddlename-txt"> Middle name:  </label> <label class="text-danger"><?php echo form_error('TPmiddlename-txt'); ?></label>
	        	<input type="text" class="form-control" name="TPmiddlename-txt" id="TPmiddlename-txt" value="<?php echo $user['user_middlename']; ?>" placeholder="Middle name" required/>
        	</div>
        	<!-- end of Middle Name -->
        	
        	<!-- Last Name -->
        	<div class="form-group">
	        	<label for="TPlastname-txt"> Last name: </label> <label class="text-danger"><?php echo form_error('TPlastname-txt'); ?></label>
				<input type="text" class="form-control" name="TPlastname-txt" id="TPlastname-txt" value="<?php echo $user['user_lastname']; ?>" placeholder="Last name" required/>
        	</div>
        	<!-- end of Last Name -->
        	
        	<!-- Contact Number -->
        	<div class="form-group">
	        	<label for="TPcontactno-txt"> Contact Number: </label> <label class="text-danger"><?php echo form_error('TPcontactno-txt'); ?></label>
				<input type="text" class="form-control" name="TPcontactno-txt" id="TPcontactno-txt" value="<?php echo $user['user_contact']; ?>" placeholder="e.g. 09XX XXXXXXX, 999-9999" required/>
			</div>
			<!-- end of Contact Number -->
			
			<!-- User Type -->
			<?php if ($user['user_type'] == 'BHW') {?>
			<label> User type: </label>
		    <div class="radio">
		        <label><input name="TPusertype-rd" type="radio" checked="checked" value="BHW" /> Barangay Health Worker </label>
		   	</div>
		   	<div class="radio">
		   		<label><input name="TPusertype-rd" type="radio" value="MIDWIFE" /> Midwife </label>
		   	</div>
		   	<?php } else if($user['user_type'] == 'MIDWIFE') {?>
		   	<label> User type: </label>
		   	<div class="radio">
		        <label><input name="TPusertype-rd" type="radio" value="BHW" /> Barangay Health Worker </label>
		   	</div>
		   	<div class="radio">
		   		<label><input name="TPusertype-rd" type="radio" checked="checked" value="MIDWIFE" /> Midwife </label>
		   	</div>
		   	<?php } else {?>
		   	<?php } ?>
		   	<!-- end of User Type -->
		   	
        </div>
        <div class="col-lg-6">
        	<!-- Username -->
        	<div class="form-group">
	        	<label for="TPusername-txt"> Username: </label> <label class="text-danger"><?php echo form_error('TPusername-txt'); ?></label>
	        	<input type="text" class="form-control" name="TPusername-txt" id="TPusername-txt" value="<?php echo $user['user_username']; ?>" placeholder="Username" required />
        	</div>
        	<!-- end of Username -->
        	
        	<!-- Password -->
        	<div class="form-group">
	        	<label for="TPpassword-txt"> Password: </label> <label class="text-danger"><?php echo form_error('TPpassword-txt'); ?></label>
	        	<input type="password" class="form-control" name="TPpassword-txt" id="TPpassword-txt" placeholder="Password" required />
        	</div>
        	<!-- end of Password -->
        	
        	<!-- Repeat Password -->
        	<div class="form-group">
	        	<label for="TPpassword2-txt"> Repeat Password: </label> <label class="text-danger"><?php echo form_error('TPpassword2-txt'); ?></label>
				<input type="password" class="form-control" name="TPpassword2-txt" id="TPpassword2-txt" placeholder="Repeat Password" required />
		    </div>
		    <!-- end of Repeat Password -->
		    
		    <!-- Barangays -->
		    <div class="form-group">
			   	<label for=""> Barangay: </label> <label class="text-danger"><?php echo form_error('TPbrgy-dd'); ?></label>
				<select class="form-control" name="TPbrgy-dd">
				<?php for ($ctr = 0; $ctr < count($brgys); $ctr++) { ?>
					<option value="<?= $brgys[$ctr]['barangay'] ?>"> <?= $brgys[$ctr]['barangay'] ?> </option>
				<?php } ?>
				</select>
			</div>
			<!-- end of Barangays -->
			<br/><br/>
			
			<div class="form-group"><center><input type="submit" value="Update" class="btn btn-lg btn-primary" /></center></div>
        </div>
    </div>
	</form>
	</div>
</div>
</div>
      
<!-- FOOTER -->
<?php $this->load->view('/site/templates/footer');?>